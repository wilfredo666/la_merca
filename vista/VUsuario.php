<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">

    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <h5 class="table-title">
      Lista de usuarios
    </h5>

    <table id="DataTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#ID</th>
          <th>Nombre Usuario</th>
          <th>Email</th>
          <th>Estado</th>
          <th>Categoria</th>
          <td>
            <button class="btn btn-block btn-primary btn-sm" onclick="MNuevoUsuario()"> <i class="fas fa-plus"></i> Nuevo</button>
          </td>
        </tr>
      </thead>
      <tbody>
        <?php
        $usuario = ControladorUsuario::ctrInfoUsuarios();

        foreach ($usuario as $value) {
        ?>
        <tr>
          <td><?php echo $value["id_usuario"]; ?></td>
          <td><?php echo $value["nombre"]; ?></td>
          <td><?php echo $value["email"]; ?></td>

          <td>
            <?php if($value["estado_usuario"]==1){
            ?>

            <a href="#" 
               class="badge bg-success estadoUsuario" 
               data-id="<?php echo $value["id_usuario"]?>" 
               data-est="1" 
               style="cursor:pointer;">
              Activo
            </a>
            <?php
        }else{
            ?>
            <a data-id="<?php echo $value["id_usuario"]?>" data-est="0" class="estadoUsuario badge bg-danger" style="cursor:pointer;">Inactivo</a>
            <?php
        }?>
          </td>

          <td><?php echo $value["categoria"]; ?></td>
          <td>
            <div class="btn-group">
              <div class="btn-group">
                <button class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown"></button>
                <ul class="dropdown-menu">

                  <li>
                    <a href="permisos?<?php echo $value["id_usuario"]; ?>" class="dropdown-item" target="_blank">Permisos</a>
                  </li>
                </ul>

              </div>
              <button class="btn btn-sm btn-secondary" onclick="MEditUsuario(<?php echo $value["id_usuario"]; ?>)">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-sm btn-danger" onclick="MEliUsuario(<?php echo $value["id_usuario"]; ?>)">
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