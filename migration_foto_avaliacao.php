<?php
require __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();
    
    echo "Checking if 'foto_avaliacao' column exists in 'tbl_avaliacao'...\n";

    try {
        $db->query("SELECT foto_avaliacao FROM tbl_avaliacao LIMIT 1");
        echo "Column 'foto_avaliacao' already exists.\n";
    } catch (PDOException $e) {
        echo "Adding 'foto_avaliacao' column...\n";
        // Adiciona a coluna após comentario_avaliacao (ou no fim se não encontrar, mas AFTER ajuda na organização)
        $db->exec("ALTER TABLE tbl_avaliacao ADD COLUMN foto_avaliacao VARCHAR(255) DEFAULT NULL AFTER comentario_avaliacao");
        echo "Column 'foto_avaliacao' added successfully.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
