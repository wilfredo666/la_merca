<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">

        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <h5 class="table-title">
            Reporte de Productos por Proveedor <span class="text-muted">[Mayor y Menor]</span>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Rango de Fecha:</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-default btn-block" id="daterange-producto-proveedor">
                                    <i class="far fa-calendar-alt"></i> <span>Seleccionar fecha</span>
                                </button>
                            </div>
                            <input type="hidden" id="fechaInicialKardexProveedor">
                            <input type="hidden" id="fechaFinalKardexProveedor">
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

                    <!-- Filtro de Proveedor -->
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Proveedor:</label>
                            <div class="input-group">
                                <select class="form-control select2" id="filtroProveedor" style="width: 80%;">
                                    <option value="">-- Todos los proveedores --</option>
                                    <?php
                                    require_once "controlador/proveedorControlador.php";
                                    $proveedores = ControladorProveedor::ctrInformacionProveedor();
                                    foreach ($proveedores as $proveedor) {
                                        echo '<option value="' . $proveedor["id_proveedor"] . '">' . $proveedor["nombre_empresa"] . '</option>';
                                    }
                                    ?>
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="btnBusProductoProveedor"><i class="fas fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Kardex -->
        <div class="card">
            <div class="card-body">
                <div id="prueba"></div>
                <table id="DataTable_KxProductoProveedor" class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>P.U.</th>
                            <th>Cantidad</th>
                            <th>Valor Total</th>
                            <th>Referencia</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyProductoProveedor">

                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>