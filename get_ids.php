<?php
require __DIR__ . '/vendor/autoload.php';
use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();
    $stmt = $db->query("SELECT id_usuario FROM tbl_usuario LIMIT 1");
    $user = $stmt->fetchColumn();
    
    $stmt2 = $db->query("SELECT id_item FROM tbl_itens LIMIT 1");
    $item = $stmt2->fetchColumn();
    
    echo "ID Usuario: {$user}\n";
    echo "ID Item: {$item}\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
