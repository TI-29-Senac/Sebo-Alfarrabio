<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
use Exception;

/**
 * Model para gerenciar a tabela tbl_itens (Remoto)
 * Schema Remoto: id_item, titulo_item, preco_item, foto_item, id_genero, id_categoria, estoque, excluido_em
 */
class Item
{
    private $db;
    public $imagem; // Mantido para compatibilidade, mas o banco usa foto_item

    public function __construct($db)
    {
        $this->db = $db;
    }

    // --- HELPER PARA ALIASES ---
    // Cria a string de seleção para converter nomes do banco remoto para o esperado pela aplicação
    private function getSelectFields($prefix = 'i')
    {
        return "
            {$prefix}.id_item,
            {$prefix}.id_item AS id,
            {$prefix}.titulo_item,
            {$prefix}.titulo_item AS titulo,
            {$prefix}.tipo_item,
            {$prefix}.tipo_item AS tipo,
            {$prefix}.preco_item,
            {$prefix}.preco_item AS preco,
            {$prefix}.foto_item,
            {$prefix}.foto_item AS imagem,
            {$prefix}.id_genero,
            {$prefix}.id_categoria,
            {$prefix}.descricao,
            {$prefix}.ano_publicacao,
            {$prefix}.editora_gravadora,
            {$prefix}.editora_gravadora AS editora,
            {$prefix}.estoque,
            {$prefix}.isbn,
            {$prefix}.duracao_minutos,
            {$prefix}.numero_edicao,
            {$prefix}.criado_em,
            {$prefix}.atualizado_em,
            {$prefix}.excluido_em
        ";
    }

    // --- MÉTODOS DE ESCRITA (CREATE, UPDATE, DELETE) ---

