<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">

    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <h5 class="table-title">
      Lista de Proveedores
    </h5>
    <table id="DataTable" class="table table-bordered table-striped">

      <thead>
        <tr>
          <th>Empresa</th>
          <th>Nombre(s)</th>
          <th>C.I./NIT</th>
          <th>Contactos</th>
          <td>
            <button class="btn btn-block btn-primary btn-sm" onclick="MNuevoProveedor()">
              <i class="fas fa-plus"></i>
              Nuevo</button>
          </td>
        </tr>
      </thead>
      <tbody>
        <?php
        $proveedor = ControladorProveedor::ctrInformacionProveedor();
        foreach ($proveedor as $value) {
        ?>
          <tr>
            <td><?php echo $value["nombre_empresa"]; ?></td>
            <td><?php echo $value["nombre_pro"] . " " . $value["ap_paterno_pro"] . " " . $value["ap_materno_pro"]; ?>
            </td>
            <td><?php echo $value["ci_proveedor"]; ?></td>
            <td><?php echo $value["telefono_pro"]; ?></td>
            <td>
              <div class="btn-group">
                <button class="btn btn-sm btn-info"
                  onclick="MVerProveedor(<?php echo $value['id_proveedor']; ?>)">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-sm btn-secondary"
                  onclick="MEditProveedor(<?php echo $value['id_proveedor']; ?>)">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger"
                  onclick="MEliProveedor(<?php echo $value['id_proveedor']; ?>)">
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