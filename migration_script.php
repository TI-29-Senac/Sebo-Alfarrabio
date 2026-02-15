<?php
require __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;
use PDO;

try {
    $db = Database::getInstance();
    
    echo "Checking if columns exist in tbl_perfil_usuario...\n";

    // 1. Data de Nascimento
    try {
        $db->query("SELECT data_nascimento_usuario FROM tbl_perfil_usuario LIMIT 1");
        echo "Column 'data_nascimento_usuario' already exists.\n";
    } catch (PDOException $e) {
        echo "Adding 'data_nascimento_usuario' column...\n";
        $db->exec("ALTER TABLE tbl_perfil_usuario ADD COLUMN data_nascimento_usuario DATE DEFAULT NULL");
    }

    // 2. Gênero
    try {
        $db->query("SELECT genero_usuario FROM tbl_perfil_usuario LIMIT 1");
        echo "Column 'genero_usuario' already exists.\n";
    } catch (PDOException $e) {
        echo "Adding 'genero_usuario' column...\n";
        $db->exec("ALTER TABLE tbl_perfil_usuario ADD COLUMN genero_usuario VARCHAR(20) DEFAULT NULL");
    }
    
    // 3. Idioma
    try {
        $db->query("SELECT idioma_usuario FROM tbl_perfil_usuario LIMIT 1");
        echo "Column 'idioma_usuario' already exists.\n";
    } catch (PDOException $e) {
        echo "Adding 'idioma_usuario' column...\n";
        $db->exec("ALTER TABLE tbl_perfil_usuario ADD COLUMN idioma_usuario VARCHAR(50) DEFAULT 'Português'");
    }

    echo "Migration completed successfully.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
