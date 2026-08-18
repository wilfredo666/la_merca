<?php

declare(strict_types=1);

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/MetodoPago.php';
require_once __DIR__ . '/../Database.php';

class CartController extends Controller
{
    public function index(): string
    {
        $cart = $this->getCart();
        $items = array_values($cart);
        $subtotal = 0.0;
        $itemCount = 0;

        foreach ($items as $item) {
            $price = (float) ($item['price'] ?? 0);
            $quantity = max(1, (int) ($item['qty'] ?? 1));
            $subtotal += $price * $quantity;
            $itemCount += $quantity;
        }

        return $this->render('cart.index', [
            'pageTitle' => 'Carrito de compras - La Merca',
            'cartItems' => $items,
            'subtotal' => $subtotal,
            'itemCount' => $itemCount,
            'categories' => Category::all(),
        ]);
    }

    public function add(): string
    {
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $productId = $productId ? (int) $productId : 0;

        if ($productId <= 0) {
            return $this->redirectToCart();
        }

        $product = Product::findById($productId);
        if ($product === null) {
            return $this->redirectToCart();
        }

        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] = (int) $cart[$productId]['qty'] + 1;
        } else {
            $cart[$productId] = [
                'id' => (int) $product['id'],
                'codigo' => (string) $product['codigo'],
                'name' => (string) $product['name'],
                'price' => (float) $product['price'],
                'image' => (string) $product['image'],
                'category' => (string) $product['category'],
                'qty' => 1,
            ];
        }

        $this->saveCart($cart);
        return $this->redirectToCart();
    }

    public function update(): string
    {
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $productId = $productId ? (int) $productId : 0;
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
        $quantity = $quantity ? (int) $quantity : 0;
        $delta = filter_input(INPUT_POST, 'delta', FILTER_SANITIZE_STRING);

        if ($productId <= 0) {
            return $this->redirectToCart();
        }

        $cart = $this->getCart();

        if (!isset($cart[$productId])) {
            return $this->redirectToCart();
        }

        $currentQty = max(1, (int) $cart[$productId]['qty']);

        if ($delta === '-1') {
            $quantity = max(1, $currentQty - 1);
        } elseif ($delta === '+1') {
            $quantity = $currentQty + 1;
        }

        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId]['qty'] = $quantity;
        }

        $this->saveCart($cart);
        return $this->redirectToCart();
    }

    public function remove(): string
    {
        $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $productId = $productId ? (int) $productId : 0;

        if ($productId > 0) {
            $cart = $this->getCart();
            unset($cart[$productId]);
            $this->saveCart($cart);
        }

        return $this->redirectToCart();
    }

    public function clear(): string
    {
        $this->saveCart([]);
        return $this->redirectToCart();
    }

    public function checkout(): string
    {
        $cart = $this->getCart();
        $items = array_values($cart);
        $subtotal = 0.0;
        $itemCount = 0;

        foreach ($items as $item) {
            $price = (float) ($item['price'] ?? 0);
            $quantity = max(1, (int) ($item['qty'] ?? 1));
            $subtotal += $price * $quantity;
            $itemCount += $quantity;
        }

        $qrMethod = MetodoPago::findActiveByType('QR');
        $qrImage = $qrMethod ? (string) $qrMethod['image'] : '';

        return $this->render('cart.checkout', [
            'pageTitle' => 'Finalizar compra - La Merca',
            'cartItems' => $items,
            'subtotal' => $subtotal,
            'itemCount' => $itemCount,
            'categories' => Category::all(),
            'qrImageName' => $qrImage,
        ]);
    }

    public function confirm(): string
    {
        $cart = $this->getCart();

        if (empty($cart)) {
            return $this->redirectToCart();
        }

        $nombre = trim((string) ($_POST['nombre'] ?? ''));
        $apellidoPaterno = trim((string) ($_POST['apellido_paterno'] ?? ''));
        $apellidoMaterno = trim((string) ($_POST['apellido_materno'] ?? ''));
        $nitCi = trim((string) ($_POST['nit_ci'] ?? ''));
        $direccion = trim((string) ($_POST['direccion'] ?? ''));
        $telefonos = trim((string) ($_POST['telefonos'] ?? ''));
        $metodoPago = trim((string) ($_POST['metodo_pago'] ?? ''));

        if ($nombre === '' || $nitCi === '' || $telefonos === '' || $metodoPago === '') {
            return $this->redirectToCheckout();
        }

        $paymentMethodLabel = 'Método no válido';
        if ($metodoPago === 'QR') {
            $paymentMethod = MetodoPago::findActiveByType('QR');
            $paymentMethodLabel = $paymentMethod ? (string) $paymentMethod['name'] : 'Pago con QR';
        } elseif ($metodoPago === 'contrareembolso') {
            $paymentMethodLabel = 'Contra Reembolso';
        } else {
            return $this->redirectToCheckout();
        }

        // prepare sale data
        $items = array_values($cart);
        $detalleItems = [];
        $total = 0.0;
        foreach ($items as $it) {
            $price = (float) ($it['price'] ?? 0);
            $qty = max(1, (int) ($it['qty'] ?? 1));
            $subtotal = $price * $qty;
            $total += $subtotal;

            $detalleItems[] = [
                'idProducto' => (string) ($it['id'] ?? ''),
                'codigoProducto' => (string) ($it['codigo'] ?? ''),
                'descripcion' => (string) ($it['name'] ?? ''),
                'cantidad' => $qty,
                'uniMedida' => 'UNIDAD',
                'precioUnitario' => $price,
                'subtotal' => $subtotal,
            ];
        }

        $detalleDatosFactura = [
            'nombre' => $nombre,
            'apellido_paterno' => $apellidoPaterno,
            'apellido_materno' => $apellidoMaterno,
            'nit_ci' => $nitCi,
            'direccion' => $direccion,
            'telefonos' => $telefonos,
        ];

        // insert into DB
        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            // determine next sequence for NT-
            $seqStmt = $db->prepare("SELECT MAX(CAST(SUBSTRING_INDEX(cod_venta_tienda, '-', -1) AS UNSIGNED)) AS max_seq FROM venta_tienda WHERE cod_venta_tienda LIKE 'NT-%'");
            $seqStmt->execute();
            $row = $seqStmt->fetch();
            $maxSeq = $row && isset($row['max_seq']) ? (int) $row['max_seq'] : 0;
            $nextSeq = $maxSeq + 1;
            $codVenta = 'NT-' . $nextSeq;

            $insert = $db->prepare(
                'INSERT INTO venta_tienda (cod_venta_tienda, detalle_venta_tienda, detalle_datos_factura, id_usuario_tienda, metodo_pago_tienda, estado_venta_tienda, total_venta_tienda, create_at, update_at)
                 VALUES (:cod, :detalle_venta, :detalle_factura, :id_usuario, :metodo_pago, :estado, :total_venta, NOW(), NOW())'
            );

            $userId = isset($_SESSION['usuario_tienda']['id_cliente']) ? (int) $_SESSION['usuario_tienda']['id_cliente'] : 1;
            
            $insert->bindValue(':cod', $codVenta, PDO::PARAM_STR);
            $insert->bindValue(':detalle_venta', json_encode($detalleItems, JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $insert->bindValue(':detalle_factura', json_encode($detalleDatosFactura, JSON_UNESCAPED_UNICODE), PDO::PARAM_STR);
            $insert->bindValue(':id_usuario', $userId, PDO::PARAM_INT);
            $insert->bindValue(':metodo_pago', $metodoPago, PDO::PARAM_STR);
            $insert->bindValue(':estado', 'pendiente', PDO::PARAM_STR);
            $insert->bindValue(':total_venta', $total, PDO::PARAM_STR);

            $insert->execute();
            $ventaId = (int) $db->lastInsertId();

            $db->commit();
        } catch (Throwable $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            // fallback: redirect back to checkout on error
            return $this->redirectToCheckout();
        }

        // clear cart after successful insert
        $this->saveCart([]);

        return $this->render('cart.confirmation', [
            'pageTitle' => 'Pedido confirmado - La Merca',
            'nombre' => $nombre,
            'apellidoPaterno' => $apellidoPaterno,
            'apellidoMaterno' => $apellidoMaterno,
            'nitCi' => $nitCi,
            'direccion' => $direccion,
            'telefonos' => $telefonos,
            'metodoPago' => $paymentMethodLabel,
            'cartItems' => $items,
            'categories' => Category::all(),
            'codVenta' => $codVenta,
            'ventaId' => $ventaId,
            'detalleVentaJson' => json_encode($detalleItems, JSON_UNESCAPED_UNICODE),
            'detalleDatosFacturaJson' => json_encode($detalleDatosFactura, JSON_UNESCAPED_UNICODE),
            'total' => $total,
        ]);
    }

    private function getCart(): array
    {
        if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
            return [];
        }

        return $_SESSION['cart'];
    }

    private function saveCart(array $cart): void
    {
        $_SESSION['cart'] = $cart;
    }

    private function redirectToCart(): string
    {
        $referrer = $_SERVER['HTTP_REFERER'] ?? '/lamerca_web/';
        $redirectUrl = $referrer;

        if (strpos($redirectUrl, '/lamerca_web/index.php') === false && strpos($redirectUrl, '/lamerca_web/') !== false) {
            $redirectUrl = '/lamerca_web/';
        }

        header('Location: ' . $redirectUrl);
        exit;
    }

    private function redirectToCheckout(): string
    {
        header('Location: /lamerca_web/index.php?route=cart/checkout');
        exit;
    }
}
