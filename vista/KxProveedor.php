<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <h5 class="table-title">
            Kardex de Proveedores <span class="text-muted">[Reporte]</span>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Rango de Fecha:</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-default btn-block" id="daterange-kardex-proveedor">
                                    <i class="far fa-calendar-alt"></i> <span>Seleccionar fecha</span>
                                </button>
                            </div>
                            <input type="hidden" id="fechaInicialKardexProveedor">
                            <input type="hidden" id="fechaFinalKardexProveedor">
                        </div>
                    </div>

                    <!-- Filtro de Proveedor -->
                    <div class="col-md-6">
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
                                    <button type="button" class="btn btn-primary" id="btnBuscarProveedor"><i class="fas fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aquí irá la tabla de reporte -->
        <div class="card">
            <div class="card-body">
                <table id="DataTable_KxProveedor" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Codigo</th>
                            <th>Monto Total</th>
                            <th>Almacen</th>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="cuerpoKardexProveedor">
                        <!-- Los datos se llenarán dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>