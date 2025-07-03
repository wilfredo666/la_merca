<?php
require "../../controlador/productoControlador.php";
require "../../modelo/productoModelo.php";

header('Content-Type: application/json');
$producto = ControladorProducto::ctrInfoProductos();
echo json_encode(["data" => $producto], JSON_PRETTY_PRINT);
?>