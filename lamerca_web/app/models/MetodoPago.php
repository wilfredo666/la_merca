<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database.php';

class MetodoPago
{
    public static function allActive(): array
    {
        $db = Database::getInstance();

        $stmt = $db->prepare(
            'SELECT id_metodopago AS id,
                    tipo_metodo AS type,
                    nombre_metodo AS name,
                    desc_metodo AS description,
                    img_metodo AS image,
                    estado_metodo AS status
             FROM metodo_pago
             WHERE estado_metodo = 1'
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getInstance();

        $stmt = $db->prepare(
            'SELECT id_metodopago AS id,
                    tipo_metodo AS type,
                    nombre_metodo AS name,
                    desc_metodo AS description,
                    img_metodo AS image,
                    estado_metodo AS status
             FROM metodo_pago
             WHERE id_metodopago = :id AND estado_metodo = 1'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $paymentMethod = $stmt->fetch();
        return $paymentMethod === false ? null : $paymentMethod;
    }

    public static function findActiveByType(string $type): ?array
    {
        $db = Database::getInstance();

        $stmt = $db->prepare(
            'SELECT id_metodopago AS id,
                    tipo_metodo AS type,
                    nombre_metodo AS name,
                    desc_metodo AS description,
                    img_metodo AS image,
                    estado_metodo AS status
             FROM metodo_pago
             WHERE tipo_metodo = :type AND estado_metodo = 1
             LIMIT 1'
        );
        $stmt->bindValue(':type', $type, PDO::PARAM_STR);
        $stmt->execute();

        $paymentMethod = $stmt->fetch();
        return $paymentMethod === false ? null : $paymentMethod;
    }
}
