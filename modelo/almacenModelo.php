<?php
require_once 'conexion.php'; 

class ModeloAlmacen {
  static public function mdlRegAlmacen($data) {
    $stmt = Conexion::conectar()->prepare("
                INSERT INTO almacen (nombre_almacen, descripcion, direccion, encargado, contacto)
                VALUES (:nomAlmacen, :descAlmacen, :dirAlmacen, :encargado, :contacto)");

    foreach ($data as $key => $value) {
      $stmt->bindParam(":$key", $data[$key], PDO::PARAM_STR);
    }

    $resultado= $stmt->execute() ? 'ok' : $stmt->errorInfo();
    $stmt=null;
    return $resultado;
  }

  static public function mdlInfoAlmacen($id){
    $stmt = Conexion::conectar()->prepare("SELECT * FROM almacen WHERE id_almacen=$id");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  static public function mdlEditAlmacen($data) {
    $pdo = Conexion::conectar();

    $stmt = $pdo->prepare("
    UPDATE almacen 
    SET 
        descripcion = :descAlmacen,
        direccion = :dirAlmacen,
        encargado = :encargado,
        contacto = :contacto,
        estado_almacen = :estado
    WHERE id_almacen = :idAlmacen
");

    $stmt->bindParam(':descAlmacen', $data['descAlmacen'], PDO::PARAM_STR);
    $stmt->bindParam(':dirAlmacen', $data['dirAlmacen'], PDO::PARAM_STR);
    $stmt->bindParam(':encargado', $data['encargado'], PDO::PARAM_STR);
    $stmt->bindParam(':contacto', $data['contacto'], PDO::PARAM_STR);
    $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_INT);
    $stmt->bindParam(':idAlmacen', $data['idAlmacen'], PDO::PARAM_INT);

    $result = $stmt->execute() ? 'ok' : $stmt->errorInfo();

    // Liberar recursos
    $stmt = null;
    $pdo = null;

    return $result;
  }

  static public function mdlEliAlmacen($id) {
    $stmt = Conexion::conectar()->prepare("DELETE FROM almacen WHERE id_almacen = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    return $stmt->execute() ? 'ok' : $stmt->errorInfo();
  }

  static public function mdlMostrarRegistros() {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM almacen");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>