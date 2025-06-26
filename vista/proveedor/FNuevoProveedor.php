<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Registrar nuevo Proveedor</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form action="" id="FormRegProveedor">
  <div class="modal-body row">
    <div class="form-group col-md-6">
      <label for="">Nombre Empresa</label>
      <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa">
    </div>
    <div class="form-group col-md-6">
      <label for="">Nombre(s)</label>
      <input type="text" class="form-control" id="nombre_pro" name="nombre_pro">
    </div>
    <div class="form-group col-md-6">
      <label for="">Apellido Paterno</label>
      <input type="text" class="form-control" id="ap_paterno_pro" name="ap_paterno_pro">
    </div>
    <div class="form-group col-md-6">
      <label for="">Apellido Materno</label>
      <input type="text" class="form-control" id="ap_materno_pro" name="ap_materno_pro">
    </div>
    <div class="form-group col-md-6">
      <label for="">C.I./NIT</label>
      <input type="text" class="form-control" id="ci_proveedor" name="ci_proveedor">
    </div>
    <div class="form-group col-md-6">
      <label for="">Teléfono</label>
      <input type="text" class="form-control" id="telefono_pro" name="telefono_pro">
    </div>
    <div class="form-group col-md-6">
      <label for="">Dirección</label>
      <input type="text" class="form-control" id="direccion_pro" name="direccion_pro">
    </div>

  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary" id="guardar">Guardar</button>
  </div>
</form>


<script>
  $(function() {
    $.validator.setDefaults({
      submitHandler: function() {
        RegProveedor()
      }
    })
    $(document).ready(function() {
      $("#FormRegProveedor").validate({
        rules: {
          nombre_empresa: {
            required: true,
            minlength: 3
          },
          nombre_pro: {
            required: true,
            minlength: 3
          },
          ci_proveedor: {
            required: true,
          }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback')
          element.closest('.form-group').append(error)
        },

        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid')
        },

        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid')
        }

      })
    })

  })

</script>