<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
use Exception;

/**
 * Model para gerenciar a tabela tbl_itens (Livros, CDs, DVDs, Revistas)
 * Lida com o relacionamento N:N com Autores (tbl_item_autores)
 */
class Item
{

    private $id;
    private $titulo;
    private $tipo;
    private $id_genero;
    private $id_categoria;
    private $descricao;
    private $ano_publicacao;
    private $editora;
    private $estoque;
    private $isbn;
    private $criado_em;
    private $atualizado_em;
    private $deleted_at;

    private $db;
    private $autores_ids = [];
    public $imagem;
    public $preco;
    public $quantidade_item;
    public $desconto_item;
    private $itemModel;


    public function __construct($db)
    {
        $this->db = $db;
    }

    // --- MÉTODOS DE ESCRITA (CREATE, UPDATE, DELETE) ---

    /**
     * Insere um novo item e seus autores associados usando uma transação.
     */
    function inserirItem(array $dadosItem, array $autores_ids)
    {
        $colunas = implode(', ', array_keys($dadosItem));
        $placeholders = ':' . implode(', :', array_keys($dadosItem));

        $sqlItem = "INSERT INTO tbl_itens ($colunas) VALUES ($placeholders)";
        $sqlPivot = "INSERT INTO tbl_item_autores (item_id, autor_id) VALUES (:item_id, :autor_id)";

        try {
            $this->db->beginTransaction();

            $stmtItem = $this->db->prepare($sqlItem);
            foreach ($dadosItem as $coluna => &$valor) {
                $stmtItem->bindValue(":$coluna", $valor);
            }

            if (!$stmtItem->execute()) {
                throw new Exception("Falha ao inserir o item principal.");
            }

            $idNovoItem = $this->db->lastInsertId();

            if (!empty($autores_ids)) {
                $stmtPivot = $this->db->prepare($sqlPivot);
                foreach ($autores_ids as $id_autor) {
                    $stmtPivot->bindParam(':item_id', $idNovoItem, PDO::PARAM_INT);
                    $stmtPivot->bindParam(':autor_id', $id_autor, PDO::PARAM_INT);
                    if (!$stmtPivot->execute()) {
                        throw new Exception("Falha ao inserir autor ID: $id_autor.");
                    }
                }
            }

            $this->db->commit();
            return $idNovoItem;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Atualiza um item e seus autores associados usando uma transação.
     */
    function atualizarItem(int $id_item, array $dadosItem, array $autores_ids)
    {
        $dadosItem['atualizado_em'] = date('Y-m-d H:i:s');

        $setParts = [];
        foreach ($dadosItem as $coluna => $valor) {
            $setParts[] = "$coluna = :$coluna";
        }
        $setString = implode(', ', $setParts);

        $sqlItem = "UPDATE tbl_itens SET $setString WHERE id = :id";
        $sqlDeletePivot = "DELETE FROM tbl_item_autores WHERE item_id = :item_id";
        $sqlInsertPivot = "INSERT INTO tbl_item_autores (item_id, autor_id) VALUES (:item_id, :autor_id)";

        try {
            $this->db->beginTransaction();

            $stmtItem = $this->db->prepare($sqlItem);
            $stmtItem->bindParam(':id', $id_item, PDO::PARAM_INT);
            foreach ($dadosItem as $coluna => &$valor) {
                $stmtItem->bindValue(":$coluna", $valor);
            }

            if (!$stmtItem->execute()) {
                throw new Exception("Falha ao atualizar o item principal.");
            }

            $stmtDelete = $this->db->prepare($sqlDeletePivot);
            $stmtDelete->bindParam(':item_id', $id_item, PDO::PARAM_INT);
            if (!$stmtDelete->execute()) {
                throw new Exception("Falha ao limpar autores antigos.");
            }

            if (!empty($autores_ids)) {
                $stmtInsert = $this->db->prepare($sqlInsertPivot);
                foreach ($autores_ids as $id_autor) {
                    $stmtInsert->bindParam(':item_id', $id_item, PDO::PARAM_INT);
                    $stmtInsert->bindParam(':autor_id', $id_autor, PDO::PARAM_INT);
                    if (!$stmtInsert->execute()) {
                        throw new Exception("Falha ao inserir novo autor ID: $id_autor.");
                    }
                }
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Inativa um item (Soft Delete)
     */
    function excluirItem(int $id)
    {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_itens SET deleted_at = :atual WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':atual', $dataatual);
        return $stmt->execute();
    }

    /**
     * Re-ativa um item que foi excluído
     */
    function ativarItem(int $id)
    {
        $sql = "UPDATE tbl_itens SET deleted_at = NULL WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // --- MÉTODOS DE LEITURA (READ) ---

    /**
     * Busca um item específico pelo seu ID
     */
    function buscarItemPorID(int $id)
    {
        $sql = "SELECT * FROM tbl_itens WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $item['autores_ids'] = $this->buscarAutoresDoItem($id);
            // Adiciona propriedades da classe como padrão caso não existam no DB
            $item += [
                'imagem' => $this->imagem,
                'preco' => $this->preco,
                'quantidade_item' => $this->quantidade_item,
                'desconto_item' => $this->desconto_item
            ];
        }
        return $item;
    }


    /**
     * Helper para buscar os IDs dos autores de um item
     */
    private function buscarAutoresDoItem(int $id_item)
    {
        $sql = "SELECT autor_id FROM tbl_item_autores WHERE item_id = :item_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':item_id', $id_item, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // --- MÉTODOS DE PESQUISA ---

    /**
     * Pesquisa itens com paginação
     * Busca por: título, autor, categoria, gênero, ISBN
     */
    public function pesquisarItens(string $termo, int $pagina = 1, int $por_pagina = 10): array
    {
        $termo = "%{$termo}%";

        // Contagem Total
        $totalQuery = "
            SELECT COUNT(DISTINCT i.id) 
            FROM tbl_itens i
            LEFT JOIN tbl_item_autores ia ON i.id = ia.item_id
            LEFT JOIN tbl_autores a ON ia.autor_id = a.id
            LEFT JOIN tbl_generos g ON i.genero_id = g.id
            WHERE i.deleted_at IS NULL
            AND (
                i.titulo LIKE :termo
                OR a.nome LIKE :termo
                OR g.nome LIKE :termo
                OR i.isbn LIKE :termo
                OR i.editora LIKE :termo
            )
        ";


        $totalStmt = $this->db->prepare($totalQuery);
        $totalStmt->bindParam(':termo', $termo);
        $totalStmt->execute();
        $total_de_registros = $totalStmt->fetchColumn();

        // Busca Paginada
        $offset = ($pagina - 1) * $por_pagina;

        $dataQuery = "
            SELECT 
                i.*, 
                g.nome AS nome_genero,
                (SELECT GROUP_CONCAT(a2.nome SEPARATOR ', ') 
                 FROM tbl_item_autores ia2
                 JOIN tbl_autores a2 ON ia2.autor_id = a2.id
                 WHERE ia2.item_id = i.id) AS autores
            FROM tbl_itens i
            LEFT JOIN tbl_item_autores ia ON i.id = ia.item_id
            LEFT JOIN tbl_autores a ON ia.autor_id = a.id
            LEFT JOIN tbl_generos g ON i.genero_id = g.id
            WHERE i.deleted_at IS NULL
            AND (
                i.titulo LIKE :termo
                OR a.nome LIKE :termo
                OR g.nome LIKE :termo
                OR i.isbn LIKE :termo
                OR i.editora LIKE :termo
            )
            GROUP BY i.id
            ORDER BY i.titulo ASC
            LIMIT :limit OFFSET :offset
        ";

        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindParam(':termo', $termo);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();
        $dados = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

        $lastPage = ceil($total_de_registros / $por_pagina);

        return [
            'data' => $dados,
            'total' => (int) $total_de_registros,
            'por_pagina' => (int) $por_pagina,
            'pagina_atual' => (int) $pagina,
            'ultima_pagina' => (int) $lastPage,
            'de' => $offset + 1,
            'para' => $offset + count($dados)
        ];
    }



    /**
     * Pesquisa simples para autocomplete/AJAX
     * Retorna apenas id e título
     */
    public function pesquisarItensSimples(string $termo, int $limite = 10): array
    {
        $termo = "%{$termo}%";

        $sql = "
            SELECT 
                i.id,
                i.titulo,
                i.tipo,
                (SELECT GROUP_CONCAT(a.nome SEPARATOR ', ') 
                 FROM tbl_item_autores ia
                 JOIN tbl_autores a ON ia.autor_id = a.id
                 WHERE ia.item_id = i.id) AS autores
            FROM tbl_itens i
            WHERE i.deleted_at IS NULL
            AND i.titulo LIKE :termo
            ORDER BY i.titulo ASC
            LIMIT :limite
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':termo', $termo);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- MÉTODOS DE PAGINAÇÃO E CONTAGEM ---

    /**
     * Paginação de itens com dados relacionados
     */
    public function paginacao(int $pagina = 1, int $por_pagina = 8, ?string $tipo = null): array
    {
        $whereClause = "i.deleted_at IS NULL";
        $params = [];
        if ($tipo) {
            $whereClause .= " AND i.tipo = :tipo";
            $params[':tipo'] = $tipo;
        }

        $totalQuery = "SELECT COUNT(DISTINCT i.id) FROM tbl_itens i WHERE $whereClause";
        $totalStmt = $this->db->prepare($totalQuery);
        $totalStmt->execute($params);
        $total_de_registros = $totalStmt->fetchColumn();

        $offset = ($pagina - 1) * $por_pagina;

        $dataQuery = "
            SELECT 
                i.*, 
                g.nome AS nome_genero,
                (SELECT GROUP_CONCAT(a.nome SEPARATOR ', ') 
                 FROM tbl_item_autores ia
                 JOIN tbl_autores a ON ia.autor_id = a.id
                 WHERE ia.item_id = i.id) AS autores
            FROM tbl_itens i
            LEFT JOIN tbl_generos g ON i.genero_id = g.id
            WHERE $whereClause
            GROUP BY i.id
            ORDER BY i.titulo ASC
            LIMIT :limit OFFSET :offset
        ";

        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        foreach ($params as $key => $value) {
            $dataStmt->bindValue($key, $value);
        }

        $dataStmt->execute();
        $dados = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

        $lastPage = ceil($total_de_registros / $por_pagina);

        return [
            'data' => $dados,
            'total' => (int) $total_de_registros,
            'por_pagina' => (int) $por_pagina,
            'pagina_atual' => (int) $pagina,
            'ultima_pagina' => (int) $lastPage,
            'de' => $offset + 1,
            'para' => $offset + count($dados)
        ];
    }

    // --- Métodos de Contagem Simples ---

    function totalDeItens(?string $tipo = null)
    {
        $sql = "SELECT count(*) as total FROM tbl_itens";
        $params = [];
        if ($tipo) {
            $sql .= " WHERE tipo = :tipo";
            $params[':tipo'] = $tipo;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    function totalDeItensInativos(?string $tipo = null)
    {
        $sql = "SELECT count(*) as total FROM tbl_itens WHERE deleted_at IS NOT NULL";
        $params = [];
        if ($tipo) {
            $sql .= " AND tipo = :tipo";
            $params[':tipo'] = $tipo;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    function totalDeItensAtivos(?string $tipo = null)
    {
        $sql = "SELECT count(*) as total FROM tbl_itens WHERE deleted_at IS NULL";
        $params = [];
        if ($tipo) {
            $sql .= " AND tipo = :tipo";
            $params[':tipo'] = $tipo;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    public function buscarItemAtivos()
    {
        $sql = "SELECT item.id, titulo, tipo, preco, imagem, autor.nome AS nome_autor 
                FROM tbl_itens as item
                INNER JOIN tbl_item_autores as item_autor ON item_autor.item_id = item.id
                INNER JOIN tbl_autores as autor ON autor.id = item_autor.autor_id
                WHERE item.deleted_at IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Corrige o caminho da imagem para ser exibido tanto no admin quanto no frontend.
     */
    public static function corrigirCaminhoImagem($foto_item)
    {
        if (empty($foto_item)) {
            return '/img/sem-imagem.png'; // Placeholder padrão
        }

        $foto_item = trim($foto_item);

        // Se já for uma URL absoluta
        if (strpos($foto_item, 'http://') === 0 || strpos($foto_item, 'https://') === 0) {
            return $foto_item;
        }

        // Se começar com /backend/, assume que o caminho está completo a partir da raiz do servidor
        if (strpos($foto_item, '/backend/') === 0) {
            return $foto_item;
        }

        // Se começar com /uploads/, adiciona o prefixo /backend
        if (strpos($foto_item, '/uploads/') === 0) {
            return '/backend' . $foto_item;
        }

        // Se for itens/nome.jpg ou apenas nome.jpg
        if (strpos($foto_item, 'itens/') === 0) {
            return '/backend/uploads/' . $foto_item;
        }

        // Por padrão, se for apenas o nome do arquivo, tenta na pasta raiz de uploads
        return '/backend/uploads/' . $foto_item;
    }
}






