<?php
//capturamos la ruta
$ruta=parse_url($_SERVER['REQUEST_URI']);

if(isset($ruta["query"])){
  if($ruta["query"] == "ctrRegNotaVenta" ||
     $ruta["query"] == "ctrEliFactura" ||
     $ruta["query"] == "ctrNumFactura" ||
     $ruta["query"] == "ctrAnularFactura" ||
     $ruta["query"] == "ctrReporteVentas"){

    $metodo = $ruta["query"];
    $Factura= new ControladorSalida();
    $Factura -> $metodo();
  }
}

class ControladorSalida{

  static public function ctrInfoFacturas(){
    $respuesta=ModeloSalida::mdlInfoFacturas();
    return $respuesta;
  }

  static public function ctrRegNotaVenta(){
    require_once "../modelo/salidaModelo.php";

    $respuesta=ModeloSalida::mdlRegNotaVenta();

    echo $respuesta;
  }

  static public function ctrInfoFactura($id){
    $respuesta=ModeloSalida::mdlInfoFactura($id);
    return $respuesta;
  }

  static public function ctrAnularFactura(){
    require_once "../modelo/salidaModelo.php";

    $cuf =$_POST["cuf"];
    $respuesta=ModeloSalida::mdlAnularFactura($cuf);

    echo $respuesta;
  }

  static public function ctrNumFactura(){
    require_once "../modelo/salidaModelo.php";

    $resultado=ModeloSalida::mdlNumFactura();

    if($resultado["max(id_venta)"]==null){
      echo "1";
    }else{
      echo $resultado["max(id_venta)"]+1;
    }
  }

  static public function ctrUltimoCufd(){
    require_once "../modelo/salidaModelo.php";

    $resultado=ModeloSalida::mdlUltimoCufd();
    echo json_encode($resultado);
  }

  static public function ctrCantidadFacturas(){
    $respuesta=ModeloSalida::mdlCantidadFacturas();
    return $respuesta;
  }

  static public function ctrInfoCajaChica(){
    $respuesta=ModeloSalida::mdlInfoCajaChica();
    return $respuesta;
  }

  static public function ctrReporteVentas(){
    require_once "../modelo/salidaModelo.php";
    $fechaInicial=$_POST["inicio"];
    $fechaFinal=$_POST["final"];

    $respuesta=ModeloSalida::mdlReporteVentas($fechaInicial, $fechaFinal);
    echo json_encode($respuesta);
  }

}







