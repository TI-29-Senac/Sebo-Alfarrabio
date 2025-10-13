<?php
namespace App\Sebo_Alfarrabio\Models;
use PDO;
class DVDS{
    public $id_DVDs;
    public $id_acervo;
    public $titulo_dvds;
    public $diretor_dvds;
    public $duracao_dvds;
    public $classificacao_dvds;
    public $id_cat_musica;
    public $descricao_dvds;
    public $foto_dvds;
    public $preco_dvds;
    public $criado_em;
    public $atualizado_em;
    public $excluido_em;
    public $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os DVDs read
    function buscarDVDs(){
        $sql = "SELECT * FROM tbl_dvds where excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos os DVDs por id read
    function buscarDVDspor(){
        $sql = "SELECT * FROM tbl_dvds where id_DVDs  = :id and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id'); 
        $stmt->execute();
    }
    
    // metodo de inserir DVDs create
    function inserirDVDs($id_DVDs, $id_acervo, $titulo_dvds, $diretor_dvds, $duracao_dvds, $classificacao_dvds, $id_cat_musica,  $descricao_dvds, $foto_dvds, $preco_dvds){
        $sql = "INSERT INTO tbl_dvds (titulo_dvds, diretor_dvds, duracao_dvds, classificacao_dvds, descricao_dvds, foto_dvds, preco_dvds) 
                VALUES (:titulo, :diretor, :duracao, :classificacao, :descricao, :foto, :preco)"; 
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo_dvds);
        $stmt->bindParam(':diretor',$diretor_dvds);
        $stmt->bindParam(':duracao', $duracao_dvds);
        $stmt->bindParam(':classificacao', $classificacao_dvds);
        $stmt->bindParam(':descricao',  $descricao_dvds);
        $stmt->bindParam(':foto', $foto_dvds);
        $stmt->bindParam(':preco', $preco_dvds);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    // metodo de atualizar o DVDs update
    function atualizarDVDs($id_DVDs, $id_acervo, $titulo_dvds, $diretor_dvds, $duracao_dvds, $classificacao_dvds, $id_cat_musica,  $descricao_dvds, $foto_dvds, $preco_dvds){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_dvds SET titulo_dvds = :titulo,
         diretor_dvds= :diretor,
         duracao_dvds  = :duracao, 
         classificacao_dvds = :classificacao,
         descricao_dvds = descricao
         foto_dvds = :foto,
          preco_dvds = :preco,
         atualizado_em = :atual
         WHERE id_DVDs = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_DVDs);
        $stmt->bindParam(':titulo', $titulo_dvds);
        $stmt->bindParam(':diretor', $diretor_dvds);
        $stmt->bindParam(':duracao', $duracao_dvds);
        $stmt->bindParam(':classificacao', $classificacao_dvds);
        $stmt->bindParam(':descricao', $descricao_dvds);
        $stmt->bindParam(':foto', $foto_dvds);
        $stmt->bindParam(':preco', $preco_dvds);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de deletar o DVD (delete)
    function excluirDVDs($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_cds SET
         excluido_em = :atual
         WHERE id_DVDs = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function ativarDVDs($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_dvds SET
         excluido_em = :atual
         WHERE id_DVDs = :id";
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