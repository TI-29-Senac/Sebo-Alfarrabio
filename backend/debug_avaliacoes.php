<?php
/**
 * Script de Debug para verificar avaliações no banco
 * Acesse via: http://localhost/backend/debug_avaliacoes.php
 */

// Headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Carrega dependências manualmente
require_once __DIR__ . '/Database/Config.php';
require_once __DIR__ . '/Database/Database.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();

    $debug = [];

    // 1. Verificar estrutura da tabela tbl_avaliacao
    $debug['1_estrutura_tabela'] = [];
    $estrutura = $db->query("DESCRIBE tbl_avaliacao")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($estrutura as $col) {
        $debug['1_estrutura_tabela'][] = $col['Field'] . ' (' . $col['Type'] . ')';
    }

    // 2. Contagem total de avaliações
    $countAll = $db->query("SELECT COUNT(*) as total FROM tbl_avaliacao")->fetch(PDO::FETCH_ASSOC);
    $debug['2_total_avaliacoes'] = $countAll['total'];

    // 3. Contagem de avaliações não excluídas
    $countActive = $db->query("SELECT COUNT(*) as total FROM tbl_avaliacao WHERE excluido_em IS NULL")->fetch(PDO::FETCH_ASSOC);
    $debug['3_avaliacoes_ativas'] = $countActive['total'];

    // 4. Avaliações com status ativo
    $countStatus = $db->query("SELECT COUNT(*) as total FROM tbl_avaliacao WHERE status_avaliacao = 'ativo'")->fetch(PDO::FETCH_ASSOC);
    $debug['4_status_ativo'] = $countStatus['total'];

    // 5. Primeiras 5 avaliações (dados brutos)
    $avaliacoes = $db->query("SELECT * FROM tbl_avaliacao LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    $debug['5_primeiras_5_avaliacoes'] = $avaliacoes;

    // 6. Verificar se os id_usuario existem na tbl_usuario
    if (!empty($avaliacoes)) {
        $ids_usuarios = array_column($avaliacoes, 'id_usuario');
        $ids_usuarios = array_filter($ids_usuarios);
        if (!empty($ids_usuarios)) {
            $ids_str = implode(',', array_map('intval', $ids_usuarios));
            $usuarios = $db->query("SELECT id_usuario, nome_usuario FROM tbl_usuario WHERE id_usuario IN ($ids_str)")->fetchAll(PDO::FETCH_ASSOC);
            $debug['6_usuarios_encontrados'] = $usuarios;
        } else {
            $debug['6_usuarios_encontrados'] = "Nenhum id_usuario nas avaliações";
        }
    }

    // 7. Verificar se os id_item existem na tbl_itens
    if (!empty($avaliacoes)) {
        $ids_itens = array_column($avaliacoes, 'id_item');
        $ids_itens = array_filter($ids_itens);
        if (!empty($ids_itens)) {
            $ids_str = implode(',', array_map('intval', $ids_itens));
            $itens = $db->query("SELECT id_item, titulo_item FROM tbl_itens WHERE id_item IN ($ids_str)")->fetchAll(PDO::FETCH_ASSOC);
            $debug['7_itens_encontrados'] = $itens;
        } else {
            $debug['7_itens_encontrados'] = "Nenhum id_item nas avaliações";
        }
    }

    // 8. Testar a query completa do PublicApiController
    $query_completa = "SELECT 
        a.id_avaliacao,
        a.nota_avaliacao,
        a.comentario_avaliacao,
        a.data_avaliacao,
        a.status_avaliacao,
        a.criado_em,
        u.id_usuario,
        u.nome_usuario,
        i.id_item,
        i.titulo_item
    FROM tbl_avaliacao a
    LEFT JOIN tbl_usuario u ON a.id_usuario = u.id_usuario
    LEFT JOIN tbl_itens i ON a.id_item = i.id_item
    WHERE a.excluido_em IS NULL
    ORDER BY a.data_avaliacao DESC
    LIMIT 5";

    $resultado_query = $db->query($query_completa)->fetchAll(PDO::FETCH_ASSOC);
    $debug['8_resultado_query_completa'] = $resultado_query;

    // 9. Total de usuários
    $totalUsuarios = $db->query("SELECT COUNT(*) as total FROM tbl_usuario")->fetch(PDO::FETCH_ASSOC);
    $debug['9_total_usuarios'] = $totalUsuarios['total'];

    // 10. Total de itens
    $totalItens = $db->query("SELECT COUNT(*) as total FROM tbl_itens")->fetch(PDO::FETCH_ASSOC);
    $debug['10_total_itens'] = $totalItens['total'];

    // Resultado
    echo json_encode([
        'success' => true,
        'debug' => $debug,
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro PDO: ' . $e->getMessage(),
        'code' => $e->getCode()
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
