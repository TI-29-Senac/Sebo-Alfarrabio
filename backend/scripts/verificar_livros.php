<?php
/**
 * Script para verificar o estado atual dos livros no banco de dados
 * Verifica quais livros existem, quais têm descrição e quais têm autores
 */

require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../Database/Config.php';

use Sebo\Alfarrabio\Database\Database;

// Arquivo de log
$logFile = __DIR__ . '/verificacao_livros.log';
$log = fopen($logFile, 'w');

function logMessage($msg, $file) {
    fwrite($file, $msg);
    echo $msg;
}

try {
    $db = Database::getInstance();
    
    logMessage("=== VERIFICAÇÃO DE LIVROS ===\n\n", $log);
    
    // 1. Buscar todos os livros
    $sqlLivros = "SELECT id_item, titulo_item, descricao, tipo_item 
                  FROM tbl_itens 
                  WHERE tipo_item = 'livro' AND excluido_em IS NULL";
    $stmtLivros = $db->prepare($sqlLivros);
    $stmtLivros->execute();
    $livros = $stmtLivros->fetchAll(PDO::FETCH_ASSOC);
    
    logMessage("Total de livros cadastrados: " . count($livros) . "\n\n", $log);
    
    // 2. Verificar descrições
    $semDescricao = 0;
    $comDescricao = 0;
    
    foreach ($livros as $livro) {
        if (empty($livro['descricao']) || trim($livro['descricao']) === '') {
            $semDescricao++;
        } else {
            $comDescricao++;
        }
    }
    
    logMessage("Livros com descrição: $comDescricao\n", $log);
    logMessage("Livros sem descrição: $semDescricao\n\n", $log);
    
    // 3. Verificar autores
    $semAutor = 0;
    $comAutor = 0;
    
    foreach ($livros as $livro) {
        $sqlAutores = "SELECT COUNT(*) as total 
                       FROM tbl_item_autores 
                       WHERE item_id = :item_id";
        $stmtAutores = $db->prepare($sqlAutores);
        $stmtAutores->bindParam(':item_id', $livro['id_item'], PDO::PARAM_INT);
        $stmtAutores->execute();
        $resultado = $stmtAutores->fetch(PDO::FETCH_ASSOC);
        
        if ($resultado['total'] == 0) {
            $semAutor++;
        } else {
            $comAutor++;
        }
    }
    
    logMessage("Livros com autor(es): $comAutor\n", $log);
    logMessage("Livros sem autor: $semAutor\n\n", $log);
    
    // 4. Listar alguns exemplos de livros
    logMessage("=== EXEMPLOS DE LIVROS (primeiros 10) ===\n\n", $log);
    $contador = 0;
    foreach ($livros as $livro) {
        if ($contador >= 10) break;
        
        logMessage("ID: {$livro['id_item']} | Título: {$livro['titulo_item']}\n", $log);
        logMessage("Descrição: " . (empty($livro['descricao']) ? "[VAZIO]" : substr($livro['descricao'], 0, 50) . "...") . "\n", $log);
        
        // Buscar autores
        $sqlAutores = "SELECT a.nome_autor 
                       FROM tbl_item_autores ia 
                       INNER JOIN tbl_autores a ON ia.autor_id = a.id_autor 
                       WHERE ia.item_id = :item_id";
        $stmtAutores = $db->prepare($sqlAutores);
        $stmtAutores->bindParam(':item_id', $livro['id_item'], PDO::PARAM_INT);
        $stmtAutores->execute();
        $autores = $stmtAutores->fetchAll(PDO::FETCH_COLUMN);
        
        logMessage("Autores: " . (empty($autores) ? "[NENHUM]" : implode(", ", $autores)) . "\n", $log);
        logMessage("---\n", $log);
        
        $contador++;
    }
    
    logMessage("\n=== VERIFICAÇÃO CONCLUÍDA ===\n", $log);
    logMessage("Log salvo em: $logFile\n", $log);
    
    fclose($log);
    
} catch (Exception $e) {
    $msg = "ERRO: " . $e->getMessage() . "\n";
    logMessage($msg, $log);
    fclose($log);
    exit(1);
}

