<?php
require "../../controlador/usuarioControlador.php";
require "../../modelo/usuarioModelo.php";

$id = $_GET["id"];
$usuario = ControladorUsuario::ctrInfoUsuario($id);
?>
<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Editar Usuario</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form action="" id="FormEditUsuario">
  <div class="modal-body">
    <div class="form-group">
      <label for="">Nombre de usuario</label>
      <input type="text" class="form-control" id="nomUsuario" name="nomUsuario" value="<?php echo $usuario["nombre"]; ?>">
    </div>
        <div class="form-group">
      <label for="">E-mail</label>
      <input type="email" class="form-control" id="emailUsuario" name="emailUsuario" value="<?php echo $usuario["email"]; ?>" readonly>
      <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $id; ?>">
    </div>
    <div class="form-group">
      <label for="">Password</label>
      <input type="password" class="form-control" id="passUsuario" name="passUsuario" value="<?php echo $usuario["password"]; ?>">
      <p class="text-danger" id="error-pass"></p>
    </div>
    <div class="form-group">
      <label for="">Repetir Password</label>
      <input type="password" class="form-control" id="passUsuario2" name="passUsuario2" value="<?php echo $usuario["password"]; ?>">

      <input type="hidden" id="passActual" name="passActual" value="<?php echo $usuario["password"]; ?>">

    </div>
    
    <div class="form-group">
      <label for="">Categoria</label>
      <select name="catUsuario" id="catUsuario" class="form-control">
        <option value="Administrador" <?php if ($usuario["categoria"] == "Administrador") : ?>selected<?php endif; ?>>Administrador</option>
        <option value="Encargado" <?php if ($usuario["categoria"] == "Encargado") : ?>selected<?php endif; ?>>Encargado</option>
      </select>
    </div>
  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary">Actualizar</button>
  </div>
</form>



<script>
  $(function() {
    $.validator.setDefaults({
      submitHandler: function() {
        EditUsuario()
      }
    })
    $(document).ready(function() {
      $("#FormEditUsuario").validate({
        rules: {
          nomUsuario: {
            required: true,
            minlength: 3
          },
          passUsuario: {
            required: true,
            minlength: 8
          },
          passUsuario2:{
            required: true,
            equalTo: "#passUsuario"
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