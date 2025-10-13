<?php
namespace App\Sebo_Alfarrabio\Models;
use PDO;
class Discos{
    public $id_discos;
    public $id_acervo;
    public $artista_discos;
    public $gravadora_discos;
    public $formato_discos;
    public $id_cat_musica;
    public $status_avaliacao;
    public $descricao_discos;
    public $foto_discos;
    public $preco_discos;
    public $criado_em;
    public $atualizado_em;
    public $excluido_em;
     public $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os discos read
    function buscarDiscospor(){
        $sql = "SELECT * FROM tbl_discos where excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos os discos por id read
    function buscarDiscopor(){
        $sql = "SELECT * FROM tbl_discos where id_discos  = :id and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id'); 
        $stmt->execute();
    }
    
    // metodo de inserir discos create
    function inserirDiscos($id_discos, $id_acervo, $artista_discos, $gravadora_discos, $formato_discos, $id_cat_musica, $status_avaliacao, $descricao_discos, $foto_discos,  $preco_discos,){
        $sql = "INSERT INTO tbl_discos (artista_discos, gravadora_discos, formato_discos, 
        status_avaliacao, descricao_discos, foto_discos, preco_discos) 
                VALUES (:artista, :gravadora, :formato, :status, :descricao, :foto, :preco)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':artista', $artista_discos);
        $stmt->bindParam(':gravadora',$gravadora_discos);
        $stmt->bindParam(':formato', $formato_discos);
        $stmt->bindParam(':status', $status_avaliacao);
        $stmt->bindParam(':descricao', $descricao_discos);
        $stmt->bindParam(':foto', $foto_discos);
        $stmt->bindParam(':preco', $preco_discos);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    // metodo de atualizar o discos update
    function atualizarDiscos($id_discos, $id_acervo, $artista_discos, $gravadora_discos, $formato_discos, $id_cat_musica, $status_avaliacao, $descricao_discos, $foto_discos,  $preco_discos,){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_discos SET artista_discos = :artista,
         gravadora_discos = :gravadora,
         formato_discos  = :formato, 
         status_avaliacao = :status,
         descricao_discos = :descricao,
         foto_discos = :foto,
          preco_discos = :preco,
         atualizado_em = :atual
         WHERE id_livros = :id";
       $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':artista', $artista_discos);
        $stmt->bindParam(':gravadora',$gravadora_discos);
        $stmt->bindParam(':formato', $formato_discos);
        $stmt->bindParam(':status', $status_avaliacao);
        $stmt->bindParam(':descricao', $descricao_discos);
        $stmt->bindParam(':foto', $foto_discos);
        $stmt->bindParam(':preco', $preco_discos);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de deletar o discos (delete)
    function excluirDiscos($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_discos SET
         excluido_em = :atual
         WHERE id_discos = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function ativarDiscos($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_discos SET
         excluido_em = :atual
         WHERE id_discos = :id";
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
