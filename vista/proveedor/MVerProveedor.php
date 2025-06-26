<?php
require "../../controlador/proveedorControlador.php";
require "../../modelo/proveedorModelo.php";

$id = $_GET["id"];
$proveedor = ControladorProveedor::ctrInfoProveedor($id);

?>
<style>
  .col-md-6{
    margin-top:15px;
  }
</style>
<div class="modal-header bg-primary text-white">
  <h5 class="modal-title" id="proveedorModalLabel"><i class="fas fa-user-tie me-2"></i> Datos del Proveedor</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="modal-body">
  <div class="row g-3">
    <div class="col-md-6"><i class="fas fa-building me-2 text-secondary"></i><strong> Empresa:</strong> <?php echo $proveedor["nombre_empresa"]; ?></div>
    <div class="col-md-6"><i class="fas fa-id-card me-2 text-secondary"></i><strong> C.I./NIT:</strong> <?php echo $proveedor["ci_proveedor"]; ?></div>
    <div class="col-md-6"><i class="fas fa-phone-alt me-2 text-secondary"></i><strong> Contacto:</strong> <?php echo $proveedor["telefono_pro"]; ?></div>
    <div class="col-md-6"><i class="fas fa-user me-2 text-secondary"></i><strong> Nombre:</strong> <?php echo $proveedor["nombre_pro"]; ?></div>
    <div class="col-md-6"><i class="fas fa-user-tag me-2 text-secondary"></i><strong> Apellido Paterno:</strong> <?php echo $proveedor["ap_paterno_pro"]; ?></div>
    <div class="col-md-6"><i class="fas fa-user-tag me-2 text-secondary"></i><strong> Apellido Materno:</strong> <?php echo $proveedor["ap_materno_pro"]; ?></div>
    <div class="col-md-6"><i class="fas fa-check-circle me-2 text-success"></i><strong> Estado:</strong>   <?php
      if ($proveedor["estado_pro"] == 1) {
      ?>
      <td><span class="badge badge-success">Activo</span></td>
      <?php
      } else {
      ?>
      <td><span class="badge badge-danger">Inactivo</span></td>
      <?php
      }
      ?></div>
    <div class="col-md-6"><i class="fas fa-map-marker-alt me-2 text-secondary"></i><strong> Dirección:</strong> <?php echo $proveedor["direccion_pro"]; ?></div>
  </div>
</div>
