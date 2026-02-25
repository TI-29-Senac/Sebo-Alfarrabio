<?php
require_once __DIR__ . '/Database/Database.php';
use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();
    $stmt = $db->query("PRAGMA table_info(tbl_usuario)");
    $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cols, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
