<?php
/* controladores */
require_once "controlador/plantillaControlador.php";
require_once "controlador/usuarioControlador.php";
require_once "controlador/personalControlador.php";
require_once "controlador/proveedorControlador.php";
require_once "controlador/almacenControlador.php";
require_once "controlador/categoriaControlador.php";
require_once "controlador/clienteControlador.php";
require_once "controlador/productoControlador.php";
require_once "controlador/salidaControlador.php";
require_once "controlador/ingresoControlador.php";

/* modelos */
require_once "modelo/usuarioModelo.php";
require_once "modelo/proveedorModelo.php";
require_once "modelo/personalModelo.php";
require_once "modelo/almacenModelo.php";
require_once "modelo/categoriaModelo.php";
require_once "modelo/clienteModelo.php";
require_once "modelo/productoModelo.php";
require_once "modelo/salidaModelo.php";
require_once "modelo/ingresoModelo.php";

$plantilla=new ControladorPlantilla();
$plantilla->ctrPlantilla();