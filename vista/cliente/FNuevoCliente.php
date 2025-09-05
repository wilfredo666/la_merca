<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Registrar nuevo Cliente</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form action="" id="FormRegCliente">
  <div class="modal-body">
    <div class="form-group">
      <label for="">Razon Social Cliente</label>
      <input type="text" class="form-control" id="rzCliente" name="rzCliente">
      <p id="error-login"></p>
    </div>
    <div class="form-group">
      <label for="">N.I.T. / C.I.</label>
      <input type="text" class="form-control" id="nitCliente" name="nitCliente">
    </div>
    <div class="form-group">
      <label for="">Dirección</label>
      <input type="text" class="form-control" id="dirCliente" name="dirCliente">
      <p class="text-danger" id="error-pass"></p>
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label for="">País</label>
        <input type="text" name="paisCliente" id="paisCliente" class="form-control" value="Bolivia" readonly>
        </div>
      <div class="form-group col-md-6">
        <label for="">Ciudad</label>
        <select name="ciudadCliente" id="ciudadCliente" class="form-control">
          <option value="">Seleccionar</option>
          <option value="La Paz">La Paz</option>
          <option value="Oruro">Oruro</option>
          <option value="Potosi">Potosi</option>
          <option value="Cochabamba">Cochabamba</option>
          <option value="Chuquisaca">Chuquisaca</option>
          <option value="Tarija">Tarija</option>
          <option value="Pando">Pando</option>
          <option value="Beni">Beni</option>
          <option value="Santa Cruz">Santa Cruz</option>
          <option value="Ninguno">Otros</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="">Nombre del Cliente</label>
      <input type="text" class="form-control" id="nomCliente" name="nomCliente">
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label for="">Teléfono del Cliente</label>
        <input type="text" class="form-control" id="telCliente" name="telCliente">
      </div>
      <div class="form-group col-md-6">
        <label for="">Porcentaje de Descuento</label>
        <div class="input-group mb-2">
          <input type="number" class="form-control" id="descuento" name="descuento" placeholder="Porcentaje de descuento">
          <div class="input-group-prepend">
            <span class="input-group-text"> %</span>
          </div>
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
  $(function() {
    $.validator.setDefaults({

      submitHandler: function() {
        RegCliente()
      }
    })
    $(document).ready(function() {
      $("#FormRegCliente").validate({
        rules: {
          rzCliente: {
            required: true,
            minlength: 5
          },
          nitCliente: {
            required: true,
          },
          telCliente: {
            required: true,
            minlength: 7
          }
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback')
          element.closest('.form-group').append(error)
        },

        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid')
          /* .is-invalid */
        },

        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid')
        }

      })
    })

  })

</script>