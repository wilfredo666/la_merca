<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Registrar nuevo Almacen</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form action="" id="FormRegAlmacen">
  <div class="modal-body">
    <div class="form-group">
      <label for="">Nombre de Almacen</label>
      <input type="text" class="form-control" id="nomAlmacen" name="nomAlmacen">
    </div>
    <div class="form-group">
      <label for="">Descripcion</label>
      <input type="text" class="form-control" id="descAlmacen" name="descAlmacen">
    </div>
    <div class="form-group">
      <label for=""><i class="fas fa-map-marker-alt me-2 text-secondary"></i> Dirección</label>
      <input type="text" class="form-control" id="dirAlmacen" name="dirAlmacen">
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label for="">Encargado</label>
        <input type="text" class="form-control" id="encargado" name="encargado">
      </div>
      <div class="form-group col-md-6">
        <label for=""><i class="fas fa-phone-alt me-2 text-secondary"></i> Contacto(s)</label>
        <input type="text" class="form-control" id="contacto" name="contacto">
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
        RegAlmacen()
      }
    })
    $(document).ready(function(){
      $("#FormRegAlmacen").validate({
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