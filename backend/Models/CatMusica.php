<?php
    namespace Sebo\Alfarrabio\Models;
    use PDO;
class CategoriaMusica {
    private $id_cat_musica;
    private $nome_categoria;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function buscarAtivos() {
        $sql = "SELECT * FROM tbl_cat_musica WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inserir($nome) {
        $sql = "INSERT INTO tbl_cat_musica (nome_categoria, atualizado_em)
                VALUES (:nome, NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function atualizar($id, $nome) {
        $sql = "UPDATE tbl_cat_musica 
                SET nome_categoria = :nome, atualizado_em = NOW()
                WHERE id_cat_musica = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function excluir($id) {
        $sql = "UPDATE tbl_cat_musica SET excluido_em = NOW() WHERE id_cat_musica = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
