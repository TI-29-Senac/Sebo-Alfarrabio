<?php
require 'vendor/autoload.php';

use Sebo\Alfarrabio\Core\Env;
use Sebo\Alfarrabio\Database\Database;

// Carrega .env do diretório backend
Env::carregar(__DIR__ . '/backend');

try {
    $db = Database::getInstance();

    echo "Verificando se a coluna 'estante' já existe...\n";

    // Verifica se a coluna já existe para evitar erro
    $check = $db->query("SHOW COLUMNS FROM tbl_itens LIKE 'estante'");
    if ($check->rowCount() == 0) {
        echo "Adicionando coluna 'estante' na tabela tbl_itens...\n";
        $db->exec("ALTER TABLE tbl_itens ADD COLUMN estante VARCHAR(255) NULL AFTER autores");
        echo "Coluna 'estante' adicionada com sucesso!\n";
    } else {
        echo "A coluna 'estante' já existe.\n";
    }

} catch (Exception $e) {
    echo "ERRO NA MIGRAÇÃO: " . $e->getMessage() . "\n";
}
