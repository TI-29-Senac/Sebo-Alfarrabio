<?php
require_once __DIR__ . '/Database/Config.php';
require_once __DIR__ . '/Database/Database.php';

use Sebo\Alfarrabio\Database\Database;

header('Content-Type: application/json');

try {
    $db = Database::getInstance();
    // Lista todas as tabelas
    $tabelas = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($tabelas, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
