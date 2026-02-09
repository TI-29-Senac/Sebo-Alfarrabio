<?php
require_once __DIR__ . '/Database/Config.php';
require_once __DIR__ . '/Database/Database.php';

use Sebo\Alfarrabio\Database\Database;

header('Content-Type: application/json');

try {
    $db = Database::getInstance();
    $estrutura = $db->query("DESCRIBE tbl_perfil_usuario")->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($estrutura, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
