<?php

declare(strict_types=1);

require_once __DIR__ . '/../Database.php';

class Category
{
    public static function all(): array
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT id_categoria AS id, descripcion_cat AS name FROM categoria ORDER BY descripcion_cat ASC');
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
