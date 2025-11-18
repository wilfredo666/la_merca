<?php

require_once "../../controlador/salidaControlador.php";
require_once "../../modelo/salidaModelo.php";

$id = $_GET["id"];

$notaTraspaso = ControladorSalida::ctrInfoTraspaso($id);
$productos = json_decode($notaTraspaso["detalle_traspaso"], true);
?>
<div class="modal-header">
  <h4 class="modal-title">
    <i class="fas fas fa-dolly mr-2"></i>
    Información de Nota de Traspaso
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
          <td><?php echo $notaTraspaso["cod_traspaso"]; ?></td>
        </tr>

        <tr>
          <th>Observacion</th>
          <td><?php echo $notaTraspaso["observacion_traspaso"]; ?></td>
        </tr>

        <tr>
          <th>Almace de Origen</th>
          <td><?php echo $notaTraspaso["NomAlmacenOrigen"] . " - " . $notaTraspaso["descAlmacenOrigen"]; ?></td>
        </tr>

        <tr>
          <th>Almace de Destino</th>
          <td><?php echo $notaTraspaso["NomAlmacenDestino"] . " - " . $notaTraspaso["descAlmacenDestino"]; ?></td>
        </tr>

        <tr>
          <th>Fecha</th>
          <td><?php echo $notaTraspaso["create_at"]; ?></td>
        </tr>

        <tr>
          <th>Emitido por</th>
          <td><?php echo $notaTraspaso["Usuario"]; ?></td>
        </tr>

        <tr>
          <th>Estado</th>
          <td><?php
              if ($notaTraspaso["estado_traspaso"] == 0) {
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
        </thead>
        <tbody>
          <?php
          $contador = 1;
          foreach ($productos as $value) {
          ?>
            <tr>
              <td><?php echo $contador++; ?></td>
              <td><?php echo $value["codigoProducto"]; ?></td>
              <td><?php echo $value["descripcion"]; ?></td>
              <td><?php echo $value["cantidad"]; ?></td>
            </tr>
          <?php
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>

</div>