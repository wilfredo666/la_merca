<?php
require_once "conexion.php";
class ModeloProveedor
{


  static public function mdlInformacionProveedor()
  {
    $stmt = Conexion::conectar()->prepare("select * from proveedor");
    $stmt->execute();

    return $stmt->fetchAll();

    $stmt->close();
    $stmt->null;
  }

  static public function mdlRegProveedor($data)
  {

    $nombre_empresa = $data["nombre_empresa"];
    $nombre_pro = $data["nombre_pro"];
    $ap_paterno_pro = $data["ap_paterno_pro"];
    $ap_materno_pro = $data["ap_materno_pro"];
    $ci_proveedor = $data["ci_proveedor"];
    $direccion_pro = $data["direccion_pro"];
    $telefono_pro = $data["telefono_pro"];

    $stmt = Conexion::conectar()->prepare("INSERT INTO proveedor(nombre_empresa, nombre_pro, ap_paterno_pro, ap_materno_pro, ci_proveedor, direccion_pro, telefono_pro) VALUES ('$nombre_empresa','$nombre_pro','$ap_paterno_pro','$ap_materno_pro','$ci_proveedor','$direccion_pro','$telefono_pro')");

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    $stmt->close();
    $stmt->null;
  }

  static public function mdlInfoProveedor($id)
  {
    $stmt = Conexion::conectar()->prepare("select * from proveedor where id_proveedor=$id");
    $stmt->execute();
    return $stmt->fetch();
    $stmt->close();
    $stmt->null;
  }

  static public function mdlEditProveedor($data)
  {
    $id_proveedor = $data["id_proveedor"];
    $nombre_empresa = $data["nombre_empresa"];
    $nombre_pro = $data["nombre_pro"];
    $ap_paterno_pro = $data["ap_paterno_pro"];
    $ap_materno_pro = $data["ap_materno_pro"];
    $ci_proveedor = $data["ci_proveedor"];
    $direccion_pro = $data["direccion_pro"];
    $telefono_pro = $data["telefono_pro"];
    $email_pro = $data["email_pro"];
    $estado_pro = $data["estado_pro"];

    $stmt = Conexion::conectar()->prepare("UPDATE proveedor SET nombre_empresa='$nombre_empresa', nombre_pro='$nombre_pro', ap_paterno_pro='$ap_paterno_pro', ap_materno_pro='$ap_materno_pro', ci_proveedor='$ci_proveedor', direccion_pro='$direccion_pro', telefono_pro='$telefono_pro', email_pro='$email_pro', estado_pro='$estado_pro' WHERE id_proveedor=$id_proveedor");

    if ($stmt->execute()) {
      return "ok";
    } else {
      return "error";
    }
    $stmt->close();
    $stmt->null;
  }

  static public function mdlEliProveedor($id)
  {
    try {
      $Proveedor = Conexion::conectar()->prepare("delete from proveedor where id_proveedor=$id");
      $Proveedor->execute();
    } catch (PDOException $e) {
      $codeError = $e->getCode();
      if ($codeError == "23000") {
        return "error";
        $stmt->close();
        $stmt->null;
      }
    }
    return "ok";
    $stmt->close();
    $stmt->null;
  }

  static public function mdlKardexProveedor($id_proveedor = null, $fecha_inicial = null, $fecha_final = null)
  {
    // Iniciar la consulta base
    $sql = "SELECT oi.*, nombre_almacen, descripcion, nombre_empresa
            FROM otros_ingresos AS oi
            JOIN proveedor ON proveedor.id_proveedor = oi.id_proveedor
            JOIN almacen ON almacen.id_almacen = oi.id_almacen
            WHERE concepto_oi = 'proveedor'";

    // Condicional para agregar filtro por id_proveedor
    if ($id_proveedor) {
      $sql .= " AND oi.id_proveedor = :id_proveedor";
    }

    // Condicional para agregar filtro por fecha
    if ($fecha_inicial) {
      $sql .= " AND oi.create_at >= :fecha_inicial";
    }
    if ($fecha_final) {
      $sql .= " AND oi.create_at <= :fecha_final";
    }

    // Preparar la consulta
    $stmt = Conexion::conectar()->prepare($sql);

    // Vincular parámetros si es necesario
    if ($id_proveedor) {
      $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
    }
    if ($fecha_inicial) {
      $stmt->bindParam(':fecha_inicial', $fecha_inicial);
    }
    if ($fecha_final) {
      $stmt->bindParam(':fecha_final', $fecha_final);
    }

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Cerrar la conexión (si es necesario)
    $stmt = null;

    return $result;
  }
}
