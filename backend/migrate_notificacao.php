<?php
require_once __DIR__ . '/Database/Database.php';
use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();

    // Verifica se a coluna já existe para evitar erro
    $stmt = $db->query("PRAGMA table_info(tbl_usuario)");
    $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $exists = false;
    foreach ($cols as $col) {
        if ($col['name'] === 'notificar_novidades') {
            $exists = true;
            break;
        }
    }

    if (!$exists) {
        $db->exec("ALTER TABLE tbl_usuario ADD COLUMN notificar_novidades INTEGER DEFAULT 1");
        echo "Coluna 'notificar_novidades' adicionada com sucesso!";
    } else {
        echo "A coluna 'notificar_novidades' já existe.";
    }
} catch (Exception $e) {
    echo "Erro ao atualizar banco: " . $e->getMessage();
}
