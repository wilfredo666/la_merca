<?php 
$ruta=parse_url($_SERVER['REQUEST_URI']);

if(isset($ruta["query"])){
  if($ruta["query"]=="ctrRegistrarCategoria"||
     $ruta["query"]=="ctrEditCategoria"||
     $ruta["query"]=="ctrEliCategoria"||
     $ruta["query"]=="ctrInfoCategoria"){
    $metodo=$ruta["query"];
    $categoria=new ControladorCategoria();
    $categoria->$metodo();
  }
}


class ControladorCategoria{

  static public function ctrRegistrarCategoria(){
    require "../modelo/categoriaModelo.php";
    
    $data=array(
      "desCategoria"=>$_POST["desCategoria"]
    );

    $respuesta=ModeloCategoria::mdlRegCategoria($data);

    echo $respuesta;
  }
  
  static public function ctrInfoCategorias(){
    $respuesta=ModeloCategoria::mdlInfoCategorias();

    return $respuesta;
  }

  static public function ctrInfoCategoria($id){
    $respuesta=ModeloCategoria::mdlInfoCategoria($id);

    return $respuesta;
  }

  static public function ctrEditCategoria(){
    require "../modelo/categoriaModelo.php";

    $data=array(
      "desCategoria"=>$_POST["desCategoria"],
      "idCategoria"=>$_POST["idCategoria"],
    );

    $respuesta=ModeloCategoria::mdlEditCategoria($data);
    echo $respuesta;

  }

  static public function ctrEliCategoria(){
    require "../modelo/categoriaModelo.php";
    $data=$_POST["id"];

    $respuesta=ModeloCategoria::mdlEliCategoria($data);

    echo $respuesta;

  }

}