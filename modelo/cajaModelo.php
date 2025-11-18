<?php
require_once 'conexion.php';

class ModeloCaja
{
  static public function mdlRegCaja($data)
  {
    $stmt = Conexion::conectar()->prepare("
                INSERT INTO caja (tipo, concepto, descripcion, cantidad, id_usuario, id_almacen)
                VALUES (:tipo, :concepto, :descripcion, :cantidad, :id_usuario, :id_almacen)");

    $stmt->bindParam(":tipo", $data['tipo'], PDO::PARAM_STR);
    $stmt->bindParam(":concepto", $data['concepto'], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion", $data['descripcion'], PDO::PARAM_STR);
    $stmt->bindParam(":cantidad", $data['cantidad'], PDO::PARAM_STR);
    $stmt->bindParam(":id_usuario", $data['id_usuario'], PDO::PARAM_INT);
    $stmt->bindParam(":id_almacen", $data['id_almacen'], PDO::PARAM_INT);

    $resultado = $stmt->execute() ? 'ok' : $stmt->errorInfo();
    $stmt = null;
    return $resultado;
  }

  static public function mdlInfoCaja($id)
  {
    $stmt = Conexion::conectar()->prepare("SELECT * FROM caja WHERE id_caja = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  static public function mdlEditCaja($data)
  {
    $pdo = Conexion::conectar();

    $stmt = $pdo->prepare("
    UPDATE caja 
    SET 
        tipo = :tipo,
        concepto = :concepto,
        descripcion = :descripcion,
        cantidad = :cantidad,
        estado_caja = :estado,
        update_at = NOW()
    WHERE id_caja = :id_caja
      AND id_almacen = :id_almacen");

    $stmt->bindParam(':tipo', $data['tipo'], PDO::PARAM_STR);
    $stmt->bindParam(':concepto', $data['concepto'], PDO::PARAM_STR);
    $stmt->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
    $stmt->bindParam(':cantidad', $data['cantidad'], PDO::PARAM_STR);
    $stmt->bindParam(':estado', $data['estado'], PDO::PARAM_INT);
    $stmt->bindParam(':id_caja', $data['id_caja'], PDO::PARAM_INT);

    $result = $stmt->execute() ? 'ok' : $stmt->errorInfo();

    // Liberar recursos
    $stmt = null;
    $pdo = null;

    return $result;
  }

  static public function mdlEliCaja($id)
  {
    $stmt = Conexion::conectar()->prepare("DELETE FROM caja WHERE id_caja = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $resultado = $stmt->execute() ? 'ok' : $stmt->errorInfo();
    $stmt = null;
    return $resultado;
  }

  static public function mdlMostrarRegistros()
  {
    //obtener el id del almacen desde la sesión
    $id_almacen = $_SESSION["idAlmacen"];
    $stmt = Conexion::conectar()->prepare("
        SELECT c.*, u.nombre
        FROM caja c 
        LEFT JOIN usuario u ON c.id_usuario = u.id_usuario 
        WHERE c.id_almacen = :id_almacen 
        ORDER BY c.create_at DESC;
    ");
    $stmt->bindParam(":id_almacen", $id_almacen, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  static public function mdlInfoCajaChica()
  {
    //obtener el id del almacen desde la sesión
    $id_almacen = $_SESSION['idAlmacen'];
    $stmt = Conexion::conectar()->prepare("
        SELECT 
            SUM(CASE WHEN tipo = 'ingreso' THEN cantidad ELSE 0 END) as total_ingresos,
            SUM(CASE WHEN tipo = 'salida' THEN cantidad ELSE 0 END) as total_salidas,
            (SUM(CASE WHEN tipo = 'ingreso' THEN cantidad ELSE 0 END) - 
             SUM(CASE WHEN tipo = 'salida' THEN cantidad ELSE 0 END)) as saldo_actual
        FROM caja 
        WHERE id_almacen = :id_almacen
    ");
    $stmt->bindParam(":id_almacen", $id_almacen, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
