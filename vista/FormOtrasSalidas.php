<div class="content-wrapper">
  <section class="content-header text-center pt-1 mt-1 pb-1 mb-1">
  </section>
  <section class="content">
    <style>

      .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        padding: 0.25rem 1.25rem;
        position: relative;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
      }
    </style>
    <!--encabezado-->
    <form id="FSalidaOtros">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header bg-info">
              <h4 class="card-title" style="font-size:20px;"><i class="fas fa-arrow-right"></i> NOTA DE SALIDA</h4>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>

            <div class="card-body row pb-0 mb-0">
              <!--carrito de productos-->
              <div class="col-md-9">

                <h5 class="text-primary" style="margin-bottom: 10px;">
                  <i class="fas fa-box"></i>
                  Carrito
                </h5>
                <div class="row">
                  <div class="form-group col-md-3">
                    <label for="">Cod. Producto</label>
                    <div class="input-group form-group">
                      <input type="text" class="form-control form-control-sm" name="codProducto" id="codProducto" list="listaProductos">
                      <input type="hidden" name="idProducto" id="idProducto">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="busProductoIngreso()">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>

                    </div>
                    <datalist id="listaProductos">
                      <?php
                      $productos=ControladorProducto::ctrInfoProductos();
                      foreach($productos as $value){
                      ?>
                      <option value="<?php echo $value["cod_producto"];?>"><?php echo $value["nombre_producto"];?></option>
                      <?php
                      }
                      ?>
                    </datalist>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="">Nombre del Producto</label>
                    <div class="input-group form-group">
                      <input type="text" class="form-control form-control-sm" name="conceptoPro" id="conceptoPro" readonly>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group">
                      <label for="">Costo</label>
                      <input type="text" class="form-control form-control-sm" name="preUnitario" id="preUnitario" value="0.00">
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group">
                      <label for="">Cantidad</label>
                      <input type="number" class="form-control form-control-sm" name="cantProducto" id="cantProducto" placeholder="0" value="0">
                    </div>
                  </div>
                  <div class="form-group col-md-1">
                    <label for="">&nbsp;</label>
                    <div class="input-group form-group">
                      <span class="btn btn-block btn-info btn-sm" onclick="agregarCarritoNS()">
                        <i class="fas fa-plus"></i>
                      </span>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <table class="table table-bordered table-sm" id="detalleNE">
                      <thead class="text-center">
                        <tr>
                          <th>Nombre del Producto</th>
                          <th>Costo</th>
                          <th>Cantidad</th>
                          <th>Sub Total</th>
                          <th></th>
                          <!-- <th>&nbsp;</th> -->
                        </tr>
                      </thead>
                      <tbody class="text-center" id="listaDetalleNS">
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--encabezado de datos para la nota-->
              <div class="col-sm-3">
                <h5 class="text-primary" style="margin-bottom: 10px;">
                  <i class="fas fa-store"></i>
                  Detalle
                </h5>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Concepto</label>
                    <select class="form-control" name="conceptoNS" id="conceptoNS">
                      <option value=""></option>
                      <option value="ajuste">Por Ajuste</option>
                      <option value="marketing">Marketing</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Almacen Origen</label>
                    <select class="form-control" name="almacen_origen" id="almacen_origen">
                      <option value=""></option>

                      <?php
                      $almacen=ControladorAlmacen::ctrMostrarRegistros();
                      foreach($almacen as $value){
                      ?>
                      <option value="<?php echo $value["id_almacen"];?>"><?php echo $value["nombre_almacen"]." - ".$value["descripcion"];?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="">Observación</label>
                    <textarea class="form-control" name="observacion" id="observacion" cols="30" rows="3" placeholder="Observaciones..."></textarea>
                  </div>
                </div>

              </div>

            </div>

            <div class="card-footer">
              <button type="button" class="btn btn-default bg-dark" onclick="location.reload();">
                <i class="fas fa-times"></i> Anular
              </button>

              <button id="btnGuardarNS" class="btn btn-success float-right">
                <i class="fas fa-download"></i> Guardar
              </button>
            </div>

          </div>
        </div>
      </div>
    </form>

  </section>
</div>
