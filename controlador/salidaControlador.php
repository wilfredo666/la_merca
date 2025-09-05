<?php
//capturamos la ruta
$ruta=parse_url($_SERVER['REQUEST_URI']);

if(isset($ruta["query"])){
  if($ruta["query"] == "ctrRegNotaVenta" ||
     $ruta["query"] == "ctrEliFactura" ||
     $ruta["query"] == "ctrNumFactura" ||
     $ruta["query"] == "ctrAnularFactura" ||
     $ruta["query"] == "ctrRegNotaSalida" ||
     $ruta["query"] == "ctrEliNotaSalida" ||
     $ruta["query"] == "ctrEditQr" ||
     $ruta["query"] == "ctrRegNotaTraspaso" ||
     $ruta["query"] == "ctrEliNotaTraspaso" ||
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

    echo $respuesta["status"];
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

  static public function ctrRegNotaSalida(){
    require_once "../modelo/salidaModelo.php";

    $respuesta=ModeloSalida::mdlRegNotaSalida();

    echo $respuesta;
  }

  static public function ctrInfoSalida($id){
    $respuesta=ModeloSalida::mdlInfoSalida($id);
    return $respuesta;
  }

  static public function ctrEliNotaSalida(){
    require_once "../modelo/salidaModelo.php";

    
    $respuesta=ModeloSalida::mdlEliNotaSalida($id);

    echo $respuesta;
  }

  static public function ctrInfoSalidas(){

    $respuesta=ModeloSalida::mdlInfoSalidas($_SESSION["idAlmacen"]);
    return $respuesta;
  }

  static public function ctrInfoUltimoQr(){
    $respuesta=ModeloSalida::mdlInfoUltimoQr();
    return $respuesta;
  }

  static public function ctrEditQr(){
    require_once "../modelo/salidaModelo.php";

    if(isset($_FILES["imgQrPago"]) && $_FILES["imgQrPago"]["error"] === 0){
      $imagen = $_FILES["imgQrPago"];
      $nomImagen = uniqid()."_".$imagen["name"]; // evita nombres repetidos
      $archImagen = $imagen["tmp_name"];

      if(move_uploaded_file($archImagen, "../assest/dist/img/" . $nomImagen)){
        $data = array(
          "id" => $_POST["id"],
          "imgQr" => $nomImagen
        );

        $respuesta = ModeloSalida::mdlEditQr($data);
        echo $respuesta;
      } else {
        echo "error_subida";
      }
    } else {
      echo "sin_imagen";
    }
  }

  static public function ctrRegNotaTraspaso(){
    require_once "../modelo/salidaModelo.php";

    $respuesta=ModeloSalida::mdlRegNotaTraspaso();

    echo $respuesta["status"];
  }

  static public function ctrInfoTraspasos(){
    $respuesta=ModeloSalida::mdlInfoTraspasos();
    return $respuesta;
  }

  static public function ctrInfoTraspaso($id){
    $respuesta=ModeloSalida::mdlInfoTraspaso($id);
    return $respuesta;
  }

  static public function ctrEliNotaTraspaso(){
    require_once "../modelo/salidaModelo.php";
    $id =$_POST["id"];
    $respuesta=ModeloSalida::mdlEliNotaTraspaso($id);
    echo $respuesta;
  }
}







