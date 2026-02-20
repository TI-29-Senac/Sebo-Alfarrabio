<?php
/**
 * Migration: Cria a tabela tbl_password_resets para o fluxo de "Esqueci a Senha".
 * 
 * Executar: php backend/scripts/create_password_resets_table.php
 */

namespace Sebo\Alfarrabio;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/helpers.php';

\Sebo\Alfarrabio\Core\Env::carregar(__DIR__ . '/..');

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();

    $sql = "
        CREATE TABLE IF NOT EXISTS tbl_password_resets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            token_hash VARCHAR(64) NOT NULL,
            expira_em DATETIME NOT NULL,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_email (email),
            INDEX idx_token_hash (token_hash),
            INDEX idx_expira_em (expira_em)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ";

    $db->exec($sql);
    echo "✅ Tabela 'tbl_password_resets' criada com sucesso!\n";

} catch (\Exception $e) {
    echo "❌ Erro ao criar tabela: " . $e->getMessage() . "\n";
    exit(1);
}
