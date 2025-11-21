<?php
$ruta = parse_url($_SERVER['REQUEST_URI']);

if (isset($ruta["query"])) {
  if (
    $ruta["query"] == "ctrRegProducto" ||
    $ruta["query"] == "ctrEditProducto" ||
    $ruta["query"] == "ctrBusProducto" ||
    $ruta["query"] == "ctrBusProductoTs" ||
    $ruta["query"] == "ctrGuardarPrecio" ||
    $ruta["query"] == "ctrListarPrecios" ||
    $ruta["query"] == "ctrEliminarPrecio" ||
    $ruta["query"] == "ctrInfoPrecio" ||
    $ruta["query"] == "ctrActualizarPrecio" ||
    $ruta["query"] == "ctrPreciosAdicionales" ||
    $ruta["query"] == "ctrEliProducto" ||
    $ruta["query"] == "ctrReporteKardex"
  ) {
    $metodo = $ruta["query"];
    $Producto = new ControladorProducto();
    $Producto->$metodo();
  }
}


class ControladorProducto
{

  static public function ctrInfoProductos(){
    $respuesta = ModeloProducto::mdlInfoProductos();
    return $respuesta;
  }

  static public function ctrCantidadProductos(){
    $respuesta = ModeloProducto::mdlCantidadProductos();
    return $respuesta;
  }

  static public function ctrRegProducto(){
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

    // DEBUG: Registrar información recibida
    error_log("=== DEBUG PRODUCTO ===");
    error_log("POST completo: " . print_r($_POST, true));
    error_log("FILES: " . print_r($_FILES, true));
    
    // Obtener precios adicionales del carrito si existen
    $preciosAdicionales = isset($_POST["preciosCarrito"]) ? json_decode($_POST["preciosCarrito"], true) : array();
    
    error_log("Precios adicionales recibidos: " . print_r($preciosAdicionales, true));
    error_log("Data del producto: " . print_r($data, true));
    
    $respuesta = ModeloProducto::mdlRegProducto($data, $preciosAdicionales);
    
    error_log("Respuesta del modelo: " . $respuesta);
    error_log("=== FIN DEBUG ===");
    
    echo $respuesta;
  }

  static public function ctrInfoProducto($id){
    $respuesta = ModeloProducto::mdlInfoProducto($id);
    return $respuesta;
  }

  static public function ctrPreciosAdicionales(){
    require "../modelo/productoModelo.php";
    $id = $_POST["idProducto"];
    $respuesta = ModeloProducto::mdlPreciosAdicionales($id);
    echo json_encode($respuesta);
  }

  static public function ctrEditProducto(){
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
      "codProducto" => $_POST["codProducto"],
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

  static public function ctrEliProducto(){
    require "../modelo/productoModelo.php";
    $id = $_POST["id"];

    $respuesta = ModeloProducto::mdlEliProducto($id);
    echo $respuesta;
  }

  static public function ctrBusProducto(){
    require_once "../modelo/productoModelo.php";
    session_start();

    $codProducto =$_POST["codProducto"];
    $idAlmacen  = $_SESSION["idAlmacen"] ?? 0;
    $respuesta=ModeloProducto::mdlBusProducto($codProducto, $idAlmacen);

    echo json_encode($respuesta);
  }

  static public function ctrBusProductoTs(){
    require_once "../modelo/productoModelo.php";

    $codProducto =$_POST["codProducto"];
    $almacenOrigen =$_POST["almacenOrigen"];

    $respuesta=ModeloProducto::mdlBusProductoTs($codProducto, $almacenOrigen);

    echo json_encode($respuesta);
  }

  static public function ctrGuardarPrecio(){
    if (isset($_GET["ctrGuardarPrecio"])) {
      require_once "../modelo/productoModelo.php";

      $idProducto = $_POST["idProducto"] ?? 0;
      $concepto   = trim($_POST["concepto"] ?? '');
      $precio     = $_POST["precioAdicional"] ?? 0;

      // Validar duplicado
      /*      $existe = ModeloProducto::mdlExisteConcepto($idProducto, $concepto);
      if ($existe) {
        echo json_encode(["status" => "duplicado"]);
        return;
      }*/

      // Registrar nuevo precio
      $respuesta = ModeloProducto::mdlGuardarPrecio($idProducto, $concepto, $precio);
      echo json_encode(["status" => $respuesta ? "ok" : "error"]);
    }
  }

  static public function ctrListarPrecios(){
    if (isset($_GET["ctrListarPrecios"])) {
      require_once "../modelo/productoModelo.php";
      $respuesta = ModeloProducto::mdlListarPrecios($_POST["idProducto"]);
      echo json_encode($respuesta);
    }
  }

  static public function ctrEliminarPrecio(){
    if (isset($_GET["ctrEliminarPrecio"])) {
      require_once "../modelo/productoModelo.php";
      $respuesta = ModeloProducto::mdlEliminarPrecio($_POST["idPrecio"]);
      echo json_encode(["status" => $respuesta ? "ok" : "error"]);
    }
  }

  static public function ctrInfoPrecio(){
    if (isset($_GET["ctrInfoPrecio"])) {
      require_once "../modelo/productoModelo.php";
      $respuesta = ModeloProducto::mdlInfoPrecio($_POST["idPrecio"]);
      echo json_encode($respuesta);
    }
  }

  static public function ctrActualizarPrecio(){
    if (isset($_GET["ctrActualizarPrecio"])) {
      require_once "../modelo/productoModelo.php";

      $idPrecio  = $_POST["idPrecio"] ?? 0;
      $concepto  = trim($_POST["concepto"] ?? '');
      $precio    = $_POST["precioAdicional"] ?? 0;
      $estado    = $_POST["estado"] ?? 1;

      $respuesta = ModeloProducto::mdlActualizarPrecio($idPrecio, $concepto, $precio, $estado);
      echo json_encode(["status" => $respuesta ? "ok" : "error"]);
    }
  }

  static public function ctrProductosPorCategoria($categoria) {
    $respuesta = ModeloProducto::mdlProductosPorCategoria($categoria);
    return $respuesta;
  }

  static public function ctrMasVendidos(){
    $respuesta=ModeloProducto::mdlMasVendidos();
    return $respuesta;
  }

  static public function ctrReporteKardex(){
    require "../modelo/productoModelo.php";
    
    $fechaInicial = $_POST["fechaInicial"] ?? '';
    $fechaFinal = $_POST["fechaFinal"] ?? '';
    $idProducto = $_POST["idProducto"] ?? '';
    $tipo = $_POST["tipo"] ?? '';
    
    $respuesta = ModeloProducto::mdlReporteKardex($fechaInicial, $fechaFinal, $idProducto, $tipo);
    echo json_encode($respuesta);
  }

}
