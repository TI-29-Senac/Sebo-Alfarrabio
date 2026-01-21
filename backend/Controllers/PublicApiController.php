<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Database\Database;

class PublicApiController {
    
    private $db;
    private $item;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->item = new Item($this->db);
    }

    /**
     * Endpoint público para buscar itens do catálogo
     * GET /api/item
     * GET /api/item?id=123 (para buscar um item específico)
     */
    public function getItem() {
        header('Content-Type: application/json; charset=utf-8');
        header('Access-Control-Allow-Origin: *');
        
        try {
            $id = $_GET['id'] ?? null;
            
            if ($id) {
                // Buscar item específico
                $item = $this->buscarItemCompleto((int)$id);
                
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
     * Busca todos os itens com informações completas
     */
    private function buscarTodosItensCompletos() {
        $sql = "
            SELECT 
                i.id_item,
                i.titulo_item,
                i.tipo_item,
                i.descricao,
                i.preco_item,
                i.foto_item,
                i.estoque,
                i.isbn,
                i.editora_gravadora,
                i.ano_publicacao,
                i.duracao_minutos,
                i.numero_edicao,
                g.nome_genero,
                c.nome_categoria,
                GROUP_CONCAT(DISTINCT a.nome_autor ORDER BY a.nome_autor SEPARATOR ', ') AS autores,
                i.foto_item AS caminho_imagem
            FROM tbl_itens i
            LEFT JOIN tbl_generos g ON i.id_genero = g.id_genero
            LEFT JOIN tbl_categorias c ON i.id_categoria = c.id_categoria
            LEFT JOIN tbl_item_autores ia ON i.id_item = ia.id_item
            LEFT JOIN tbl_autores a ON ia.id_autor = a.id_autor AND a.excluido_em IS NULL
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
    private function buscarItemCompleto($id) {
        $sql = "
            SELECT 
                i.id_item,
                i.titulo_item,
                i.tipo_item,
                i.descricao,
                i.preco_item,
                i.foto_item,
                i.estoque,
                i.isbn,
                i.editora_gravadora,
                i.ano_publicacao,
                i.duracao_minutos,
                i.numero_edicao,
                g.nome_genero,
                c.nome_categoria,
                GROUP_CONCAT(DISTINCT a.nome_autor ORDER BY a.nome_autor SEPARATOR ', ') AS autores,
                i.foto_item AS caminho_imagem
            FROM tbl_itens i
            LEFT JOIN tbl_generos g ON i.id_genero = g.id_genero
            LEFT JOIN tbl_categorias c ON i.id_categoria = c.id_categoria
            LEFT JOIN tbl_item_autores ia ON i.id_item = ia.id_item
            LEFT JOIN tbl_autores a ON ia.id_autor = a.id_autor AND a.excluido_em IS NULL
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
    private function corrigirCaminhoImagem($foto_item) {
        // Se não tem foto, retorna imagem padrão
        if (empty($foto_item)) {
            return '/img/sem-imagem.png';
        }

        // Remove barras duplas e espaços
        $foto_item = trim($foto_item);
        $foto_item = str_replace('//', '/', $foto_item);

        // Se já começa com http:// ou https://, retorna como está
        if (strpos($foto_item, 'http://') === 0 || strpos($foto_item, 'https://') === 0) {
            return $foto_item;
        }

        // Tenta diferentes formatos comuns
        $possiveisCaminhos = [
            $foto_item,                                    // Como está no banco
            '/backend/uploads/' . basename($foto_item),     // /backend/uploads/nome.jpg

        ];

        // Testa qual caminho existe fisicamente
        foreach ($possiveisCaminhos as $caminho) {
            $caminhoCompleto = $_SERVER['DOCUMENT_ROOT'] . $caminho;
            if (file_exists($caminhoCompleto)) {
                return $caminho; // Retorna o primeiro que existir
            }
        }

        // Se nenhum existe, retorna o original ou imagem padrão
        return !empty($foto_item) ? $foto_item : '/img/sem-imagem.png';
    }
}