<?php
require_once 'backend/Database/Config.php';
require_once 'backend/Database/Database.php';
use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();
    echo "--- Tabelas no Banco de Dados ---\n";
    $stmt = $db->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo $row[0] . "\n";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
