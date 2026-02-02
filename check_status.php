<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();

    echo "<h1>Check Excluido_em</h1>";
    $stmt = $db->query("SELECT id_usuario, nome_usuario, email_usuario, excluido_em FROM tbl_usuario WHERE email_usuario = 'carla.menezes@email.com'");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<pre>";
    print_r($user);
    echo "</pre>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
