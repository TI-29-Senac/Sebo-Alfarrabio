<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Usuario{
    public $id_usuario;
    public $nome_usuario;
    public $email_usuario;
    private $senha_usuario;
    public $tipo_usuario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
 
 
        public function __construct($db){
        $this->db = $db;
    }
   
    // Buscar todos os usuários não excluídos
    function buscarUsuarios(){
        $sql = "SELECT * FROM tbl_usuario WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   
 
    // Inserir Usuários
 
    function inserirUsuarios($nome_usuario, $email_usuario, $senha_usuario, $tipo_usuario){
        $sql = 'INSERT INTO tbl_usuario (nome_usuario, email_usuario,
        senha_usuario, tipo_usuario)
        VALUES (:nome, :email, :senha, :tipo)';
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
 
    // Atualizar Usuários
 
    function atualizarUsuarios($id_usuario, $nome_usuario, $email_usuario, $senha_usuario, $tipo_usuario){
        $senha_usuario = password_hash($senha_usuario, PASSWORD_DEFAULT);
        $sql = 'UPDATE tbl_usuario
        SET nome_usuario = :nome,
         email_usuario = :email,
         senha_usuario = :senha,
         tipo_usuario = :tipo
        WHERE id_usuario = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_usuario);
        $stmt->bindParam(':nome', $nome_usuario);
        $stmt->bindParam(':email', $email_usuario);
        $stmt->bindParam(':senha', $senha_usuario);
        $stmt->bindParam(':tipo', $tipo_usuario);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de inativar o usuario delete
    function excluirUsuario($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET
         excluido_em = :atual
         WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
// metodo de ativar o usuario excluido
    function ativarUsuario($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_usuario SET
         excluido_em = :atual
         WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}
 