<?php

require_once "../../controlador/salidaControlador.php";
require_once "../../modelo/salidaModelo.php";

$id = $_GET["id"];

$factura = ControladorSalida::ctrInfoVentaWeb($id);
$productos = json_decode($factura["detalle_venta_tienda"], true);
$cliente = json_decode($factura["detalle_datos_factura"], true);
?>
<div class="modal-header">
  <h4 class="modal-title">
    <i class="fas fa-cash-register mr-2"></i>
    Información de Nota de Venta hecha en el sitio Web
  </h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-4">

      <table class="table">
        <tr>
          <th>Codigo</th>
          <td><?php echo $factura["cod_venta_tienda"]; ?></td>
        </tr>

        <tr>
          <th>Fecha</th>
          <td><?php echo $factura["create_at"]; ?></td>
        </tr>

        <tr>
          <th>Cliente</th>
          <td><?php echo $cliente["nombre"]." ".$cliente["apellido_paterno"]." ".$cliente["apellido_materno"]; ?></td>
        </tr>

        <tr>
          <th>NIT/CI</th>
          <td><?php echo $cliente["nit_ci"]; ?></td>
        </tr>

        <tr>
          <th>Ciudad</th>
          <td><?php echo $factura["ciudad_cliente"]; ?></td>
        </tr>

        <tr>
          <th>Dirección</th>
          <td><?php echo $cliente["direccion"]; ?></td>
        </tr>

        <tr>
          <th>Teléfono</th>
          <td><?php echo $cliente["telefonos"]; ?></td>
        </tr>

        <tr>
          <th>Estado</th>
          <td>
            <?php if($factura["estado_venta_tienda"]=="pendiente"){
            ?>
            <span class="badge badge-warning btn-flat">Pendiente</span>
            <?php
}else if($factura["estado_venta_tienda"]=="emitido"){
            ?>
            <span class="badge badge-success btn-flat">Emitido</span>
            <?php
}else if($factura["estado_venta_tienda"]=="cancelado"){
            ?>
            <span class="badge badge-danger btn-flat">Cancelado</span>
            <?php
}?>
          </td>
        </tr>

        <tr>
          <th>Metodo de Pago</th>
          <td><?php if($factura["metodo_pago_tienda"]=="EFECTIVO"){
            ?>
            CONTRAREEMBOLSO
            <?php
}else{
            ?>
            QR
            <?php
}?></td>
        </tr>

      </table>

    </div>
    <div class="col-sm-8">
      <table class="table">
        <thead class="bg-gradient-dark">
          <th>#</th>
          <th>Codigo</th>
          <th>Producto</th>
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
            <td colspan="5"><b>Total (Bs.)</b></td>
            <td><b><?php echo $total; ?></b></td>
          </tr>

        </tbody>
      </table>
    </div>
  </div>

</div>