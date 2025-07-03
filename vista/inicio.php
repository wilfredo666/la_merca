<?php 
$usuario=ControladorUsuario::ctrCantidadUsuarios();
$cliente=ControladorCliente::ctrCantidadClientes();
$producto=ControladorProducto::ctrCantidadProductos();
/*$venta=ControladorFactura::ctrCantidadFacturas();*/
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Panel de Control</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">

        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- gatgets de registros -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo $cliente["cliente"];?></h3>

              <p>Clientes</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="VCliente" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?php echo $producto["producto"];?></h3>

              <p>Productos</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="VProducto" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?php echo $usuario["usuarios"];?></h3>

              <p>Usuarios registrados</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="VUsuario" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>1</h3>

              <p>Items</p>
              <!--iconos sacados de https://themeon.net/nifty/v2.9.1/icons-ionicons.html?-->
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <a href="VCliente" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <!--===========grafico de ventas=============-->
      <!-- Date and time range -->
      <div class="form-group">
        <label>Seleccione una fecha:</label>

        <div class="input-group">
          <button type="button" class="btn btn-default float-right" id="daterange-btn">
            <span>
              <i class="far fa-calendar-alt"></i> Rango de fecha
            </span>
            <i class="fas fa-caret-down"></i>
          </button>
          <button type="button" class="btn btn-danger float-right" id="dataCancelPicker">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </div>
      <!-- /.form group -->

      <div class="card bg-gradient-info">
        <div class="card-header border-0">
          <h3 class="card-title">
            <i class="fas fa-th mr-1"></i>
            Reporte de Ventas
          </h3>

          <div class="card-tools">
            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
        <!-- /.card-body -->
        <div class="card-footer bg-transparent">

        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

      <!--mas vendidos y caja chica-->
      <div class="row">
        <div class="col-sm-8">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Productos más vendidos</h3>
            </div>


            <div class="card-body table-responsive p-0">
              <table class="table table-head-fixed text-nowrap">
                <tahead>
                  <tr>
                    <th>Cod. Producto</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total en Ventas</th>
                  </tr>
                </tahead>
                <tbody>
                  <?php
                  /*  $mayorVenta=ControladorProducto::ctrMasVendidos();
              foreach($mayorVenta as $value){ */            
                  ?>
                  <tr>
                    <td><?php //echo //$value["cod_producto"]?></td>
                    <td><?php //echo //$value["nombre_producto"]?></td>
                    <td><?php //echo //$value["precio_producto"]?></td>
                    <td><?php //echo //$value["cantidad_egreso"]?></td>
                    <td><?php //echo //$value["cantidad_egreso"] * $value["precio_producto"]?></td>
                  </tr>
                  <?php
                  //}
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card card-success card-outline">
            <div class="card-body box-profile">
              <h3 class="profile-username text-center">Caja Chica</h3>
              <p class="text-muted text-center">Ventas diarias</p>
              <ul class="lista-group list-group-unbordered mb-3">
                <?php
                //$cajaChica=ControladorFactura::ctrInfoCajaChica();
                ?>

                <li class="list-group-item">
                  <b>INICIAL (Bs.)</b>
                  <span class="float-right">0</span>
                </li>
                <li class="list-group-item">
                  <b>VENTAS (Bs.)</b>
                  <span class="float-right"><?php //echo //$cajaChica["total_venta"];?></span>
                </li>
                <li class="list-group-item">
                  <b>TOTAL EN CAJA (Bs.)</b>
                  <span class="float-right"><?php //echo //$cajaChica["total_venta"]+300;?></span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->