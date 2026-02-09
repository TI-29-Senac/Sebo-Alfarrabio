<?php
/**
 * API Endpoint: Cancelar Reserva
 * Processa o cancelamento de uma reserva pelo cliente
 */

header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Models\Pedidos;

try {
    // Verifica autenticação
    if (!isset($_SESSION['usuario_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Usuário não autenticado.'
        ]);
        exit;
    }

    // Verifica método POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'success' => false,
            'message' => 'Método não permitido.'
        ]);
        exit;
    }

    // Valida ID do pedido
    $idPedido = $_POST['id_pedido'] ?? null;
    if (!$idPedido || !is_numeric($idPedido)) {
        echo json_encode([
            'success' => false,
            'message' => 'ID do pedido inválido.'
        ]);
        exit;
    }

    $db = Database::getInstance();
    $pedidosModel = new Pedidos($db);
    $usuarioId = $_SESSION['usuario_id'];

    // Busca o pedido
    $pedido = $pedidosModel->buscarPedidosPorID($idPedido);

    if (!$pedido) {
        echo json_encode([
            'success' => false,
            'message' => 'Pedido não encontrado.'
        ]);
        exit;
    }

    // Verifica se o pedido pertence ao usuário
    if ($pedido['id_usuario'] != $usuarioId) {
        echo json_encode([
            'success' => false,
            'message' => 'Você não tem permissão para cancelar este pedido.'
        ]);
        exit;
    }

    // Verifica se o pedido já está cancelado
    $statusAtual = strtolower($pedido['status']);
    if (strpos($statusAtual, 'cancel') !== false) {
        echo json_encode([
            'success' => false,
            'message' => 'Este pedido já está cancelado.'
        ]);
        exit;
    }

    // Verifica se o pedido já foi entregue (não pode cancelar pedidos entregues)
    if (strpos($statusAtual, 'entreg') !== false) {
        echo json_encode([
            'success' => false,
            'message' => 'Não é possível cancelar um pedido já entregue.'
        ]);
        exit;
    }

    // Atualiza o status para "Cancelado"
    $resultado = $pedidosModel->atualizarStatus($idPedido, 'Cancelado');

    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Reserva cancelada com sucesso!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao cancelar a reserva. Tente novamente.'
        ]);
    }

} catch (Exception $e) {
    error_log("Erro ao cancelar reserva: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao processar cancelamento. Tente novamente.'
    ]);
}
