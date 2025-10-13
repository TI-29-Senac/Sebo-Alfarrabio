<?php
namespace App\Sebo_Alfarrabio\Models\Revistas;
use PDO;

Class Revistas{
    public $id_revistas;
    public $id_acervo;
    public $editora_revistas;
    public $edicao_revistas;
    public $mes_ano_revistas;
    public $criado_em;
    public $atualizado_em;
    public $excluido_em;
    public $db;

    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todas as Revistas read
    function buscarRevistas(){
        $sql = "SELECT * FROM tbl_servico where excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todas as revistas por id read
    function buscarRevistasPorID($id){
        $sql = "SELECT * FROM tbl_revistas where id_revistas = :id and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // metodo de inserir revistas create
    function inseriRevistas($id_acervo, $editora_revistas, $edicao_revistas, $mes_ano_revistas){
        $sql = "INSERT INTO tbl_revistas (editora_revistas, edicao_revistas, mes_ano_revistas) 
                VALUES (:editora, :edicao, :mes_ano)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':editora', $editora_revistas);
        $stmt->bindParam(':edicao', $edicao_revistas);
        $stmt->bindParam(':mes_ano', $mes_ano_revistas);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    // metodo de atualizar o revistas update
    function atualizarUsuario($id_revistas, $id_acervo, $editora_revistas, $edicao_revistas, $mes_ano_revistas){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_revistas SET editora_revistas = :editora_revistas,
         edicao_revistas = :edicao_revistas, 
         mes_ano_revistas = :mes_ano_revistas, 
         atualizado_em = :atual
         WHERE id_revistas = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_revistas);
        $stmt->bindParam(':editora', $editora_revistas);
        $stmt->bindParam(':edicao', $edicao_revistas);
        $stmt->bindParam(':mes_ano', $mes_ano_revistas);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de deletar a revista delete
    function excluirUsuario($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_revistas SET
         excluido_em = :atual
         WHERE id_revistas = :id";
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