<?php
    namespace Sebo\Alfarrabio\Models;
class CategoriaLivro {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function buscarAtivos() {
        $sql = "SELECT * FROM tbl_cat_livros WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inserirCatLivros($nome) {
        $sql = "INSERT INTO tbl_cat_livros (nome_categoria, atualizado_em)
                VALUES (:nome, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function atualizarCatLivros($id, $nome) {
        $sql = "UPDATE tbl_cat_livros 
                SET nome_categoria = :nome, atualizado_em = NOW()
                WHERE id_cat_livros = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function excluirCatLivros($id) {
        $sql = "UPDATE tbl_cat_livros SET excluido_em = NOW() WHERE id_cat_livros = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

