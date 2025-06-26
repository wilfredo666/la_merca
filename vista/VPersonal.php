<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">

    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <h5 class="table-title">
      Lista del Personal
    </h5>
    <table id="DataTable" class="table table-bordered table-striped">

      <thead>
        <tr>
          <th>Nombre(s)</th>
          <th>Apellido Paterno</th>
          <th>Apellido Materno</th>
          <th>C.I.</th>
          <th>Cargo</th>
          <th>Estado</th>
          <td>
            <button class="btn btn-block btn-primary btn-sm" onclick="MNuevoPersonal()">
              <i class="fas fa-plus"></i>
              Nuevo</button>
          </td>
        </tr>
      </thead>
      <tbody>
        <?php
        $personal = ControladorPersonal::ctrInformacionPersonal();
        foreach ($personal as $value) {
        ?>
        <tr>
          <td><?php echo $value["nombre"]; ?></td>
          <td><?php echo $value["ap_paterno"]; ?></td>
          <td><?php echo $value["ap_materno"]; ?></td>
          <td><?php echo $value["ci_personal"]; ?></td>
          <td><?php echo $value["cargo"]; ?></td>
                      <?php 
            if($value["estado_personal"]==1){
              ?>
              <td><span class="badge badge-success">Activo</span></td>
              <?php
            }else{
              ?>
              <td><span class="badge badge-danger">Inactivo</span></td>
              <?php
            }
            ?>
          <td>
            <div class="btn-group">
              <button class="btn btn-sm btn-info" onclick="MVerPersonal(<?php echo $value['id_personal']; ?>)">
                <i class="fas fa-eye"></i>
              </button>
              <button class="btn btn-sm btn-secondary" onclick="MEditPersonal(<?php echo $value['id_personal']; ?>)">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-sm btn-danger" onclick="MEliPersonal(<?php echo $value['id_personal']; ?>)">
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

  </section>
</div>