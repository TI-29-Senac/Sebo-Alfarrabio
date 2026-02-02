<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();

    echo "<h1>Schema tbl_perfil_usuario</h1>";
    $stmt = $db->query("DESCRIBE tbl_perfil_usuario");
    echo "<pre>";
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    echo "</pre>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
