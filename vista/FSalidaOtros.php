<div class="content-wrapper">
  <section class="content-header text-center pt-1 mt-1 pb-1 mb-1">
    <h4 class="align-item-center pt-0 mt-0 pb-0 mb-0 bg-dark">NOTA DE SALIDA POR OTROS CONCEPTOS</h4>
  </section>
  <section class="content">

    <!--encabezado-->
    <form id="FSalidaOtros">
      <div class="row">
        <div class="col-sm-6">
          <div class="card card-info card-outline">
            <div class="card-header bg-info">
              <h4 class="card-title" style="font-size:20px;">DATOS GENERALES</h4>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!--encabezado de datos para la nota-->
            <div class="card-body row pb-2 mb-2">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Fecha:</label>
                  <input type="date" class="form-control" name="fecha" id="fecha" value="<?php date_default_timezone_set('America/La_Paz'); 
                echo date('Y-m-d'); ?>" readonly>
                </div>
              </div>

              <div class="col-md-8">
                <div class="form-group">
                  <label>Concepto de Salida</label>
                  <select class="form-control" name="concepto_salida" id="concepto_salida">
                    <option value="">-- Seleccionar concepto de salida --</option>
                    <option value="Promocion">Promocion</option>
                    <option value="Regalo">Regalo</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Ajuste">Por Ajuste</option>
                    <option value="Otros">Otros</option>
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Nro de Comprobante</label>
                  <?php
                  $a;
                  $item = null;
                  $valor = null;
                  $registros = ControladorVenta::ctrMostrarCantVentasOtros();
                  if ($registros == 0) {
                    echo '<input type="text" class="form-control" id="nroComprobante" name="nroComprobante" value="SO-1" readonly>';
                  } else {
                    $notaRegistro = ControladorVenta::ctrUltimaVentaOtros();
                    $codigo = $notaRegistro["codigo_salida_otros"];
                    $dividirCodigo = explode("-", $codigo);
                    $numeroCorrelativo = $dividirCodigo[1] + 1;
                    echo '<input type="text" class="form-control" id="nroComprobante" name="nroComprobante" value="SO-' . $numeroCorrelativo . '" readonly>';
                  }
                  ?>
                  <p class="text-danger" id="aviso"></p>
                </div>
              </div>



              <div class="col-md-8">
                <div class="form-group">
                  <label for="">Observación</label>
                  <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="3" placeholder="Observaciones..."></textarea>
                </div>
              </div>
            </div>
            <!-- </div> -->
            <div class="card-footer text-right">
              <button type="button" class="btn btn-default bg-dark" onclick="location.reload();"><i class="fas fa-times"></i> Anular Nota</button>
              <a id="btnGuardarNV" class="btn btn-primary" onclick="GuardarNotaVentaOtros()"><i class="fas fa-download"></i> Guardar Nota</a>
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="card card-info card-outline">
            <div class="card-header bg-info">
              <h4 class="card-title" style="font-size:20px;">DETALLE DE ARTICULOS</h4>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!--encabezado de datos para la nota-->
            <div class="card-body row pb-0 mb-0">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Código EAN:</label>
                  <input type="text" class="form-control" name="codigoEAN" id="codigoEAN" placeholder="Código EAN" readonly>
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label>Artículo / Descripción Porducto</label>
                  <select class="form-control select2bs4" name="productoEmpaque" id="productoEmpaque" onchange="datosProducto('s');">
                    <option value="">Seleccionar Artículo</option>
                    <?php
                    $producto = ControladorProducto::ctrInfoProductos();
                    foreach ($producto as $value) {
                    ?>
                    <option value="<?php echo $value["id_producto"]; ?>"><?php echo $value["nombre_producto"]; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <input type="hidden" name="descripcionProd" id="descripcionProd">
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Precio Docena</label>
                  <input type="text" class="form-control" name="ventaProducto" id="ventaProducto" placeholder="0.00">
                  <input type="hidden" class="form-control" name="costoProducto" id="costoProducto" placeholder="0.00">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Stock Docenas</label>
                  <input type="text" class="form-control" name="stockDocenas" id="stockDocenas" placeholder="0" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Stock Unidades</label>
                  <input type="text" class="form-control" name="stockUnidades" id="stockUnidades" placeholder="0" readonly>
                </div>
              </div>

              <input type="hidden" name="descuentoCliente" id="descuentoCliente" value=0>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Salida Docenas</label>
                  <input type="text" class="form-control" name="ingDocenas" id="ingDocenas" placeholder="0" value="0">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="">Salida Unidades</label>
                  <input type="text" class="form-control" name="ingUnidades" id="ingUnidades" placeholder="0" value="0">
                </div>
              </div>
            </div>
            <!-- </div> -->
            <div class="card-footer text-right">
              <button type="button" class="btn btn-dark" id="btnCarritoNV" onclick="validarFormularioSO()"><i class="fas fa-plus-circle"></i> Agregar Item</button>
            </div>
          </div>
        </div>
      </div>

      <!--tabla donde elejir los productos-->
      <div class="card card-info card-outline">
        <div class="card-header bg-info">
          <h4 class="card-title" style="font-size:20px;">DETALLE DE LA NOTA</h4>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>

        <div class="card-body">
          <style>
            td,
            th {
              border: #E7E7E7 1px solid;
            }

            .card-header {
              background-color: transparent;
              border-bottom: 1px solid rgba(0, 0, 0, 0.125);
              padding: 0.25rem 1.25rem;
              position: relative;
              border-top-left-radius: 0.25rem;
              border-top-right-radius: 0.25rem;
            }
          </style>
          <!--tabla de productos seleccionados-->
          <div class=" row">
            <div class="col-md-12">

              <table class="table" id="detalleNE">
                <thead class="text-center">
                  <tr>
                    <th>ID</th>
                    <th width=250px;>Descripción</th>
                    <th>Docenas</th>
                    <th>Unidades</th>
                    <th>P/Docena</th>
                    <th>Subtotal</th>
                    <th>Descuento</th>
                    <th>Liq. Pagable</th>
                    <th>Acciones</th>
                    <!-- <th>&nbsp;</th> -->
                  </tr>
                </thead>
                <tbody class="text-center" id="listaDetalleNV">
                </tbody>
                <tfoot class="text-center">
                  <tr style="margin-right: 200px; padding-right: 500px;">
                    <td></td>
                    <th class="text-right">TOTALES:</th>
                    <td id="totalDocenas" class="font-weight-bold"></td>
                    <td id="totalUnidades" class="font-weight-bold"></td>
                    <td></td>
                    <td id="totalCell" class="font-weight-bold">0</td>
                    <td id="totalDescuento" class="font-weight-bold">0</td>
                    <td id="totalNeto" class="font-weight-bold" style="background-color: #C4F2F5;">0</td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </form>

  </section>
</div>
