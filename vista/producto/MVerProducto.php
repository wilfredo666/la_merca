<?php
require "../../controlador/productoControlador.php";
require "../../modelo/productoModelo.php";

$id=$_GET["id"];
$producto=ControladorProducto::ctrInfoProducto($id);

?>
<div class="modal-header bg-dark text-white">
  <h4 class="modal-title font-weight-light">
    <i class="fas fa-box-open mr-2"></i> Información del Producto
  </h4>
  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="modal-body">
  <div class="row">
    <!-- Información del producto -->
    <div class="col-md-6">
      <table class="table table-bordered table-hover">
        <tbody>
          <tr>
            <th scope="row">Código</th>
            <td><?= $producto["cod_producto"]; ?></td>
          </tr>
          <tr>
            <th scope="row">Nombre</th>
            <td><?= $producto["nombre_producto"]; ?></td>
          </tr>
          <tr>
            <th scope="row">Descripción</th>
            <td><?= $producto["descripcion_prod"]; ?></td>
          </tr>

          <tr>
            <th scope="row">Unidad</th>
            <td><?= $producto["unidad_medida"]; ?></td>
          </tr>
          <tr>
            <th scope="row">Marca</th>
            <td><?= $producto["marca"]; ?></td>
          </tr>
          <tr>
            <th scope="row">Categoría</th>
            <td><?= $producto["categoria"]; ?></td>
          </tr>
          <tr>
            <th scope="row">Disponibilidad</th>
            <td>
              <?php if ($producto["disponible"] == 1): ?>
              <span class="badge badge-success px-3 py-1">Disponible</span>
              <?php else: ?>
              <span class="badge badge-danger px-3 py-1">No disponible</span>
              <?php endif; ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Imagen  -->
    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
      <div class="border rounded p-2 bg-light mb-3">
        <img 
             src="assest/dist/img/producto/<?= $producto["imagen_producto"] ?: 'product_default.png'; ?>" 
             alt="Imagen del producto" 
             class="img-fluid rounded shadow-sm" 
             style="max-width: 100%; height: auto; max-height: 300px;"
             >
      </div>

      <!-- Precio y Costo -->
      <div class="text-center">
        <p class="mb-1">
          <i class="fas fa-dollar-sign text-muted"></i>
          <strong>Costo:</strong> 
          <span class="text-primary"><?= number_format($producto["costo"], 2); ?> Bs.</span>
        </p>
        <p>
          <i class="fas fa-tags text-muted"></i>
          <strong>Precio:</strong> 
          <span class="text-success"><?= number_format($producto["precio"], 2); ?> Bs.</span>
        </p>
      </div>

    </div>
  </div>
</div>