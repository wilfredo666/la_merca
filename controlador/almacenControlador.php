<?php
class ControladorAlmacen {
    public static function ctrMostrarRegistros() {

        $respuesta = ModeloAlmacen::mdlMostrarRegistros();
        return $respuesta;
    }

    public static function ctrInsertarRegistro() {
        require "../modelo/almacenModelo.php";
        $data = $_POST;
        $respuesta = ModeloAlmacen::mdlInsertarRegistro($data);
        echo $respuesta;
    }

    public static function ctrEditarRegistro() {
        require "../modelo/almacenModelo.php";
        $data = $_POST;
        $respuesta = ModeloAlmacen::mdlEditarRegistro($data);
        echo $respuesta;
    }

    public static function ctrEliminarRegistro() {
        require "../modelo/almacenModelo.php";
        $id = $_POST["id"];
        $respuesta = ModeloAlmacen::mdlEliminarRegistro($id);
        echo $respuesta;
    }
}
?>