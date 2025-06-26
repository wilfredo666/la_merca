<?php
require "../../controlador/personalControlador.php";
require "../../modelo/personalModelo.php";

$id = $_GET["id"];
$personal = ControladorPersonal::ctrInfoPersonal($id);
?>
<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Editar Personal</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form action="" id="FormEditPersonal">
  <div class="modal-body row">
    <div class="form-group col-md-4">
      <label for="">Nombres</label>
      <input type="text" class="form-control" id="nomPersonal" name="nomPersonal" value="<?php echo $personal['nombre']; ?>">
      <input type="hidden" name="idPersonal" id="idPersonal" value="<?php echo $id; ?>">
    </div>
    <div class="form-group col-md-4">
      <label for="">Apellido Paterno</label>
      <input type="text" class="form-control" id="patPersonal" name="patPersonal" value="<?php echo $personal['ap_paterno']; ?>">
    </div>
    <div class="form-group col-md-4">
      <label for="">Apellido Materno</label>
      <input type="text" class="form-control" id="matPersonal" name="matPersonal" value="<?php echo $personal['ap_materno']; ?>">
    </div>
    <div class="form-group col-md-3">
      <label for="">C.I.</label>
      <input type="text" class="form-control" id="ciPersonal" name="ciPersonal" value="<?php echo $personal['ci_personal']; ?>">
    </div>
    <div class="form-group col-md-3">
      <label for="">Teléfono(s)</label>
      <input type="text" class="form-control" id="telPersonal" name="telPersonal" value="<?php echo $personal['telefono']; ?>">
    </div>
    <div class="form-group col-md-3">
      <label for="">Ciudad</label>
      <input type="text" class="form-control" id="ciudadPersonal" name="ciudadPersonal" value="<?php echo $personal['ciudad_personal']; ?>">
    </div>
    <div class="form-group col-md-3">
      <label for="">Estado <span class="text-muted">(Si aun trabaja o no )</span></label>
      <select name="estadoPersonal" id="estadoPersonal" class="form-control">
        <option value="1" <?php if ($personal["estado_personal"] == 1) : ?> selected <?php endif; ?>>Activo</option>
        <option value="0" <?php if ($personal["estado_personal"] == 0) : ?> selected <?php endif; ?>>Inactivo</option>
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="">Departamento<span class="text-muted"> (Area de trabajo)</span></label>
      <input type="text" class="form-control" id="depPersonal" name="depPersonal" value="<?php echo $personal['departamento']; ?>">
    </div>
    <div class="form-group col-md-3">
      <label for="">Cargo</label>
      <input type="text" class="form-control" id="cargoPersonal" name="cargoPersonal" value="<?php echo $personal['cargo']; ?>">
    </div>

    <div class="form-group col-md-3">
      <label for="">Fecha de inicio</label>
      <input type="date" class="form-control" id="fechaInicio" name="fechaInicio"  value="<?php echo $personal['fecha_inicio']; ?>">
    </div>

    <div class="form-group col-md-3">
      <label for="">Salario (Bs)</label>
      <input type="number" class="form-control" id="salarioPersonal" name="salarioPersonal"  value="<?php echo $personal['salario_personal']; ?>">
    </div>

    <div class="form-group col-md-3">
      <label for="">Dirección <span class="text-muted">(Cargar QR de la ubicacion)</span></label>
      <input type="file" class="form-control" id="dirPersonal" name="dirPersonal" onchange="previsualizarID()" accept="image/png, image/jpeg">
      <input type="hidden" id="dirPerAntiguo" name="dirPerAntiguo" value="<?php echo $personal['direccion']; ?>">
    </div>
    <div class="form-group col-md-3 text-center">
      <img class="img-thumbnail previsualizarID" src="assest/dist/img/personal/<?php echo $personal['direccion']; ?>" alt="" width="100">
    </div>
    <div class="form-group col-md-3">
      <label for="">Imagen <span class="text-muted">(Cargar foto de la persona)</span></label>
      <input type="file" class="form-control" id="imgPersonal" name="imgPersonal" onchange="previsualizarIP()" accept="image/png, image/jpeg">
      <input type="hidden" id="imgPerAntiguo" name="imgPerAntiguo" value="<?php echo $personal['imagen_personal']; ?>">
    </div>
    <div class="form-group col-md-3 text-center">
      <img class="img-thumbnail previsualizarIP" src="assest/dist/img/personal/<?php echo $personal['imagen_personal']; ?>" alt="" width="100">
    </div>

    <div class="col-md-12">
      <h6 class="text-uppercase text-muted text-center">-------- Persona de referencia -------- </h6>
    </div>


    <div class="form-group col-md-4">
      <label for="">Nombre(s)</label>
      <input type="text" class="form-control" id="personaRef" name="personaRef"  value="<?php echo $personal['persona_referencia']; ?>">
    </div>
    <div class="form-group col-md-4">
      <label for="">Telefono</label>
      <input type="text" class="form-control" id="telefonoRef" name="telefonoRef"  value="<?php echo $personal['telefono_referencia']; ?>">
    </div>
    <div class="form-group col-md-4">
      <label for="">Dirección</label>
      <input type="text" class="form-control" id="direccionRef" name="direccionRef"  value="<?php echo $personal['direccion_referencia']; ?>">
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
        EditPersonal()
      }
    })
    $(document).ready(function() {
      $("#FormEditPersonal").validate({
        rules: {
          nomPersonal: {
            required: true,
            minlength: 3
          },
          ciPersonal: {
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