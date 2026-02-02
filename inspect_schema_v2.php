<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();

    echo "<h1>Schema: tbl_pedido_itens</h1>";
    $stmt = $db->query('DESCRIBE tbl_pedido_itens');
    echo "<pre>";
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    echo "</pre>";

    echo "<h1>Schema: tbl_itens</h1>";
    $stmt = $db->query('DESCRIBE tbl_itens');
    echo "<pre>";
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    echo "</pre>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
