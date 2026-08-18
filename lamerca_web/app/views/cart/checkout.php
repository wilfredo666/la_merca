<?php

/** @var array $cartItems */
/** @var float $subtotal */
/** @var int $itemCount */
/** @var string $qrImageName */
$qrImageName = $qrImageName ?? '';
?>
<section class="py-2">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Finalizar compra</h1>
        <p class="text-muted mb-0">Completa tus datos para generar la factura y elegir cómo pagar.</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 mb-4">Datos para la factura</h2>
                    <form action="/lamerca_web/index.php?route=cart/confirm" method="post">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Apellido paterno</label>
                                <input type="text" class="form-control" name="apellido_paterno">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Apellido materno</label>
                                <input type="text" class="form-control" name="apellido_materno">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIT/CI <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nit_ci" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfonos de contacto <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="telefonos" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="direccion">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Método de pago <span class="text-danger">*</span></label>
                                <select class="form-select" name="metodo_pago" id="paymentMethodSelect" required>
                                    <option value="">Selecciona una opción</option>
                                    <option value="QR">Pago con QR</option>
                                    <option value="contrareembolso">Contra Reembolso</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="d-flex flex-column align-items-center" style="height: 100%;">
                                        <img id="paymentQrImage" src="" alt="QR de pago" class="img-fluid rounded shadow-sm mb-2" style="display: none; max-width: 320px;" data-default-src="https://lamercabolivia.com/assest/dist/img/qr_default.png">
                                    </div>
                                    <p id="paymentQrLabel" class="small text-muted mb-0" style="display: none;">Escanea el código QR para pagar.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <a href="/lamerca_web/index.php?route=cart" class="btn btn-outline-secondary">Volver al carrito</a>
                            <button type="submit" class="btn btn-success">Confirmar pedido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            const qrImageName = <?= json_encode($qrImageName, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
            (function() {
                const select = document.getElementById('paymentMethodSelect');
                const qrImage = document.getElementById('paymentQrImage');
                const qrLabel = document.getElementById('paymentQrLabel');
                const qrDefaultSrc = qrImage.dataset.defaultSrc || 'https://lamercabolivia.com/assest/dist/img/qr_default.png';

                qrImage.onerror = function() {
                    if (qrImage.src && !qrImage.dataset.fallbackUsed) {
                        qrImage.dataset.fallbackUsed = 'true';
                        qrImage.src = qrDefaultSrc;
                    } else {
                        qrImage.style.display = 'none';
                        qrLabel.style.display = 'none';
                    }
                };

                function updateQr() {
                    const selected = select.selectedOptions[0];
                    if (!selected) {
                        qrImage.style.display = 'none';
                        qrLabel.style.display = 'none';
                        qrImage.src = '';
                        delete qrImage.dataset.fallbackUsed;
                        return;
                    }

                    const value = selected.value || '';

                    if (value === 'QR' && qrImageName) {
                        qrImage.dataset.fallbackUsed = '';
                        qrImage.src = 'https://lamercabolivia.com/assest/dist/img/' + encodeURIComponent(qrImageName);
                        qrImage.style.display = 'block';
                        qrLabel.style.display = 'block';
                    } else {
                        qrImage.style.display = 'none';
                        qrLabel.style.display = 'none';
                        qrImage.src = '';
                        delete qrImage.dataset.fallbackUsed;
                    }
                }

                select.addEventListener('change', updateQr);
                updateQr();
            })();
        </script>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Resumen del pedido</h2>
                    <?php foreach ($cartItems as $item): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?= htmlspecialchars((string) $item['name'], ENT_QUOTES, 'UTF-8') ?> x<?= (int) $item['qty'] ?></span>
                            <span>$<?= number_format((float) $item['price'] * (int) $item['qty'], 2) ?></span>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span>$<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="alert alert-info mt-4 mb-0">
                        <i class="fas fa-info-circle me-2"></i>Tu pedido se registrará con los datos que ingreses aquí.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>