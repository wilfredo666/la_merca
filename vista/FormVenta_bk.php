<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">

        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <form id="FormNotaVenta">
      <!--encabezado -->
      <div class="card">
        <div class="card-header bg-primary">
          <h3 class="card-title">
            <i class="fas fa-cash-register"></i>
            Formulario de Venta</h3>

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
          <!--Datos producto-->
          <div class="row">
            <div class="col-sm-9">

              <h5 class="text-primary" style="margin-bottom: 10px;">
                <i class="fas fa-box"></i>
                Productos
              </h5>
              <div class="row">
                <div class="form-group col-md-12">
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
                <input type="hidden" class="form-control" name="stock" id="stock">
                <input type="hidden" class="form-control" name="conceptoPro" id="conceptoPro" readonly>
                <input type="hidden" class="form-control" name="cantProducto" id="cantProducto">
                <input type="hidden" class="form-control" name="imagen" id="imagen">
                <input type="hidden" class="form-control" name="categoria" id="categoria">
                <input type="hidden" class="form-control" name="preUnitario" id="preUnitario">
                <input type="hidden" class="form-control" name="2" id="preTotal" readonly>
                
                <!--carrito-->
                <table class="table table-bordered table-sm">
                  <thead class="bg-info">
                    <tr>
                      <th>Imagen</th>
                      <th>Codigo</th>
                      <th>Descripcion</th>
                      <th>Categoria</th>
                      <th>Cantidad</th>
                      <th>Stock</th>
                      <th>P. Unitario</th>
                      <th>P. Total</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody id="listaDetalle"></tbody>
                  <tfooter>
                    <tr>
                      <td colspan="6"></td>
                      <th>TOTAL</th>
                      <th id="totVenta">0</th>
                      <td></td>
                    </tr>
                  </tfooter>
                </table>
              </div>

            </div>

            <div class="col-sm-3">
              <!--datos del cliente-->
              <h5 class="text-primary" style="margin-bottom: 10px;">
                <i class="fas fa-user-tie"></i>
                Datos del cliente
              </h5>

              <div class="form-group">
                <label for="nitCliente">NIT/CI</label>
                <div class="input-group">
                  <input type="text" class="form-control" list="listaClientes" name="nitCliente" id="nitCliente" placeholder="0" onchange="busCliente()">
                  <input type="hidden" id="idCliente" name="idCliente" value="1">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" onclick="busCliente()">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
                <span class="text-danger" style="font-size:14px" id="errNit"></span>
                <datalist id="listaClientes">
                  <?php
                  $clientes=ControladorCliente::ctrInfoClientes();
                  foreach($clientes as $value){
                  ?>
                  <option value="<?php echo $value["nit_ci_cliente"]?>"><?php echo $value["razon_social_cliente"]?></option>
                  <?php
                  }
                  ?>
                </datalist>
              </div>

              <div class="form-group">
                <label for="">Razon Social</label>
                <input type="text" class="form-control" name="rsCliente" id="rsCliente" value="Sin Nombre">
              </div>

              <div class="form-group">
                <label for="">Observacion</label>
                <textarea class="form-control" name="observacion" id="observacion" cols="3" rows="3"></textarea>
              </div>


            </div>

          </div>


          <div class="row">

          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-sm-2">
              <button class="btn btn-success">Vender</button>
            </div>
            <div class="col-sm-2">
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="metodoPago" id="efectivo" checked>
                <label for="efectivo" class="custom-control-label">Efectivo</label>
              </div>
            </div>

            <div class="col-sm-2">
              <div class="custom-control custom-radio">
                <input class="custom-control-input" type="radio" name="metodoPago" id="qr" onclick="mostrarQr()">
                <label for="qr" class="custom-control-label">QR</label>
              </div>
            </div>
          </div>
          <div class="col-sm-6"></div>
        </div>
      </div>
    </form>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
