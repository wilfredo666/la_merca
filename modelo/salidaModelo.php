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

  static public function mdlRegNotaVenta(){
    date_default_timezone_set("America/La_Paz");
    session_start();

    $stmt = Conexion::conectar()->prepare("
  INSERT INTO venta (
    codigo_venta, id_cliente, detalle_venta, total, descuento, neto,
    observacion, id_usuario, id_almacen,
    create_at, update_at
  ) VALUES (
    :codigo, :cliente, :detalle, :total, :descuento, :neto,
    :observacion, :usuario, :almacen,
    :creado, :actualizado
  )
");

    $codigo      = "NV-".($_POST["numFactura"] ?? '');
    $cliente     = $_POST["idCliente"] ?? '';
    $detalle     = $_POST["carritoVenta"] ?? '';
    $total       = $_POST["totVenta"] ?? 0;
    $descuento   = $_POST["descuento"] ?? 0;
    $neto        = $total - $descuento;
    $observacion = $_POST["observacion"] ?? '';
    $id_usuario  = $_SESSION["idUsuario"] ?? 0;
    $id_almacen  = $_SESSION["idAlmacen"] ?? 0;
    $creado      = date("Y-m-d H:i:s");
    $actualizado = date("Y-m-d H:i:s");

    // Bind de parámetros seguros
    $stmt->bindParam(":codigo", $codigo);
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

    // Ejecutar y validar
    if ($stmt->execute()) {
      //registrando el detalle de la nota de venta

      $detalle=json_decode($_POST["carritoVenta"], true);

      for($i=0; $i<count($detalle); $i++){
        $idProducto=$detalle[$i]["idProducto"];
        $cantProducto=$detalle[$i]["cantidad"];
        $preProducto=$detalle[$i]["precioUnitario"];

        $stmtNV=Conexion::conectar()->prepare("INSERT INTO movimiento
        (id_almacen, id_producto, codigo, cantidad, tipo, costo, create_at)
        VALUES
        ($id_almacen,$idProducto,'$codigo','$cantProducto','salida','$preProducto','$creado')");

        if(!$stmtNV->execute()){
          return "error";
        }
      }

      return "ok";
    } else {
      return "error";
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

}