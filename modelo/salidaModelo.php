<?php
require_once "conexion.php";
class ModeloSalida{

  static public function mdlNumFactura(){
    $stmt=Conexion::conectar()->prepare("select max(id_venta) from venta");
    $stmt->execute();
    $resul = $stmt->fetch();
    $stmt->closeCursor();
    return $resul;
  }

 static public function mdlRegNotaVenta() {
  date_default_timezone_set("America/La_Paz");
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  try {
    $conn = Conexion::conectar();
    $conn->beginTransaction();

    $cliente     = $_POST["idCliente"] ?? 1;
    $detalle     = $_POST["carritoVenta"] ?? '';
    $total       = $_POST["totVenta"] ?? 0;
    $descuento   = $_POST["descuento"] ?? 0;
    $neto        = $total - $descuento;
    $observacion = $_POST["observacion"] ?? '';
    $id_usuario  = $_SESSION["idUsuario"] ?? 0;
    $id_almacen  = $_SESSION["idAlmacen"] ?? 0;
    $creado      = date("Y-m-d H:i:s");
    $actualizado = date("Y-m-d H:i:s");

    // Insertar sin código inicial
    $stmt = $conn->prepare("
      INSERT INTO venta (
        id_cliente, detalle_venta, total, descuento, neto,
        observacion, id_usuario, id_almacen,
        create_at, update_at
      ) VALUES (
        :cliente, :detalle, :total, :descuento, :neto,
        :observacion, :usuario, :almacen,
        :creado, :actualizado
      )
    ");

    $stmt->bindParam(":cliente", $cliente);
    $stmt->bindParam(":detalle", $detalle);
    $stmt->bindParam(":total", $total);
    $stmt->bindParam(":descuento", $descuento);
    $stmt->bindParam(":neto", $neto);
    $stmt->bindParam(":observacion", $observacion);
    $stmt->bindParam(":usuario", $id_usuario);
    $stmt->bindParam(":almacen", $id_almacen);
    $stmt->bindParam(":creado", $creado);
    $stmt->bindParam(":actualizado", $actualizado);

    if (!$stmt->execute()) {
      $conn->rollBack();
      return "error_insert";
    }

    // Obtener ID generado y crear código
    $ultimoId = $conn->lastInsertId();
    $codigo = "NV-" . $ultimoId;

    // Actualizar código de venta
    $stmtCodigo = $conn->prepare("
      UPDATE venta SET codigo_venta = :codigo WHERE id_venta = :id
    ");
    $stmtCodigo->bindParam(":codigo", $codigo);
    $stmtCodigo->bindParam(":id", $ultimoId);

    if (!$stmtCodigo->execute()) {
      $conn->rollBack();
      return "error_update_codigo";
    }

    // Insertar movimientos
    $detalleArray = json_decode($_POST["carritoVenta"], true) ?? [];
    if (!is_array($detalleArray) || empty($detalleArray)) {
      $conn->rollBack();
      return "error_detalle_vacio";
    }

    foreach ($detalleArray as $item) {
      $idProducto   = $item["idProducto"];
      $cantProducto = $item["cantidad"];
      $preProducto  = $item["precioUnitario"];

      $stmtNV = $conn->prepare("
        INSERT INTO movimiento
        (id_almacen, id_producto, codigo, cantidad, tipo, costo, create_at)
        VALUES
        (:almacen, :producto, :codigo, :cantidad, 'salida', :costo, :fecha)
      ");

      $stmtNV->bindParam(":almacen", $id_almacen);
      $stmtNV->bindParam(":producto", $idProducto);
      $stmtNV->bindParam(":codigo", $codigo);
      $stmtNV->bindParam(":cantidad", $cantProducto);
      $stmtNV->bindParam(":costo", $preProducto);
      $stmtNV->bindParam(":fecha", $creado);

      if (!$stmtNV->execute()) {
        $conn->rollBack();
        return "error_movimiento";
      }
    }

    $conn->commit();
    return ["status" => "ok", "id" => $ultimoId, "codigo" => $codigo];

  } catch (Exception $e) {
    if (isset($conn)) {
      $conn->rollBack();
    }
    return "error_exception: " . $e->getMessage();
  }
}
  
  static public function mdlInfoFacturas(){
    $stmt=Conexion::conectar()->prepare("SELECT
    id_venta,
    codigo_venta,
    total,
    create_at,
    estado_venta,
    u.nombre,
    c.razon_social_cliente
FROM
    venta
JOIN cliente as c ON c.id_cliente = venta.id_cliente
JOIN usuario as u ON u.id_usuario = venta.id_usuario");
    $stmt->execute();
    $resul = $stmt->fetchAll();
    $stmt->closeCursor();
    return $resul;
  }

  static public function mdlInfoFactura($id){
    $stmt=Conexion::conectar()->prepare("SELECT
    id_venta,
    codigo_venta,
    total,
    create_at,
    estado_venta,
    u.nombre,
    c.razon_social_cliente,
    detalle_venta,
    observacion
FROM
    venta
JOIN cliente as c ON c.id_cliente = venta.id_cliente
JOIN usuario as u ON u.id_usuario = venta.id_usuario
WHERE id_venta=$id");
    $stmt->execute();
    $resul = $stmt->fetch();
    $stmt->closeCursor();
    return $resul;
  }

  static public function mdlAnularFactura($cuf){
    $stmt=Conexion::conectar()->prepare("UPDATE factura set estado=0 WHERE cuf='$cuf'");

    if($stmt->execute()){
      $stmt->closeCursor();
      return "ok";
    }else{
      return "error";
    }
  }

  static public function mdlCantidadFacturas(){
    $stmt=Conexion::conectar()->prepare("SELECT COUNT(*) as total FROM factura");
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

    $stmt=Conexion::conectar()->prepare("SELECT SUM(total) AS total_venta FROM factura WHERE fecha_emision BETWEEN '$fecha 00:01:00' AND '$fecha 23:59:00'");

    $stmt->execute();
    $respuesta= $stmt->fetch();
    $stmt->closeCursor();
    return $respuesta;

  }

  static public function mdlReporteVentas($fechaInicial, $fechaFinal){

    $stmt=Conexion::conectar()->prepare("SELECT total, fecha_emision FROM factura WHERE fecha_emision BETWEEN '$fechaInicial 00:01:00' AND '$fechaFinal 23:59:00'");

    $stmt->execute();
    $respuesta= $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $respuesta;
  }

  static public function mdlRegNotaSalida() {
    date_default_timezone_set("America/La_Paz");
    session_start();

    try {
      $conn = Conexion::conectar();
      $conn->beginTransaction();

      // Insertar sin código_oi
      $stmt = $conn->prepare("
            INSERT INTO otras_salidas(id_usuario, id_almacen, detalle_os, total_os, observacion_os, concepto_os, create_at, update_at)
            VALUES (:usuario, :almacen, :detalle, :total, :observacion, :concepto, :creado, :actualizado)
        ");

      $detalle     = $_POST["carritoNS"] ?? '';
      $total       = $_POST["totalNS"] ?? 0;
      $observacion = $_POST["observacion"] ?? '';
      $concepto    = $_POST["conceptoNS"] ?? '';
      $id_usuario  = $_SESSION["idUsuario"] ?? 0;
      $id_almacen  = $_POST["almacen_origen"] ?? 0;
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
      $codigo = "NS-" . $ultimoId;

      // Actualizar código_oi
      $stmtCodigo = $conn->prepare("UPDATE otras_salidas SET codigo_os = :codigo WHERE id_otras_salidas = :id");
      $stmtCodigo->bindParam(":codigo", $codigo);
      $stmtCodigo->bindParam(":id", $ultimoId);

      if (!$stmtCodigo->execute()) {
        $conn->rollBack();
        return "error_update_codigo";
      }

      // Insertar detalle de productos
      $detalleArray = json_decode($_POST["carritoNS"], true);

      foreach ($detalleArray as $item) {
        $idProducto = $item["idProducto"];
        $cantProducto = $item["cantidad"];
        $preProducto = $item["precioUnitario"];

        $stmtNI = $conn->prepare("
                INSERT INTO movimiento (id_almacen, id_producto, codigo, cantidad, tipo, costo, create_at)
                VALUES (:almacen, :producto, :codigo, :cantidad, 'salida', :costo, :fecha)
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

  static public function mdlInfoSalidas($idAlmacen){
    $stmt=Conexion::conectar()->prepare("SELECT
    nombre,
    id_otras_salidas ,
    codigo_os,
    concepto_os,
    create_at
FROM
    otras_salidas
JOIN usuario ON usuario.id_usuario = otras_salidas.id_usuario
WHERE id_almacen = $idAlmacen");
    $stmt->execute();
    $resul = $stmt->fetchAll();
    $stmt->closeCursor();
    return $resul;
  }

  static public function mdlInfoSalida($id){
    $stmt=Conexion::conectar()->prepare("SELECT
    nombre,
    id_otras_salidas,
    codigo_os,
    concepto_os,
    detalle_os,
    observacion_os,
    estado_os,
    create_at
FROM
    otras_salidas
JOIN usuario ON usuario.id_usuario = otras_salidas.id_usuario
WHERE id_otras_salidas = $id");
    $stmt->execute();
    $resul = $stmt->fetch();
    $stmt->closeCursor();
    return $resul;
  }

  static public function mdlEliNotaSalida($id){
    $stmt=Conexion::conectar()->prepare("DELETE FROM otras_salidas WHERE id_otras_salidas =$id");

    if($stmt->execute()){
      $stmt->closeCursor();
      return "ok";
    }else{
      return "error";
    }
  }

  static public function mdlInfoUltimoQr(){
    $stmt=Conexion::conectar()->prepare("SELECT *
FROM metodo_pago
WHERE tipo_metodo = 'qr'
ORDER BY id_metodopago DESC
LIMIT 1");

    $stmt->execute();
    $resul = $stmt->fetch();
    $stmt->closeCursor();
    return $resul;
  }

  static public function mdlEditQr($data){
    $stmt = Conexion::conectar()->prepare(
      "UPDATE metodo_pago SET img_metodo = :img WHERE id_metodopago = :id"
    );

    $stmt->bindParam(":img", $data["imgQr"], PDO::PARAM_STR);
    $stmt->bindParam(":id", $data["id"], PDO::PARAM_INT);

    if($stmt->execute()){
      return "ok";
    } else {
      return "error";
    }
    $stmt = null; // buena práctica cerrar conexión
  }

  static public function mdlRegNotaTraspaso() {
    date_default_timezone_set("America/La_Paz");
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    try {
      $conn = Conexion::conectar();
      $conn->beginTransaction();

      // Insertar sin código inicial
      $stmt = $conn->prepare("
            INSERT INTO traspaso 
            (id_almacen_origen, id_almacen_destino, detalle_traspaso, observacion_traspaso, id_usuario, create_at, update_at) 
            VALUES (:almacenOrigen, :almacenDestino, :detalle, :observacion, :usuario, :creado, :actualizado)
        ");

      $id_almacen_origen  = $_POST["almacen_origen"] ?? 0;
      $id_almacen_destino = $_POST["almacen_destino"] ?? 0;
      $detalle            = $_POST["carritoTraspaso"] ?? '';
      $observacion        = $_POST["observacion"] ?? '';
      $id_usuario         = $_SESSION["idUsuario"] ?? 0;
      $creado             = date("Y-m-d H:i:s");
      $actualizado        = date("Y-m-d H:i:s");

      $stmt->bindParam(":almacenOrigen", $id_almacen_origen);
      $stmt->bindParam(":almacenDestino", $id_almacen_destino);
      $stmt->bindParam(":detalle", $detalle);
      $stmt->bindParam(":observacion", $observacion);
      $stmt->bindParam(":usuario", $id_usuario);
      $stmt->bindParam(":creado", $creado);
      $stmt->bindParam(":actualizado", $actualizado);

      if (!$stmt->execute()) {
        $conn->rollBack();
        return "error_insert";
      }

      // Obtener ID generado
      $ultimoId = $conn->lastInsertId();
      $codigo = "NT-" . $ultimoId;

      // Actualizar código de traspaso
      $stmtCodigo = $conn->prepare("
            UPDATE traspaso 
            SET cod_traspaso = :codigo 
            WHERE id_traspaso = :id
        ");
      $stmtCodigo->bindParam(":codigo", $codigo);
      $stmtCodigo->bindParam(":id", $ultimoId);

      if (!$stmtCodigo->execute()) {
        $conn->rollBack();
        return "error_update_codigo";
      }

      // Insertar detalle de productos
      $detalleArray = json_decode($_POST["carritoTraspaso"], true) ?? [];
      if (!is_array($detalleArray) || empty($detalleArray)) {
        $conn->rollBack();
        return "error_detalle_vacio";
      }

      foreach ($detalleArray as $item) {
        $idProducto   = $item["idProducto"];
        $cantProducto = $item["cantidad"];
        $preProducto  = $item["costo"];

        // Salida - origen
        $stmtSalida = $conn->prepare("
                INSERT INTO movimiento 
                (id_almacen, id_producto, codigo, cantidad, tipo, costo, create_at)
                VALUES (:almacen, :producto, :codigo, :cantidad, 'salida', :costo, :fecha)
            ");
        $stmtSalida->bindParam(":almacen", $id_almacen_origen);
        $stmtSalida->bindParam(":producto", $idProducto);
        $stmtSalida->bindParam(":codigo", $codigo);
        $stmtSalida->bindParam(":cantidad", $cantProducto);
        $stmtSalida->bindParam(":costo", $preProducto);
        $stmtSalida->bindParam(":fecha", $creado);

        if (!$stmtSalida->execute()) {
          $conn->rollBack();
          return "error_salida";
        }

        // Ingreso - destino
        $stmtIngreso = $conn->prepare("
                INSERT INTO movimiento 
                (id_almacen, id_producto, codigo, cantidad, tipo, costo, create_at)
                VALUES (:almacen, :producto, :codigo, :cantidad, 'ingreso', :costo, :fecha)
            ");
        $stmtIngreso->bindParam(":almacen", $id_almacen_destino);
        $stmtIngreso->bindParam(":producto", $idProducto);
        $stmtIngreso->bindParam(":codigo", $codigo);
        $stmtIngreso->bindParam(":cantidad", $cantProducto);
        $stmtIngreso->bindParam(":costo", $preProducto);
        $stmtIngreso->bindParam(":fecha", $creado);

        if (!$stmtIngreso->execute()) {
          $conn->rollBack();
          return "error_ingreso";
        }
      }

      $conn->commit();
      return ["status" => "ok", "id" => $ultimoId, "codigo" => $codigo];

    } catch (Exception $e) {
      if (isset($conn)) {
        $conn->rollBack();
      }
      return "error_exception: " . $e->getMessage();
    }
  }

  static public function mdlInfoTraspasos(){
    $stmt=Conexion::conectar()->prepare("SELECT
    t.id_traspaso,
    t.cod_traspaso,
    ao.nombre_almacen AS NomAlmacenOrigen,
    ao.descripcion AS descAlmacenOrigen,
    ad.nombre_almacen AS NomAlmacenDestino,
    ad.descripcion AS descAlmacenDestino,
    u.nombre AS Usuario,
    t.create_at
FROM traspaso t
JOIN usuario u ON u.id_usuario = t.id_usuario
JOIN almacen ao ON ao.id_almacen = t.id_almacen_origen
JOIN almacen ad ON ad.id_almacen = t.id_almacen_destino;
");
    $stmt->execute();
    $resul = $stmt->fetchAll();
    $stmt->closeCursor();
    return $resul;
  }
  
  static public function mdlInfoTraspaso($id){
    $stmt=Conexion::conectar()->prepare("SELECT
    t.id_traspaso,
    t.cod_traspaso,
    t.detalle_traspaso,
    t.observacion_traspaso,
    t.estado_traspaso,
    ao.nombre_almacen AS NomAlmacenOrigen,
    ao.descripcion AS descAlmacenOrigen,
    ad.nombre_almacen AS NomAlmacenDestino,
    ad.descripcion AS descAlmacenDestino,
    u.nombre AS Usuario,
    t.create_at
FROM traspaso t
JOIN usuario u ON u.id_usuario = t.id_usuario
JOIN almacen ao ON ao.id_almacen = t.id_almacen_origen
JOIN almacen ad ON ad.id_almacen = t.id_almacen_destino
WHERE id_traspaso=$id
");
    $stmt->execute();
    $resul = $stmt->fetch();
    $stmt->closeCursor();
    return $resul;
  }
  
  static public function mdlEliNotaTraspaso($id){
    $stmt=Conexion::conectar()->prepare("DELETE FROM traspaso WHERE id_traspaso= $id");

    if($stmt->execute()){
      $stmt->closeCursor();
      return "ok";
    }else{
      return "error";
    }
  }
}
