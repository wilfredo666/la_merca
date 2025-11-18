<?php 
require_once "conexion.php";
class ModeloProducto{


  static public function mdlInfoProductos(){
    session_start();
    $idAlmacen=$_SESSION["idAlmacen"];
    $stmt=Conexion::conectar()->prepare("SELECT
    p.id_producto,
    p.cod_producto,
    p.imagen_producto,
    p.nombre_producto,
    p.descripcion_prod,
    p.categoria,
    p.precio,
    COALESCE(SUM(CASE WHEN m.tipo = 'ingreso' AND m.id_almacen = $idAlmacen THEN m.cantidad ELSE 0 END), 0) -
    COALESCE(SUM(CASE WHEN m.tipo = 'salida' AND m.id_almacen = $idAlmacen THEN m.cantidad ELSE 0 END), 0) AS stock
FROM
    producto p
LEFT JOIN
    movimiento m ON p.id_producto = m.id_producto
GROUP BY
    p.id_producto, p.cod_producto, p.imagen_producto, p.nombre_producto,
    p.descripcion_prod, p.categoria, p.precio");
    $stmt->execute();

    $resultado= $stmt->fetchAll();

    $stmt=null;
    return $resultado;
  }

  static public function mdlRegProducto($data, $preciosAdicionales = array()) {
    try {
      // DEBUG: Información recibida en el modelo
      error_log("=== DEBUG MODELO ===");
      error_log("Data producto en modelo: " . print_r($data, true));
      error_log("Precios adicionales en modelo: " . print_r($preciosAdicionales, true));
      
      // Iniciar transacción
      $conexion = Conexion::conectar();
      $conexion->beginTransaction();

      // Registrar el producto
      $stmt = $conexion->prepare("
          INSERT INTO producto (
              cod_producto, nombre_producto, descripcion_prod, imagen_producto,
              unidad_medida, categoria, marca, costo, precio, create_at, update_at, disponible
          ) VALUES (
              :cod_producto, :nombre_producto, :descripcion_prod, :imagen_producto,
              :unidad_medida, :categoria, :marca, :costo, :precio, :create_at, :update_at, 1
          )
      ");

      $stmt->bindParam(":cod_producto", $data["codProducto"], PDO::PARAM_STR);
      $stmt->bindParam(":nombre_producto", $data["nomProducto"], PDO::PARAM_STR);
      $stmt->bindParam(":descripcion_prod", $data["descProducto"], PDO::PARAM_STR);
      $stmt->bindParam(":imagen_producto", $data["imgProducto"], PDO::PARAM_STR);
      $stmt->bindParam(":unidad_medida", $data["unidad_medida"], PDO::PARAM_STR);
      $stmt->bindParam(":categoria", $data["categoriaProducto"], PDO::PARAM_STR);
      $stmt->bindParam(":marca", $data["marca"], PDO::PARAM_STR);
      $stmt->bindParam(":costo", $data["costoProducto"], PDO::PARAM_STR);
      $stmt->bindParam(":precio", $data["precioProducto"], PDO::PARAM_STR);
      $stmt->bindParam(":create_at", $data["create_at"], PDO::PARAM_STR);
      $stmt->bindParam(":update_at", $data["update_at"], PDO::PARAM_STR);

      if (!$stmt->execute()) {
        $errorInfo = $stmt->errorInfo();
        error_log("Error SQL producto: " . print_r($errorInfo, true));
        throw new Exception("Error al registrar producto: " . $errorInfo[2]);
      }

      // Obtener el ID del producto recién creado
      $idProducto = $conexion->lastInsertId();
      error_log("ID producto creado: " . $idProducto);

      // Registrar precios adicionales si existen
      if (!empty($preciosAdicionales) && is_array($preciosAdicionales)) {
        error_log("Procesando " . count($preciosAdicionales) . " precios adicionales");
        $stmtPrecio = $conexion->prepare("
            INSERT INTO precio_producto (id_producto, precio, concepto) 
            VALUES (:id_producto, :precio, :concepto)
        ");

        foreach ($preciosAdicionales as $index => $precioAdicional) {
          error_log("Procesando precio " . ($index + 1) . ": " . print_r($precioAdicional, true));
          
          $stmtPrecio->bindParam(":id_producto", $idProducto, PDO::PARAM_INT);
          $stmtPrecio->bindParam(":precio", $precioAdicional['precio'], PDO::PARAM_STR);
          $stmtPrecio->bindParam(":concepto", $precioAdicional['concepto'], PDO::PARAM_STR);
          
          if (!$stmtPrecio->execute()) {
            $errorInfo = $stmtPrecio->errorInfo();
            error_log("Error SQL precio adicional: " . print_r($errorInfo, true));
            throw new Exception("Error al registrar precio adicional '" . $precioAdicional['concepto'] . "': " . $errorInfo[2]);
          }
          
          error_log("Precio adicional registrado exitosamente: " . $precioAdicional['concepto']);
        }
        $stmtPrecio = null;
      }

      // Confirmar transacción
      $conexion->commit();
      $stmt = null;
      return "ok";

    } catch (Exception $e) {
      // Revertir transacción en caso de error
      $conexion->rollback();
      error_log("Error al registrar producto con precios: " . $e->getMessage());
      return "error";
    }
  }

  static public function mdlInfoProducto($id){
    $stmt=Conexion::conectar()->prepare("select * from producto where id_producto=$id");
    $stmt->execute();
    $resultado= $stmt->fetch();
    $stmt=null;
    return $resultado;
  }

  static public function mdlPreciosAdicionales($id){
    $stmt=Conexion::conectar()->prepare("SELECT * FROM precio_producto WHERE id_producto = $id ORDER BY precio DESC");
    $stmt->execute();
    $resultado= $stmt->fetchAll();
    $stmt=null;
    return $resultado;
  }

  static public function mdlEditProducto($data){
    $stmt = Conexion::conectar()->prepare("
    UPDATE producto SET 
        nombre_producto = :nombre_producto,
        cod_producto  = :codProducto,
        descripcion_prod = :descripcion_prod,
        imagen_producto = :imagen_producto,
        unidad_medida = :unidad_medida,
        categoria = :categoria,
        marca = :marca,
        costo = :costo,
        precio = :precio,
        update_at = :update_at,
        disponible = :disponible
    WHERE id_producto = :id_producto

    ");

    $stmt->bindParam(":id_producto", $data["id_producto"], PDO::PARAM_STR);
    $stmt->bindParam(":codProducto", $data["codProducto"], PDO::PARAM_STR);
    $stmt->bindParam(":nombre_producto", $data["nomProducto"], PDO::PARAM_STR);
    $stmt->bindParam(":descripcion_prod", $data["descProducto"], PDO::PARAM_STR);
    $stmt->bindParam(":imagen_producto", $data["imgProducto"], PDO::PARAM_STR);
    $stmt->bindParam(":unidad_medida", $data["unidad_medida"], PDO::PARAM_STR);
    $stmt->bindParam(":categoria", $data["categoriaProducto"], PDO::PARAM_STR);
    $stmt->bindParam(":marca", $data["marca"], PDO::PARAM_STR);
    $stmt->bindParam(":costo", $data["costoProducto"], PDO::PARAM_STR);
    $stmt->bindParam(":precio", $data["precioProducto"], PDO::PARAM_STR);
    $stmt->bindParam(":update_at", $data["update_at"], PDO::PARAM_STR);
    $stmt->bindParam(":disponible", $data["estadoProducto"], PDO::PARAM_INT);

    if ($stmt->execute()) {
      $stmt = null;
      return "ok";
    } else {
      error_log("Error al actualizar producto: " . implode(" | ", $stmt->errorInfo()));
      $stmt = null;
      return "error";
    }
  }

  static public function mdlEliProducto($id){
    try {
      $stmt = Conexion::conectar()->prepare("DELETE FROM producto WHERE id_producto = :id");
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->execute();
      $stmt = null; // liberar recursos
      return "ok";
    } catch (PDOException $e) {
      if ($e->getCode() == "23000") {
        return "error";
      } else {
        return "error_desconocido"; // opcional para otros errores
      }
    }
  }

  static public function mdlCantidadProductos(){
    $stmt=Conexion::conectar()->prepare("select count(*) as producto from producto");
    $stmt->execute();

    $resultado= $stmt->fetch();

    $stmt=null;
    return $resultado;
  }

  static public function mdlBusProducto($cod, $idAlmacen){
    $stmt=Conexion::conectar()->prepare("SELECT
    p.id_producto,
    p.cod_producto,
    p.nombre_producto,
    p.descripcion_prod,
    p.unidad_medida,
    p.precio,
    p.costo,
    p.imagen_producto,
    p.categoria,
    COALESCE(
        SUM(
            CASE 
                WHEN m.id_almacen = $idAlmacen AND m.tipo = 'ingreso' THEN m.cantidad
                WHEN m.id_almacen = $idAlmacen AND m.tipo = 'salida'  THEN -m.cantidad
                ELSE 0
            END
        ), 0
    ) AS stock
FROM producto p
LEFT JOIN movimiento m ON p.id_producto = m.id_producto
WHERE p.cod_producto = '$cod'
GROUP BY p.id_producto, p.cod_producto, p.imagen_producto, 
         p.nombre_producto, p.descripcion_prod, p.categoria, p.precio;");
    $stmt->execute();

    $respuesta = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt->closeCursor();

    return $respuesta;
  }

  static public function mdlBusProductoTs($cod, $idAlmacen){
    $stmt=Conexion::conectar()->prepare("SELECT
    p.id_producto,
    p.cod_producto,
    p.nombre_producto,
    p.descripcion_prod,
    p.precio,
    p.costo,
    p.imagen_producto,
    p.categoria,
    COALESCE(
        SUM(
            CASE 
                WHEN m.id_almacen = $idAlmacen AND m.tipo = 'ingreso' THEN m.cantidad
                WHEN m.id_almacen = $idAlmacen AND m.tipo = 'salida'  THEN -m.cantidad
                ELSE 0
            END
        ), 0
    ) AS stock
FROM producto p
LEFT JOIN movimiento m ON p.id_producto = m.id_producto
WHERE p.cod_producto = '$cod'
GROUP BY p.id_producto, p.cod_producto, p.imagen_producto, 
         p.nombre_producto, p.descripcion_prod, p.categoria, p.precio;");
    $stmt->execute();

    $respuesta = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt->closeCursor();

    return $respuesta;
  }

  static public function mdlListarPrecios($idProducto){
    try {
      $stmt = Conexion::conectar()->prepare("
        SELECT id_precioproducto, precio, concepto, estado
        FROM precio_producto
        WHERE id_producto = :idProducto
        ORDER BY id_precioproducto DESC
      ");
      $stmt->bindParam(":idProducto", $idProducto, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      return []; // o podés retornar un mensaje de error si querés
    }

  }

  /*  static public function mdlExisteConcepto($idProducto, $concepto) {
    $stmt = Conexion::conectar()->prepare("
      SELECT COUNT(*) FROM precio_producto
      WHERE id_producto = :id AND concepto = :concepto
    ");
    $stmt->bindParam(":id", $idProducto, PDO::PARAM_INT);
    $stmt->bindParam(":concepto", $concepto, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
  }*/

  static public function mdlGuardarPrecio($idProducto, $concepto, $precio) {
    $stmt = Conexion::conectar()->prepare("
      INSERT INTO precio_producto (id_producto, precio, concepto)
      VALUES (:id, :precio, :concepto)");
    $stmt->bindParam(":id", $idProducto, PDO::PARAM_INT);
    $stmt->bindParam(":precio", $precio);
    $stmt->bindParam(":concepto", $concepto);
    return $stmt->execute(); //devuelve true o false
  }

  static public function mdlEliminarPrecio($idPrecio) {
    $stmt = Conexion::conectar()->prepare("
    DELETE FROM precio_producto WHERE id_precioproducto = :id
  ");
    $stmt->bindParam(":id", $idPrecio, PDO::PARAM_INT);
    return $stmt->execute();
  }

  static public function mdlInfoPrecio($idPrecio) {
    $stmt = Conexion::conectar()->prepare("
    SELECT concepto, precio, estado
    FROM precio_producto
    WHERE id_precioproducto = :id
  ");
    $stmt->bindParam(":id", $idPrecio, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  static public function mdlActualizarPrecio($idPrecio, $concepto, $precio, $estado) {
  $stmt = Conexion::conectar()->prepare("
    UPDATE precio_producto
    SET concepto = :concepto, precio = :precio, estado = :estado
    WHERE id_precioproducto = :id
  ");
  $stmt->bindParam(":concepto", $concepto);
  $stmt->bindParam(":precio", $precio);
  $stmt->bindParam(":estado", $estado, PDO::PARAM_INT);
  $stmt->bindParam(":id", $idPrecio, PDO::PARAM_INT);
  return $stmt->execute();
}

static public function mdlProductosPorCategoria($categoria) {
    session_start();
    $idAlmacen = $_SESSION["idAlmacen"];
    
    if ($categoria === 'todos') {
        $stmt = Conexion::conectar()->prepare("
            SELECT 
                p.*,
                COALESCE(SUM(CASE WHEN m.tipo = 'ingreso' AND m.id_almacen = :idAlmacen THEN m.cantidad ELSE 0 END), 0) -
                COALESCE(SUM(CASE WHEN m.tipo = 'salida' AND m.id_almacen = :idAlmacen THEN m.cantidad ELSE 0 END), 0) AS stock
            FROM producto p
            LEFT JOIN movimiento m ON p.id_producto = m.id_producto
            WHERE p.disponible = 1
            GROUP BY p.id_producto
            HAVING stock > 0
        ");
        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_INT);
    } else {
        $stmt = Conexion::conectar()->prepare("
            SELECT 
                p.*,
                COALESCE(SUM(CASE WHEN m.tipo = 'ingreso' AND m.id_almacen = :idAlmacen THEN m.cantidad ELSE 0 END), 0) -
                COALESCE(SUM(CASE WHEN m.tipo = 'salida' AND m.id_almacen = :idAlmacen THEN m.cantidad ELSE 0 END), 0) AS stock
            FROM producto p
            LEFT JOIN movimiento m ON p.id_producto = m.id_producto
            WHERE p.categoria = :categoria AND p.disponible = 1
            GROUP BY p.id_producto
            HAVING stock > 0
        ");
        $stmt->bindParam(":categoria", $categoria, PDO::PARAM_STR);
        $stmt->bindParam(":idAlmacen", $idAlmacen, PDO::PARAM_INT);
    }
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt = null;
    return $resultado;
  }

  static public function mdlMasVendidos(){
    $stmt = Conexion::conectar()->prepare("
      SELECT 
        p.id_producto,
        p.cod_producto, 
        p.nombre_producto, 
        p.imagen_producto,
        p.precio,
        p.costo,
        SUM(m.cantidad) AS total_vendido
      FROM movimiento m
      JOIN producto p ON m.id_producto = p.id_producto
      WHERE m.tipo = 'salida' 
        AND m.codigo LIKE 'NV-%'
      GROUP BY 
        p.id_producto,
        p.cod_producto, 
        p.nombre_producto, 
        p.imagen_producto,
        p.precio,
        p.costo
      ORDER BY total_vendido DESC
      LIMIT 10
    ");
    
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    $stmt = null;
    
    return $resultado;
  }

}