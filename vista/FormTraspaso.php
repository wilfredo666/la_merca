<div class="content-wrapper">
  <section class="content-header text-center pt-1 mt-1 pb-1 mb-1">
  </section>
  <section class="content">
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
    <!--encabezado-->
    <form id="FSalidaOtros">
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-info">
            <div class="card-header bg-info">
              <h4 class="card-title" style="font-size:20px;"><i class="fas fa-dolly"></i> NOTA DE TRASPASO</h4>
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
                      <input type="text" class="form-control" name="codProducto" id="codProducto" list="listaProductos">
                      <input type="hidden" name="idProducto" id="idProducto">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="busProducto()">
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
                      <input type="text" class="form-control" name="conceptoPro" id="conceptoPro" readonly>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group">
                      <label for="">Stock</label>
                      <input type="text" class="form-control" name="stock" id="stock" placeholder="0" readonly>
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div class="form-group">
                      <label for="">Cantidad</label>
                      <input type="text" class="form-control" name="ingUnidades" id="ingUnidades" placeholder="0" value="0">
                    </div>
                  </div>
                  <div class="form-group col-md-1">
                    <label for="">&nbsp;</label>
                    <div class="input-group form-group">
                      <span class="btn btn-info btn-circle form-control" onclick="agregarCarrito()">
                        <i class="fas fa-plus"></i>
                      </span>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <table class="table" id="detalleNE">
                      <thead class="text-center">
                        <tr>
                          <th>Codigo</th>
                          <th>Nombre del Producto</th>
                          <th>Cantidad de Traspaso</th>
                          <th></th>
                          <!-- <th>&nbsp;</th> -->
                        </tr>
                      </thead>
                      <tbody class="text-center" id="listaDetalleNV">
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
                    <label>Almacen origen</label>
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
                    <label>Almacen destino</label>
                    <select class="form-control" name="almacen_destino" id="almacen_destino">
                      <option value=""></option>

                      <?php
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

                <!-- </div> -->
                <div class="card-footer text-right">
                  <button type="button" class="btn btn-default bg-dark" onclick="location.reload();"><i class="fas fa-times"></i> Anular Nota</button>
                  <a id="btnGuardarNV" class="btn btn-primary" onclick="GuardarNotaVentaOtros()"><i class="fas fa-download"></i> Guardar Nota</a>
                </div>

              </div>

            </div>

          </div>
        </div>
      </div>
    </form>

  </section>
</div>
