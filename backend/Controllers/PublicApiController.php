<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Models\Reservas;

class PublicApiController{
    private $itemModel;
    private $reservasModel;
    public function __construct(){
        $db = Database::getInstance();
        $this->itemModel = new Item($db);
        $this->reservasModel = new Reservas($db);
    }

    public function getItem(){
        header('Content-Type: application/json');
        $dados = $this->itemModel->buscarItemAtivos();
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $dados], JSON_UNESCAPED_SLASHES);
        exit;
    }

    public function salvarReservas() {
        header('Content-Type: application/json');
        $carrinho = json_decode(file_get_contents('php://input'), true);
        if (empty($carrinho) || !is_array($carrinho)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no carrinho.']);
            exit;
        }
        $novoReservasId = $this->reservasModel->criarReservas($carrinho);
        if ($novoReservasId) {
            http_response_code(201);
            echo json_encode([
                'status' => 'success', 'message' => 'Reserva recebida com sucesso!',  'id_Reservas' => $novoReservasId
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 'message' => 'Ocorreu um erro ao processar sua Reserva. Tente novamente.'
            ]);
        }
        exit;
    }
}