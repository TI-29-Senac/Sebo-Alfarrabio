<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Models\Item;

class APIItemController{
    private $itemModel;
    private $chaveAPI;
    public function __construct(){
        $db = Database::getInstance();
        $this->itemModel = new Item($db);
        $this->chaveAPI = "9D67A537A9329E0F1E9D088A1C991F1CC728EA87D3D154B409ED3320EA940303";
    }
    private function buscaChaveAPI(){
        $headers = getallheaders();
        if (!isset($headers["Authorization"])) {
            return false;
        }
        $token = explode(" ", $headers["Authorization"])[1];
        return $token === $this->chaveAPI;
    }
    public function getItem() {
        if (!$this->buscaChaveAPI()) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 'message' => 'chave de API inválida'
            ]);
            exit;
        } 
        // condição ternaria é igual if else
     
        $dados = $this->itemModel->buscarItemAtivos();
      
    
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        exit;
    }

    public function salvarItem() {
        header('Content-Type: application/json');
        $item = json_decode(file_get_contents('php://input'), true);
        if (empty($item) || !is_array($item)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no carrinho.']);
            exit;
        }
        $novoPedidoId = $this->itemModel->inserirItem(
            $item["nome_usuario"],
            $item["email_usuario"],
            $item["senha_usuario"],
            $item["tipo_usuario"],
            $item["status_usuario"]
        );
        if ($novoPedidoId) {
            http_response_code(201);
            echo json_encode([
                'status' => 'success', 'message' => 'cadastrado com sucesso!',  'id_pedido' => $novoPedidoId
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
