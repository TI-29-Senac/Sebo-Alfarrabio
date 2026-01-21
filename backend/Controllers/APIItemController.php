<?php
namespace Sebo\Alfarrabio\Controllers\Api;

use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Database\Database;

/**
 * API Controller para endpoints públicos de itens
 * Retorna dados em JSON para o frontend
 */
class APIItemController {
    
    private $db;
    private $item;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->item = new Item($this->db);
    }

    /**
     * GET /api/item
     * Retorna todos os itens ativos com paginação
     * Parâmetros opcionais: ?pagina=1&por_pagina=8&tipo=livro&search=termo
     */
    public function listarItens() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        try {
            // Parâmetros de paginação
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $por_pagina = isset($_GET['por_pagina']) ? (int)$_GET['por_pagina'] : 8;
            $tipo = $_GET['tipo'] ?? null;
            $search = $_GET['search'] ?? null;
            
            // Validação
            if ($pagina < 1) $pagina = 1;
            if ($por_pagina < 1 || $por_pagina > 100) $por_pagina = 8;
            
            // Busca com ou sem filtro
            if ($search) {
                $dados = $this->item->pesquisarItens($search, $pagina, $por_pagina);
            } else {
                $dados = $this->item->paginacao($pagina, $por_pagina, $tipo);
            }
            
            // Processa os itens para adicionar caminho completo da imagem
            foreach ($dados['data'] as &$item) {
                // Adiciona caminho completo da imagem
                if (!empty($item['foto_item'])) {
                    // Se já tem barra, mantém, senão adiciona
                    $item['caminho_imagem'] = $item['foto_item'];
                } else {
                    // Imagem padrão se não houver foto
                    $item['caminho_imagem'] = '/img/sem-imagem.png';
                }
                
                // Formata o preço
                $item['preco'] = isset($item['preco_item']) ? number_format((float)$item['preco_item'], 2, '.', '') : '0.00';
                
                // Garante que temos um estoque
                $item['estoque'] = $item['estoque'] ?? 0;
            }
            
            echo json_encode([
                'status' => 'success',
                'data' => $dados['data'],
                'paginacao' => [
                    'total' => $dados['total'],
                    'por_pagina' => $dados['por_pagina'],
                    'pagina_atual' => $dados['pagina_atual'],
                    'ultima_pagina' => $dados['ultima_pagina'],
                    'de' => $dados['de'],
                    'para' => $dados['para']
                ]
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao buscar itens: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * GET /api/item/{id}
     * Retorna um item específico
     */
    public function buscarItem($id) {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        try {
            $id = (int)$id;
            
            if ($id <= 0) {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'ID inválido'
                ], JSON_UNESCAPED_UNICODE);
                return;
            }
            
            $item = $this->item->buscarItemPorID($id);
            
            if (!$item) {
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Item não encontrado'
                ], JSON_UNESCAPED_UNICODE);
                return;
            }
            
            // Processa dados do item
            if (!empty($item['foto_item'])) {
                $item['caminho_imagem'] = $item['foto_item'];
            } else {
                $item['caminho_imagem'] = '/img/sem-imagem.png';
            }
            
            $item['preco'] = isset($item['preco_item']) ? number_format((float)$item['preco_item'], 2, '.', '') : '0.00';
            
            echo json_encode([
                'status' => 'success',
                'data' => $item
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao buscar item: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * GET /api/item/pesquisar
     * Pesquisa itens por termo
     */
    public function pesquisarItens() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        try {
            $termo = $_GET['termo'] ?? $_GET['q'] ?? '';
            $limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 10;
            
            if (strlen($termo) < 2) {
                echo json_encode([
                    'status' => 'success',
                    'data' => []
                ], JSON_UNESCAPED_UNICODE);
                return;
            }
            
            $resultados = $this->item->pesquisarItensSimples($termo, $limite);
            
            echo json_encode([
                'status' => 'success',
                'data' => $resultados
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao pesquisar: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * GET /api/item/tipos
     * Retorna os tipos de itens disponíveis
     */
    public function listarTipos() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        echo json_encode([
            'status' => 'success',
            'data' => ['livro', 'cd', 'dvd', 'revista']
        ], JSON_UNESCAPED_UNICODE);
    }
}