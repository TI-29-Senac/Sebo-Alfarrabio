<?php
require 'vendor/autoload.php';
use Sebo\Alfarrabio\Database\Database;

$tables = ['tbl_itens', 'tbl_categorias', 'tbl_generos', 'tbl_autores', 'tbl_usuario', 'tbl_item_autores', 'tbl_pedidos', 'tbl_pedido_itens'];
$db = Database::getInstance();

echo "=== ALL TABLES ===\n";
$stmt = $db->query("SHOW TABLES");
print_r($stmt->fetchAll(PDO::FETCH_COLUMN));
echo "\n";

foreach ($tables as $table) {
    echo "--- Structure of $table ---\n";
    try {
        $stmt = $db->query("DESCRIBE $table");
        $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cols as $col) {
            echo "{$col['Field']} ({$col['Type']}) - Null: {$col['Null']}, Key: {$col['Key']}\n";
        }
    } catch (Exception $e) {
        echo "Error describe $table: " . $e->getMessage() . "\n";
    }
    echo "\n";
}
