<?php
$ruta = parse_url($_SERVER['REQUEST_URI']);

if (isset($ruta["query"])) {
  if (
    $ruta["query"] == "ctrRegProveedor" ||
    $ruta["query"] == "ctrEditProveedor" ||
    $ruta["query"] == "ctrEliProveedor" ||
    $ruta["query"] == "ctrKardexProveedor"
  ) {
    $metodo = $ruta["query"];
    $Proveedor = new ControladorProveedor();
    $Proveedor->$metodo();
  }
}


class ControladorProveedor
{

  static public function ctrInformacionProveedor()
  {
    $respuesta = ModeloProveedor::mdlInformacionProveedor();
    return $respuesta;
  }

  static public function ctrRegProveedor()
  {
    require "../modelo/proveedorModelo.php";

    $data = array(
      "nombre_empresa" => $_POST["nombre_empresa"],
      "nombre_pro" => $_POST["nombre_pro"],
      "ap_paterno_pro" => $_POST["ap_paterno_pro"],
      "ap_materno_pro" => $_POST["ap_materno_pro"],
      "ci_proveedor" => $_POST["ci_proveedor"],
      "direccion_pro" => $_POST["direccion_pro"],
      "telefono_pro" => $_POST["telefono_pro"]
    );

    $respuesta = ModeloProveedor::mdlRegProveedor($data);
    echo $respuesta;
  }

  static public function ctrInfoProveedor($id)
  {
    $respuesta = ModeloProveedor::mdlInfoProveedor($id);
    return $respuesta;
  }

  static public function ctrEditProveedor()
  {
    require "../modelo/proveedorModelo.php";

    $data = array(
      "id_proveedor" => $_POST["id_proveedor"],
      "nombre_empresa" => $_POST["nombre_empresa"],
      "nombre_pro" => $_POST["nombre_pro"],
      "ap_paterno_pro" => $_POST["ap_paterno_pro"],
      "ap_materno_pro" => $_POST["ap_materno_pro"],
      "ci_proveedor" => $_POST["ci_proveedor"],
      "direccion_pro" => $_POST["direccion_pro"],
      "telefono_pro" => $_POST["telefono_pro"],
      "email_pro" => null,
      "estado_pro" => 1
    );
    $respuesta = ModeloProveedor::mdlEditProveedor($data);
    echo $respuesta;
  }

  static public function ctrEliProveedor()
  {
    require "../modelo/proveedorModelo.php";
    $id = $_POST["id"];

    $respuesta = ModeloProveedor::mdlEliProveedor($id);
    echo $respuesta;
  }

    static public function ctrKardexProveedor()
  {
    require "../modelo/proveedorModelo.php";

    // Obtener los parámetros enviados desde la solicitud AJAX
    $id_proveedor = $_POST["id_proveedor"];
    $fecha_inicial = $_POST["fecha_inicial"];
    $fecha_final = $_POST["fecha_final"];
    $respuesta = ModeloProveedor::mdlKardexProveedor($id_proveedor, $fecha_inicial, $fecha_final);
    echo json_encode($respuesta);
  }

}
