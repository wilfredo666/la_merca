<?php
require "../../controlador/almacenControlador.php";
require "../../modelo/almacenModelo.php";

$id = $_GET["id"];
$almacen = ControladorAlmacen::ctrInfoAlmacen($id);
?>
<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Editar Almacen</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form action="" id="FormEditAlmacen">
  <div class="modal-body">
    <div class="form-group">
      <label for="">Nombre de Almacen</label>
      <input type="text" class="form-control" id="nomAlmacen" name="nomAlmacen" value="<?php echo $almacen["nombre_almacen"];?>" readonly>
      <input type="hidden" name="idAlmacen" value="<?php echo $almacen["id_almacen"];?>">
    </div>
    <div class="form-group">
      <label for="">Descripcion</label>
      <input type="text" class="form-control" id="descAlmacen" name="descAlmacen" value="<?php echo $almacen["descripcion"];?>">
    </div>
    <div class="form-group">
      <label for=""><i class="fas fa-map-marker-alt me-2 text-secondary"></i> Dirección</label>
      <input type="text" class="form-control" id="dirAlmacen" name="dirAlmacen" value="<?php echo $almacen["direccion"];?>">
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label for="">Encargado</label>
        <input type="text" class="form-control" id="encargado" name="encargado" value="<?php echo $almacen["encargado"];?>">
      </div>
      <div class="form-group col-md-6">
        <label for=""><i class="fas fa-phone-alt me-2 text-secondary"></i> Contacto(s)</label>
        <input type="text" class="form-control" id="contacto" name="contacto" value="<?php echo $almacen["contacto"];?>">
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" id="disponible" name="estado" value="1" <?php if($almacen["estado_almacen"]==1):?>checked<?php endif;?>>
          <label for="disponible" class="custom-control-label">Activo</label>
        </div>
      </div>
      <div class="col-sm-6">

        <div class="custom-control custom-radio">
          <input class="custom-control-input" type="radio" id="nodisponible" name="estado" value="0" <?php if($almacen["estado_almacen"]==0):?>checked<?php endif;?>>
          <label for="nodisponible" class="custom-control-label">Inactivo</label>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary" id="guardar">Guardar</button>
  </div>
</form>


<script>
  $(function(){
    $.validator.setDefaults({

      submitHandler:function(){
        EditAlmacen()
      }
    })
    $(document).ready(function(){
      $("#FormEditAlmacen").validate({
        rules:{
          nomAlmacen:{
            required:true
          }

        },
        errorElement:'span',
        errorPlacement:function(error, element){
          error.addClass('invalid-feedback')
          element.closest('.form-group').append(error)
        },

        highlight: function(element, errorClass, validClass){
          $(element).addClass('is-invalid')
          /* .is-invalid */
        },

        unhighlight: function(element, errorClass, validClass){
          $(element).removeClass('is-invalid')
        }

      })
    })

  })

</script>