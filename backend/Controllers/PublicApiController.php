<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Models\Avaliacao;
use Sebo\Alfarrabio\Database\Database;

class PublicApiController
{

    private $db;
    private $item;
    private $avaliacao;
    private $categoriaModel;
    private $generoModel;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->item = new \Sebo\Alfarrabio\Models\Item($this->db);
        $this->avaliacao = new \Sebo\Alfarrabio\Models\Avaliacao($this->db);
        $this->categoriaModel = new \Sebo\Alfarrabio\Models\Categoria($this->db);
        $this->generoModel = new \Sebo\Alfarrabio\Models\Genero($this->db);
        $this->autorModel = new \Sebo\Alfarrabio\Models\Autor($this->db);
    }

    /**
     * Endpoint público para buscar itens do catálogo
     * GET /api/item
     * GET /api/item?id=123 (para buscar um item específico)
     */
    public function getItem()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        try {
            $id = $_GET['id'] ?? null;

            if ($id) {
                // Buscar item específico
                $item = $this->item->buscarItemCompleto((int) $id);
                if (!$item) {
                    http_response_code(404);
                    echo json_encode(['status' => 'error', 'message' => 'Item não encontrado']);
                    return;
                }
                
                // Formata com base64
                $item = $this->formatItemWithBase64($item);
                
                echo json_encode(['status' => 'success', 'data' => $item]);

            } else {
                // Buscar todos os itens ativos
                $itens = $this->item->buscarTodosItensCompletos();
                
                // Formata cada item com base64
                $itensFormatados = array_map(function($item) {
                    return $this->formatItemWithBase64($item);
                }, $itens);

                echo json_encode([
                    'status' => 'success',
                    'data' => $itensFormatados,
                    'total' => count($itensFormatados)
                ]);
            }

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erro ao buscar dados: ' . $e->getMessage()]);
        }
    }

    /**
     * Auxiliar para formatar item com imagem em base64 e caminhos absolutos
     */
    private function formatItemWithBase64($item)
    {
        if (empty($item)) return $item;

        // Tenta processar a imagem se existir
        if (!empty($item['foto_item'])) {
            $caminhoRelativo = $item['foto_item'];
            $baseDir = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
            
            $caminhoLimpo = ltrim($caminhoRelativo, '/');
            if (strpos($caminhoLimpo, 'backend/uploads/') === 0) {
                $caminhoLimpo = substr($caminhoLimpo, strlen('backend/uploads/'));
            } elseif (strpos($caminhoLimpo, 'uploads/') === 0) {
                $caminhoLimpo = substr($caminhoLimpo, strlen('uploads/'));
            }

            $caminhoFinal = $baseDir . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $caminhoLimpo);

            if (file_exists($caminhoFinal)) {
                $imageData = file_get_contents($caminhoFinal);
                $mimeType = mime_content_type($caminhoFinal);
                $base64 = base64_encode($imageData);
                
                // Adiciona a propriedade base64 (usando a mesma lógica do método standalone)
                $item['imagem_base64'] = 'data:' . $mimeType . ';base64,' . $base64;
                
                // Se o usuário quiser substituir foto_item ou adicionar caminho_imagem específico, fazemos aqui
                $item['caminho_imagem'] = '/backend/uploads/' . $caminhoLimpo;
            } else {
                $item['imagem_base64'] = null;
            }
        } else {
            $item['imagem_base64'] = null;
        }

        return $item;
    }

    /**
     * Endpoint público para buscar categorias
     * GET /api/categorias
     */
    public function getCategorias()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        try {
            $categorias = $this->categoriaModel->buscarCategorias();
            echo json_encode([
                'status' => 'success',
                'data' => $categorias
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Endpoint público para buscar gêneros
     * GET /api/generos
     */
    public function getGeneros()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        try {
            $generos = $this->generoModel->buscarGeneros();
            echo json_encode([
                'status' => 'success',
                'data' => $generos
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * NOVO: Endpoint público para buscar avaliações
     * GET /api/avaliacoes
     * GET /api/avaliacoes?limite=10
     * GET /api/avaliacoes?nota_minima=4
     */
    public function getAvaliacoes()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, OPTIONS');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        try {
            $limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 10;
            $nota_minima = isset($_GET['nota_minima']) ? (int) $_GET['nota_minima'] : null;

            $dadosCompletos = $this->avaliacao->getAvaliacoesCompletas($limite, $nota_minima);
            
            $avaliacoes = $dadosCompletos['avaliacoes'];
            $totalInDB = $this->avaliacao->totalDeAvaliacaoAtivos();

            $avaliacoes_formatadas = array_map(function ($av) {
                return [
                    'id' => (int) $av['id_avaliacao'],
                    'nota' => (int) $av['nota_avaliacao'],
                    'comentario' => $av['comentario_avaliacao'],
                    'data' => date('d/m/Y', strtotime($av['data_avaliacao'])),
                    'data_completa' => date('d/m/Y H:i', strtotime($av['criado_em'])),
                    'data_iso' => $av['data_avaliacao'],

                    'usuario' => [
                        'id' => (int) $av['id_usuario'],
                        'nome' => $av['nome_usuario'],
                        'email' => $av['email_usuario'],
                        'foto' => $av['foto_usuario'] ? $this->item->corrigirCaminhoImagem($av['foto_usuario']) : null,
                        'iniciais' => strtoupper(substr($av['nome_usuario'] ?? 'U', 0, 2))
                    ],

                    'item' => [
                        'id' => (int) $av['id_item'],
                        'titulo' => $av['titulo_item'],
                        'descricao' => $av['descricao_item'] ?? '',
                        'preco' => (float) ($av['preco_item'] ?? 0),
                        'imagem' => $this->item->corrigirCaminhoImagem($av['imagem_item']),
                        'categoria' => $av['nome_categoria'] ?? 'Sem categoria',
                        'genero' => $av['nome_genero'] ?? null,
                        'autor' => $av['nome_autor'] ?? null
                    ],

                    'tempo_decorrido' => calcularTempoDecorrido($av['criado_em'])
                ];
            }, $avaliacoes);

            echo json_encode([
                'success' => true,
                'total' => $dadosCompletos['total'],
                'total_no_banco' => $totalInDB,
                'media_notas' => $dadosCompletos['media_notas'],
                'distribuicao' => $dadosCompletos['distribuicao'],
                'avaliacoes' => $avaliacoes_formatadas,
                'timestamp' => date('Y-m-d H:i:s'),
                'filtros' => [
                    'limite' => $limite,
                    'nota_minima' => $nota_minima
                ]
            ], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Erro interno',
                'message' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Debug endpoint para verificar avaliações no banco
     * GET /api/debug-avaliacoes
     */
    public function debugAvaliacoes()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        try {
            // Este método ainda usa DB direto para propósitos de DEBUG/INSPEÇÃO de tabelas
            // mas poderia ser refatorado se o debug fosse mais "limpo". 
            // Para manter a funcionalidade de debug original sem poluir os models com metadados de tabelas:
            $debug = [];

            // 1. Verificar estrutura da tabela tbl_avaliacao
            $debug['1_estrutura_tabela'] = $this->db->query("DESCRIBE tbl_avaliacao")->fetchAll(\PDO::FETCH_ASSOC);

            // 2. Contagem total de avaliações
            $debug['2_total_avaliacoes'] = $this->avaliacao->totalDeAvaliacao();

            // 3. Contagem de avaliações não excluídas
            $debug['3_avaliacoes_nao_excluidas'] = $this->avaliacao->totalDeAvaliacaoAtivos();

            // 4. Primeiras 5 avaliações (dados brutos)
            $debug['4_primeiras_5_avaliacoes'] = $this->db->query("SELECT * FROM tbl_avaliacao LIMIT 5")->fetchAll(\PDO::FETCH_ASSOC);

            echo json_encode([
                'success' => true,
                'debug' => $debug,
                'timestamp' => date('Y-m-d H:i:s')
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Erro: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Endpoint público para buscar autores
     * GET /api/autores
     */
    public function getAutores()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        try {
            $autores = $this->autorModel->buscarAutores();
            echo json_encode([
                'status' => 'success',
                'data' => $autores
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Endpoint público para buscar imagem em base64
     * GET /api/item/imagem-base64?id=123
     */
    public function getImageBase64()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        try {
            $id = $_GET['id'] ?? null;

            if (!$id) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'ID não fornecido']);
                return;
            }

            $item = $this->item->buscarItemCompleto((int) $id);
            if (!$item || empty($item['foto_item'])) {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Item ou imagem não encontrada']);
                return;
            }

            $caminhoRelativo = $item['foto_item'];
            $baseDir = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
            
            $caminhoLimpo = ltrim($caminhoRelativo, '/');
            if (strpos($caminhoLimpo, 'backend/uploads/') === 0) {
                $caminhoLimpo = substr($caminhoLimpo, strlen('backend/uploads/'));
            } elseif (strpos($caminhoLimpo, 'uploads/') === 0) {
                $caminhoLimpo = substr($caminhoLimpo, strlen('uploads/'));
            }

            $caminhoFinal = $baseDir . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $caminhoLimpo);

            if (!file_exists($caminhoFinal)) {
                http_response_code(404);
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Arquivo de imagem não encontrado no servidor',
                    'debug_path' => $caminhoFinal
                ]);
                return;
            }

            $imageData = file_get_contents($caminhoFinal);
            $base64 = base64_encode($imageData);
            $mimeType = mime_content_type($caminhoFinal);

            echo json_encode([
                'status' => 'success',
                'id' => (int)$id,
                'mime_type' => $mimeType,
                'filename' => basename($caminhoFinal),
                'base64' => 'data:' . $mimeType . ';base64,' . $base64
            ], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erro ao processar imagem: ' . $e->getMessage()]);
        }
    }

}
