<?php
$ruta = parse_url($_SERVER['REQUEST_URI']);

if (isset($ruta["query"])) {
  if (
    $ruta["query"] == "ctrRegCaja" ||
    $ruta["query"] == "ctrEditCaja" ||
    $ruta["query"] == "ctrEliCaja"
  ) {
    $metodo = $ruta["query"];
    $Caja = new ControladorCaja();
    $Caja->$metodo();
  }
}

class ControladorCaja {
  public static function ctrMostrarRegistros() {
    $respuesta = ModeloCaja::mdlMostrarRegistros();
    return $respuesta;
  }

  public static function ctrInfoCaja($id) {
    $respuesta = ModeloCaja::mdlInfoCaja($id);
    return $respuesta;
  }

  public static function ctrRegCaja() {
    require "../modelo/cajaModelo.php";

    $data = $_POST;
    $respuesta = ModeloCaja::mdlRegCaja($data);
    echo $respuesta;
  }

  public static function ctrEditCaja() {
    require "../modelo/cajaModelo.php";
    
    // recuperando los datos del formulario
    $data = $_POST;
    $respuesta = ModeloCaja::mdlEditCaja($data);
    echo $respuesta;
  }

  public static function ctrEliCaja() {
    require "../modelo/cajaModelo.php";
    $id = $_POST["id"];
    $respuesta = ModeloCaja::mdlEliCaja($id);
    echo $respuesta;
  }

  public static function ctrInfoCajaChica() {
    $respuesta = ModeloCaja::mdlInfoCajaChica();
    return $respuesta;
  }
}