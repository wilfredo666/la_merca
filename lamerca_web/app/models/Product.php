<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database.php';

class Product
{
    public static function paginate(int $page = 1, int $perPage = 6, ?string $search = null, ?string $categoryName = null): array
    {
        $db = Database::getInstance();

        $countSql = 'SELECT COUNT(*) FROM producto WHERE disponible = 1';
        $dataSql = 'SELECT id_producto AS id,
                    cod_producto AS codigo,
                    nombre_producto AS name,
                    categoria AS category,
                    precio AS price,
                    descripcion_prod AS description,
                    imagen_producto AS image
             FROM producto
             WHERE disponible = 1';

        if ($search !== null && $search !== '') {
            $countSql .= ' AND nombre_producto LIKE :search';
            $dataSql .= ' AND nombre_producto LIKE :search';
        }

        if ($categoryName !== null && $categoryName !== '') {
            $countSql .= ' AND categoria = :categoryName';
            $dataSql .= ' AND categoria = :categoryName';
        }

        $countStmt = $db->prepare($countSql);
        $dataStmt = $db->prepare($dataSql . '
             ORDER BY id_producto ASC
             LIMIT :limit OFFSET :offset');

        if ($search !== null && $search !== '') {
            $searchTerm = '%' . $search . '%';
            $countStmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
            $dataStmt->bindValue(':search', $searchTerm, PDO::PARAM_STR);
        }

        if ($categoryName !== null && $categoryName !== '') {
            $countStmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
            $dataStmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
        }

        $countStmt->execute();
        $total = (int) $countStmt->fetchColumn();

        $offset = max(0, ($page - 1) * $perPage);
        $dataStmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();

        return [
            'products' => $dataStmt->fetchAll(),
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $page,
            'totalPages' => (int) ceil($total / $perPage),
        ];
    }

    public static function all(): array
    {
        return self::paginate(1, 1000)['products'];
    }

    public static function findById(int $id): ?array
    {
        $db = Database::getInstance();

        $stmt = $db->prepare(
            'SELECT id_producto AS id,
                    cod_producto AS codigo,
                    nombre_producto AS name,
                    categoria AS category,
                    precio AS price,
                    descripcion_prod AS description,
                    imagen_producto AS image
             FROM producto
             WHERE id_producto = :id AND disponible = 1'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch();
        return $product === false ? null : $product;
    }
}
