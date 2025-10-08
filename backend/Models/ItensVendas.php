<?php
    namespace Sebo\Alfarrabio\Models;
    use PDO;
class ItensVenda {
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

    public function inserirItensVendas($id_venda, $id_acervo, $quantidade, $preco) {
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
}
