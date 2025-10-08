<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Contato{
    private $id_contato;
    private $nome_contato;
    private $telefone_contato;
    private $email_contato;
    private $mensagem_contato;
    private $status_usuario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os usuarios read
    function buscarContatos(){
        $sql = "SELECT * FROM tbl_contato where excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

      function buscarContatosInativos(){
        $sql = "SELECT * FROM tbl_contato where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar todos usuario por email read
    function buscarContatosPorEMail($email){
        $sql = "SELECT * FROM tbl_contato where email_contato = :email and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     // metodo de buscar todos usuario por id
    function buscarContatosPorId($id){
        $sql = "SELECT * FROM tbl_contato where id_contato = :id_contato and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_contato', $id); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    function buscarContatosPorEMailInativo($email){
        $sql = "SELECT * FROM tbl_contato where email_contato = :email and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de inserir usuario create
    function inseriContatos($nome, $telefone, $email, $mensagem, $status,){
        $sql = "INSERT INTO tbl_contato (nome_contato, telefone_contato, email_contato, 
        mensagem_contato, status_contato, ) 
                VALUES (:nome, :email, :mensagem, :status,)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->bindParam(':status', $status);
        
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario update
    function atualizarContatos($id, $nome, $telefone, $email, $mensagem, $status){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_contato SET nome_contato = :nome,
         email_contato = :email, 
         telefone_contato = :telefone, 
         mensagem_contato = :mensagem,
         status_contato = :status,
         atualizado_em = :atual
         WHERE id_contato = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de inativar o usuario delete
    function excluirContato($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_contato SET
         excluido_em = :atual
         WHERE id_contato = :id";
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
    function ativarContato($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_contato SET
         excluido_em = :atual
         WHERE id_contato = :id";
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
