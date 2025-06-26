<?php
require_once "../../controlador/usuarioControlador.php";
require_once "../../modelo/usuarioModelo.php";

$id=$_GET["id"];

$respuesta=ControladorUsuario::ctrInfoUsuario($id);

?>
 <div class="modal-header">
  <h4 class="modal-title">Editar Usuario</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form class="form-horizontal" id="FEditUsuario">
  <div class="modal-body">

    <div class="card-body">
      <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Login</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="login" name="login" value="<?php echo $respuesta["login_usuario"];?>" readonly>
          <input type="hidden" value="<?php echo $id;?>" name="idUsuario">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $respuesta["password"];?>">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10">
          <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirmar Password" value="<?php echo $respuesta["password"];?>">
          <input type="hidden" value="<?php echo $respuesta["password"];?>" name="passActual">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Perfil</label>
        <div class="col-sm-10">
          <select name="perfil" id="perfil" class="form-control">
            <option value="Moderador" <?php if($respuesta["perfil"]=="Moderador"):?>selected<?php endif;?> >Moderador</option>
            <option value="Administrador" <?php if($respuesta["perfil"]=="Administrador"):?>selected<?php endif;?>>Administrador</option>
          </select>
        </div>
      </div>
    </div>

    <!-- /.card-footer -->

  </div>
  <div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="submit" class="btn btn-primary">Guardar</button>
  </div>
</form>
<script>
  $(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        editUsuario()
      }
    });
    $('#FEditUsuario').validate({
      rules: {
        password: {
          required: true,
          minlength: 5
        },
        password2: {
          required: true,
          equalTo: "#password"
        },
      },

      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });
</script>


