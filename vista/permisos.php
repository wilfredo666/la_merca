<?php
$path = parse_url($_SERVER['REQUEST_URI']);
global $id;
$id = $path["query"];

function permiso($idPermiso)
{
  global $id;

  $permiso = ControladorUsuario::ctrUsuarioPermiso($id, $idPermiso);
  return $permiso;
}

?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1></h1>
        </div>
        <div class="col-sm-6">

        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Permisos habilitados para: </h3>
            </div>
            <div class="card-body">

              <div class="class row">
                <?php
                $liPermisos=ControladorUsuario::ctrListaPermisos();
                foreach($liPermisos as $value){
                ?>
                <div class="col-sm-4">
                  <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                      <input type="checkbox" id="checkboxPrimary<?php echo $value["id_permiso"] ?>" <?php if (permiso($value["id_permiso"]) != NULL): ?>checked<?php endif; ?> onChange="actualizarPermiso(<?php echo $id ?>,<?php echo $value["id_permiso"] ?>)">
                      <label for="checkboxPrimary<?php echo $value["id_permiso"] ?>">
                        <?php echo $value["desc_permiso"];?>
                      </label>
                    </div>
                  </div>
                </div>

                <?php
                }

                ?>

              </div>

            </div>
          </div>

        </div>
        <div class="card-footer clearfix">

        </div>
      </div>
    </div>
  </section>

</div>
