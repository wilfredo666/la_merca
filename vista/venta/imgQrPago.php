<?php
require "../../controlador/salidaControlador.php";
require "../../modelo/salidaModelo.php";

$qr = ControladorSalida::ctrInfoUltimoQr();

?>

<div class="modal-header bg-info text-white">
  <h5 class="modal-title">
    <i class="fas fa-qrcode mr-2"></i> Pago por QR
  </h5>
  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="modal-body text-center">
  <?php if (!empty($qr['img_metodo'])): ?>
    <img 
      src="assest/dist/img/<?php echo htmlspecialchars($qr['img_metodo']); ?>" 
      alt="Código QR de pago" 
      class="img-fluid img-thumbnail shadow-sm" 
      style="max-width: 300px;"
    >
    <p class="mt-3 text-muted">
      Escanea este código para realizar tu pago de forma segura.
    </p>
  <?php else: ?>
    <div class="alert alert-warning" role="alert">
      <i class="fas fa-exclamation-triangle"></i> No hay imagen de QR disponible.
    </div>
  <?php endif; ?>
</div>
