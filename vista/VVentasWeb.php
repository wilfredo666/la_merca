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

    <!-- Default box -->
    <div class="card">
      <div class="card-header bg-gradient-dark">

        <h3 class="card-title">
          <i class="fas fa-shopping-cart mr-2"></i>
          Compras hechas en el sitio Web

          <span class="badge badge-light ml-2" id="totalVentas">0</span>
        </h3>

        <div class="card-tools">

          <button type="button" class="btn btn-tool text-white" data-card-widget="collapse" title="Contraer">
            <i class="fas fa-minus"></i>
          </button>

          <button type="button" class="btn btn-tool text-white" data-card-widget="remove" title="Cerrar">
            <i class="fas fa-times"></i>
          </button>

        </div>

      </div>
      <div class="card-body">
        <table id="DataTableVentas" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Codigo</th>
              <th>Cliente</th>
              <th>Total</th>
              <th>Fecha</th>
              <th>Estado</th>
              <th>Metodo de Pago</th>
              <td></td>
            </tr>
          </thead>
          <tbody>
            <?php
            $ventas=ControladorSalida::ctrInfoVentasWeb();
            foreach($ventas as $value){
            ?>
            <tr>
              <td><?php echo $value["cod_venta_tienda"];?></td>
              <td><?php echo $value["razon_social_cliente"];?></td>
              <td><?php echo $value["total_venta_tienda"];?></td>
              <td><?php echo $value["create_at"];?></td>
              <td>
                <!-- <div class="btn-group"> -->
                  <?php if($value["estado_venta_tienda"]=="pendiente"){
                  ?>
                  <!-- <button type="button" class="btn btn-warning btn-flat">Pendiente</button> -->
                   <span class="btn btn-warning btn-flat">Pendiente</span>
                  <?php
            }else if($value["estado_venta_tienda"]=="emitido"){
                  ?>
                  <!-- <button type="button" class="btn btn-success btn-flat">Emitido</button> -->
                   <span class="btn btn-success btn-flat">Emitido</span>
                  <?php
            }else if($value["estado_venta_tienda"]=="cancelado"){
                  ?>
                  <!-- <button type="button" class="btn btn-danger btn-flat">Cancelado</button> -->
                   <span class="btn btn-danger btn-flat">Cancelado</span>
                  <?php
            }?>

                  <!-- <button type="button" class="btn btn-default btn-flat dropdown-toggle dropdown-icon" data-toggle="dropdown">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu" role="menu">

                    <a class="dropdown-item" href="#">Pendiente</a>
                    <a class="dropdown-item" href="#">Emitido</a>
                    <a class="dropdown-item" href="#">Cancelado</a>
                  </div>
                </div> -->


              </td>
              <td>
                <?php if($value["metodo_pago_tienda"]=="contrareembolso"){
                ?>

                CONTRAREEMBOLSO
                <?php
            }else{
                ?>
                QR
                <?php
            }?>

              </td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-sm btn-info" onclick="MVerNotaVentaWeb(<?php echo $value["id_venta_tienda"]?>)">
                    <i class="fas fa-eye"></i>
                  </button>

                  <a class="btn btn-sm btn-success" href="vista/venta/ImpVentaWeb.php?id=<?php echo $value["id_venta_tienda"]?>" target="_blank">
                    <i class="fas fa-print"></i>
                  </a>
                </div>
              </td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>

      </div>
      <!-- /.card-body -->
      <div class="card-footer">

      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
