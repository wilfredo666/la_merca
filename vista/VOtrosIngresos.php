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
        <h3 class="card-title">Lista de Ingresos</h3>

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
              <th>Concepto</th>
              <th>Fecha</th>
              <td><a href="FormOtrosIngresos" type="button" class="btn btn-block btn-primary btn-xs">Nuevo</a></td>
            </tr>
          </thead>
          <tbody>
            <?php
            $ingresos=ControladorIngreso::ctrInfoIngresos();
            foreach($ingresos as $value){
            ?>
            <tr>
              <td><?php echo $value["codigo_oi"];?></td>
              <td><?php echo $value["nombre"];?></td>
              <td><?php echo $value["concepto_oi"];?></td>
              <td><?php echo $value["create_at"];?></td>

              <td>
                <div class="btn-group">
                  <button class="btn btn-sm btn-info btn-xs" onclick="MVerNotaIngreso(<?php echo $value["id_otros_ingresos"]?>)">
                    <i class="fas fa-eye"></i>
                  </button>

                  <button class="btn btn-sm btn-danger btn-xs" onclick="MEliNotaIngreso(<?php echo $value["id_otros_ingresos"]?>)">
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
