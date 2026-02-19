<?php
/**
 * Script para adicionar descrições e autores aos livros
 * Este script:
 * 1. Busca todos os livros sem descrição ou sem autores
 * 2. Gera descrições automáticas baseadas nos títulos
 * 3. Identifica e cadastra autores
 * 4. Associa autores aos livros
 */

require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../Database/Config.php';

use Sebo\Alfarrabio\Database\Database;

// Arquivo de log
$logFile = __DIR__ . '/migracao_descricoes_autores_' . date('Y-m-d_H-i-s') . '.log';
$log = fopen($logFile, 'w');

function logMessage($msg, $file) {
    fwrite($file, $msg);
    echo $msg;
}

/**
 * Gera uma descrição automática baseada no título do livro
 */
function gerarDescricao($titulo, $genero = null, $categoria = null) {
    // Remove informações extras do título (Capa comum, Capa dura, etc.)
    $tituloLimpo = preg_replace('/(Capa comum|Capa dura|eBook Kindle|: \d+)\s*$/i', '', $titulo);
    $tituloLimpo = trim($tituloLimpo);
    
    // Separa título de possível subtítulo
    $partes = explode(':', $tituloLimpo, 2);
    $tituloPrincipal = trim($partes[0]);
    $subtitulo = isset($partes[1]) ? trim($partes[1]) : null;
    
    // Gera descrição contextual
    $descricoes = [
        "\"$tituloPrincipal\" é uma obra literária que cativa leitores com sua narrativa envolvente e personagens marcantes.",
        "Este livro, \"$tituloPrincipal\", oferece uma experiência de leitura única, explorando temas profundos e emocionantes.",
        "\"$tituloPrincipal\" é uma leitura indispensável para amantes da literatura, trazendo reflexões importantes sobre a condição humana.",
        "Com uma narrativa cativante, \"$tituloPrincipal\" transporta o leitor para um universo fascinante de histórias e emoções.",
        "\"$tituloPrincipal\" é um livro que conquista pela qualidade literária e pela profundidade de seus temas.",
    ];
    
    $descricaoBase = $descricoes[array_rand($descricoes)];
    
    // Adiciona informações sobre subtítulo se houver
    if ($subtitulo) {
        $descricaoBase .= " Com o subtítulo \"$subtitulo\", a obra aborda de forma magistral as nuances desta temática.";
    }
    
    // Adiciona informações sobre gênero/categoria se disponível
    if ($genero) {
        $descricaoBase .= " Classificado como $genero, este título é uma excelente escolha para diversificar sua biblioteca.";
    }
    
    return $descricaoBase;
}

/**
 * Extrai o nome do autor do título do livro
 * Muitos livros seguem padrões como "Título - Autor" ou têm o autor implícito
 */
function extrairAutor($titulo) {
    // Remove informações de formato
    $tituloLimpo = preg_replace('/(Capa comum|Capa dura|eBook Kindle)\s*$/i', '', $titulo);
    $tituloLimpo = trim($tituloLimpo);
    
    // Alguns padrões comuns:
    // 1. "Título - Autor"
    // 2. "Título por Autor"
    // 3. Para títulos conhecidos, podemos inferir autores
    
    // Tenta encontrar padrão "- Autor" ou "por Autor"
    if (preg_match('/\s+-\s+([A-ZÀ-Ú][a-zà-ú]+(?:\s+[A-ZÀ-Ú][a-zà-ú]+)+)\s*$/u', $tituloLimpo, $matches)) {
        return $matches[1];
    }
    
    if (preg_match('/\s+por\s+([A-ZÀ-Ú][a-zà-ú]+(?:\s+[A-ZÀ-Ú][a-zà-ú]+)+)/ui', $tituloLimpo, $matches)) {
        return $matches[1];
    }
    
    // Mapeamento de títulos conhecidos para autores
    $autoresConhecidos = [
        'O Pequeno Príncipe' => 'Antoine de Saint-Exupéry',
        'Hold Me Closer' => 'David Levithan',
        'Malorie' => 'Josh Malerman',
        'Coração de tinta' => 'Cornelia Funke',
        'Reparação' => 'Ian McEwan',
    ];
    
    foreach ($autoresConhecidos as $titulo => $autor) {
        if (stripos($tituloLimpo, $titulo) !== false) {
            return $autor;
        }
    }
    
    return null;
}

/**
 * Busca ou cria um autor no banco de dados
 */
function buscarOuCriarAutor($db, $nomeAutor, $log) {
    // Verifica se autor já existe
    $sqlBusca = "SELECT id_autor FROM tbl_autores WHERE nome_autor = :nome";
    $stmt = $db->prepare($sqlBusca);
    $stmt->bindParam(':nome', $nomeAutor);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado) {
        logMessage("  → Autor '$nomeAutor' já existe (ID: {$resultado['id_autor']})\n", $log);
        return $resultado['id_autor'];
    }
    
    // Cria novo autor
    $biografia = "Autor(a) de diversas obras literárias.";
    $sqlInsert = "INSERT INTO tbl_autores (nome_autor, biografia) VALUES (:nome, :biografia)";
    $stmt = $db->prepare($sqlInsert);
    $stmt->bindParam(':nome', $nomeAutor);
    $stmt->bindParam(':biografia', $biografia);
    
    if ($stmt->execute()) {
        $id = $db->lastInsertId();
        logMessage("  → Novo autor criado: '$nomeAutor' (ID: $id)\n", $log);
        return $id;
    }
    
    return null;
}

/**
 * Associa um autor a um livro
 */
