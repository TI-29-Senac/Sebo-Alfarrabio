<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
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
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os usuarios read
    function buscarUsuarios(){
        $sql = "SELECT * FROM tbl_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar todos usuario por email read
    function buscarUsuariosPorEMail($email_usuario){
        $sql = "SELECT * FROM tbl_usuario where email_usuario = :email and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email_usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarUsuariosPorID($id_usuario){
        $sql = "SELECT * FROM tbl_usuario where id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de inserir usuario create
    function inserirUsuario($nome_usuario,
     $email_usuario, 
     $senha_usuario, 
     $tipo_usuario
     ){
        $senha_usuario = password_hash($senha_usuario, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbl_usuario (nome_usuario, email_usuario, 
        senha_usuario, tipo_usuario) 
                VALUES (:nome, :email, :senha, :tipo)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome_usuario);
        $stmt->bindParam(':email', $email_usuario);
        $stmt->bindParam(':senha', $senha_usuario);
        $stmt->bindParam(':tipo', $tipo_usuario);

        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario update
    function atualizarUsuario($id_usuario, $nome_usuario, $email_usuario, $senha_usuario, $tipo_usuario){
        $senha_usuario = password_hash($senha_usuario, PASSWORD_DEFAULT);
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET nome_usuario = :nome,
         email_usuario = :email, 
         senha_usuario = :senha, 
         tipo_usuario = :tipo,
         atualizado_em = :atual,
         WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_usuario);
        $stmt->bindParam(':nome', $nome_usuario);
        $stmt->bindParam(':email', $email_usuario);
        $stmt->bindParam(':senha', $senha_usuario);
        $stmt->bindParam(':tipo', $tipo_usuario);

        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de inativar o usuario delete
    function excluirUsuario($id_usuario){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET
         excluido_em = :atual
         WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_usuario);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
// metodo de ativar o usuario excluido
    function ativarUsuario($id_usuario){
        $dataatual = NULL;
        $sql = "UPDATE tbl_usuario SET
         excluido_em = :atual
         WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_usuario);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}