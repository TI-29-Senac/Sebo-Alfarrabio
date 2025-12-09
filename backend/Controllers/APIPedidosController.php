<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Models\Pedidos;

class APIPedidosController{
    private $pedidosModel;
    private $chaveAPI;
    public function __construct(){
        $db = Database::getInstance();
        $this->pedidosModel = new Pedidos($db);
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
    public function getPedidos() {
        if (!$this->buscaChaveAPI()) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 'message' => 'chave de API inválida'
            ]);
            exit;
        } 
        // condição ternaria é igual if else
     
        $dados = $this->pedidosModel->buscarPedidos();
      
        
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([

            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        exit;
    }
    public function getPedidosx() {
        echo "teste";
        // if (!$this->buscaChaveAPI()) {
        //     http_response_code(500);
        //     echo json_encode([
        //         'status' => 'error', 'message' => 'chave de API inválida'
        //     ]);
        //     exit;
        // } 
        // condição ternaria é igual if else
     
       
    }

    public function salvarPedidos() {
        header('Content-Type: application/json');
        $pedidos = json_decode(file_get_contents('php://input'), true);
        if (empty($pedidos) || !is_array($pedidos)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum pedido recebido no carrinho.']);
            exit;
        }
        $novoPedidoId = $this->pedidosModel->inserirPedidos(
            $pedidos["nome_usuario"],
            $pedidos["email_usuario"],
            $pedidos["senha_usuario"],
            $pedidos["tipo_usuario"],
            $pedidos["status_usuario"]
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