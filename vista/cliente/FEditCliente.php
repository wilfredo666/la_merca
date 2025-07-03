<?php
require "../../controlador/clienteControlador.php";
require "../../modelo/clienteModelo.php";

$id = $_GET["id"];
$cliente = ControladorCliente::ctrInfoCliente($id);
?>
<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Editar Cliente</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form action="" id="FormEditCliente">
  <div class="modal-body">
    <div class="form-group">
      <label for="">Razon Social Cliente</label>
      <input type="text" class="form-control" id="rzCliente" name="rzCliente" value="<?php echo $cliente["razon_social_cliente"]; ?>">
      <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $id; ?>">
    </div>
    <div class="form-group">
      <label for="">N.I.T. / C.I.</label>
      <input type="text" class="form-control" id="nitCliente" name="nitCliente" value="<?php echo $cliente["nit_ci_cliente"]; ?>">
    </div>
    <div class="form-group">
      <label for="">Dirección</label>
      <input type="text" class="form-control" id="dirCliente" name="dirCliente" value="<?php echo $cliente["direccion_cliente"]; ?>">
      <p class="text-danger" id="error-pass"></p>
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label for="">Pais</label>
        <input type="text" name="paisCliente" id="paisCliente" class="form-control" value="<?php echo $cliente["pais_cliente"]; ?>">
      </div>
      <div class="form-group col-md-6">
        <label for="">Ciudad</label>
        <select name="ciudadCliente" id="ciudadCliente" class="form-control">
          <option value="">Seleccionar</option>
          <option value="La Paz" <?php if ($cliente["ciudad_cliente"] == "La Paz") : ?>selected<?php endif; ?>>La Paz</option>
          <option value="Oruro" <?php if ($cliente["ciudad_cliente"] == "Oruro") : ?>selected<?php endif; ?>>Oruro</option>
          <option value="Potosi" <?php if ($cliente["ciudad_cliente"] == "Potosi") : ?>selected<?php endif; ?>>Potosi</option>
          <option value="Cochabamba" <?php if ($cliente["ciudad_cliente"] == "Cochabamba") : ?>selected<?php endif; ?>>Cochabamba</option>
          <option value="Chuquisaca" <?php if ($cliente["ciudad_cliente"] == "Chuquisaca") : ?>selected<?php endif; ?>>Chuquisaca</option>
          <option value="Tarija" <?php if ($cliente["ciudad_cliente"] == "Tarija") : ?>selected<?php endif; ?>>Tarija</option>
          <option value="Pando" <?php if ($cliente["ciudad_cliente"] == "Pando") : ?>selected<?php endif; ?>>Pando</option>
          <option value="Beni" <?php if ($cliente["ciudad_cliente"] == "Beni") : ?>selected<?php endif; ?>>Beni</option>
          <option value="Santa Cruz" <?php if ($cliente["ciudad_cliente"] == "Santa Cruz") : ?>selected<?php endif; ?>>Santa Cruz</option>
          <option value="Ninguno" <?php if ($cliente["ciudad_cliente"] == "Ninguno") : ?>selected<?php endif; ?>>Otros</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="">Nombre del Cliente</label>
      <input type="text" class="form-control" id="nomCliente" name="nomCliente" value="<?php echo $cliente["nombre_cliente"]; ?>">
    </div>
    <div class="row">
      <div class="form-group col-sm-6">
        <label for="">Teléfono del Cliente</label>
        <input type="text" class="form-control" id="telCliente" name="telCliente" value="<?php echo $cliente["telefono_cliente"]; ?>">
      </div>
      <div class="form-group col-md-6 ">
        <label for="">Porcentaje de Descuento</label>
        <div class="input-group mb-2">
          <input type="number" class="form-control" id="descuento" name="descuento" value="<?php echo $cliente["descuento"]; ?>">
          <div class="input-group-prepend">
            <span class="input-group-text"> %</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <!-- <button type="button" class="btn btn-primary" onclick="Editcliente()">Guardar</button> -->
    <button type="submit" class="btn btn-primary">Actualizar</button>
  </div>
</form>

<script>
  $(function() {
    $.validator.setDefaults({
      submitHandler: function() {
        EditCliente()
      }
    })
    $(document).ready(function() {
      $("#FormEditCliente").validate({
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