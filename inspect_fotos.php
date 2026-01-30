<?php
require_once 'backend/Database/Config.php';
require_once 'backend/Database/Database.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();
    echo "--- Dados de foto_item ---\n";
    $stmt = $db->query("SELECT id_item, titulo_item, foto_item FROM tbl_itens LIMIT 10");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
