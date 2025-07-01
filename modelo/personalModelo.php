<?php 
require_once "conexion.php";
class ModeloPersonal{


  static public function mdlInformacionPersonal(){
    $stmt=Conexion::conectar()->prepare("select * from personal");
    $stmt->execute();

    return $stmt->fetchAll();

    $stmt->close();
    $stmt->null;
  }

  static public function mdlRegPersonal($data){
    $nomPersonal=$data["nomPersonal"];
    $patPersonal=$data["patPersonal"];
    $matPersonal=$data["matPersonal"];
    $ciPersonal=$data["ciPersonal"];
    $cargoPersonal=$data["cargoPersonal"];
    $telPersonal=$data["telPersonal"];
    $dirPersonal=$data["dirPersonal"];
    $ciudadPersonal = $data["ciudadPersonal"];
    $imgPersonal = $data["imgPersonal"];
    $fechaInicio = $data["fechaInicio"];
    $salarioPersonal = $data["salarioPersonal"];
    $personaRef = $data["personaRef"];
    $telefonoRef = $data["telefonoRef"];
    $direccionRef = $data["direccionRef"];

    $stmt=Conexion::conectar()->prepare("insert into personal(ci_personal, ap_paterno, ap_materno, nombre, cargo, direccion, telefono, ciudad_personal, imagen_personal, fecha_inicio, salario_personal, persona_referencia, telefono_referencia, direccion_referencia) values('$ciPersonal', '$patPersonal', '$matPersonal',  '$nomPersonal', '$cargoPersonal', '$dirPersonal', '$telPersonal', '$ciudadPersonal', '$imgPersonal', '$fechaInicio', '$salarioPersonal', '$personaRef', '$telefonoRef', '$direccionRef')");

    if($stmt->execute()){
      $stmt = null;
      return "ok";
    }else{
      $stmt = null;
      return "error";
    }
    
  }

  static public function mdlInfoPersonal($id){
    $stmt=Conexion::conectar()->prepare("select * from personal where id_personal=$id");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->close();
    $stmt->null;
  }

  static public function mdlEditPersonal($data){
    $idPersonal=$data["idPersonal"];
    $estadoPersonal=$data["estadoPersonal"];
    $nomPersonal=$data["nomPersonal"];
    $patPersonal=$data["patPersonal"];
    $matPersonal=$data["matPersonal"];
    $ciPersonal=$data["ciPersonal"];
    $cargoPersonal=$data["cargoPersonal"];
    $telPersonal=$data["telPersonal"];
    $dirPersonal=$data["dirPersonal"];
    $ciudadPersonal = $data["ciudadPersonal"];
    $imgPersonal = $data["imgPersonal"];
    $fechaInicio = $data["fechaInicio"];
    $salarioPersonal = $data["salarioPersonal"];
    $personaRef = $data["personaRef"];
    $telefonoRef = $data["telefonoRef"];
    $direccionRef = $data["direccionRef"];

    $stmt=Conexion::conectar()->prepare("update personal set nombre='$nomPersonal', ap_paterno='$patPersonal',  ap_materno='$matPersonal', ci_personal='$ciPersonal', cargo='$cargoPersonal', direccion='$dirPersonal', telefono='$telPersonal', estado_personal='$estadoPersonal', ciudad_personal='$ciudadPersonal', imagen_personal='$imgPersonal', fecha_inicio='$fechaInicio', salario_personal='$salarioPersonal', persona_referencia='$personaRef', telefono_referencia='$telefonoRef', direccion_referencia='$direccionRef'  where id_personal=$idPersonal");

    if($stmt->execute()){
      return "ok";
    }else{
      return "error";
    }
    $stmt->close();
    $stmt->null;
  }

  static public function mdlEliPersonal($id){
    try{
      $personal=Conexion::conectar()->prepare("delete from personal where id_personal=$id");
      $personal->execute();
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