<?php 
require_once "conexion.php";
class ModeloProducto{


  static public function mdlInfoProductos(){
    $stmt=Conexion::conectar()->prepare("select * from producto");
    $stmt->execute();

    $resultado= $stmt->fetchAll();

    $stmt=null;
    return $resultado;
  }

  static public function mdlRegProducto($data) {
    $stmt = Conexion::conectar()->prepare("
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

    if ($stmt->execute()) {
      $stmt = null;
      return "ok";
    } else {
      error_log("Error al registrar producto: " . implode(" | ", $stmt->errorInfo()));
      $stmt = null;
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

  static public function mdlEditProducto($data){
    $stmt = Conexion::conectar()->prepare("
    UPDATE producto SET 
        nombre_producto = :nombre_producto,
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

    static public function mdlBusProducto($cod){
    $stmt=Conexion::conectar()->prepare("SELECT * FROM producto WHERE cod_producto='$cod'");
    $stmt->execute();

    $respuesta = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt->closeCursor();

    return $respuesta;
  }
}