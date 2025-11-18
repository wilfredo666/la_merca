<?php

require_once "../../controlador/salidaControlador.php";
require_once "../../modelo/salidaModelo.php";

$id = $_GET["id"];

$factura = ControladorSalida::ctrInfoFactura($id);
$productos = json_decode($factura["detalle_venta"], true);
?>
<div class="modal-header">
  <h4 class="modal-title">
  <i class="fas fa-cash-register mr-2"></i>
  Información de Nota de Venta
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
          <th>Codigo</th>
          <td><?php echo $factura["codigo_venta"]; ?></td>
        </tr>

        <tr>
          <th>Cliente</th>
          <td><?php echo $factura["razon_social_cliente"]; ?></td>
        </tr>

        <tr>
          <th>Fecha</th>
          <td><?php echo $factura["create_at"]; ?></td>
        </tr>

        <tr>
          <th>Emitido por</th>
          <td><?php echo $factura["nombre"]; ?></td>
        </tr>

        <tr>
          <th>Estado</th>
          <td><?php
              if ($factura["estado_venta"] == 0) {
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
          <th>#</th>
          <th>Codigo</th>
          <th>Nombre</th>
          <th>Cantidad</th>
          <th>Precio U.</th>
          <th>Total</th>
        </thead>
        <tbody>
          <?php
          $total = 0;
          $contador = 1;
          foreach ($productos as $value) {
          ?>
            <tr>
              <td><?php echo $contador++; ?></td>
              <td><?php echo $value["codigoProducto"]; ?></td>
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
            <td colspan="5"><b>Total</b></td>
            <td><b><?php echo $total; ?></b></td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>

</div>