<?php
/* controladores */
require_once "controlador/plantillaControlador.php";
require_once "controlador/usuarioControlador.php";
require_once "controlador/personalControlador.php";
require_once "controlador/proveedorControlador.php";
require_once "controlador/almacenControlador.php";

/* modelos */
require_once "modelo/usuarioModelo.php";
require_once "modelo/proveedorModelo.php";
require_once "modelo/personalModelo.php";
require_once "modelo/almacenModelo.php";

$plantilla=new ControladorPlantilla();
$plantilla->ctrPlantilla();