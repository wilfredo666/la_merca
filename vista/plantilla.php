<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema</title>
    <link rel="shortcut icon" href="#">
    <!-- Base URL dinámica -->
    <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/'; ?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->

    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/dist/css/adminlte.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/jqvmap/jqvmap.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/summernote/summernote-bs4.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>assest/plugins/dropzone/min/dropzone.min.css">
    <!--icono-->
    <link rel="icon" href="<?php echo $base_url; ?>assest/dist/img/logotipo.png">

    <link href="https://cdn.jsdelivr.net/npm/fontawesome-4.7@4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- daterange picker -->
    <link rel="stylesheet" href="assest/plugins/daterangepicker/daterangepicker.css">
    <style>
      table {
        /*font-size: 14px;*/
      }

      .brand-link {
        padding: 3%;
      }

      .main-header {
        padding: 0.2%;
      }

      aside {
        /* font-size: 0.9em;*/
      }

      table.dataTable tbody th,
      table.dataTable tbody td {
        /*padding: 0;*/
      }

      .table-title {
        border-left: 5px solid #6c757d;
        padding-left: 5px;
        color: #484848;
      }
    </style>
  </head>

  <body>
    <?php
    date_default_timezone_set("America/La_Paz");
    $fechaActual= date("Y-m-d");

    //comprobamos las sesiones
    if (isset($_SESSION["ingreso"]) && $_SESSION["ingreso"] == "ok") {
      include "asideMenu.php";

      if (isset($_GET["ruta"])) {
        $rutas_validas = [
          "inicio",
          "salir",
          "VUsuario",
          "VPersonal",
          "VProveedor",
          "VAlmacen",
          "VProducto",
          "VCliente",
          "VVentas",
          "FormVenta",
          "inicio",
          "permisos",
          "FSalidaOtros",
          "RNotaSalidaOtros",
          "FormTraspaso",
          "FormOtrosIngresos",
          "VOtrosIngresos",
          "FormOtrasSalidas",
          "VOtrasSalidas",
        ];

        if (in_array($_GET["ruta"], $rutas_validas)) {
          // Definir la carpeta base para las rutas
          $carpeta_base = "vista/";

          // Crear la ruta completa
          $ruta = $carpeta_base . $_GET["ruta"] . ".php";

          // Incluir el archivo si existe
          if (file_exists($ruta)) {
            include $ruta;
          } else {
            echo "Archivo no encontrado: " . htmlspecialchars($ruta);
          }
        } else {
          echo "Ruta no válida.";
        }

        include "vista/footer.php";
      }
    } else {
      include "vista/login.php";
    }
    ?>