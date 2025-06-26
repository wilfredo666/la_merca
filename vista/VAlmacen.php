<!-- Content Wrapper. Contains page content -->
<div class='content-wrapper'>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">

    </div><!-- /.container-fluid -->
  </section>

  <section class='content'>
    <h5 class="table-title">
      Lista de Almacenes
    </h5>

    <table id='DataTable' class='table table-bordered table-striped'>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Descripcion</th>
          <th>Direccion</th>
          <th>Encargado</th>
          <th>Contactos</th>
          <th>Estado</th>

          <th><button type='button' class='btn btn-block btn-primary btn-xs' onclick='MNuevoAlmacen()'>Nuevo</button></th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Obtener registros de la tabla
        $registros = ControladorAlmacen::ctrMostrarRegistros();
        foreach ($registros as $value) {
        ?>
        <tr>
          <td><?php echo $value["nombre_almacen"]; ?></td>
          <td><?php echo $value["descripcion"]; ?></td>
          <td><?php echo $value["direccion"]; ?></td>
          <td><?php echo $value["encargado"]; ?></td>
          <td><?php echo $value["contacto"]; ?></td>

          <td>
            <?php if($value["estado_almacen"]==1){
            ?>

            <span href="#" 
               class="badge bg-success estadoUsuario">
              Activo
            </span>
            <?php
        }else{
            ?>
            <span class="estadoUsuario badge bg-danger">Inactivo</span>
            <?php
        }?>
          </td>

          <td>
            <div class="btn-group">

              <button class="btn btn-sm btn-secondary" onclick="MEditAlmacen(<?php echo $value["id_almacen"]; ?>)">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-sm btn-danger" onclick="MEliAlmacen(<?php echo $value["id_almacen"]; ?>)">
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