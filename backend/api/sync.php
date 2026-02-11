<?php
/**
 * API REST para Sincronização com PDV Desktop
 * Endpoint: /backend/api/sync.php
 */

// Headers CORS
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Autoload do Composer
require_once __DIR__ . '/../../vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();

    // Determinar qual recurso foi solicitado
    $recurso = $_GET['recurso'] ?? '';
    $pagina = (int) ($_GET['pagina'] ?? 1);
    $porPagina = (int) ($_GET['por_pagina'] ?? 50);

    switch ($recurso) {
        case 'categorias':
            $stmt = $db->query("SELECT id_categoria, nome_categoria, excluido_em FROM tbl_categorias WHERE excluido_em IS NULL ORDER BY nome_categoria");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $data]);
            break;

        case 'generos':
            $stmt = $db->query("SELECT id_generos, nome_generos, excluido_em FROM tbl_generos WHERE excluido_em IS NULL ORDER BY nome_generos");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $data]);
            break;

        case 'autores':
            $stmt = $db->query("SELECT id_autor, nome_autor, biografia FROM tbl_autores ORDER BY nome_autor");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $data]);
            break;

        case 'itens':
            // Contagem total
            $countStmt = $db->query("SELECT COUNT(*) FROM tbl_itens WHERE excluido_em IS NULL");
            $total = $countStmt->fetchColumn();

            // Paginação
            $offset = ($pagina - 1) * $porPagina;

            $sql = "SELECT 
                        i.id_item, i.titulo_item, i.tipo_item, i.preco_item, i.foto_item,
                        i.id_genero, i.id_categoria, i.descricao, i.ano_publicacao,
                        i.editora_gravadora, i.isbn, i.estoque, i.duracao_minutos,
                        i.numero_edicao, i.criado_em, i.atualizado_em,
                        c.nome_categoria,
                        g.nome_generos AS nome_genero,
                        (SELECT GROUP_CONCAT(a.nome_autor SEPARATOR ', ') 
                         FROM tbl_item_autores ia 
                         JOIN tbl_autores a ON ia.autor_id = a.id_autor 
                         WHERE ia.item_id = i.id_item) AS autores
                    FROM tbl_itens i
                    LEFT JOIN tbl_categorias c ON i.id_categoria = c.id_categoria
                    LEFT JOIN tbl_generos g ON i.id_genero = g.id_generos
                    WHERE i.excluido_em IS NULL
                    ORDER BY i.criado_em DESC
                    LIMIT :limit OFFSET :offset";

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                'success' => true,
                'data' => $data,
                'total' => (int) $total,
                'pagina_atual' => $pagina,
                'por_pagina' => $porPagina,
                'ultima_pagina' => (int) ceil($total / $porPagina)
            ]);
            break;

        case 'vendas':
            // Receber vendas do PDV (POST)
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $input = json_decode(file_get_contents('php://input'), true);

                if (!$input || !isset($input['venda'])) {
                    http_response_code(400);
                    echo json_encode(['success' => false, 'error' => 'Dados inválidos']);
                    break;
                }

                // Aqui você implementaria a lógica de salvar a venda
                // Por enquanto, apenas confirmamos o recebimento
                echo json_encode([
                    'success' => true,
                    'message' => 'Venda recebida com sucesso',
                    'uuid' => $input['venda']['uuid'] ?? null
                ]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Use POST para enviar vendas']);
            }
            break;

        case 'status':
            // Retorna status da API para teste de conexão
            echo json_encode([
                'success' => true,
                'message' => 'API Sebo Alfarrabio Online',
                'timestamp' => date('Y-m-d H:i:s'),
                'version' => '1.0'
            ]);
            break;

        default:
            echo json_encode([
                'success' => false,
                'error' => 'Recurso não especificado',
                'recursos_disponiveis' => ['categorias', 'generos', 'autores', 'itens', 'vendas', 'status']
            ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro no servidor: ' . $e->getMessage()
    ]);
}
