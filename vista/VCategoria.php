<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">

    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <h4>Lista de Categorias</h4>
    <table id="DataTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#ID</th>
          <th>Descripción</th>
          <td>
            <button class="btn btn-primary" onclick="MNuevoCategoria()">Nuevo</button>
          </td>
        </tr>
      </thead>
      <tbody>
        <?php
        $categoria = ControladorCategoria::ctrInfoCategorias();

        foreach ($categoria as $value) {
        ?>
          <tr>
            <td><?php echo $value["id_categoria"]; ?></td>
            <td><?php echo $value["descripcion_cat"]; ?></td>
            <td>
              <div class="btn-group">
                <button class="btn btn-sm btn-secondary" onclick="MEditCategoria(<?php echo $value['id_categoria']; ?>)">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="MEliCategoria(<?php echo $value['id_categoria']; ?>)">
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