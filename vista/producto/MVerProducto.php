<?php
require "../../controlador/productoControlador.php";
require "../../modelo/productoModelo.php";

$id = $_GET["id"];
$producto = ControladorProducto::ctrInfoProducto($id);

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
          style="max-width: 100%; height: auto; max-height: 300px;">
      </div>

      <!-- Precio y Costo -->
      <div class="text-center">
        <div class="mb-2">
          <i class="fas fa-dollar-sign text-muted"></i>
          <strong>Costo:</strong>
          <span id="costoValue" class="text-primary">***</span>
          <span id="costoHidden" class="text-muted font-weight-bold" style="display: none;"><?= number_format($producto["costo"], 2); ?> Bs.</span>
          <button type="button" class="btn btn-sm btn-outline-secondary ml-2" id="toggleCosto" onclick="toggleVisibility('costo')">
            <i class="fas fa-eye" id="iconCosto"></i>
          </button>
        </div>
        <div>
          <i class="fas fa-tags text-muted"></i>
          <strong>Precio:</strong>
          <span id="precioValue" class="text-success"><?= number_format($producto["precio"], 2); ?> Bs.</span>
          <span id="precioHidden" class="text-muted font-weight-bold" style="display: none;">***</span>
          <button type="button" class="btn btn-sm btn-outline-secondary ml-2" id="togglePrecio" onclick="toggleVisibility('precio')">
            <i class="fas fa-eye" id="iconPrecio"></i>
          </button>
          <button type="button" class="btn btn-sm btn-outline-info ml-1" id="verPreciosAdicionales" onclick="verPreciosAdicionales(<?= $producto['id_producto']; ?>)" title="Ver precios adicionales">
            <i class="fas fa-list"></i>
          </button>
        </div>

        <!-- Panel para mostrar precios adicionales -->
        <div id="panelPreciosAdicionales" class="mt-3" style="display: none;">
          <div class="card">
            <div class="card-header bg-info text-white text-center py-2">
              <h6 class="mb-0">
                <i class="fas fa-dollar-sign mr-1"></i>
                Precios Adicionales
              </h6>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-sm table-striped mb-0" id="tablaPreciosAdicionales">
                  <thead>
                    <tr>
                      <th class="text-center">Concepto</th>
                      <th class="text-center">Precio</th>
                    </tr>
                  </thead>
                  <tbody id="listaPreciosAdicionales">
                    <!-- Los precios se cargarán aquí -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  function toggleVisibility(tipo) {
    const valueElement = document.getElementById(tipo + 'Value');
    const hiddenElement = document.getElementById(tipo + 'Hidden');
    const iconElement = document.getElementById('icon' + tipo.charAt(0).toUpperCase() + tipo.slice(1));

    if (valueElement.style.display === 'none') {
      // Mostrar valor
      valueElement.style.display = 'inline';
      hiddenElement.style.display = 'none';
      iconElement.className = 'fas fa-eye';
    } else {
      // Ocultar valor
      valueElement.style.display = 'none';
      hiddenElement.style.display = 'inline';
      iconElement.className = 'fas fa-eye-slash';
    }
  }
</script>

<style>
  .btn-outline-secondary {
    border-color: #6c757d;
    color: #6c757d;
  }

  .btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
  }

  .btn-outline-info {
    border-color: #17a2b8;
    color: #17a2b8;
  }

  .btn-outline-info:hover {
    background-color: #17a2b8;
    color: white;
  }

  .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
  }

  #panelPreciosAdicionales .card {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }

  #tablaPreciosAdicionales th {
    background-color: #f8f9fa;
    font-size: 0.875rem;
    padding: 0.5rem;
  }

  #tablaPreciosAdicionales td {
    padding: 0.5rem;
    font-size: 0.875rem;
  }
</style>