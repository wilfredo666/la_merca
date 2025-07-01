<?php
$ruta = parse_url($_SERVER['REQUEST_URI']);

if (isset($ruta["query"])) {
  if (
    $ruta["query"] == "ctrRegAlmacen" ||
    $ruta["query"] == "ctrEditAlmacen" ||
    $ruta["query"] == "ctrEliAlmacen"
  ) {
    $metodo = $ruta["query"];
    $Almacen = new ControladorAlmacen();
    $Almacen->$metodo();
  }
}


class ControladorAlmacen {
  public static function ctrMostrarRegistros() {

    $respuesta = ModeloAlmacen::mdlMostrarRegistros();
    return $respuesta;
  }

  public static function ctrInfoAlmacen($id) {

    $respuesta = ModeloAlmacen::mdlInfoAlmacen($id);
    return $respuesta;
  }

  public static function ctrRegAlmacen() {
    require "../modelo/almacenModelo.php";

    $data = $_POST;
    $respuesta = ModeloAlmacen::mdlRegAlmacen($data);
    echo $respuesta;
  }

  public static function ctrEditAlmacen() {
    require "../modelo/almacenModelo.php";
    
    // recuperando los datos del formulario
    $data = $_POST;
    $respuesta = ModeloAlmacen::mdlEditAlmacen($data);
    echo $respuesta;
  }

  public static function ctrEliAlmacen() {
    require "../modelo/almacenModelo.php";
    $id = $_POST["id"];
    $respuesta = ModeloAlmacen::mdlEliAlmacen($id);
    echo $respuesta;
  }
}
?>