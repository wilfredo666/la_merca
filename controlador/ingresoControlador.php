<?php
//capturamos la ruta
$ruta=parse_url($_SERVER['REQUEST_URI']);

if(isset($ruta["query"])){
  if($ruta["query"] == "ctrRegNotaIngreso" ||
     $ruta["query"] == "ctrEliNotaIngreso" ||
     $ruta["query"] == "ctrNumIngreso" ||
     $ruta["query"] == "ctrAnularIngreso" ||
     $ruta["query"] == "ctrReporteNI"){

    $metodo = $ruta["query"];
    $Ingreso= new Controladoringreso();
    $Ingreso -> $metodo();
  }
}

class ControladorIngreso{


  static public function ctrInfoIngresos(){
    
    $respuesta=Modeloingreso::mdlInfoIngresos($_SESSION["idAlmacen"]);
    return $respuesta;
  }

  static public function ctrRegNotaIngreso(){
    require_once "../modelo/ingresoModelo.php";

    $respuesta=ModeloIngreso::mdlRegNotaIngreso();

    echo $respuesta;
  }


  static public function ctrInfoIngreso($id){
    $respuesta=ModeloIngreso::mdlInfoIngreso($id);
    return $respuesta;
  }

  static public function ctrEliNotaIngreso(){
    require_once "../modelo/ingresoModelo.php";

    $id =$_POST["id"];
    $respuesta=ModeloIngreso::mdlEliNotaIngreso($id);

    echo $respuesta;
  }
/*
  static public function ctrNumIngreso(){
    require_once "../modelo/ingresoModelo.php";

    $resultado=Modeloingreso::mdlNumIngreso();

    if($resultado["max(id_venta)"]==null){
      echo "1";
    }else{
      echo $resultado["max(id_venta)"]+1;
    }
  }

  static public function ctrUltimoCufd(){
    require_once "../modelo/ingresoModelo.php";

    $resultado=Modeloingreso::mdlUltimoCufd();
    echo json_encode($resultado);
  }

  static public function ctrCantidadIngresos(){
    $respuesta=Modeloingreso::mdlCantidadIngresos();
    return $respuesta;
  }

  static public function ctrInfoCajaChica(){
    $respuesta=Modeloingreso::mdlInfoCajaChica();
    return $respuesta;
  }

  static public function ctrReporteVentas(){
    require_once "../modelo/ingresoModelo.php";
    $fechaInicial=$_POST["inicio"];
    $fechaFinal=$_POST["final"];

    $respuesta=Modeloingreso::mdlReporteVentas($fechaInicial, $fechaFinal);
    echo json_encode($respuesta);
  }
*/

}







