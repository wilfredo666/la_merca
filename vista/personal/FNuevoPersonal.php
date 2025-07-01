<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Registrar nuevo Personal</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form action="" id="FormRegPersonal">
  <div class="modal-body row">
    <div class="form-group col-md-4">
      <label for="">Nombre(s)</label>
      <input type="text" class="form-control" id="nomPersonal" name="nomPersonal">
    </div>
    <div class="form-group col-md-4">
      <label for="">Apellido Paterno</label>
      <input type="text" class="form-control" id="patPersonal" name="patPersonal">
    </div>
    <div class="form-group col-md-4">
      <label for="">Apellido Materno</label>
      <input type="text" class="form-control" id="matPersonal" name="matPersonal">
    </div>
    <div class="form-group col-md-4">
      <label for="">C.I.</label>
      <input type="text" class="form-control" id="ciPersonal" name="ciPersonal">
    </div>
    <div class="form-group col-md-4">
      <label for="">Teléfono(s)</label>
      <input type="text" class="form-control" id="telPersonal" name="telPersonal">
    </div>
    <div class="form-group col-md-4">
      <label for="">Ciudad</label>
      <input type="text" class="form-control" id="ciudadPersonal" name="ciudadPersonal">
    </div>
    <div class="form-group col-md-6">
      <label for="">Dirección</label>
      <input type="text" class="form-control" id="dirPersonal" name="dirPersonal">
    </div>    
    <div class="form-group col-md-6">
      <label for="">Imagen <span class="text-muted">(Cargar foto de la persona)</span></label>
      <input type="file" class="form-control" id="imgPersonal" name="imgPersonal">
    </div>
    <div class="form-group col-md-6">
      <label for="">Cargo</label>
      <input type="text" class="form-control" id="cargoPersonal" name="cargoPersonal">
    </div>
    <div class="form-group col-md-3">
      <label for="">Fecha de inicio</label>
      <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
    </div>

    <div class="form-group col-md-3">
      <label for="">Salario (Bs)</label>
      <input type="number" class="form-control" id="salarioPersonal" name="salarioPersonal">
    </div>

    <div class="col-md-12">
      <h6 class="text-uppercase text-muted text-center">-------- Persona de referencia -------- </h6>
    </div>
    

    <div class="form-group col-md-4">
      <label for="">Nombre(s)</label>
      <input type="text" class="form-control" id="personaRef" name="personaRef">
    </div>
    <div class="form-group col-md-4">
      <label for="">Telefono</label>
      <input type="text" class="form-control" id="telefonoRef" name="telefonoRef">
    </div>
    <div class="form-group col-md-4">
      <label for="">Dirección</label>
      <input type="text" class="form-control" id="direccionRef" name="direccionRef">
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
        RegPersonal()
      }
    })
    $(document).ready(function() {
      $("#FormRegPersonal").validate({
        rules: {
          nomPersonal: {
            required: true,
            minlength: 3
          },
          ciPersonal: {
            required: true,
          },
          dirPersonal: {
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