<?php
    namespace Sebo\Alfarrabio\Models;
class Acervo {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Buscar acervo ativo
    public function buscarAtivos() {
        $sql = "SELECT * FROM tbl_acervo WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar acervo inativo
    public function buscarInativos() {
        $sql = "SELECT * FROM tbl_acervo WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserir item
    public function inserirItemAcervo($titulo, $tipo, $estado, $disponibilidade, $estoque) {
        $sql = "INSERT INTO tbl_acervo 
                (titulo_acervo, tipo_item_acervo, estado_conservacao, disponibilidade_acervo, estoque_acervo, atualizado_em) 
                VALUES (:titulo, :tipo, :estado, :disponibilidade, :estoque, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':disponibilidade', $disponibilidade);
        $stmt->bindParam(':estoque', $estoque);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // Atualizar item
    public function atualizarAcervo($id, $dados) {
        $sql = "UPDATE tbl_acervo 
                SET titulo_acervo = :titulo, 
                    tipo_item_acervo = :tipo, 
                    estado_conservacao = :estado, 
                    disponibilidade_acervo = :disponibilidade, 
                    estoque_acervo = :estoque, 
                    atualizado_em = NOW()
                WHERE id_acervo = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $dados['titulo']);
        $stmt->bindParam(':tipo', $dados['tipo']);
        $stmt->bindParam(':estado', $dados['estado']);
        $stmt->bindParam(':disponibilidade', $dados['disponibilidade']);
        $stmt->bindParam(':estoque', $dados['estoque']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Deletar (soft delete → marca excluido_em)
    public function excluirAcervo($id) {
        $sql = "UPDATE tbl_acervo 
                SET excluido_em = NOW() 
                WHERE id_acervo = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
