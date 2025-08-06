<?php

require_once "../../controlador/ingresoControlador.php";
require_once "../../modelo/ingresoModelo.php";

$id = $_GET["id"];

$notaIngreso = ControladorIngreso::ctrInfoIngreso($id);
$productos = json_decode($notaIngreso["detalle_oi"], true);
?>
<div class="modal-header">
  <h4 class="modal-title">
  <i class="fas fas fa-arrow-left mr-2"></i>
  Información de Nota de Ingreso
  </h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-6">

      <table class="table">
        <tr>
          <th>Código</th>
          <td><?php echo $notaIngreso["codigo_oi"]; ?></td>
        </tr>

        <tr>
          <th>Concepto</th>
          <td><?php echo $notaIngreso["concepto_oi"]; ?></td>
        </tr>

       <tr>
          <th>Observación</th>
          <td><?php echo $notaIngreso["observacion_oi"]; ?></td>
        </tr>
        
        <tr>
          <th>Fecha</th>
          <td><?php echo $notaIngreso["create_at"]; ?></td>
        </tr>

        <tr>
          <th>Emitido por</th>
          <td><?php echo $notaIngreso["nombre"]; ?></td>
        </tr>

        <tr>
          <th>Estado</th>
          <td><?php
              if ($notaIngreso["estado_oi"] == 0) {
              ?>
              <span class="badge badge-danger">Anulado</span>
            <?php
              } else {
            ?>
              <span class="badge badge-success">Emitido</span>
            <?php
              } ?>
          </td>
        </tr>

      </table>

    </div>
    <div class="col-sm-6">
      <table class="table">
        <thead class="bg-gradient-dark">
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Precio U.</th>
          <th>Total</th>
        </thead>
        <tbody>
          <?php
          $total = 0;
          foreach ($productos as $value) {
          ?>
            <tr>
              <td><?php echo $value["descripcion"]; ?></td>
              <td><?php echo $value["cantidad"]; ?></td>
              <td><?php echo $value["precioUnitario"]; ?></td>
              <td><?php echo $value["subtotal"]; ?></td>
            </tr>
          <?php
            $total = $total + $value["subtotal"];
          }
          ?>
          <tr>
            <td colspan="3"><b>Total</b></td>
            <td><?php echo $total; ?></td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>

</div>