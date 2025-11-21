<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">

    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <h5 class="table-title">
      Kardex de Productos <span class="text-muted">[Mayor y Menor]</span>
    </h5>

    <!-- Filtros de búsqueda -->
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-filter"></i> Filtros de Búsqueda
        </h3>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Filtro de Fecha -->
          <div class="col-md-4">
            <div class="form-group">
              <label>Rango de Fecha:</label>
              <div class="input-group">
                <button type="button" class="btn btn-default btn-block" id="daterange-kardex">
                  <i class="far fa-calendar-alt"></i> <span>Seleccionar fecha</span>
                </button>
              </div>
              <input type="hidden" id="fechaInicialKardex">
              <input type="hidden" id="fechaFinalKardex">
            </div>
          </div>

          <!-- Filtro de Producto -->
          <div class="col-md-4">
            <div class="form-group">
              <label>Producto:</label>
              <select class="form-control select2" id="filtroProducto" style="width: 100%;">
                <option value="">-- Todos los productos --</option>
                <?php
                require_once "controlador/productoControlador.php";
                $productos = ControladorProducto::ctrInfoProductos();
                foreach ($productos as $producto) {
                  echo '<option value="' . $producto["id_producto"] . '">' . $producto["cod_producto"] . ' - ' . $producto["nombre_producto"] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>

          <!-- Filtro de Tipo -->
          <div class="col-md-4">
            <div class="form-group">
              <label>Tipo de Movimiento:</label>
              <select class="form-control select2" id="filtroTipo" style="width: 100%;">
                <option value="">-- Todos los tipos --</option>
                <option value="ingreso">Ingreso</option>
                <option value="salida">Salida</option>
                <option value="venta">Venta</option>
                <option value="traspaso">Traspaso</option>
                <option value="ajuste">Ajuste</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <button type="button" class="btn btn-primary" id="btnFiltrarKardex">
              <i class="fas fa-search"></i> Buscar
            </button>
            <button type="button" class="btn btn-secondary" id="btnLimpiarFiltros">
              <i class="fas fa-eraser"></i> Limpiar Filtros
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabla de Kardex -->
    <div class="card">
      <div class="card-body">
        <div id="prueba"></div>
        <table id="DataTable_KxProducto" class="table table-bordered table-striped table-sm">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Código</th>
              <th>Producto</th>
              <th>Tipo</th>
              <th>Entrada</th>
              <th>Salida</th>
              <th>Saldo</th>
              <th>P.U.</th>
              <th>Valor Total</th>
              <th>Referencia</th>
            </tr>
          </thead>
          <tbody id="tbodyKardex">

          </tbody>
        </table>
      </div>
    </div>

  </section>
</div>
