<?php
require_once 'conexion.php'; 

class ModeloAlmacen {
  static public function mdlInsertarRegistro($data) {
    $stmt = Conexion::conectar()->prepare("
                INSERT INTO almacen (id_almacen, nombre_almacen, descripcion, direccion, encargado, contacto, estado_almacen)
                VALUES (:id_almacen, :nombre_almacen, :descripcion, :direccion, :encargado, :contacto, :estado_almacen)
            ");

    foreach ($data as $key => $value) {
      $stmt->bindParam(":$key", $data[$key], PDO::PARAM_STR);
    }

    return $stmt->execute() ? 'ok' : $stmt->errorInfo();
  }

  static public function mdlEditarRegistro($data) {
    $sqlSet = '';
    foreach ($data as $key => $value) {
      if ($key !== 'id') {
        $sqlSet .= "$key = :$key, ";
      }
    }
    $sqlSet = rtrim($sqlSet, ', ');

    $stmt = Conexion::conectar()->prepare("UPDATE almacen SET $sqlSet WHERE id = :id");

    foreach ($data as $key => $value) {
      $stmt->bindParam(":$key", $data[$key], PDO::PARAM_STR);
    }

    return $stmt->execute() ? 'ok' : $stmt->errorInfo();
  }

  static public function mdlEliminarRegistro($id) {
    $stmt = Conexion::conectar()->prepare("DELETE FROM almacen WHERE id = :id");
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