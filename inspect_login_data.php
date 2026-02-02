<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();

    echo "<h1>Usuarios (Top 5)</h1>";
    $stmt = $db->query('SELECT id_usuario, nome_usuario, email_usuario, tipo_usuario, senha_usuario FROM tbl_usuario LIMIT 5');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<pre>";
    foreach ($users as $u) {
        echo "ID: " . $u['id_usuario'] . "\n";
        echo "Email: " . $u['email_usuario'] . "\n";
        echo "Tipo: " . $u['tipo_usuario'] . "\n";
        echo "Senha Hash: " . substr($u['senha_usuario'], 0, 20) . "...\n";
        echo "----------------\n";
    }
    echo "</pre>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
