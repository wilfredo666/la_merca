<?php
require_once "conexion.php";
class ModeloIngreso{

  /* static public function mdlNumNotaIngreso(){
    $stmt=Conexion::conectar()->prepare("select max(id_venta) from venta");
    $stmt->execute();
    $resul = $stmt->fetch();
    $stmt->closeCursor();
    return $resul;
  }
*/
  static public function mdlRegNotaIngreso() {
    date_default_timezone_set("America/La_Paz");
    session_start();

    try {
      $conn = Conexion::conectar();
      $conn->beginTransaction();

      // Insertar sin código_oi
      $stmt = $conn->prepare("
            INSERT INTO otros_ingresos(id_usuario, id_almacen, detalle_oi, total_oi, observacion_oi, concepto_oi, create_at, update_at)
            VALUES (:usuario, :almacen, :detalle, :total, :observacion, :concepto, :creado, :actualizado)
        ");

      $detalle     = $_POST["carritoNI"] ?? '';
      $total       = $_POST["totalNI"] ?? 0;
      $observacion = $_POST["observacion"] ?? '';
      $concepto    = $_POST["conceptoNI"] ?? '';
      $id_usuario  = $_SESSION["idUsuario"] ?? 0;
      $id_almacen  = $_POST["almacen_destino"] ?? 0;
      $creado      = date("Y-m-d H:i:s");
      $actualizado = date("Y-m-d H:i:s");

      // Bind de parámetros
      $stmt->bindParam(":detalle", $detalle);
      $stmt->bindParam(":total", $total);
      $stmt->bindParam(":observacion", $observacion);
      $stmt->bindParam(":concepto", $concepto);
      $stmt->bindParam(":usuario", $id_usuario);
      $stmt->bindParam(":almacen", $id_almacen);
      $stmt->bindParam(":creado", $creado);
      $stmt->bindParam(":actualizado", $actualizado);

      if (!$stmt->execute()) {
        $conn->rollBack();
        return "error_insert";
      }

      // Obtener ID generado
      $ultimoId = $conn->lastInsertId();
      $codigo = "NI-" . $ultimoId;

      // Actualizar código_oi
      $stmtCodigo = $conn->prepare("UPDATE otros_ingresos SET codigo_oi = :codigo WHERE id_otros_ingresos = :id");
      $stmtCodigo->bindParam(":codigo", $codigo);
      $stmtCodigo->bindParam(":id", $ultimoId);

      if (!$stmtCodigo->execute()) {
        $conn->rollBack();
        return "error_update_codigo";
      }

      // Insertar detalle de productos
      $detalleArray = json_decode($_POST["carritoNI"], true);

      foreach ($detalleArray as $item) {
        $idProducto = $item["idProducto"];
        $cantProducto = $item["cantidad"];
        $preProducto = $item["precioUnitario"];

        $stmtNI = $conn->prepare("
                INSERT INTO movimiento (id_almacen, id_producto, codigo, cantidad, tipo, costo, create_at)
                VALUES (:almacen, :producto, :codigo, :cantidad, 'ingreso', :costo, :fecha)
            ");

        $stmtNI->bindParam(":almacen", $id_almacen);
        $stmtNI->bindParam(":producto", $idProducto);
        $stmtNI->bindParam(":codigo", $codigo);
        $stmtNI->bindParam(":cantidad", $cantProducto);
        $stmtNI->bindParam(":costo", $preProducto);
        $stmtNI->bindParam(":fecha", $creado);

        if (!$stmtNI->execute()) {
          $conn->rollBack();
          return "error_detalle";
        }
      }

      $conn->commit();
      return "ok";

    } catch (Exception $e) {
      if (isset($conn)) {
        $conn->rollBack();
      }
      return "error_exception: " . $e->getMessage();
    }
  }

  static public function mdlInfoIngresos($idAlmacen){
    $stmt=Conexion::conectar()->prepare("SELECT
    nombre,
    id_otros_ingresos,
    codigo_oi,
    concepto_oi,
    create_at
FROM
    otros_ingresos
JOIN usuario ON usuario.id_usuario = otros_ingresos.id_usuario
WHERE id_almacen = $idAlmacen");
    $stmt->execute();
    $resul = $stmt->fetchAll();
    $stmt->closeCursor();
    return $resul;
  }
 
  static public function mdlInfoIngreso($id){
    $stmt=Conexion::conectar()->prepare("SELECT
    nombre,
    id_otros_ingresos,
    codigo_oi,
    concepto_oi,
    detalle_oi,
    observacion_oi,
    estado_oi,
    create_at
FROM
    otros_ingresos
JOIN usuario ON usuario.id_usuario = otros_ingresos.id_usuario
WHERE id_otros_ingresos = $id");
    $stmt->execute();
    $resul = $stmt->fetch();
    $stmt->closeCursor();
    return $resul;
  }

  static public function mdlEliNotaIngreso($id){
    $stmt=Conexion::conectar()->prepare("DELETE FROM otros_ingresos WHERE id_otros_ingresos =$id");

    if($stmt->execute()){
      $stmt->closeCursor();
      return "ok";
    }else{
      return "error";
    }
  }
 /*
  static public function mdlCantidadNotaIngresos(){
    $stmt=Conexion::conectar()->prepare("SELECT COUNT(*) as total FROM NotaIngreso");
    $stmt->execute();

    $respuesta = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt->closeCursor();

    return $respuesta;
  }

  static public function mdlRegEgreso($data){
    $cod_producto=$data["cod_producto"];
    $cantidad_egreso=$data["cantidad_egreso"];
    $concepto_egreso=$data["concepto_egreso"];
    $descripcion_egreso=$data["descripcion_egreso"];


    $stmt=Conexion::conectar()->prepare("INSERT INTO egreso(cod_producto, cantidad_egreso, concepto_egreso, descripcion_egreso) VALUES ('$cod_producto','$cantidad_egreso','$concepto_egreso','$descripcion_egreso')");

    if($stmt->execute()){
      $stmt->closeCursor();
      return "ok";
    }else{
      return "error";
    }
  }

  static public function mdlInfoCajaChica(){

    date_default_timezone_set("America/La_Paz");
    $fecha=date("Y-m-d");

    $stmt=Conexion::conectar()->prepare("SELECT SUM(total) AS total_venta FROM NotaIngreso WHERE fecha_emision BETWEEN '$fecha 00:01:00' AND '$fecha 23:59:00'");

    $stmt->execute();
    $respuesta= $stmt->fetch();
    $stmt->closeCursor();
    return $respuesta;

  }

  static public function mdlReporteVentas($fechaInicial, $fechaFinal){

    $stmt=Conexion::conectar()->prepare("SELECT total, fecha_emision FROM NotaIngreso WHERE fecha_emision BETWEEN '$fechaInicial 00:01:00' AND '$fechaFinal 23:59:00'");

    $stmt->execute();
    $respuesta= $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $respuesta;
  }
*/


}