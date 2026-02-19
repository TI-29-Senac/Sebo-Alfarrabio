<?php
require __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();
    
    echo "Creating 'tbl_avaliacao_fotos' table...\n";
    
    $sql = "CREATE TABLE IF NOT EXISTS tbl_avaliacao_fotos (
        id_foto INT AUTO_INCREMENT PRIMARY KEY,
        id_avaliacao INT NOT NULL,
        caminho_foto VARCHAR(255) NOT NULL,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_avaliacao) REFERENCES tbl_avaliacao(id_avaliacao) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    $db->exec($sql);
    echo "Table 'tbl_avaliacao_fotos' created successfully.\n";

    // Migrate existing photos
    echo "Migrating existing photos from 'tbl_avaliacao'...\n";
    
    // Check if foto_avaliacao column exists
    try {
        $stmt = $db->query("SELECT id_avaliacao, foto_avaliacao FROM tbl_avaliacao WHERE foto_avaliacao IS NOT NULL AND foto_avaliacao != ''");
        $avaliacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $count = 0;
        foreach ($avaliacoes as $av) {
            // Check if already migrated to avoid duplicates if run multiple times
            $check = $db->prepare("SELECT COUNT(*) FROM tbl_avaliacao_fotos WHERE id_avaliacao = ? AND caminho_foto = ?");
            $check->execute([$av['id_avaliacao'], $av['foto_avaliacao']]);
            
            if ($check->fetchColumn() == 0) {
                $insert = $db->prepare("INSERT INTO tbl_avaliacao_fotos (id_avaliacao, caminho_foto) VALUES (?, ?)");
                $insert->execute([$av['id_avaliacao'], $av['foto_avaliacao']]);
                $count++;
            }
        }
        echo "Migrated $count photos.\n";
        
    } catch (PDOException $e) {
        echo "Error checking/migrating photos (maybe column doesn't exist?): " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
