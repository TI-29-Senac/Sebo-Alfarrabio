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
                $item = $this->buscarItemCompleto((int) $id);
                if (!$item) {
                    http_response_code(404);
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Item não encontrado'
                    ]);
                    return;
                }

                echo json_encode([
                    'status' => 'success',
                    'data' => $item
                ]);

            } else {
                // Buscar todos os itens ativos
                $itens = $this->buscarTodosItensCompletos();

                echo json_encode([
                    'status' => 'success',
                    'data' => $itens,
                    'total' => count($itens)
                ]);
            }

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao buscar dados: ' . $e->getMessage()
            ]);
        }
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

        // Resposta para OPTIONS (CORS)
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        try {
            $limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 10;
            $nota_minima = isset($_GET['nota_minima']) ? (int) $_GET['nota_minima'] : null;

            // Query com JOIN para pegar dados relacionados
            // Primeiro, verificar se há avaliações na tabela
            $countStmt = $this->db->query("SELECT COUNT(*) as total FROM tbl_avaliacao WHERE excluido_em IS NULL");
            $countResult = $countStmt->fetch(\PDO::FETCH_ASSOC);
            $totalNoBanco = (int) ($countResult['total'] ?? 0);

            $sql = "SELECT 
                        a.id_avaliacao,
                        a.nota_avaliacao,
                        a.comentario_avaliacao,
                        a.data_avaliacao,
                        a.status_avaliacao,
                        a.criado_em,
                        
                        -- Dados do usuário
                        u.id_usuario,
                        u.nome_usuario,
                        u.email_usuario,
                        pu.foto_perfil_usuario AS foto_usuario,
                        
                        -- Dados do item
                        i.id_item,
                        i.titulo_item,
                        i.descricao AS descricao_item,
                        i.preco_item,
                        i.foto_item AS imagem_item,
                        
                        -- Dados opcionais
                        c.nome_categoria,
                        g.nome_generos AS nome_genero,
                        aut.nome_autor
                        
                    FROM tbl_avaliacao a
                    
                    LEFT JOIN tbl_usuario u 
                        ON a.id_usuario = u.id_usuario
                    
                    LEFT JOIN tbl_perfil_usuario pu 
                        ON u.id_usuario = pu.usuario_id
                    
                    LEFT JOIN tbl_itens i 
                        ON a.id_item = i.id_item
                    
                    LEFT JOIN tbl_categorias c 
                        ON i.id_categoria = c.id_categoria
                    
                    LEFT JOIN tbl_generos g 
                        ON i.id_genero = g.id_generos
                    
                    LEFT JOIN tbl_autores aut 
                        ON aut.id_autor = (SELECT ia.autor_id FROM tbl_item_autores ia WHERE ia.item_id = i.id_item LIMIT 1) 
                    
                    WHERE a.excluido_em IS NULL";

            // Filtro por nota mínima
            if ($nota_minima !== null) {
                $sql .= " AND a.nota_avaliacao >= :nota_minima";
            }

            $sql .= " ORDER BY a.data_avaliacao DESC, a.criado_em DESC LIMIT :limite";

            // Prepara e executa
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limite', $limite, \PDO::PARAM_INT);

            if ($nota_minima !== null) {
                $stmt->bindValue(':nota_minima', $nota_minima, \PDO::PARAM_INT);
            }

            $stmt->execute();
            $avaliacoes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Calcula estatísticas
            $total = count($avaliacoes);
            $soma_notas = 0;
            $distribuicao = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

            foreach ($avaliacoes as $av) {
                $soma_notas += (int) $av['nota_avaliacao'];
                $nota = (int) $av['nota_avaliacao'];
                if (isset($distribuicao[$nota])) {
                    $distribuicao[$nota]++;
                }
            }

            $media_notas = $total > 0 ? round($soma_notas / $total, 2) : 0;

            // Formata dados
            $avaliacoes_formatadas = array_map(function ($av) {
                // Foto do usuário
                $foto_usuario = $av['foto_usuario'] ?? null;
                if ($foto_usuario && !preg_match('/^(http|\/|img)/', $foto_usuario)) {
                    $foto_usuario = '/img/usuarios/' . $foto_usuario;
                }

                // Imagem do item
                $imagem_item = $av['imagem_item'] ?? null;
                if ($imagem_item && !preg_match('/^(http|\/|img)/', $imagem_item)) {
                    $imagem_item = '/img/livros/' . $imagem_item;
                }

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
                        'foto' => $foto_usuario,
                        'iniciais' => strtoupper(substr($av['nome_usuario'], 0, 2))
                    ],

                    'item' => [
                        'id' => (int) $av['id_item'],
                        'titulo' => $av['titulo_item'],
                        'descricao' => $av['descricao_item'] ?? '',
                        'preco' => (float) ($av['preco_item'] ?? 0),
                        'imagem' => $imagem_item,
                        'categoria' => $av['nome_categoria'] ?? 'Sem categoria',
                        'genero' => $av['nome_genero'] ?? null,
                        'autor' => $av['nome_autor'] ?? null
                    ],

                    'tempo_decorrido' => $this->calcularTempoDecorrido($av['criado_em'])
                ];
            }, $avaliacoes);

            // Resposta
            echo json_encode([
                'success' => true,
                'total' => $total,
                'total_no_banco' => $totalNoBanco,
                'media_notas' => $media_notas,
                'distribuicao' => $distribuicao,
                'avaliacoes' => $avaliacoes_formatadas,
                'timestamp' => date('Y-m-d H:i:s'),
                'filtros' => [
                    'limite' => $limite,
                    'nota_minima' => $nota_minima
                ]
            ], JSON_UNESCAPED_UNICODE);

        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Erro ao buscar avaliações',
                'message' => 'Erro no banco de dados',
                'details' => $e->getMessage()
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
     * Calcula tempo decorrido
     */
    private function calcularTempoDecorrido($data)
    {
        try {
            $agora = new \DateTime();
            $data_av = new \DateTime($data);
            $diff = $agora->diff($data_av);

            if ($diff->y > 0) {
                return $diff->y . ' ano' . ($diff->y > 1 ? 's' : '') . ' atrás';
            } elseif ($diff->m > 0) {
                return $diff->m . ' mês' . ($diff->m > 1 ? 'es' : '') . ' atrás';
            } elseif ($diff->d > 0) {
                return $diff->d . ' dia' . ($diff->d > 1 ? 's' : '') . ' atrás';
            } elseif ($diff->h > 0) {
                return $diff->h . ' hora' . ($diff->h > 1 ? 's' : '') . ' atrás';
            } elseif ($diff->i > 0) {
                return $diff->i . ' minuto' . ($diff->i > 1 ? 's' : '') . ' atrás';
            } else {
                return 'Agora mesmo';
            }
        } catch (\Exception $e) {
            return date('d/m/Y', strtotime($data));
        }
    }

    /**
     * Busca todos os itens com informações completas
     */
    private function buscarTodosItensCompletos()
    {
        $sql = "
            SELECT 
                i.id_item,
                i.titulo_item AS titulo,
                i.tipo_item AS tipo,
                i.descricao,
                i.preco_item AS preco,
                i.foto_item,
                i.estoque,
                i.isbn,
                i.editora_gravadora AS editora,
                i.ano_publicacao,
                i.duracao_minutos,
                i.numero_edicao,
                g.nome_generos AS nome_genero,
                c.nome_categoria,
                GROUP_CONCAT(DISTINCT a.nome_autor ORDER BY a.nome_autor SEPARATOR ', ') AS autores,
                i.foto_item AS caminho_imagem
            FROM tbl_itens i
            LEFT JOIN tbl_generos g ON i.id_genero = g.id_generos
            LEFT JOIN tbl_categorias c ON i.id_categoria = c.id_categoria
            LEFT JOIN tbl_item_autores ia ON i.id_item = ia.item_id
            LEFT JOIN tbl_autores a ON ia.autor_id = a.id_autor
            WHERE i.excluido_em IS NULL
            GROUP BY i.id_item
            ORDER BY i.criado_em DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Garantir que valores numéricos estejam corretos e corrigir caminhos de imagem
        foreach ($result as &$item) {
            $item['preco_item'] = floatval($item['preco_item'] ?? 0);
            $item['estoque'] = intval($item['estoque'] ?? 0);
            $item['ano_publicacao'] = $item['ano_publicacao'] ? intval($item['ano_publicacao']) : null;

            // Corrigir caminho da imagem
            $item['caminho_imagem'] = $this->corrigirCaminhoImagem($item['foto_item']);
        }

        return $result;
    }

    /**
     * Busca um item específico com todas as informações
     */
    private function buscarItemCompleto($id)
    {
        $sql = "
            SELECT 
                i.id_item,
                i.titulo_item AS titulo,
                i.tipo_item AS tipo,
                i.descricao,
                i.preco_item AS preco,
                i.foto_item,
                i.estoque,
                i.isbn,
                i.editora_gravadora AS editora,
                i.ano_publicacao,
                i.duracao_minutos,
                i.numero_edicao,
                g.nome_generos AS nome_genero,
                c.nome_categoria,
                GROUP_CONCAT(DISTINCT a.nome_autor ORDER BY a.nome_autor SEPARATOR ', ') AS autores,
                i.foto_item AS caminho_imagem
            FROM tbl_itens i
            LEFT JOIN tbl_generos g ON i.id_genero = g.id_generos
            LEFT JOIN tbl_categorias c ON i.id_categoria = c.id_categoria
            LEFT JOIN tbl_item_autores ia ON i.id_item = ia.item_id
            LEFT JOIN tbl_autores a ON ia.autor_id = a.id_autor
            WHERE i.id_item = :id AND i.excluido_em IS NULL
            GROUP BY i.id_item
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($item) {
            $item['preco_item'] = floatval($item['preco_item'] ?? 0);
            $item['estoque'] = intval($item['estoque'] ?? 0);
            $item['ano_publicacao'] = $item['ano_publicacao'] ? intval($item['ano_publicacao']) : null;

            // Corrigir caminho da imagem
            $item['caminho_imagem'] = $this->corrigirCaminhoImagem($item['foto_item']);
        }

        return $item;
    }

    /**
     * Corrige o caminho da imagem para funcionar no frontend
     */
    private function corrigirCaminhoImagem($foto_item)
    {
        return \Sebo\Alfarrabio\Models\Item::corrigirCaminhoImagem($foto_item);
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
            $debug = [];

            // 1. Verificar estrutura da tabela tbl_avaliacao
            $debug['1_estrutura_tabela'] = [];
            $estrutura = $this->db->query("DESCRIBE tbl_avaliacao")->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($estrutura as $col) {
                $debug['1_estrutura_tabela'][] = $col['Field'] . ' (' . $col['Type'] . ')';
            }

            // 2. Contagem total de avaliações
            $countAll = $this->db->query("SELECT COUNT(*) as total FROM tbl_avaliacao")->fetch(\PDO::FETCH_ASSOC);
            $debug['2_total_avaliacoes'] = $countAll['total'];

            // 3. Contagem de avaliações não excluídas
            $countActive = $this->db->query("SELECT COUNT(*) as total FROM tbl_avaliacao WHERE excluido_em IS NULL")->fetch(\PDO::FETCH_ASSOC);
            $debug['3_avaliacoes_nao_excluidas'] = $countActive['total'];

            // 4. Primeiras 5 avaliações (dados brutos)
            $avaliacoes = $this->db->query("SELECT * FROM tbl_avaliacao LIMIT 5")->fetchAll(\PDO::FETCH_ASSOC);
            $debug['4_primeiras_5_avaliacoes'] = $avaliacoes;

            // 5. Verificar se os id_usuario existem na tbl_usuario
            if (!empty($avaliacoes)) {
                $ids_usuarios = array_filter(array_column($avaliacoes, 'id_usuario'));
                if (!empty($ids_usuarios)) {
                    $ids_str = implode(',', array_map('intval', $ids_usuarios));
                    $usuarios = $this->db->query("SELECT id_usuario, nome_usuario FROM tbl_usuario WHERE id_usuario IN ($ids_str)")->fetchAll(\PDO::FETCH_ASSOC);
                    $debug['5_usuarios_encontrados'] = $usuarios;
                } else {
                    $debug['5_usuarios_encontrados'] = "Nenhum id_usuario nas avaliações";
                }
            }

            // 6. Verificar se os id_item existem na tbl_itens
            if (!empty($avaliacoes)) {
                $ids_itens = array_filter(array_column($avaliacoes, 'id_item'));
                if (!empty($ids_itens)) {
                    $ids_str = implode(',', array_map('intval', $ids_itens));
                    $itens = $this->db->query("SELECT id_item, titulo_item FROM tbl_itens WHERE id_item IN ($ids_str)")->fetchAll(\PDO::FETCH_ASSOC);
                    $debug['6_itens_encontrados'] = $itens;
                } else {
                    $debug['6_itens_encontrados'] = "Nenhum id_item nas avaliações";
                }
            }

            // 7. Testar a query completa
            $query_completa = "SELECT 
                a.id_avaliacao,
                a.nota_avaliacao,
                a.comentario_avaliacao,
                u.nome_usuario,
                i.titulo_item
            FROM tbl_avaliacao a
            LEFT JOIN tbl_usuario u ON a.id_usuario = u.id_usuario
            LEFT JOIN tbl_itens i ON a.id_item = i.id_item
            WHERE a.excluido_em IS NULL
            LIMIT 5";

            $resultado_query = $this->db->query($query_completa)->fetchAll(\PDO::FETCH_ASSOC);
            $debug['7_resultado_query_completa'] = $resultado_query;

            // 8. Totais
            $debug['8_total_usuarios'] = $this->db->query("SELECT COUNT(*) FROM tbl_usuario")->fetchColumn();
            $debug['9_total_itens'] = $this->db->query("SELECT COUNT(*) FROM tbl_itens")->fetchColumn();

            echo json_encode([
                'success' => true,
                'debug' => $debug,
                'timestamp' => date('Y-m-d H:i:s')
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        } catch (\PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Erro PDO: ' . $e->getMessage(),
                'code' => $e->getCode()
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Erro: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}