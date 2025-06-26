<?php 
require_once "conexion.php";
class ModeloProveedor{


  static public function mdlInformacionProveedor(){
    $stmt=Conexion::conectar()->prepare("select * from proveedor");
    $stmt->execute();

    return $stmt->fetchAll();

    $stmt->close();
    $stmt->null;
  }

  static public function mdlRegProveedor($data){

    $nombre_empresa = $data["nombre_empresa"];
    $nombre_pro = $data["nombre_pro"];
    $ap_paterno_pro = $data["ap_paterno_pro"];
    $ap_materno_pro = $data["ap_materno_pro"];
    $ci_proveedor = $data["ci_proveedor"];
    $direccion_pro = $data["direccion_pro"];
    $telefono_pro = $data["telefono_pro"];

    $stmt=Conexion::conectar()->prepare("INSERT INTO proveedor(nombre_empresa, nombre_pro, ap_paterno_pro, ap_materno_pro, ci_proveedor, direccion_pro, telefono_pro) VALUES ('$nombre_empresa','$nombre_pro','$ap_paterno_pro','$ap_materno_pro','$ci_proveedor','$direccion_pro','$telefono_pro')");

    if($stmt->execute()){
      return "ok";
    }else{
      return "error";
    }
    $stmt->close();
    $stmt->null;
  }

  static public function mdlInfoProveedor($id){
    $stmt=Conexion::conectar()->prepare("select * from proveedor where id_proveedor=$id");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->close();
    $stmt->null;
  }

  static public function mdlEditProveedor($data){
    $id_proveedor = $data["id_proveedor"];
    $nombre_empresa = $data["nombre_empresa"];
    $nombre_pro = $data["nombre_pro"];
    $ap_paterno_pro = $data["ap_paterno_pro"];
    $ap_materno_pro = $data["ap_materno_pro"];
    $ci_proveedor = $data["ci_proveedor"];
    $direccion_pro = $data["direccion_pro"];
    $telefono_pro = $data["telefono_pro"];
    $email_pro = $data["email_pro"];
    $estado_pro = $data["estado_pro"];

    $stmt=Conexion::conectar()->prepare("UPDATE proveedor SET nombre_empresa='$nombre_empresa', nombre_pro='$nombre_pro', ap_paterno_pro='$ap_paterno_pro', ap_materno_pro='$ap_materno_pro', ci_proveedor='$ci_proveedor', direccion_pro='$direccion_pro', telefono_pro='$telefono_pro', email_pro='$email_pro', estado_pro='$estado_pro' WHERE id_proveedor=$id_proveedor");

    if($stmt->execute()){
      return "ok";
    }else{
      return "error";
    }
    $stmt->close();
    $stmt->null;
  }

  static public function mdlEliProveedor($id){
    try{
      $Proveedor=Conexion::conectar()->prepare("delete from proveedor where id_proveedor=$id");
      $Proveedor->execute();
    }catch (PDOException $e){
      $codeError= $e->getCode();
      if($codeError=="23000"){
        return "error";
        $stmt->close();
        $stmt->null;
      }
    }
    return "ok";
    $stmt->close();
    $stmt->null;
  }
}