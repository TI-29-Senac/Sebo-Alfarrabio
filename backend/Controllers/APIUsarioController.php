<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Usuario;
use Sebo\Alfarrabio\Database\Database;

class APIUsarioController{
    private $usuarioModel;
    private $chaveAPI = "E374866E2EC5DB735C243D92F135816FFB913F3EA3E3E4E76264EA454FE43697";
    public function __construct(){
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
    }

    public function getUsuarios($pagina=0) {
        if ($this->buscaChaveAPI()) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error', 'message' => 'Chave API inválida.'
            ]);
        }


        $registros_por_pagina = $pagina===0 ? 200 : 5;
        $pagina = $pagina===0 ? 1 : (int)$pagina;
        $dados = $this->usuarioModel->paginacaoAPI($pagina, $registros_por_pagina);
        foreach ($dados['data'] as &$usuario) {
            unset($usuario['senha_usuario']);
        }
        unset($usuario);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'data' => $dados
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
       
        exit;
    }

    private function buscaChaveAPI(){
        $headers = getallheaders();
        $token = explode(" ", $headers['Authorization'] ?? '')[1] ?? null;
        return $token === $this->chaveAPI
        ;exit;
        
   }

    public function salvarUsuarios() {
        header('Content-Type: application/json');
        $usuario = json_decode(file_get_contents('php://input'), true);
        if (empty($usuario) || !is_array($usuario)) {
            echo json_encode(['status' => 'error', 'message' => 'Nenhum item recebido no usuario.']);
            exit;
        }
        $novoPedidoId = $this->usuarioModel->inseriUsuario(
            $usuario["nome_usuario"],
            $usuario["email_usuario"],
            $usuario["senha_usuario"],
            $usuario["tipo_usuario"],
            $usuario["status_usuario"]
        );
        if ($novoPedidoId) {
            http_response_code(201);
            echo json_encode([
                'status' => 'success', 'message' => 'Cadastrado com sucesso!',  'id_pedido' => $novoPedidoId
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