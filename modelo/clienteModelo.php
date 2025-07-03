<?php 
require_once "conexion.php";
class ModeloCliente{


  static public function mdlInfoClientes(){
    $stmt=Conexion::conectar()->prepare("select * from cliente");
    $stmt->execute();

    return $stmt->fetchAll();

    $stmt->close();
    $stmt->null;
  }

  static public function mdlRegCliente($data){

    $rzCliente=$data["rzCliente"];
    $nitCliente=$data["nitCliente"];
    $dirCliente=$data["dirCliente"];
    $paisCliente=$data["paisCliente"];
    $ciudadCliente=$data["ciudadCliente"];
    $nomCliente=$data["nomCliente"];
    $telCliente=$data["telCliente"];
    $descuento=$data["descuento"];

    date_default_timezone_set('America/La_Paz');
    $fecha = date('Y-m-d');

    $stmt=Conexion::conectar()->prepare("insert into cliente(razon_social_cliente, nit_ci_cliente, pais_cliente, ciudad_cliente, direccion_cliente, nombre_cliente, telefono_cliente, descuento) values('$rzCliente', '$nitCliente', '$paisCliente', '$ciudadCliente',  '$dirCliente', '$nomCliente', '$telCliente', '$descuento')");

    if($stmt->execute()){
      return "ok";
    }else{
      return "error";
    }

    $stmt->close();
    $stmt->null;
  }

  static public function mdlInfoCliente($id){
    $stmt=Conexion::conectar()->prepare("select * from cliente where id_cliente=$id");
    $stmt->execute();

    return $stmt->fetch();

    $stmt->close();
    $stmt->null;
  }

  static public function mdlEditCliente($data){

    $rzCliente=$data["rzCliente"];
    $nitCliente=$data["nitCliente"];
    $dirCliente=$data["dirCliente"];
    $paisCliente=$data["paisCliente"];
    $ciudadCliente=$data["ciudadCliente"];
    $nomCliente=$data["nomCliente"];
    $telCliente=$data["telCliente"];
    $idCliente=$data["idCliente"];
    $descuento=$data["descuento"];

    $stmt=Conexion::conectar()->prepare("update cliente set razon_social_cliente='$rzCliente', nit_ci_cliente='$nitCliente',  direccion_cliente='$dirCliente', pais_cliente='$paisCliente', ciudad_cliente='$ciudadCliente', nombre_cliente='$nomCliente', telefono_cliente='$telCliente', descuento='$descuento' where id_cliente=$idCliente");

    if($stmt->execute()){
      return "ok";
    }else{
      return "error";
    }

    $stmt->close();
    $stmt->null;
  }

  static public function mdlEliCliente($id){
    try{
      $cliente=Conexion::conectar()->prepare("delete from cliente where id_cliente=$id");
      $cliente->execute();
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

  static public function mdlBusCliente($nitCliente){
    $stmt=Conexion::conectar()->prepare("select * from cliente where nit_ci_cliente=$nitCliente");
    $stmt->execute();
    return $stmt->fetch();

    $stmt->close();
    $stmt->null;
  }

  static public function mdlCantidadClientes(){
    $stmt=Conexion::conectar()->prepare("select count(*) as cliente from cliente");
    $stmt->execute();

    return $stmt->fetch();

    $stmt->close();
    $stmt->null;
  }

}