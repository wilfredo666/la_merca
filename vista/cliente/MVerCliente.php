<?php
require "../../controlador/clienteControlador.php";
require "../../modelo/clienteModelo.php";

$id = $_GET["id"];
$cliente = ControladorCliente::ctrInfoCliente($id);

$razonSocial = $cliente["razon_social_cliente"]; 

$rzCliente = preg_replace('([^A-Za-z0-9])', '', $razonSocial);
?>
<div class="modal-header bg-dark">
  <h4 class="modal-title font-weight-light">Información de Cliente</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-12">
      <table class="table">
        <tr>
          <th>Razon Social</th>
          <td><?php echo $cliente["razon_social_cliente"]; ?></td>
        </tr>

        <tr>
          <th>Nit/Ci</th>
          <td><?php echo $cliente["nit_ci_cliente"]; ?></td>
        </tr>

        <tr>
          <th>Dirección</th>
          <td><?php echo $cliente["direccion_cliente"]; ?></td>
        </tr>

        <tr>
          <th>País</th>
          <td><?php echo $cliente["pais_cliente"]; ?></td>
        </tr>

        <tr>
          <th>Ciudad</th>
          <td><?php echo $cliente["ciudad_cliente"]; ?></td>
        </tr>

        <tr>
          <th>Nombre(s)</th>
          <td><?php echo $cliente["nombre_cliente"]; ?></td>
        </tr>

        <tr>
          <th>Contactos</th>
          <td><?php echo $cliente["telefono_cliente"]; ?></td>
        </tr>

        <tr>
          <th>Porcentaje de Descuento</th>
          <td><?php echo $cliente["descuento"] . " %"; ?></td>
        </tr>

      </table>

    </div>
  </div>

</div>