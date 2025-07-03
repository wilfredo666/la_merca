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

    $stmt=Conexion::conectar()->prepare("insert into categoria(desc_categoria) values('$desCategoria')");

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

    $stmt=Conexion::conectar()->prepare("update categoria set desc_categoria='$desCategoria' where id_categoria=$idCategoria");

    if($stmt->execute()){
      return "ok";
    }else{
      return "error";
    }

    $stmt->close();
    $stmt->null;
  }

  static public function mdlEliCategoria($data){
/*    $Categoria=Conexion::conectar()->prepare("select * from factura where id_categoria=$data");
    $Categoria->execute();
    if($Categoria->fetch()>0){
      echo "error";
    }else{
      }*/
      $stmt=Conexion::conectar()->prepare("delete from categoria where id_categoria=$data");

      if($stmt->execute()){
        return "ok";
      }else{
        return "error";
      }
    

    $stmt->close();
    $stmt->null;
  }

  static public function mdlBusCategoria($nitCategoria){
    $stmt=Conexion::conectar()->prepare("select * from Categoria where nit_ci_Categoria=$nitCategoria");
    $stmt->execute();
    return $stmt->fetch();

    $stmt->close();
    $stmt->null;
  }
  
  static public function mdlCantidadCategorias(){
    $stmt=Conexion::conectar()->prepare("select count(*) as Categoria from Categoria");
    $stmt->execute();

    return $stmt->fetch();

    $stmt->close();
    $stmt->null;
  }

}