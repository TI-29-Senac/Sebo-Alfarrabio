<?php
namespace Sebo\Alfarrabio\Controllers\Admin;
use Exception;
use DateTime;
use PDOException;
use PDO;


// Headers para API JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Resposta rápida para OPTIONS (CORS preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Inclua seu arquivo de conexão com banco de dados
// AJUSTE O CAMINHO CONFORME SUA ESTRUTURA DE PASTAS
require_once __DIR__ . '/../src/Database/Database.php';

use Sebo\Alfarrabio\Database\Database;

try {
    // Obtém instância do banco
    $db = Database::getInstance();
    
    // Parâmetros opcionais via GET
    $limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 20;
    $item_id = isset($_GET['item_id']) ? (int)$_GET['item_id'] : null;
    $nota_minima = isset($_GET['nota_minima']) ? (int)$_GET['nota_minima'] : null;
    
    // Query principal com JOIN completo
    $sql = "SELECT 
                a.id_avaliacao,
                a.nota_avaliacao,
                a.comentario_avaliacao,
                a.data_avaliacao,
                a.status_avaliacao,
                a.criado_em,
                
                -- Dados do usuário
                u.id_usuario,
                u.nome_usuario,
                u.email_usuario,
                u.foto_usuario,
                
                -- Dados do item
                i.id_item,
                i.titulo_item,
                i.descricao_item,
                i.preco_item,
                i.imagem_item,
                i.estoque_item,
                
                -- Dados da categoria (se existir)
                c.nome_categoria,
                
                -- Dados do gênero (se existir)
                g.nome_genero,
                
                -- Dados do autor (se existir)
                aut.nome_autor
                
            FROM tbl_avaliacao a
            
            INNER JOIN tbl_usuario u 
                ON a.id_usuario = u.id_usuario
            
            INNER JOIN tbl_item i 
                ON a.id_item = i.id_item
            
            LEFT JOIN tbl_categoria c 
                ON i.id_categoria = c.id_categoria
            
            LEFT JOIN tbl_genero g 
                ON i.id_genero = g.id_genero
            
            LEFT JOIN tbl_autor aut 
                ON i.id_autor = aut.id_autor
            
            WHERE a.status_avaliacao = 'ativo' 
            AND a.excluido_em IS NULL
            AND a.comentario_avaliacao IS NOT NULL
            AND a.comentario_avaliacao != ''";
    
    // Filtro por item específico
    if ($item_id) {
        $sql .= " AND a.id_item = :item_id";
    }
    
    // Filtro por nota mínima
    if ($nota_minima) {
        $sql .= " AND a.nota_avaliacao >= :nota_minima";
    }
    
    $sql .= " ORDER BY a.data_avaliacao DESC, a.criado_em DESC LIMIT :limite";
    
    // Prepara e executa a query
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    
    if ($item_id) {
        $stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);
    }
    
    if ($nota_minima) {
        $stmt->bindValue(':nota_minima', $nota_minima, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    $avaliacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calcula estatísticas
    $total = count($avaliacoes);
    $soma_notas = 0;
    $distribuicao = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
    
    foreach ($avaliacoes as $av) {
        $soma_notas += (int)$av['nota_avaliacao'];
        $distribuicao[(int)$av['nota_avaliacao']]++;
    }
    
    $media_notas = $total > 0 ? round($soma_notas / $total, 2) : 0;
    
    // Formata os dados para o frontend
    $avaliacoes_formatadas = array_map(function($av) {
        // Define foto padrão se não existir
        $foto_usuario = $av['foto_usuario'] ?? 'img/default-avatar.jpg';
        
        // Garante que a foto tenha caminho completo
        if (!empty($foto_usuario) && !preg_match('/^(http|\/|img)/', $foto_usuario)) {
            $foto_usuario = 'img/' . $foto_usuario;
        }
        
        // Imagem do item
        $imagem_item = $av['imagem_item'] ?? 'img/default-book.jpg';
        if (!empty($imagem_item) && !preg_match('/^(http|\/|img)/', $imagem_item)) {
            $imagem_item = 'img/livros/' . $imagem_item;
        }
        
        return [
            // Dados da avaliação
            'id' => (int)$av['id_avaliacao'],
            'nota' => (int)$av['nota_avaliacao'],
            'comentario' => $av['comentario_avaliacao'],
            'data' => date('d/m/Y', strtotime($av['data_avaliacao'])),
            'data_completa' => date('d/m/Y H:i', strtotime($av['criado_em'])),
            'data_iso' => $av['data_avaliacao'],
            
            // Dados do usuário
            'usuario' => [
                'id' => (int)$av['id_usuario'],
                'nome' => $av['nome_usuario'],
                'email' => $av['email_usuario'],
                'foto' => $foto_usuario,
                'iniciais' => substr($av['nome_usuario'], 0, 2)
            ],
            
            // Dados do item/livro
            'item' => [
                'id' => (int)$av['id_item'],
                'titulo' => $av['titulo_item'],
                'descricao' => $av['descricao_item'] ?? '',
                'preco' => (float)($av['preco_item'] ?? 0),
                'imagem' => $imagem_item,
                'estoque' => (int)($av['estoque_item'] ?? 0),
                'categoria' => $av['nome_categoria'] ?? 'Sem categoria',
                'genero' => $av['nome_genero'] ?? 'Sem gênero',
                'autor' => $av['nome_autor'] ?? 'Autor desconhecido'
            ],
            
            // Metadados
            'tempo_decorrido' => calcularTempoDecorrido($av['criado_em'])
        ];
    }, $avaliacoes);
    
    // Resposta da API
    $resposta = [
        'success' => true,
        'total' => $total,
        'media_notas' => $media_notas,
        'distribuicao' => $distribuicao,
        'avaliacoes' => $avaliacoes_formatadas,
        'timestamp' => date('Y-m-d H:i:s'),
        'filtros_aplicados' => [
            'limite' => $limite,
            'item_id' => $item_id,
            'nota_minima' => $nota_minima
        ]
    ];
    
    http_response_code(200);
    echo json_encode($resposta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
} catch (PDOException $e) {
    // Erro de banco de dados
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro ao buscar avaliações',
        'message' => 'Erro no banco de dados: ' . $e->getMessage(),
        'code' => $e->getCode()
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    // Erro geral
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro interno do servidor',
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

/**
 * Calcula tempo decorrido desde a avaliação
 */
function calcularTempoDecorrido($data) {
    $agora = new DateTime();
    $data_av = new DateTime($data);
    $diff = $agora->diff($data_av);
    
    if ($diff->y > 0) {
        return $diff->y . ' ano' . ($diff->y > 1 ? 's' : '') . ' atrás';
    } elseif ($diff->m > 0) {
        return $diff->m . ' mês' . ($diff->m > 1 ? 'es' : '') . ' atrás';
    } elseif ($diff->d > 0) {
        return $diff->d . ' dia' . ($diff->d > 1 ? 's' : '') . ' atrás';
    } elseif ($diff->h > 0) {
        return $diff->h . ' hora' . ($diff->h > 1 ? 's' : '') . ' atrás';
    } elseif ($diff->i > 0) {
        return $diff->i . ' minuto' . ($diff->i > 1 ? 's' : '') . ' atrás';
    } else {
        return 'Agora mesmo';
    }
}