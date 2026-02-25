<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Models\Avaliacao;
use Sebo\Alfarrabio\Models\Vendas;
use Sebo\Alfarrabio\Database\Database;

class PublicApiController
{

    private $db;
    private $item;
    private $avaliacao;
    private $categoriaModel;
    private $generoModel;
    private $autorModel;

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
     * Valida o token Bearer enviado no header Authorization
     */
    private function validarAuth()
    {
        $token = '';
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);
        } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            $token = str_replace('Bearer ', '', $_SERVER['REDIRECT_HTTP_AUTHORIZATION']);
        }

        $expectedToken = getenv('API_SYNC_TOKEN') ?: '9D67A537A9329E0F1E9D088A1C991F1CC728EA87D3D154B409ED3320EA940303';

        if ($token !== $expectedToken) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Não autorizado']);
            exit;
        }
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
                $itensFormatados = array_map(function ($item) {
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
        if (empty($item))
            return $item;

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
                $mimeType = $this->getMimeType($caminhoFinal);
                $base64 = base64_encode($imageData);

                // Adiciona a propriedade base64 (usando a mesma lógica do método standalone)
                $item['imagem_base64'] = 'data:' . $mimeType . ';base64,' . $base64;

                // Se o usuário quiser substituir foto_item ou adicionar caminho_imagem específico, fazemos aqui
                $item['caminho_imagem'] = '/backend/uploads/' . $caminhoLimpo;
            } else {
                $item['imagem_base64'] = null;
                $item['caminho_imagem'] = '/img/sem-imagem.webp';
            }
        } else {
            $item['imagem_base64'] = null;
        }

        return $item;
    }

    /**
     * Helper para obter mime-type com fallback se a extensão fileinfo estiver desativada
     */
    private function getMimeType($file)
    {
        if (function_exists('mime_content_type')) {
            return mime_content_type($file);
        }

        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mimes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'bmp' => 'image/bmp',
            'svg' => 'image/svg+xml',
        ];

        return $mimes[$extension] ?? 'application/octet-stream';
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

                    'tempo_decorrido' => calcularTempoDecorrido($av['criado_em']),

                    // Fotos da avaliação (busca da tbl_avaliacao_fotos)
                    'fotos' => array_map(function ($f) {
                        return $f['caminho_foto'];
                    }, $this->avaliacao->buscarFotosAvaliacao($av['id_avaliacao']))
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
                    'message' => 'Arquivo de imagem não encontrado no servidor'
                ]);
                return;
            }

            $imageData = file_get_contents($caminhoFinal);
            $base64 = base64_encode($imageData);
            $mimeType = $this->getMimeType($caminhoFinal);

            echo json_encode([
                'status' => 'success',
                'id' => (int) $id,
                'mime_type' => $mimeType,
                'filename' => basename($caminhoFinal),
                'base64' => 'data:' . $mimeType . ';base64,' . $base64
            ], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Erro ao processar imagem: ' . $e->getMessage()]);
        }
    }

    // =========================================================================
    // BASE64 → ARQUIVO: Endpoints para cadastro/atualização via Desktop
    // =========================================================================

    /**
     * Auxiliar para decodificar imagem base64 e salvar como arquivo
     * Função reversa do formatItemWithBase64()
     * 
     * @param string $base64String String no formato "data:image/jpeg;base64,/9j/..."
     * @return string|null Caminho relativo salvo (ex: "/uploads/itens/abc123.jpg") ou null em caso de erro
     */
    private function saveBase64Image(string $base64String): ?string
    {
        // Mapa de mime-types para extensões
        $extensionMap = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
        ];

        // Extrai o mime type e os dados base64
        // Formato esperado: "data:image/jpeg;base64,/9j/4AAQ..."
        if (preg_match('/^data:(image\/[a-zA-Z+]+);base64,(.+)$/', $base64String, $matches)) {
            $mimeType = $matches[1];
            $dadosBase64 = $matches[2];
        } else {
            error_log("saveBase64Image: Formato base64 inválido (sem prefixo data:)");
            $mimeType = 'image/jpeg'; // default
            $dadosBase64 = $base64String;
        }

        // Valida o mime type
        if (!isset($extensionMap[$mimeType])) {
            error_log("saveBase64Image: Tipo de imagem não suportado: $mimeType");
            return null;
        }

        // Decodifica o base64
        $dadosBinarios = base64_decode($dadosBase64, true);
        if ($dadosBinarios === false) {
            error_log("saveBase64Image: Falha ao decodificar base64");
            return null;
        }

        // Valida tamanho (max 5MB)
        if (strlen($dadosBinarios) > 5 * 1024 * 1024) {
            error_log("saveBase64Image: Imagem excede o tamanho máximo de 5MB");
            return null;
        }

        // Gera nome único (formato correspondente ao desejado: uniqid.ext)
        $extensao = $extensionMap[$mimeType];
        $nomeArquivo = uniqid('', true) . '.' . $extensao;

        // Define o diretório de destino
        $diretorioUpload = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'itens';

        // Cria o diretório se não existir
        if (!is_dir($diretorioUpload)) {
            if (!mkdir($diretorioUpload, 0755, true)) {
                error_log("saveBase64Image: Falha ao criar diretório: $diretorioUpload");
                return null;
            }
        }

        // Salva o arquivo
        $caminhoCompleto = $diretorioUpload . DIRECTORY_SEPARATOR . $nomeArquivo;
        if (file_put_contents($caminhoCompleto, $dadosBinarios) === false) {
            error_log("saveBase64Image: Falha ao salvar arquivo: $caminhoCompleto");
            return null;
        }

        // Retorna o caminho relativo no formato usado pelo sistema
        return '/uploads/itens/' . $nomeArquivo;
    }

    /**
     * Remove um arquivo de imagem pelo caminho relativo
     */
    private function deletarImagemAntiga(?string $caminhoRelativo): void
    {
        if (empty($caminhoRelativo))
            return;

        $caminhoLimpo = ltrim($caminhoRelativo, '/');
        if (strpos($caminhoLimpo, 'backend/uploads/') === 0) {
            $caminhoLimpo = substr($caminhoLimpo, strlen('backend/'));
        }
        if (strpos($caminhoLimpo, 'uploads/') === 0) {
            $caminhoLimpo = substr($caminhoLimpo, strlen('uploads/'));
        }

        $caminhoCompleto = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR
            . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $caminhoLimpo);

        if (file_exists($caminhoCompleto) && is_file($caminhoCompleto)) {
            unlink($caminhoCompleto);
        }
    }

    /**
     * Endpoint API para criar item com imagem em base64
     * POST /api/item/salvar
     * 
     * Recebe JSON com dados do item + campo "imagem_base64"
     * Decodifica a imagem e salva como arquivo no servidor
     */
    public function postItem()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        $this->validarAuth();

        try {
            // Lê o corpo da requisição JSON
            $jsonBody = file_get_contents('php://input');
            $dados = json_decode($jsonBody, true);

            if (!$dados) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'JSON inválido ou corpo vazio']);
                return;
            }

            // Valida campos obrigatórios
            if (empty($dados['titulo_item'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Campo titulo_item é obrigatório']);
                return;
            }

            // Processa imagem base64 se fornecida
            $fotoPath = null;
            if (!empty($dados['imagem_base64'])) {
                $fotoPath = $this->saveBase64Image($dados['imagem_base64']);
                if ($fotoPath === null) {
                    error_log("postItem: Falha ao processar imagem base64 para o item: " . ($dados['titulo_item'] ?? 'sem titulo'));
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Falha ao processar imagem base64']);
                    return;
                }
            }

            // Monta os dados do item para inserção
            $dadosItem = [
                'titulo_item' => $dados['titulo_item'],
                'tipo_item' => $dados['tipo_item'] ?? 'livro',
                'id_genero' => (int) ($dados['id_genero'] ?? 0),
                'id_categoria' => (int) ($dados['id_categoria'] ?? 0),
                'descricao' => $dados['descricao'] ?? null,
                'ano_publicacao' => !empty($dados['ano_publicacao']) ? (int) $dados['ano_publicacao'] : null,
                'editora_gravadora' => $dados['editora_gravadora'] ?? null,
                'estoque' => (int) ($dados['estoque'] ?? 1),
                'preco_item' => !empty($dados['preco_item']) ? (float) $dados['preco_item'] : 0.00,
                'isbn' => $dados['isbn'] ?? null,
                'duracao_minutos' => !empty($dados['duracao_minutos']) ? (int) $dados['duracao_minutos'] : null,
                'numero_edicao' => !empty($dados['numero_edicao']) ? (int) $dados['numero_edicao'] : null,
                'foto_item' => $fotoPath,
            ];

            $autores_ids = $dados['autores_ids'] ?? [];
            $autores_ids = array_map('intval', $autores_ids);

            $resultado = $this->item->inserirItem($dadosItem, $autores_ids);

            if ($resultado) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Item cadastrado com sucesso',
                    'id_item' => (int) $resultado,
                    'foto_item' => $fotoPath
                ], JSON_UNESCAPED_UNICODE);
            } else {
                // Se falhou, remove a imagem que foi salva
                if ($fotoPath) {
                    $this->deletarImagemAntiga($fotoPath);
                }
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Erro ao inserir item no banco de dados']);
            }

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao processar requisição: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Endpoint API para atualizar item com imagem em base64
     * POST /api/item/atualizar
     * 
     * Recebe JSON com id_item + dados a atualizar + campo "imagem_base64" (opcional)
     * Se imagem_base64 vier preenchido, substitui a imagem antiga
     */
    public function putItem()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        $this->validarAuth();

        try {
            $jsonBody = file_get_contents('php://input');
            $dados = json_decode($jsonBody, true);

            if (!$dados) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'JSON inválido ou corpo vazio']);
                return;
            }

            $id_item = (int) ($dados['id_item'] ?? 0);
            if ($id_item <= 0) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Campo id_item é obrigatório e deve ser maior que 0']);
                return;
            }

            // Busca o item atual para pegar o caminho da foto existente
            $itemAtual = $this->item->buscarItemCompleto($id_item);
            if (!$itemAtual) {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Item não encontrado']);
                return;
            }

            // Processa nova imagem base64 se fornecida
            $fotoPath = $itemAtual['foto_item'] ?? null; // Mantém a foto atual por padrão
            $fotoAntiga = $fotoPath;

            if (!empty($dados['imagem_base64'])) {
                $novaFoto = $this->saveBase64Image($dados['imagem_base64']);
                if ($novaFoto === null) {
                    error_log("putItem: Falha ao processar nova imagem base64 para o item ID: $id_item");
                    http_response_code(400);
                    echo json_encode(['status' => 'error', 'message' => 'Falha ao processar imagem base64']);
                    return;
                }
                $fotoPath = $novaFoto;
            }

            // Monta os dados para atualização
            $dadosItem = [
                'titulo_item' => $dados['titulo_item'] ?? $itemAtual['titulo'],
                'tipo_item' => $dados['tipo_item'] ?? $itemAtual['tipo'],
                'id_genero' => (int) ($dados['id_genero'] ?? $itemAtual['id_genero'] ?? 0),
                'id_categoria' => (int) ($dados['id_categoria'] ?? $itemAtual['id_categoria'] ?? 0),
                'descricao' => $dados['descricao'] ?? $itemAtual['descricao'] ?? null,
                'ano_publicacao' => isset($dados['ano_publicacao']) ? (int) $dados['ano_publicacao'] : ($itemAtual['ano_publicacao'] ?? null),
                'editora_gravadora' => $dados['editora_gravadora'] ?? $itemAtual['editora'] ?? null,
                'estoque' => (int) ($dados['estoque'] ?? $itemAtual['estoque'] ?? 1),
                'preco_item' => isset($dados['preco_item']) ? (float) $dados['preco_item'] : (float) ($itemAtual['preco'] ?? 0),
                'isbn' => $dados['isbn'] ?? $itemAtual['isbn'] ?? null,
                'duracao_minutos' => isset($dados['duracao_minutos']) ? (int) $dados['duracao_minutos'] : ($itemAtual['duracao_minutos'] ?? null),
                'numero_edicao' => isset($dados['numero_edicao']) ? (int) $dados['numero_edicao'] : ($itemAtual['numero_edicao'] ?? null),
                'foto_item' => $fotoPath,
            ];

            $autores_ids = $dados['autores_ids'] ?? [];
            $autores_ids = array_map('intval', $autores_ids);

            $resultado = $this->item->atualizarItem($id_item, $dadosItem, $autores_ids);

            if ($resultado) {
                // Se a atualização foi bem-sucedida e houve troca de imagem, remove a antiga
                if ($fotoPath !== $fotoAntiga && !empty($fotoAntiga)) {
                    $this->deletarImagemAntiga($fotoAntiga);
                }

                echo json_encode([
                    'status' => 'success',
                    'message' => 'Item atualizado com sucesso',
                    'id_item' => $id_item,
                    'foto_item' => $fotoPath
                ], JSON_UNESCAPED_UNICODE);
            } else {
                // Se falhou, remove a nova imagem que foi salva
                if ($fotoPath !== $fotoAntiga && !empty($fotoPath)) {
                    $this->deletarImagemAntiga($fotoPath);
                }
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar item no banco de dados']);
            }

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao processar requisição: ' . $e->getMessage()
            ]);
        }
    }

    // =========================================================================
    // SYNC API: Endpoints para sincronização bidirecional Desktop ↔ Web
    // =========================================================================

    /**
     * Endpoint para buscar vendas (Pull para Desktop)
     * GET /api/vendas
     * GET /api/vendas?desde=2024-01-01T00:00:00 (sync incremental)
     */
    public function getVendas()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        $this->validarAuth();

        try {
            $desde = $_GET['desde'] ?? null;
            $pagina = (int) ($_GET['pagina'] ?? 1);
            $por_pagina = (int) ($_GET['por_pagina'] ?? 50);

            $offset = ($pagina - 1) * $por_pagina;

            if ($desde) {
                $sql = "SELECT * FROM tbl_vendas 
                        WHERE (atualizado_em >= :desde OR criado_em >= :desde2) AND excluido_em IS NULL
                        ORDER BY criado_em ASC 
                        LIMIT :limit OFFSET :offset";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':desde', $desde);
                $stmt->bindParam(':desde2', $desde);
            } else {
                $sql = "SELECT * FROM tbl_vendas 
                        WHERE excluido_em IS NULL
                        ORDER BY criado_em ASC
                        LIMIT :limit OFFSET :offset";
                $stmt = $this->db->prepare($sql);
            }

            $stmt->bindValue(':limit', $por_pagina, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            $vendas = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Contar total para paginação
            if ($desde) {
                $countSql = "SELECT COUNT(*) FROM tbl_vendas WHERE (atualizado_em >= :desde OR criado_em >= :desde2) AND excluido_em IS NULL";
                $countStmt = $this->db->prepare($countSql);
                $countStmt->bindParam(':desde', $desde);
                $countStmt->bindParam(':desde2', $desde);
            } else {
                $countSql = "SELECT COUNT(*) FROM tbl_vendas WHERE excluido_em IS NULL";
                $countStmt = $this->db->prepare($countSql);
            }
            $countStmt->execute();
            $total = (int) $countStmt->fetchColumn();

            echo json_encode([
                'status' => 'success',
                'data' => $vendas,
                'total' => $total,
                'pagina_atual' => $pagina,
                'ultima_pagina' => ceil($total / $por_pagina),
                'timestamp' => date('Y-m-d H:i:s')
            ], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Endpoint para receber vendas do Desktop (Push)
     * POST /api/vendas/sync
     * 
     * Recebe JSON: { venda: { uuid, data_venda, total, forma_pagamento, vendedor }, itens: [...] }
     * Verifica UUID para evitar duplicatas
     */
    public function postVenda()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        $this->validarAuth();

        try {
            $jsonBody = file_get_contents('php://input');
            $dados = json_decode($jsonBody, true);

            if (!$dados || !isset($dados['venda'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'JSON inválido ou campo venda ausente']);
                return;
            }

            $venda = $dados['venda'];
            $itensVenda = $dados['itens'] ?? [];
            $uuid = $venda['uuid'] ?? null;

            // Verificar duplicata por UUID
            if ($uuid) {
                $checkStmt = $this->db->prepare("SELECT id_vendas FROM tbl_vendas WHERE uuid_desktop = :uuid LIMIT 1");
                $checkStmt->bindParam(':uuid', $uuid);
                $checkStmt->execute();
                $existing = $checkStmt->fetch(\PDO::FETCH_ASSOC);

                if ($existing) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Venda já sincronizada anteriormente',
                        'id_venda' => (int) $existing['id_vendas'],
                        'duplicata' => true
                    ]);
                    return;
                }
            }

            $this->db->beginTransaction();

            // Inserir venda
            $sqlVenda = "INSERT INTO tbl_vendas (id_usuario, data_venda, valor_total, forma_pagamento, uuid_desktop, criado_em, atualizado_em)
                         VALUES (:id_usuario, :data, :total, :fpagamento, :uuid, NOW(), NOW())";
            $stmtVenda = $this->db->prepare($sqlVenda);
            $stmtVenda->bindValue(':id_usuario', (int) ($venda['id_usuario'] ?? 1), \PDO::PARAM_INT);
            $stmtVenda->bindParam(':data', $venda['data_venda']);
            $stmtVenda->bindParam(':total', $venda['total']);
            $stmtVenda->bindParam(':fpagamento', $venda['forma_pagamento']);
            $stmtVenda->bindParam(':uuid', $uuid);
            $stmtVenda->execute();

            $idVenda = $this->db->lastInsertId();

            // Inserir itens da venda
            if (!empty($itensVenda)) {
                $sqlItem = "INSERT INTO tbl_itens_vendas (id_venda, id_item, quantidade, preco_unitario)
                            VALUES (:id_venda, :id_item, :qtd, :preco)";
                $stmtItem = $this->db->prepare($sqlItem);

                foreach ($itensVenda as $iv) {
                    $stmtItem->bindValue(':id_venda', $idVenda, \PDO::PARAM_INT);
                    $stmtItem->bindValue(':id_item', (int) ($iv['item_id'] ?? 0), \PDO::PARAM_INT);
                    $stmtItem->bindValue(':qtd', (int) ($iv['quantidade'] ?? 1), \PDO::PARAM_INT);
                    $stmtItem->bindValue(':preco', (float) ($iv['preco_unitario'] ?? 0));
                    $stmtItem->execute();
                }
            }

            $this->db->commit();

            echo json_encode([
                'status' => 'success',
                'message' => 'Venda sincronizada com sucesso',
                'id_venda' => (int) $idVenda
            ], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            http_response_code(500);
            error_log("postVenda sync error: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Erro ao sincronizar venda: ' . $e->getMessage()]);
        }
    }

    /**
     * Endpoint para receber categorias do Desktop (Push)
     * POST /api/categorias/sync
     * 
     * Recebe JSON: { nome_categoria: "...", descricao: "..." }
     * Verifica duplicata por nome
     */
    public function postCategoria()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        $this->validarAuth();

        try {
            $jsonBody = file_get_contents('php://input');
            $dados = json_decode($jsonBody, true);

            if (!$dados || empty($dados['nome_categoria'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Campo nome_categoria é obrigatório']);
                return;
            }

            $nome = trim($dados['nome_categoria']);

            // Verificar duplicata por nome
            $checkStmt = $this->db->prepare("SELECT id_categoria FROM tbl_categorias WHERE nome_categoria = :nome AND excluido_em IS NULL LIMIT 1");
            $checkStmt->bindParam(':nome', $nome);
            $checkStmt->execute();
            $existing = $checkStmt->fetch(\PDO::FETCH_ASSOC);

            if ($existing) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Categoria já existe',
                    'id_categoria' => (int) $existing['id_categoria'],
                    'duplicata' => true
                ]);
                return;
            }

            $id = $this->categoriaModel->inserirCategoria($nome);

            if ($id) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Categoria criada com sucesso',
                    'id_categoria' => (int) $id
                ], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Erro ao inserir categoria']);
            }

        } catch (\Exception $e) {
            http_response_code(500);
            error_log("postCategoria sync error: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Endpoint para receber gêneros do Desktop (Push)
     * POST /api/generos/sync
     * 
     * Recebe JSON: { nome_generos: "...", id_categoria: 1 }
     * Verifica duplicata por nome
     */
    public function postGenero()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        $this->validarAuth();

        try {
            $jsonBody = file_get_contents('php://input');
            $dados = json_decode($jsonBody, true);

            if (!$dados || empty($dados['nome_generos'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Campo nome_generos é obrigatório']);
                return;
            }

            $nome = trim($dados['nome_generos']);

            // Verificar duplicata por nome
            $checkStmt = $this->db->prepare("SELECT id_generos FROM tbl_generos WHERE nome_generos = :nome AND excluido_em IS NULL LIMIT 1");
            $checkStmt->bindParam(':nome', $nome);
            $checkStmt->execute();
            $existing = $checkStmt->fetch(\PDO::FETCH_ASSOC);

            if ($existing) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Gênero já existe',
                    'id_generos' => (int) $existing['id_generos'],
                    'duplicata' => true
                ]);
                return;
            }

            $id = $this->generoModel->inserirGenero($nome);

            if ($id) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Gênero criado com sucesso',
                    'id_generos' => (int) $id
                ], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Erro ao inserir gênero']);
            }

        } catch (\Exception $e) {
            http_response_code(500);
            error_log("postGenero sync error: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Endpoint para receber autores do Desktop (Push)
     * POST /api/autores/sync
     * 
     * Recebe JSON: { nome_autor: "...", biografia: "..." }
     * Verifica duplicata por nome
     */
    public function postAutor()
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        $this->validarAuth();

        try {
            $jsonBody = file_get_contents('php://input');
            $dados = json_decode($jsonBody, true);

            if (!$dados || empty($dados['nome_autor'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Campo nome_autor é obrigatório']);
                return;
            }

            $nome = trim($dados['nome_autor']);
            $biografia = $dados['biografia'] ?? null;

            // Verificar duplicata por nome
            $checkStmt = $this->db->prepare("SELECT id_autor FROM tbl_autores WHERE nome_autor = :nome LIMIT 1");
            $checkStmt->bindParam(':nome', $nome);
            $checkStmt->execute();
            $existing = $checkStmt->fetch(\PDO::FETCH_ASSOC);

            if ($existing) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Autor já existe',
                    'id_autor' => (int) $existing['id_autor'],
                    'duplicata' => true
                ]);
                return;
            }

            $id = $this->autorModel->inserirAutor($nome, $biografia);

            if ($id) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Autor criado com sucesso',
                    'id_autor' => (int) $id
                ], JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Erro ao inserir autor']);
            }

        } catch (\Exception $e) {
            http_response_code(500);
            error_log("postAutor sync error: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Endpoint público para cancelamento de inscrição em notificações.
     * GET /notificacoes/cancelar?email=...
     */
    public function cancelarNotificacao()
    {
        $email = $_GET['email'] ?? null;

        if ($email) {
            $usuarioModel = new \Sebo\Alfarrabio\Models\Usuario($this->db);
            $usuarioModel->setPreferenciaNotificacao($email, 0);
        }

        echo "
        <!DOCTYPE html>
        <html lang='pt-BR'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Cancelamento de Inscrição - Sebo-Alfarrabio</title>
            <style>
                body { font-family: 'Georgia', serif; background-color: #f5f1e8; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
                .card { background: white; padding: 40px; border-radius: 8px; border: 2px solid #8b4513; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; max-width: 400px; }
                h1 { color: #8b4513; font-size: 24px; }
                p { color: #3e2723; line-height: 1.6; }
                .btn { display: inline-block; background: #8b4513; color: white; padding: 10px 25px; border-radius: 5px; text-decoration: none; margin-top: 20px; font-weight: bold; }
                .email { font-weight: bold; color: #6b4423; }
            </style>
        </head>
        <body>
            <div class='card'>
                <h1>Notificações Canceladas</h1>
                <p>O e-mail <span class='email'>" . htmlspecialchars($email ?? 'não informado') . "</span> foi removido da nossa lista de novidades.</p>
                <p>Você não receberá mais e-mails sobre novos itens no acervo.</p>
                <a href='/' class='btn'>Voltar para o site</a>
            </div>
        </body>
        </html>";
    }
}
