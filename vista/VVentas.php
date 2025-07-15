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
      <div class="card-header">
        <h3 class="card-title">Lista de Ventas</h3>

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
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Codigo</th>
              <th>Cliente</th>
              <th>Total</th>
              <th>Fecha</th>
              <th>Usuario</th>
              <th>Estado</th>
              <td><a href="FormVenta" type="button" class="btn btn-block btn-primary btn-xs">Nuevo</a></td>
            </tr>
          </thead>
          <tbody>
            <?php
            $ventas=ControladorSalida::ctrInfoFacturas();
            foreach($ventas as $value){
            ?>
            <tr>
              <td><?php echo $value["codigo_venta"];?></td>
              <td><?php echo $value["razon_social_cliente"];?></td>
              <td><?php echo $value["total"];?></td>
              <td><?php echo $value["create_at"];?></td>
              <td><?php echo $value["nombre"];?></td>
              <td>
                <?php if($value["estado_venta"]==1){
                ?>

                <span class="badge bg-success">Emitido</span>
                <?php
            }else{
                ?>
                <span class="badge bg-danger">Anulada</span>
                <?php
            }?>

              </td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-sm btn-info btn-xs" onclick="MVerNotaVenta(<?php echo $value["id_venta"]?>)">
                    <i class="fas fa-eye"></i>
                  </button>

                  <button class="btn btn-sm btn-danger btn-xs" onclick="MEliFactura(<?php echo $value["id_venta"]?>">
                    <i class="fas fa-trash"></i>
                  </button>

                  <a class="btn btn-sm btn-success btn-xs" href="vista/factura/ImpFactura.php?id=<?php echo $value["id_venta"]?>" target="_blank">
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
