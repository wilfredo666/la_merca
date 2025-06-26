<?php
require "../../controlador/personalControlador.php";
require "../../modelo/personalModelo.php";

$id = $_GET["id"];
$personal = ControladorPersonal::ctrInfoPersonal($id);

?>
<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Información de Personal</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-8">
      <table class="table">
        <tr>
          <th>Nombre(s)</th>
          <td><?php echo $personal["nombre"]; ?></td>
        </tr>

        <tr>
          <th>Apellido Paterno</th>
          <td><?php echo $personal["ap_paterno"]; ?></td>
        </tr>

        <tr>
          <th>Apellido Materno</th>
          <td><?php echo $personal["ap_materno"]; ?></td>
        </tr>

        <tr>
          <th>Cédula Identidad</th>
          <td><?php echo $personal["ci_personal"]; ?></td>
        </tr>

        <tr>
          <th>Cargo Personal</th>
          <td><?php echo $personal["cargo"]; ?></td>
        </tr>

        <tr>
          <th>Telefono(s)</th>
          <td><?php echo $personal["telefono"]; ?></td>
        </tr>

        <tr>
          <th>Fecha de inicio</th>
          <td><?php echo $personal["fecha_inicio"]; ?></td>
        </tr>
        <tr>
          <th>Salario</th>
          <td><?php echo $personal["salario_personal"]; ?></td>
        </tr>
        <tr>
          <th>Ciudad</th>
          <td><?php echo $personal["ciudad_personal"]; ?></td>
        </tr>
        <tr>
          <th>Estado Personal</th>
          <?php
          if ($personal["estado_personal"] == 1) {
          ?>
          <td><span class="badge badge-success">Activo</span></td>
          <?php
          } else {
          ?>
          <td><span class="badge badge-danger">Inactivo</span></td>
          <?php
          }
          ?>
        </tr>

      </table>

    </div>
    <div class="col-sm-4 text-center">
      <img class="img-thumbnail" src="assest/dist/img/personal/<?php echo $personal['imagen_personal']; ?>" alt="" width="200">

     <hr>
      
      <img class="img-thumbnail" src="assest/dist/img/personal/<?php echo $personal['direccion']; ?>" alt="" width="200">
      <p>UBIACION</p>
    </div>
    <div class="col-sm-12">
      <table class="table">
        <tr>
          <th colspan="3" class="text-center">Persona de referencia</th>
        </tr>
        <tr>
          <th>Nombre(s)</th>


          <th>Telefono(s)</th>


          <th>Direccion</th>

        </tr>
        <tr>
          <td><?php echo $personal["persona_referencia"]; ?></td>
          <td><?php echo $personal["telefono_referencia"]; ?></td>
          <td><?php echo $personal["direccion_referencia"]; ?></td>
        </tr>
      </table>
    </div>
  </div>

</div>