<?php
$ruta = parse_url($_SERVER['REQUEST_URI']);

if (isset($ruta["query"])) {
  if (
    $ruta["query"] == "ctrRegProducto" ||
    $ruta["query"] == "ctrEditProducto" ||
    $ruta["query"] == "ctrEliProducto"
  ) {
    $metodo = $ruta["query"];
    $Producto = new ControladorProducto();
    $Producto->$metodo();
  }
}


class ControladorProducto
{

  static public function ctrInfoProductos()
  {
    $respuesta = ModeloProducto::mdlInfoProductos();
    return $respuesta;
  }

  static public function ctrCantidadProductos()
  {
    $respuesta = ModeloProducto::mdlCantidadProductos();
    return $respuesta;
  }
  
  static public function ctrRegProducto()
  {
    require "../modelo/productoModelo.php";

    //definir fecha y hora
    date_default_timezone_set("America/La_Paz");
    $fecha = date("Y-m-d");
    $hora = date("H-i-s");

    //cargar imagen
    $imagen = $_FILES["ImgProducto"];

    $nomImagen = $imagen["name"];
    $archImagen = $imagen["tmp_name"];

    move_uploaded_file($archImagen, "../assest/dist/img/producto/" . $nomImagen);

    $data = array(
      "codProducto" => $_POST["codProducto"],
      "categoriaProducto" => $_POST["categoriaProducto"],
      "unidad_medida" => $_POST["unidad_medida"],
      "nomProducto" => $_POST["nomProducto"],
      "descProducto" => $_POST["descProducto"],
      "costoProducto" => $_POST["costoProducto"],
      "precioProducto" => $_POST["precioProducto"],
      "marca" => $_POST["marca"],
      "imgProducto" => $nomImagen,
      "create_at" => $fecha . " " . $hora,
      "update_at" => $fecha . " " . $hora
    );

    $respuesta = ModeloProducto::mdlRegProducto($data);
    echo $respuesta;
  }

  static public function ctrInfoProducto($id)
  {
    $respuesta = ModeloProducto::mdlInfoProducto($id);
    return $respuesta;
  }

  static public function ctrEditProducto()
  {
    require "../modelo/productoModelo.php";

    //definir fecha y hora
    date_default_timezone_set("America/La_Paz");
    $fecha = date("Y-m-d");
    $hora = date("H-i-s");

    //cargar imagen
    $imagen = $_FILES["ImgProducto"];
    if($imagen["name"] == ""){
      $nomImagen= $_POST["ImgProductoActual"];
    }else{
      $nomImagen = $imagen["name"];
      $archImagen = $imagen["tmp_name"];

      move_uploaded_file($archImagen, "../assest/dist/img/producto/" . $nomImagen);
    }

    $data = array(
      "id_producto" => $_POST["idProducto"],
      "categoriaProducto" => $_POST["categoriaProducto"],
      "unidad_medida" => $_POST["unidad_medida"],
      "nomProducto" => $_POST["nomProducto"],
      "descProducto" => $_POST["descProducto"],
      "costoProducto" => $_POST["costoProducto"],
      "precioProducto" => $_POST["precioProducto"],
      "estadoProducto" => $_POST["estadoProducto"],
      "marca" => $_POST["marca"],
      "imgProducto" => $nomImagen,
      "update_at" => $fecha . " " . $hora
    );

    $respuesta = ModeloProducto::mdlEditProducto($data);
    echo $respuesta;
  }

  static public function ctrEliProducto()
  {
    require "../modelo/productoModelo.php";
    $id = $_POST["id"];

    $respuesta = ModeloProducto::mdlEliProducto($id);
    echo $respuesta;
  }
}
