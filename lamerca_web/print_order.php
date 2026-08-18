<?php
declare(strict_types=1);

require_once __DIR__ . '/app/Database.php';

// Load local FPDF library from assets
$fpdfPath = __DIR__ . '/assets/fpdf/fpdf.php';
if (file_exists($fpdfPath)) {
    require_once $fpdfPath;
} elseif (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

if (!class_exists('FPDF')) {
    header('HTTP/1.1 500 Internal Server Error');
    echo 'FPDF library not found. Coloca assets/fpdf/fpdf.php o instala con Composer.';
    exit;
}

$ventaId = isset($_GET['venta_id']) ? (int) $_GET['venta_id'] : 0;
if ($ventaId <= 0) {
    http_response_code(400);
    echo 'venta_id requerido';
    exit;
}

$db = Database::getInstance();
$stmt = $db->prepare('SELECT * FROM venta_tienda WHERE id_venta_tienda = :id');
$stmt->bindValue(':id', $ventaId, PDO::PARAM_INT);
$stmt->execute();
$venta = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$venta) {
    http_response_code(404);
    echo 'Venta no encontrada';
    exit;
}

$detalleItems = [];
if (!empty($venta['detalle_venta_tienda'])) {
    $detalleItems = json_decode((string) $venta['detalle_venta_tienda'], true) ?: [];
}

$detalleDatos = [];
if (!empty($venta['detalle_datos_factura'])) {
    $detalleDatos = json_decode((string) $venta['detalle_datos_factura'], true) ?: [];
}

$total = (float) ($venta['total_venta_tienda'] ?? 0);
$codVenta = $venta['cod_venta_tienda'] ?? '';

// Create ticket-style PDF using a narrow paper width
$pdf = new FPDF('P', 'mm', [120, 297]);
$pdf->SetMargins(5, 5, 5);
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 10);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 6, 'LA MERCA', 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 5, 'Detalle de compra', 0, 1, 'C');
$pdf->Ln(2);

if (!empty($codVenta)) {
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(0, 5, utf8_decode('Código: ' . $codVenta), 0, 1);
}
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 5, 'Fecha: ' . date('d/m/Y H:i'), 0, 1);
$pdf->Ln(2);

if (!empty($detalleDatos)) {
    $name = trim(utf8_decode(($detalleDatos['nombre'] ?? '') . ' ' . ($detalleDatos['apellido_paterno'] ?? '') . ' ' . ($detalleDatos['apellido_materno'] ?? '')));
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 5, 'Cliente:', 0, 1);
    $pdf->SetFont('Arial', '', 8);
    $pdf->MultiCell(0, 5, $name, 0, 'L');
    $pdf->Cell(0, 5, 'NIT/CI: ' . ($detalleDatos['nit_ci'] ?? ''), 0, 1);
    $pdf->Cell(0, 5, 'Tel: ' . ($detalleDatos['telefonos'] ?? ''), 0, 1);
    $pdf->Ln(2);
}

$pdf->Cell(0, 0, str_repeat('-', 115), 0, 1);
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(38, 5, 'Producto', 0, 0);
$pdf->Cell(10, 5, 'Cant', 0, 0, 'R');
$pdf->Cell(15, 5, 'P.U.', 0, 0, 'R');
$pdf->Cell(15, 5, 'Total', 0, 1, 'R');
$pdf->Ln(1);

$pdf->SetFont('Arial', '', 8);
foreach ($detalleItems as $item) {
    $descripcion = (string) ($item['descripcion'] ?? '');
    $cantidad = (int) ($item['cantidad'] ?? 0);
    $precio = number_format((float) ($item['precioUnitario'] ?? 0), 2);
    $subtotal = number_format((float) ($item['subtotal'] ?? 0), 2);

    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(38, 4, utf8_decode($descripcion), 0);
    $height = $pdf->GetY() - $y;
    $pdf->SetXY($x + 38, $y);
    $pdf->Cell(10, $height, (string) $cantidad, 0, 0, 'R');
    $pdf->Cell(15, $height, 'Bs ' . $precio, 0, 0, 'R');
    $pdf->Cell(15, $height, 'Bs ' . $subtotal, 0, 1, 'R');
}

$pdf->Ln(2);
$pdf->Cell(0, 0, str_repeat('-', 115), 0, 1);
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 5, 'TOTAL: Bs ' . number_format($total, 2), 0, 1, 'R');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(0, 5, 'Gracias por su compra.', 0, 'C');

$filename = 'ticket_' . $ventaId . '.pdf';
$pdf->Output('I', $filename);
exit;
