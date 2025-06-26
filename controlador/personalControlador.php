<?php
$ruta = parse_url($_SERVER['REQUEST_URI']);

if (isset($ruta["query"])) {
  if (
    $ruta["query"] == "ctrRegPersonal" ||
    $ruta["query"] == "ctrEditPersonal" ||
    $ruta["query"] == "ctrEliPersonal" ||
    $ruta["query"] == "ctrBusPersonal"
  ) {
    $metodo = $ruta["query"];
    $Personal = new ControladorPersonal();
    $Personal->$metodo();
  }
}


class ControladorPersonal
{

  static public function ctrInformacionPersonal()
  {
    $respuesta = ModeloPersonal::mdlInformacionPersonal();
    return $respuesta;
  }

  static public function ctrRegPersonal()
  {
    require "../modelo/personalModelo.php";

    //qr de direccion
    $direccion_img=$_FILES["dirPersonal"];

    $nomImagenDir = $direccion_img["name"];
    $archImagenDir = $direccion_img["tmp_name"];

    move_uploaded_file($archImagenDir, "../assest/dist/img/personal/" . $nomImagenDir);

    //imagen del personal
    $personal_img=$_FILES["imgPersonal"];

    $nomImagenPer = $personal_img["name"];
    $archImagenPer = $personal_img["tmp_name"];

    move_uploaded_file($archImagenPer, "../assest/dist/img/personal/" . $nomImagenPer);

    $data = array(
      "nomPersonal" => $_POST["nomPersonal"],
      "patPersonal" => $_POST["patPersonal"],
      "matPersonal" => $_POST["matPersonal"],
      "ciPersonal" => $_POST["ciPersonal"],
      "depPersonal" => $_POST["depPersonal"],
      "cargoPersonal" => $_POST["cargoPersonal"],
      "telPersonal" => $_POST["telPersonal"],
      "dirPersonal" => $nomImagenDir,
      "ciudadPersonal" => $_POST["ciudadPersonal"],
      "imgPersonal" => $nomImagenPer,
      "fechaInicio" => $_POST["fechaInicio"],
      "salarioPersonal" => $_POST["salarioPersonal"],

      "personaRef" => $_POST["personaRef"],
      "telefonoRef" => $_POST["telefonoRef"],
      "direccionRef" => $_POST["direccionRef"],
    );

    $respuesta = ModeloPersonal::mdlRegPersonal($data);
    echo $respuesta;
  }

  static public function ctrInfoPersonal($id)
  {
    $respuesta = ModeloPersonal::mdlInfoPersonal($id);
    return $respuesta;
  }

  static public function ctrEditPersonal()
  {
    require "../modelo/personalModelo.php";

    //qr de direccion
    $direccion_img=$_FILES["dirPersonal"];
    if ($direccion_img["name"] == "") {
      $nomImagenDir = $_POST["dirPerAntiguo"];
    } else {

      $nomImagenDir = $direccion_img["name"];
      $archImagenDir = $direccion_img["tmp_name"];

      move_uploaded_file($archImagenDir, "../assest/dist/img/personal/" . $nomImagenDir);

    }

    //imagen del personal
    $personal_img=$_FILES["imgPersonal"];
    if ($personal_img["name"] == "") {
      $nomImagenPer = $_POST["imgPerAntiguo"];
    } else {

      $nomImagenPer = $personal_img["name"];
      $archImagenPer = $personal_img["tmp_name"];

      move_uploaded_file($archImagenPer, "../assest/dist/img/personal/" . $nomImagenPer);

    }

    $data = array(
      "estadoPersonal" => $_POST["estadoPersonal"],
      "idPersonal" => $_POST["idPersonal"],
      "nomPersonal" => $_POST["nomPersonal"],
      "patPersonal" => $_POST["patPersonal"],
      "matPersonal" => $_POST["matPersonal"],
      "ciPersonal" => $_POST["ciPersonal"],
      "depPersonal" => $_POST["depPersonal"],
      "cargoPersonal" => $_POST["cargoPersonal"],
      "telPersonal" => $_POST["telPersonal"],
      "dirPersonal" => $nomImagenDir,
      "ciudadPersonal" => $_POST["ciudadPersonal"],
      "imgPersonal" => $nomImagenPer,
      "fechaInicio" => $_POST["fechaInicio"],
      "salarioPersonal" => $_POST["salarioPersonal"],

      "personaRef" => $_POST["personaRef"],
      "telefonoRef" => $_POST["telefonoRef"],
      "direccionRef" => $_POST["direccionRef"],
    );
    $respuesta = ModeloPersonal::mdlEditPersonal($data);
    echo $respuesta;
  }

  static public function ctrEliPersonal()
  {
    require "../modelo/personalModelo.php";
    $id = $_POST["id"];

    $respuesta = ModeloPersonal::mdlEliPersonal($id);
    echo $respuesta;
  }
}
