<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();

    // Contar quantos excluidos
    $stmt = $db->query('SELECT COUNT(*) FROM tbl_usuario WHERE excluido_em IS NOT NULL');
    $count = $stmt->fetchColumn();

    echo "<h1>Reativando Usuários</h1>";
    echo "Usuários excluídos (soft-delete): $count<br>";

    if ($count > 0) {
        $update = $db->query("UPDATE tbl_usuario SET excluido_em = NULL WHERE excluido_em IS NOT NULL");
        echo "✅ Todos os usuários foram reativados (excluido_em = NULL).<br>";
        echo "Agora o login deve funcionar.";
    } else {
        echo "Nenhum usuário estava excluído.";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
