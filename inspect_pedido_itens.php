<?php
require_once 'backend/Database/Config.php';
require_once 'backend/Database/Database.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();
    echo "--- Estrutura de tbl_pedido_itens ---\n";
    $stmt = $db->query("DESCRIBE tbl_pedido_itens");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
