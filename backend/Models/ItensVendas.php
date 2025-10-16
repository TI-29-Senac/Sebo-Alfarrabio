<?php
    namespace Sebo\Alfarrabio\Models;
    use PDO;
class ItensVendas {
    private $id_itens_venda;
    private $id_venda;
    private $id_acervo;
    private $quantidade_item;
    private $preco_unitario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        
    }

    public function buscarAtivos() {
        $sql = "SELECT * FROM tbl_itens_vendas WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_itens_vendas` WHERE excluido_em IS NULL";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_itens_vendas` WHERE excluido_em IS NULL LIMIT :limit OFFSET :offset ";
        $dataStmt = $this->db->prepare($dataQuery);
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

    public function CriarItensVendas($id_venda, $id_acervo, $quantidade, $preco) {
        $sql = "INSERT INTO tbl_itens_vendas 
                (id_venda, id_acervo, quantidade_item, preco_unitario, atualizado_em) 
                VALUES (:id_venda, :id_acervo, :quantidade, :preco, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_venda', $id_venda);
        $stmt->bindParam(':id_acervo', $id_acervo);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':preco', $preco);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function atualizarItensVendas($id, $dados) {
        $sql = "UPDATE tbl_itens_vendas 
                SET id_venda = :id_venda,
                    id_acervo = :id_acervo,
                    quantidade_item = :quantidade,
                    preco_unitario = :preco,
                    atualizado_em = NOW()
                WHERE id_itens_venda = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_venda', $dados['id_venda']);
        $stmt->bindParam(':id_acervo', $dados['id_acervo']);
        $stmt->bindParam(':quantidade', $dados['quantidade']);
        $stmt->bindParam(':preco', $dados['preco']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function excluirItensVendas($id) {
        $sql = "UPDATE tbl_itens_vendas SET excluido_em = NOW() WHERE id_itens_venda = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    
    function totalDeItens(){
        $sql = "SELECT count(*) as total FROM tbl_itens_vendas";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
