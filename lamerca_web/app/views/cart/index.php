<?php
/** @var array $cartItems */
/** @var float $subtotal */
/** @var int $itemCount */
?>
<section class="py-2">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Carrito de compras</h1>
            <p class="text-muted mb-0">Revisa los productos que has agregado y finaliza tu compra.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary-subtle text-primary-emphasis px-3 py-2">
                <i class="fas fa-shopping-bag me-2"></i><?= $itemCount ?> artículos
            </span>
            <?php if (!empty($cartItems)): ?>
                <form action="/lamerca_web/index.php?route=cart/clear" method="post" class="d-inline">
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash me-2"></i>Vaciar carrito
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($cartItems)): ?>
        <div class="card border-0 shadow-sm p-5 text-center">
            <div class="display-1 text-muted">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h2 class="h4 mt-3">Tu carrito está vacío</h2>
            <p class="text-muted mb-4">Agrega productos desde el catálogo para verlos aquí.</p>
            <a href="/lamerca_web" class="btn btn-primary">Seguir comprando</a>
        </div>
    <?php else: ?>
        <div class="row g-4 align-items-start">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="h5 mb-0">Productos seleccionados</h2>
                            <span class="text-muted"><?= count($cartItems) ?> productos</span>
                        </div>

                        <?php foreach ($cartItems as $item): ?>
                            <?php
                                $itemImage = trim((string) ($item['image'] ?? ''));
                                $itemImageUrl = $itemImage
                                    ? 'https://lamercabolivia.com/assest/dist/img/producto/' . rawurlencode($itemImage)
                                    : '/lamerca_web/assets/dist/img/product_default.png';
                            ?>
                            <div class="row g-3 align-items-center border-bottom py-3">
                                <div class="col-md-3">
                                    <img src="<?= htmlspecialchars($itemImageUrl, ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars((string) $item['name'], ENT_QUOTES, 'UTF-8') ?>" class="img-fluid rounded" style="height: 100px; object-fit: cover; width: 100%;" onerror="this.onerror=null;this.src='/lamerca_web/assets/dist/img/product_default.png';">
                                </div>
                                <div class="col-md-5">
                                    <h3 class="h6 fw-bold mb-1"><?= htmlspecialchars((string) $item['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                                    <p class="text-muted mb-2 small"><?= htmlspecialchars((string) $item['category'], ENT_QUOTES, 'UTF-8') ?></p>
                                    <p class="fw-semibold mb-0">$<?= number_format((float) $item['price'], 2) ?></p>
                                </div>
                                <div class="col-md-2">
                                    <form action="/lamerca_web/index.php?route=cart/update" method="post" class="d-flex flex-wrap align-items-center gap-2">
                                        <input type="hidden" name="product_id" value="<?= (int) $item['id'] ?>">
                                        <button type="submit" class="btn btn-outline-secondary btn-sm" name="delta" value="-1">-</button>
                                        <input type="number" name="quantity" class="form-control form-control-sm text-center" value="<?= (int) $item['qty'] ?>" min="1" style="max-width: 70px;">
                                        <button type="submit" class="btn btn-outline-secondary btn-sm" name="delta" value="+1">+</button>
                                        <button type="submit" class="btn btn-outline-primary btn-sm w-100">Actualizar</button>
                                    </form>
                                </div>
                                <div class="col-md-2 text-end">
                                    <div class="fw-bold mb-2">$<?= number_format((float) $item['price'] * (int) $item['qty'], 2) ?></div>
                                    <form action="/lamerca_web/index.php?route=cart/remove" method="post" class="d-inline">
                                        <input type="hidden" name="product_id" value="<?= (int) $item['id'] ?>">
                                        <button type="submit" class="btn btn-link text-danger p-0">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="h5 mb-3">Resumen</h2>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>$<?= number_format($subtotal, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Envío</span>
                            <span class="text-success">Gratis</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span>$<?= number_format($subtotal, 2) ?></span>
                        </div>
                        <a href="/lamerca_web/index.php?route=cart/checkout" class="btn btn-success w-100 mt-4">
                            <i class="fas fa-credit-card me-2"></i>Proceder al pago
                        </a>
                        <a href="/lamerca_web" class="btn btn-outline-primary w-100 mt-2">Seguir comprando</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
