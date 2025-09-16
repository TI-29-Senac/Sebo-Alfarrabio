<?php
class Usuario{
    private $id_usuario;
    private $nome_usuario;
    private $email_usuario;
    private $senha_usuario;
    private $tipo_usuario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

// construtor inicializa a classe e ou atributos
    public function __construct($db){
        $this->db = $db;
    }
    //método de buscar todos os usuarios
    function buscarUsuarios(){
        $sql = 'SELECT * FROM tbl_usuario where excluido_em IS NULL';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //método de inserir usuario
    function inserirUsuario($db, $nome, $email, $senha, $tipo){
        $sql = 'INSERT INTO tbl_usuario (nome_usuario, email_usuario, 
        senha_usuario, tipo_usuario) 
        VALUES (:nome, :email, :senha, :tipo)';
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    //método de atualizar o usuário
    function atualizarUsuario($id, $nome, $email, $senha, $tipo){
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = 'UPDATE tbl_usuario SET nome_usuario = :nome,
         email_usuario = :email,
         senha_usuario = :senha,
         tipo_usuario = :tipo,
        atualizado_em = :atual
        WHERE id_usuario = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    //método de deletar o usuario

    function excluirUsuario($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET 
        excluido_em = :atual
        WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt = bindParam(':id', $id);
        $stmt = bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
}
}