    function inserirItem(array $dadosItem, array $autores_ids)
    {
        $dadosRemotos = [];
        foreach ($dadosItem as $key => $val) {
            $dadosRemotos[$key] = $val;
        }

        // Garante campos obrigatórios ou defaults
        if (!isset($dadosRemotos['estoque']))
            $dadosRemotos['estoque'] = 1;

        $colunas = implode(', ', array_keys($dadosRemotos));
        $placeholders = ':' . implode(', :', array_keys($dadosRemotos));

        $sqlItem = "INSERT INTO tbl_itens ($colunas) VALUES ($placeholders)";
        $sqlPivot = "INSERT INTO tbl_item_autores (item_id, autor_id) VALUES (:item_id, :autor_id)";

        try {
            $this->db->beginTransaction();

            $stmtItem = $this->db->prepare($sqlItem);
            foreach ($dadosRemotos as $coluna => &$valor) {
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
                    $stmtPivot->execute();
                }
            }

            $this->db->commit();
            return $idNovoItem;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Erro ao inserir item: " . $e->getMessage());
            return false;
        }
    }

    function atualizarItem(int $id_item, array $dadosItem, array $autores_ids)
    {
        $dadosRemotos = ['atualizado_em' => date('Y-m-d H:i:s')];
        foreach ($dadosItem as $key => $val) {
            $dadosRemotos[$key] = $val;
        }

        $setParts = [];
        foreach ($dadosRemotos as $coluna => $valor) {
            $setParts[] = "$coluna = :$coluna";
        }
        $setString = implode(', ', $setParts);

        $sqlItem = "UPDATE tbl_itens SET $setString WHERE id_item = :id";

        try {
            $this->db->beginTransaction();

            $stmtItem = $this->db->prepare($sqlItem);
            $stmtItem->bindParam(':id', $id_item, PDO::PARAM_INT);
            foreach ($dadosRemotos as $coluna => &$valor) {
                $stmtItem->bindValue(":$coluna", $valor);
            }
            $stmtItem->execute();

            // Atualiza autores (Delete all + Insert new)
            $stmtDelete = $this->db->prepare("DELETE FROM tbl_item_autores WHERE item_id = :item_id");
            $stmtDelete->bindParam(':item_id', $id_item, PDO::PARAM_INT);
            $stmtDelete->execute();

            if (!empty($autores_ids)) {
                $stmtInsert = $this->db->prepare("INSERT INTO tbl_item_autores (item_id, autor_id) VALUES (:item_id, :autor_id)");
                foreach ($autores_ids as $id_autor) {
                    $stmtInsert->bindParam(':item_id', $id_item, PDO::PARAM_INT);
                    $stmtInsert->bindParam(':autor_id', $id_autor, PDO::PARAM_INT);
                    $stmtInsert->execute();
                }
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    function excluirItem(int $id)
    {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_itens SET excluido_em = :atual WHERE id_item = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':atual', $dataatual);
        return $stmt->execute();
    }

    function ativarItem(int $id)
    {
        $sql = "UPDATE tbl_itens SET excluido_em = NULL WHERE id_item = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // --- MÉTODOS DE LEITURA (READ) ---

    function buscarItemPorID(int $id)
    {
        $select = $this->getSelectFields('i');
        $sql = "SELECT $select FROM tbl_itens i WHERE i.id_item = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $item['autores_ids'] = $this->buscarAutoresDoItem($id);
            // Corrige caminho da imagem caso use helper estático na View
            $item['imagem'] = self::corrigirCaminhoImagem($item['imagem']);
        }
        return $item;
    }

    private function buscarAutoresDoItem(int $id_item)
    {
        $sql = "SELECT autor_id FROM tbl_item_autores WHERE item_id = :item_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':item_id', $id_item, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function pesquisarItens(string $termo, int $pagina = 1, int $por_pagina = 10): array
    {
        $termo = "%{$termo}%";
        $whereClause = "i.excluido_em IS NULL";

        // Contagem
        $totalQuery = "
            SELECT COUNT(DISTINCT i.id_item) 
            FROM tbl_itens i
            LEFT JOIN tbl_item_autores ia ON i.id_item = ia.item_id
            LEFT JOIN tbl_autores a ON ia.autor_id = a.id_autor
            LEFT JOIN tbl_generos g ON i.id_genero = g.id_generos
            WHERE $whereClause
            AND (
                i.titulo_item LIKE :termo
                OR a.nome_autor LIKE :termo
                OR g.nome_generos LIKE :termo
                OR i.isbn LIKE :termo
                OR i.editora_gravadora LIKE :termo
            )
        ";
        $totalStmt = $this->db->prepare($totalQuery);
        $totalStmt->bindParam(':termo', $termo);
        $totalStmt->execute();
        $total = $totalStmt->fetchColumn();

        // Dados
        $select = $this->getSelectFields('i');
        $offset = ($pagina - 1) * $por_pagina;

        $dataQuery = "
            SELECT 
                $select,
                g.nome_generos AS nome_genero,
                c.nome_categoria,
                (SELECT GROUP_CONCAT(a2.nome_autor SEPARATOR ', ') 
                 FROM tbl_item_autores ia2
                 JOIN tbl_autores a2 ON ia2.autor_id = a2.id_autor
                 WHERE ia2.item_id = i.id_item) AS autores
            FROM tbl_itens i
            LEFT JOIN tbl_item_autores ia ON i.id_item = ia.item_id
            LEFT JOIN tbl_autores a ON ia.autor_id = a.id_autor
            LEFT JOIN tbl_generos g ON i.id_genero = g.id_generos
            LEFT JOIN tbl_categorias c ON i.id_categoria = c.id_categoria
            WHERE $whereClause
            AND (
                i.titulo_item LIKE :termo
                OR a.nome_autor LIKE :termo
                OR g.nome_generos LIKE :termo
            )
            GROUP BY i.id_item
            ORDER BY i.titulo_item ASC
            LIMIT :limit OFFSET :offset
        ";

        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindParam(':termo', $termo);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();
        $dados = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

        // Processa imagens
        foreach ($dados as &$d) {
            $d['foto_item'] = self::corrigirCaminhoImagem($d['foto_item']);
        }

        return [
            'data' => $dados,
            'total' => (int) $total,
            'por_pagina' => (int) $por_pagina,
            'pagina_atual' => (int) $pagina,
            'ultima_pagina' => (int) ceil($total / $por_pagina)
        ];
    }

    public function paginacao(int $pagina = 1, int $por_pagina = 8, ?string $tipo = null): array
    {
        $whereClause = "i.excluido_em IS NULL";
        $params = [];
        if ($tipo) {
            $whereClause .= " AND i.tipo_item = :tipo";
            $params[':tipo'] = $tipo;
        }

        // Total
        $totalQuery = "SELECT COUNT(DISTINCT i.id_item) FROM tbl_itens i WHERE $whereClause";
        $totalStmt = $this->db->prepare($totalQuery);
        $totalStmt->execute($params);
        $total = $totalStmt->fetchColumn();

        $offset = ($pagina - 1) * $por_pagina;
        $select = $this->getSelectFields('i');

        $dataQuery = "
            SELECT 
                $select,
                g.nome_generos AS nome_genero,
                c.nome_categoria,
                (SELECT GROUP_CONCAT(a.nome_autor SEPARATOR ', ') 
                 FROM tbl_item_autores ia
                 JOIN tbl_autores a ON ia.autor_id = a.id_autor
                 WHERE ia.item_id = i.id_item) AS autores
            FROM tbl_itens i
            LEFT JOIN tbl_generos g ON i.id_genero = g.id_generos
            LEFT JOIN tbl_categorias c ON i.id_categoria = c.id_categoria
            WHERE $whereClause
            GROUP BY i.id_item
            ORDER BY i.criado_em DESC
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

        foreach ($dados as &$d) {
            $d['foto_item'] = self::corrigirCaminhoImagem($d['foto_item']);
        }

        return [
            'data' => $dados,
            'total' => (int) $total,
            'por_pagina' => (int) $por_pagina,
            'pagina_atual' => (int) $pagina,
            'ultima_pagina' => (int) ceil($total / $por_pagina)
        ];
    }

    public function buscarItemAtivos()
    {
        $select = $this->getSelectFields('item');
        $sql = "SELECT $select, autor.nome_autor AS nome_autor 
                FROM tbl_itens as item
                INNER JOIN tbl_item_autores as item_autor ON item_autor.item_id = item.id_item
                INNER JOIN tbl_autores as autor ON autor.id_autor = item_autor.autor_id
                WHERE item.excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($dados as &$d) {
            $d['imagem'] = self::corrigirCaminhoImagem($d['imagem']);
        }
        return $dados;
    }

    public static function corrigirCaminhoImagem($foto_item)
    {
        // Helper para normalizar o caminho da imagem para exibição
        if (empty($foto_item))
            return '/img/sem-imagem.webp';

        // Verifica se é URL completa
        if (filter_var($foto_item, FILTER_VALIDATE_URL)) {
            return $foto_item;
        }

        // Se já tem o caminho base completo (/backend/uploads/)
        if (strpos($foto_item, '/backend/uploads/') !== false) {
            return $foto_item;
        }

        // Remove barra inicial para padronizar
        $caminhoLimpo = ltrim($foto_item, '/');

        // Se começa com uploads/ (ex: uploads/itens/foto.jpg)
        if (strpos($caminhoLimpo, 'uploads/') === 0) {
            return '/backend/' . $caminhoLimpo;
        }

        // Caso contrário, assume que é apenas o nome do arquivo na raiz de uploads
        return '/backend/uploads/' . $caminhoLimpo;
    }

    // --- MÉTODOS DE CONTAGEM (STATS) ---

    function totalDeItens()
    {
        $sql = "SELECT count(*) FROM tbl_itens";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function totalDeItensAtivos()
    {
        $sql = "SELECT count(*) FROM tbl_itens WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function totalDeItensInativos()
    {
        $sql = "SELECT count(*) FROM tbl_itens WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // --- MÉTODOS AUXILIARES ---

    /**
     * Busca todos os itens com informações completas (JOINs)
     */
    public function buscarTodosItensCompletos()
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
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as &$item) {
            $item['preco_item'] = floatval($item['preco_item'] ?? 0);
            $item['estoque'] = intval($item['estoque'] ?? 0);
            $item['ano_publicacao'] = $item['ano_publicacao'] ? intval($item['ano_publicacao']) : null;
            $item['caminho_imagem'] = self::corrigirCaminhoImagem($item['foto_item']);
        }

        return $result;
    }

    /**
     * Busca um item específico com todas as informações
     */
    public function buscarItemCompleto(int $id)
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
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $item['preco_item'] = floatval($item['preco_item'] ?? 0);
            $item['estoque'] = intval($item['estoque'] ?? 0);
            $item['ano_publicacao'] = $item['ano_publicacao'] ? intval($item['ano_publicacao']) : null;
            $item['caminho_imagem'] = self::corrigirCaminhoImagem($item['foto_item']);
        }

        return $item;
    }
}