function associarAutorAoLivro($db, $itemId, $autorId, $log) {
    // Verifica se associação já existe
    $sqlCheck = "SELECT COUNT(*) as total FROM tbl_item_autores WHERE item_id = :item_id AND autor_id = :autor_id";
    $stmt = $db->prepare($sqlCheck);
    $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
    $stmt->bindParam(':autor_id', $autorId, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($resultado['total'] > 0) {
        return true; // Já associado
    }
    
    // Cria associação
    $sqlInsert = "INSERT INTO tbl_item_autores (item_id, autor_id) VALUES (:item_id, :autor_id)";
    $stmt = $db->prepare($sqlInsert);
    $stmt->bindParam(':item_id', $itemId, PDO::PARAM_INT);
    $stmt->bindParam(':autor_id', $autorId, PDO::PARAM_INT);
    
    return $stmt->execute();
}

try {
    $db = Database::getInstance();
    $db->beginTransaction();
    
    logMessage("=== MIGRAÇÃO: ADICIONAR DESCRIÇÕES E AUTORES ===\n", $log);
    logMessage("Data/Hora: " . date('d/m/Y H:i:s') . "\n\n", $log);
    
    // Buscar todos os livros
    $sqlLivros = "SELECT i.id_item, i.titulo_item, i.descricao, i.tipo_item, i.id_genero, i.id_categoria,
                         g.nome_generos, c.nome_categoria
                  FROM tbl_itens i
                  LEFT JOIN tbl_generos g ON i.id_genero = g.id_generos
                  LEFT JOIN tbl_categorias c ON i.id_categoria = c.id_categoria
                  WHERE i.tipo_item = 'livro' AND i.excluido_em IS NULL";
    $stmt = $db->prepare($sqlLivros);
    $stmt->execute();
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    logMessage("Total de livros encontrados: " . count($livros) . "\n\n", $log);
    
    $stats = [
        'descricoes_adicionadas' => 0,
        'autores_criados' => 0,
        'associacoes_criadas' => 0,
        'livros_processados' => 0,
        'erros' => 0
    ];
    
    foreach ($livros as $livro) {
        $id = $livro['id_item'];
        $titulo = $livro['titulo_item'];
        
        logMessage("----------------------------------------\n", $log);
        logMessage("Processando: [$id] $titulo\n", $log);
        
        // 1. Adicionar descrição se não existir
        if (empty($livro['descricao']) || trim($livro['descricao']) === '') {
            $descricao = gerarDescricao($titulo, $livro['nome_generos'], $livro['nome_categoria']);
            
            $sqlUpdate = "UPDATE tbl_itens SET descricao = :descricao WHERE id_item = :id";
            $stmtUpdate = $db->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':descricao', $descricao);
            $stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ($stmtUpdate->execute()) {
                logMessage("  ✓ Descrição adicionada\n", $log);
                $stats['descricoes_adicionadas']++;
            } else {
                logMessage("  ✗ Erro ao adicionar descrição\n", $log);
                $stats['erros']++;
            }
        } else {
            logMessage("  → Já possui descrição\n", $log);
        }
        
        // 2. Verificar se já tem autor
        $sqlCheckAutor = "SELECT COUNT(*) as total FROM tbl_item_autores WHERE item_id = :id";
        $stmtCheck = $db->prepare($sqlCheckAutor);
        $stmtCheck->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtCheck->execute();
        $temAutor = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        
        if ($temAutor['total'] == 0) {
            // Tentar extrair autor do título
            $nomeAutor = extrairAutor($titulo);
            
            if ($nomeAutor) {
                $autorId = buscarOuCriarAutor($db, $nomeAutor, $log);
                
                if ($autorId) {
                    if ($autorId && !isset($autoresCriadosSet[$autorId])) {
                        $stats['autores_criados']++;
                        $autoresCriadosSet[$autorId] = true;
                    }
                    
                    if (associarAutorAoLivro($db, $id, $autorId, $log)) {
                        logMessage("  ✓ Autor associado ao livro\n", $log);
                        $stats['associacoes_criadas']++;
                    }
                }
            } else {
                // Se não conseguiu identificar, usar "Autor Desconhecido"
                $autorId = buscarOuCriarAutor($db, 'Autor Desconhecido', $log);
                if ($autorId) {
                    if (associarAutorAoLivro($db, $id, $autorId, $log)) {
                        logMessage("  ✓ Associado a 'Autor Desconhecido'\n", $log);
                        $stats['associacoes_criadas']++;
                    }
                }
            }
        } else {
            logMessage("  → Já possui autor(es)\n", $log);
        }
        
        $stats['livros_processados']++;
    }
    
    $db->commit();
    
    logMessage("\n=== MIGRAÇÃO CONCLUÍDA ===\n", $log);
    logMessage("Livros processados: {$stats['livros_processados']}\n", $log);
    logMessage("Descrições adicionadas: {$stats['descricoes_adicionadas']}\n", $log);
    logMessage("Autores criados: {$stats['autores_criados']}\n", $log);
    logMessage("Associações criadas: {$stats['associacoes_criadas']}\n", $log);
    logMessage("Erros: {$stats['erros']}\n", $log);
    logMessage("\nLog salvo em: $logFile\n", $log);
    
    fclose($log);
    
} catch (Exception $e) {
    $db->rollBack();
    $msg = "\nERRO CRÍTICO: " . $e->getMessage() . "\n";
    $msg .= "Trace: " . $e->getTraceAsString() . "\n";
    logMessage($msg, $log);
    fclose($log);
    exit(1);
}
