<?php
require "../../controlador/personalControlador.php";
require "../../modelo/personalModelo.php";

$id = $_GET["id"];
$personal = ControladorPersonal::ctrInfoPersonal($id);

?>
<style>
  .col-md-6{
    margin-top:15px;
  }
</style>
<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Información de Personal</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">

    <div class="col-sm-12 text-center">
      <?php
      if($personal['imagen_personal']==""){
      ?>
      <img class="img-thumbnail" src="assest/dist/img/user.jpg" alt="" width="200">
      <?php
      }else{
      ?>
      <img class="img-thumbnail" src="assest/dist/img/personal/<?php echo $personal['imagen_personal']; ?>" alt="" width="200">
      <?php
      }
      ?>

    </div>

    <div class="col-md-6"><i class="fas fa-id-card me-2 text-secondary"></i><strong> C.I.:</strong> <?php echo $personal["ci_personal"]; ?></div>
    <div class="col-md-6"><i class="fas fa-phone-alt me-2 text-secondary"></i><strong> Telefono:</strong> <?php echo $personal["telefono"]; ?></div>
    <div class="col-md-6"><i class="fas fa-user me-2 text-secondary"></i><strong> Nombre(s):</strong> <?php echo $personal["nombre"]; ?></div>
    <div class="col-md-6"><i class="fas fa-user-tag me-2 text-secondary"></i><strong> Apellido Paterno:</strong> <?php echo $personal["ap_paterno"]; ?></div>
    <div class="col-md-6"><i class="fas fa-user-tag me-2 text-secondary"></i><strong> Apellido Materno:</strong> <?php echo $personal["ap_materno"]; ?></div>
    <div class="col-md-6"><i class="fas fa-calendar me-2 text-secondary"></i><strong> Fecha de inicio:</strong> <?php echo $personal["fecha_inicio"]; ?></div>
    <div class="col-md-6"><i class="fas fa-briefcase me-2 text-secondary"></i><strong> Cargo:</strong> <?php echo $personal["cargo"]; ?></div>

    <div class="col-md-6"><i class="fas fa-money-bill-wave-alt me-2 text-secondary"></i><strong> Salario:</strong> <?php echo $personal["salario_personal"]; ?></div>

    <div class="col-md-6"><i class="fas fa-building me-2 text-secondary"></i><strong> Ciudad:</strong> <?php echo $personal["ciudad_personal"]; ?></div>

    <div class="col-md-6"><i class="fas fa-check-circle me-2 text-success"></i><strong> Estado:</strong>   <?php
      if ($personal["estado_personal"] == 1) {
      ?>
      <td><span class="badge badge-success">Activo</span></td>
      <?php
      } else {
      ?>
      <td><span class="badge badge-danger">Inactivo</span></td>
      <?php
      }
      ?></div>

    <div class="col-md-6"><i class="fas fa-map-marker-alt me-2 text-secondary"></i><strong> Dirección:</strong> <?php echo $personal["direccion"]; ?></div>


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