<?php 
require_once "conexion.php";
class ModeloCategoria{


  static public function mdlInfoCategorias(){
    $stmt=Conexion::conectar()->prepare("select * from categoria");
    $stmt->execute();

    return $stmt->fetchAll();

    $stmt->close();
    $stmt->null;
  }

  static public function mdlRegCategoria($data){

   $desCategoria=$data["desCategoria"];

    $stmt=Conexion::conectar()->prepare("insert into categoria (descripcion_cat) values('$desCategoria')");

    if($stmt->execute()){
      return "ok";
    }else{
      return "error";
    }

    $stmt->close();
    $stmt->null;
  }

  static public function mdlInfoCategoria($id){
    $stmt=Conexion::conectar()->prepare("select * from categoria where id_categoria=$id");
    $stmt->execute();

    return $stmt->fetch();

    $stmt->close();
    $stmt->null;
  }

  static public function mdlEditCategoria($data){

    $desCategoria=$data["desCategoria"];
    $idCategoria=$data["idCategoria"];

    $stmt=Conexion::conectar()->prepare("update categoria set descripcion_cat='$desCategoria' where id_categoria=$idCategoria");

    if($stmt->execute()){
      return "ok";
    }else{
      return "error";
    }

    $stmt->close();
    $stmt->null;
  }

  static public function mdlEliCategoria($data){

      $stmt=Conexion::conectar()->prepare("delete from categoria where id_categoria=$data");

      if($stmt->execute()){
        return "ok";
      }else{
        return "error";
      }
    

    $stmt->close();
    $stmt->null;
  }

}