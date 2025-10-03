<?php

class Contato {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Buscar contatos ativos
    public function buscarAtivos() {
        $sql = "SELECT * FROM tbl_contato WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar contatos inativos
    public function buscarInativos() {
        $sql = "SELECT * FROM tbl_contato WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserir novo contato
    public function inserir($nome, $telefone, $email, $assunto, $mensagem, $status) {
        $sql = "INSERT INTO tbl_contato 
                (nome_contato, telefone_contato, email_contato, assunto_contato, mensagem_contato, status_contato, data_envio, atualizado_em)
                VALUES (:nome, :telefone, :email, :assunto, :mensagem, :status, NOW(), NOW())";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':assunto', $assunto);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // Atualizar contato
    public function atualizar($id, $dados) {
        $sql = "UPDATE tbl_contato 
                SET nome_contato = :nome,
                    telefone_contato = :telefone,
                    email_contato = :email,
                    assunto_contato = :assunto,
                    mensagem_contato = :mensagem,
                    status_contato = :status,
                    atualizado_em = NOW()
                WHERE id_contato = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':telefone', $dados['telefone']);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':assunto', $dados['assunto']);
        $stmt->bindParam(':mensagem', $dados['mensagem']);
        $stmt->bindParam(':status', $dados['status']);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Excluir (soft delete)
    public function excluir($id) {
        $sql = "UPDATE tbl_contato SET excluido_em = NOW() WHERE id_contato = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
