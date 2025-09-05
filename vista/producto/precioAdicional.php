<?php
require "../../controlador/productoControlador.php";
require "../../modelo/productoModelo.php";

$id = $_GET["id"];
$producto = ControladorProducto::ctrInfoProducto($id);

?>

<div class="modal-header bg-info text-white">
  <h5 class="modal-title" id="modalPreciosLabel">Gestión de precios del Producto: <i class="text-warning"><?php echo $producto["nombre_producto"];?></i></h5>
  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <!-- Formulario para agregar nuevo precio -->
  <form id="formPreciosAdicionales">
    <input type="hidden" name="idProducto" value="<?php echo $id; ?>">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="concepto">Concepto</label>
        <input type="text" class="form-control" name="concepto" id="concepto" placeholder="Ej. Mayorista">
      </div>
      <div class="form-group col-md-4">
        <label for="precioAdicional">Precio</label>
        <input type="number" class="form-control" name="precioAdicional" id="precioAdicional" placeholder="0.00">
      </div>
      <div class="form-group col-md-2">
        <label for="estado">Estado</label>
        <select class="form-control" name="estado" id="estado">
          <option value="1">Activo</option>
          <option value="0">Inactivo</option>
        </select>
      </div>

    </div>
  </form>

  <!-- Tabla de precios existentes -->
  <table class="table table-sm table-bordered">
    <thead class="thead-light">
      <tr>
        <th>Concepto</th>
        <th>Precio</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="tablaPreciosProducto">
      <!-- Se llena dinámicamente con JS -->
    </tbody>
  </table>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="button" class="btn btn-primary" onclick="guardarPrecioAdicional()">Guardar</button>
</div>