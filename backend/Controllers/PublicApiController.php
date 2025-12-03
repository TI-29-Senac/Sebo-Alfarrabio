<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Models\Pedidos;

class PublicApiController{
    private $itemModel;
    private $pedidoModel;
    public function __construct(){
        $db = Database::getInstance();
        $this->itemModel = new Item($db);
        $this->pedidoModel = new Pedidos($db);
    }

    public function getItem() {
       
        $dados = $this->itemModel->buscarItemAtivos();
        foreach ($dados as &$item) {
            $item['caminho_imagem'] = '/backend/uploads/' . $item['foto_item'];
           
    
        }
        unset($item); 
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        exit;
    }

    public function salvarPedido() {
        header('Content-Type: application/json');
        $carrinho = json_decode(file_get_contents('php://input'), true);
        if (empty($carrinho) || !is_array($carrinho)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no carrinho.']);
            exit;
        }
        $novoPedidoId = $this->pedidoModel->criarPedido($carrinho);
        if ($novoPedidoId) {
            http_response_code(201);
            echo json_encode([
                'status' => 'success', 'message' => 'Pedido recebido com sucesso!',  'id_pedido' => $novoPedidoId
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 'message' => 'Ocorreu um erro ao processar seu pedido. Tente novamente.'
            ]);
        }
        exit;
    }
}