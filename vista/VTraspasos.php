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
        <h3 class="card-title">Lista de Traspasos</h3>

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
        <table id="DataTable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Codigo</th>
              <th>Usuario</th>
              <th>Almacen Origen</th>
              <th>Almacen Destino</th>
              <th>Fecha</th>
              <td><a href="FormTraspaso" type="button" class="btn btn-block btn-primary btn-xs">Nuevo</a></td>
            </tr>
          </thead>
          <tbody>
            <?php
            $salidas=ControladorSalida::ctrInfoTraspasos();
            foreach($salidas as $value){
            ?>
            <tr>
              <td><?php echo $value["cod_traspaso"];?></td>
              <td><?php echo $value["Usuario"];?></td>
              <td><?php echo $value["NomAlmacenOrigen"]." - ".$value["descAlmacenOrigen"];?></td>
              <td><?php echo $value["NomAlmacenDestino"]." - ".$value["descAlmacenDestino"];?></td>
              <td><?php echo $value["create_at"];?></td>

              <td>
                <div class="btn-group">
                  <button class="btn btn-sm btn-info btn-xs" onclick="MVerNotaTraspaso(<?php echo $value["id_traspaso"]?>)">
                    <i class="fas fa-eye"></i>
                  </button>

                  <button class="btn btn-sm btn-danger btn-xs" onclick="MEliNotaTraspaso(<?php echo $value["id_traspaso"]?>)">
                    <i class="fas fa-trash"></i>
                  </button>

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
