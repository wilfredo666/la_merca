<?php
function habilitado($idPermiso)
{
  $id = $_SESSION["idUsuario"];
  $permiso = ControladorUsuario::ctrUsuarioPermiso($id, $idPermiso);
  return $permiso;
}

?>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" id="pruebaB">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a class="nav-link" href="inicio" role="button">Inicio</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <b class="nav-link"><b><?php echo $_SESSION["nomAlmacen"]." - ".$_SESSION["descAlmacen"];?></b></b>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <b class="nav-link"><i class="fas fa-calendar me-2 text-danger"></i> <?php echo $fechaActual;?></b>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="inicio" class="brand-link">
        <img src="<?php echo $base_url; ?>assest/dist/img/logotipo.png"
             class="brand-image img-circle elevation-3" style="opacity: .8" style="width:300px">
        <span class="brand-text font-weight-light">Sitema</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?php echo $base_url; ?>assest/dist/img/user_default.png"
                 class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block" id="usuarioLogin"><?php echo $_SESSION['nombre']; ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
              data-accordion="false">

            <li class="nav-header text-info">ADMINISTRACION</li>

            <?php if (habilitado(1) != null) {
            ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Usuarios
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo $base_url; ?>VUsuario" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Lista de usuarios</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>

            <?php if (habilitado(2) != null) {
            ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-street-view"></i>
                <p>
                  Personal
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="VPersonal" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Lista de Personal</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>
            <?php if (habilitado(2) != null) {
            ?>
            <li class="nav-header text-info">COMERCIAL</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cash-register"></i>
                <p>
                  Ventas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="FormVenta" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Emitir venta</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="VVentas" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Lista Ventas</p>
                  </a>
                </li>
                <li class="nav-item">
                  <span class="nav-link" onclick="FormQrPago()" style="cursor:pointer">
                    <i class="far fa-circle nav-icon"></i>
                    <p>QR de Venta</p>
                  </span>
                </li>

              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>
                  Clientes
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="VCliente" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Lista de clientes</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>


            <?php if (habilitado(6) != null) {
            ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-handshake"></i>
                <p>
                  Proveedores
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="VProveedor" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Lista de Proveedores</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php } ?>


            <li class="nav-header text-info">KARDEX</li>
            <li class="nav-item">
              <a href="VAlmacen" class="nav-link">
                <i class="nav-icon fas fa-store"></i>
                <p>
                  Almacenes
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="VProducto" class="nav-link">
                <i class="nav-icon fas fa-box"></i>
                <p>
                  Productos
                </p>
                <i class="right fas fa-angle-left"></i>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="VProducto" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Lista de Productos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="VCategoria" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Categorias</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fas fa-arrow-left"></i>
                <p>
                  Ingresos
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="FormOtrosIngresos" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Nuevo Ingreso</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="VOtrosIngresos" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Detalle Ingresos</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fas fa-arrow-right"></i>
                <p>
                  Salidas
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="FormOtrasSalidas" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Nueva Salida</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="VOtrasSalidas" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Detalle Salidas</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-dolly"></i>
                <p>
                  Traspasos
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="FormTraspaso" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Nuevo Traspaso</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="VTraspasos" class="nav-link">
                    <i class="far fa-circle nav-icon text-info"></i>
                    <p>Detalle Traspasos</p>
                  </a>
                </li>
              </ul>
            </li>




            <!--<li class="nav-header text-info">OTROS</li>

<li class="nav-item">
<a href="#" class="nav-link">
<i class="nav-icon fas fa-file-alt"></i>
<p>
Reportes
<i class="right fas fa-angle-left"></i>
</p>
</a>


<ul class="nav nav-treeview">

<li class="nav-item">
<a href="#" class="nav-link">
<i class="far fa-circle nav-icon text-info"></i>
<p>Reporte 1</p>
</a>
</li>

</ul>
</li>-->

            <li class="nav-item">
              <a href="salir" class="nav-link text-cyan">
                <i class="fas fa-power-off nav-icon"></i>
                <p>
                  Salir
                </p>
              </a>
            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>