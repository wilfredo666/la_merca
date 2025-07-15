<?php
$ruta = parse_url($_SERVER['REQUEST_URI']);

if (isset($ruta["query"])) {
  if (
    $ruta["query"] == "ctrRegUsuario" ||
    $ruta["query"] == "ctrEditUsuario" ||
    $ruta["query"] == "ctrEliUsuario" ||
    $ruta["query"] == "ctrCambioEstado" ||
    $ruta["query"] == "ctrActualizarPermiso"
  ) {
    $metodo = $ruta["query"];
    $usuario = new ControladorUsuario();
    $usuario->$metodo();
  }
}

class ControladorUsuario
{
  static public function ctrIngresoUsuario()
  {
    if (isset($_POST["usuario"])) {
      $usuario = $_POST["usuario"];
      $password = $_POST["password"];
      $almacen = explode("-",$_POST["almacen"]);
      
      $nomAlmacen = $almacen[0];
      $idAlmacen = $almacen[1];

      //comprobando validez y disponibilidad del usuario
      $respuesta = ModeloUsuario::mdlAccesoUsuario($usuario);

      if ($respuesta == false) {
        echo "<p class='text-danger text-center bg-red mt-1 rounded-pill'>Error de acceso, intente de nuevo</p>";
        return;
      }

      if ($usuario == $respuesta['email'] && password_verify($password, $respuesta['password']) && $respuesta["estado_usuario"] == 1) {
        $_SESSION["ingreso"] = "ok";
        $_SESSION["email"] = $respuesta["email"];
        $_SESSION["nombre"] = $respuesta["nombre"];
        $_SESSION["idUsuario"] = $respuesta["id_usuario"];
        $_SESSION["categoria"] = $respuesta["categoria"];

        //comprobando si el usuario tiene acceso al almacen
        $accAlmacen=ModeloUsuario::mdlAccesoAlmacen($respuesta["id_usuario"], $nomAlmacen);
        if($accAlmacen["permiso"]==1){
          
          //guardando informacion de almacen en sesion
          $almacen=ControladorAlmacen::ctrInfoAlmacen($idAlmacen);
          $_SESSION["idAlmacen"] = $almacen["id_almacen"];
          $_SESSION["nomAlmacen"] = $almacen["nombre_almacen"];
          $_SESSION["descAlmacen"] = $almacen["descripcion"];
          
          echo '<script>
                 window.location="inicio";
                </script>';
        }else{
          echo "<p class='text-danger text-center bg-red mt-1 rounded-pill'>Error de acceso, intente de nuevo</p>";
        }

      } else {

        echo "<p class='text-danger text-center bg-red mt-1 rounded-pill'>Error de acceso, intente de nuevo</p>";
      }
    }
  }

  static public function ctrInfoUsuarios()
  {
    $respuesta = ModeloUsuario::mdlInfoUsuarios();
    return $respuesta;
  }

  static public function ctrRegUsuario()
  {
    require "../modelo/usuarioModelo.php";

    $password = password_hash($_POST["passUsuario"], PASSWORD_DEFAULT);
    $data = array(
      "emailUsuario" => $_POST["emailUsuario"],
      "nomUsuario" => $_POST["nomUsuario"],
      "passUsuario" => $password
    );

    $respuesta = ModeloUsuario::mdlRegUsuario($data);
    echo $respuesta;
  }

  static public function ctrInfoUsuario($id)
  {
    $respuesta = ModeloUsuario::mdlInfoUsuario($id);
    return $respuesta;
  }

  static public function ctrEditUsuario()
  {
    require "../modelo/usuarioModelo.php";

    $passActual = $_POST["passActual"];
    if ($passActual == $_POST["passUsuario"]) {
      $password = $passActual;
    } else {
      $password = password_hash($_POST["passUsuario"], PASSWORD_DEFAULT);
    }

    $data = array(
      "idUsuario" => $_POST["idUsuario"],
      "nomUsuario" => $_POST["nomUsuario"],
      "passUsuario" => $password,
      "catUsuario" => $_POST["catUsuario"]
    );

    $respuesta = ModeloUsuario::mdlEditUsuario($data);
    echo $respuesta;
  }


  static public function ctrEliUsuario()
  {
    require "../modelo/usuarioModelo.php";

    $id = $_POST["id"];

    $respuesta = ModeloUsuario::mdlEliUsuario($id);
    echo $respuesta;
  }

  static public function ctrCambioEstado(){
    require_once "../modelo/usuarioModelo.php";

    $estado =$_POST["est"];
    $id =$_POST["id"];

    $respuesta=ModeloUsuario::mdlCambioEstado($estado, $id);

    echo $respuesta;

  }

  static public function ctrCantidadUsuarios()
  {
    $respuesta = ModeloUsuario::mdlCantidadUsuarios();
    return $respuesta;
  }

  // PERMISOS
  static public function ctrUsuarioPermiso($idUsuario, $idPermiso)
  {
    $respuesta = ModeloUsuario::mdlUsuarioPermiso($idUsuario, $idPermiso);
    return $respuesta;
  }

  static public function ctrActualizarPermiso()
  {
    require "../modelo/usuarioModelo.php";

    $data = array(
      "idUsuario" => $_POST["idUsuario"],
      "idPermiso" => $_POST["idPermiso"]
    );

    $respuesta = ModeloUsuario::mdlActualizarPermiso($data);
    echo $respuesta;
  }

  static public function ctrListaPermisos(){
    $respuesta = ModeloUsuario::mdlListaPermisos();
    return $respuesta;
  }
}
