<?php
require_once 'backend/Database/Config.php';
require_once 'backend/Database/Database.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();
    echo "--- Estrutura de tbl_generos ---\n";
    $stmt = $db->query("DESCRIBE tbl_generos");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }

    echo "\n--- Conteudo de tbl_generos ---\n";
    $stmt = $db->query("SELECT * FROM tbl_generos LIMIT 5");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
