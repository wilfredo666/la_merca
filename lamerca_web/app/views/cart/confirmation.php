<?php
/** @var string $nombre */
/** @var string $apellidoPaterno */
/** @var string $apellidoMaterno */
/** @var string $nitCi */
/** @var string $direccion */
/** @var string $telefonos */
/** @var string $metodoPago */
/** @var array $cartItems */
/** @var string|null $codVenta */
/** @var int|null $ventaId */
/** @var string|null $detalleVentaJson */
/** @var float|null $total */
?>
<section class="py-2">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-5 text-center">
            <div class="display-1 text-success mb-3">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="h3 fw-bold mb-3">¡Pedido confirmado!</h1>
            <p class="text-muted mb-4">Tu solicitud fue registrada correctamente. A continuación te mostramos los datos de la factura que se generará.</p>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card bg-light border-0 text-start">
                        <div class="card-body">
                            <h2 class="h5 mb-3">Datos de la Compra</h2>
                            <p class="mb-2"><strong>Nombre:</strong> <?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($apellidoPaterno, ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($apellidoMaterno, ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="mb-2"><strong>NIT/CI:</strong> <?= htmlspecialchars($nitCi, ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="mb-2"><strong>Dirección:</strong> <?= htmlspecialchars($direccion, ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="mb-2"><strong>Teléfonos:</strong> <?= htmlspecialchars($telefonos, ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="mb-2"><strong>Método de pago:</strong> <?= htmlspecialchars($metodoPago, ENT_QUOTES, 'UTF-8') ?></p>
                            <?php if (!empty($codVenta)): ?>
                                <hr>
                                <p class="mb-2"><strong>Código de compra:</strong> <?= htmlspecialchars($codVenta, ENT_QUOTES, 'UTF-8') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($detalleVentaJson)): ?>
                <?php $items = json_decode($detalleVentaJson, true) ?: []; ?>
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h5">Detalle de la Compra</h2>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th class="text-end">Cant.</th>
                                                <th class="text-end">Precio</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($items as $it): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars((string) ($it['descripcion'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                                                    <td class="text-end"><?= (int) ($it['cantidad'] ?? 0) ?></td>
                                                    <td class="text-end">$<?= number_format((float) ($it['precioUnitario'] ?? 0), 2) ?></td>
                                                    <td class="text-end">$<?= number_format((float) ($it['subtotal'] ?? 0), 2) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="text-end">Total</th>
                                                <th class="text-end">$<?= number_format((float) ($total ?? 0), 2) ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <a href="/lamerca_web" class="btn btn-secondary">Volver a la tienda</a>
                                    <?php if (!empty($ventaId)): ?>
                                        <a href="/lamerca_web/print_order.php?venta_id=<?= (int) $ventaId ?>" target="_blank" class="btn btn-primary">Imprimir ticket</a>
                                    <?php else: ?>
                                        <button class="btn btn-primary" onclick="window.location.href = '/lamerca_web/print_order.php?venta_id=' + encodeURIComponent(<?= json_encode($ventaId) ?>);">Imprimir ticket</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mt-4">
                
            </div>
        </div>
    </div>
</section>
