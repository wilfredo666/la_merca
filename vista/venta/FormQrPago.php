<?php
require "../../controlador/salidaControlador.php";
require "../../modelo/salidaModelo.php";

$qr = ControladorSalida::ctrInfoUltimoQr();

?>

 <div class="modal-header bg-success">
  <h4 class="modal-title font-weight-light">Actualizar QR</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<form action="" id="FormEditQr" enctype="multipart/form-data">
  <div class="modal-body">

    <div class="form-group">
      <label for="exampleInputFile"><i class="fas fa-image me-2 text-secondary"></i> Imagen del QR</label>
      <div class="input-group">
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="imgQrPago" name="imgQrPago" onchange="previsualizarQr()">
          <label class="custom-file-label" for="imgQrPago">Elegir archivo</label>
          <input type="hidden" value="<?php echo $qr['id_metodopago']?>" name="id">
        </div>
        <div class="input-group-append">
          <span class="input-group-text">Actualizar</span>
        </div>
      </div>
    </div>
    
    <div class="form-group text-center">
      <img src="assest/dist/img/<?php echo $qr['img_metodo']?>" alt="" class="img-thumbnail previsualizarQr" width="200">
    </div>
  </div>
</form>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <button type="button" class="btn btn-primary" onclick="EditQr()">Guardar</button>
  </div>


