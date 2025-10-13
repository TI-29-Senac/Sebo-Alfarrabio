<?php
namespace App\Sebo_Alfarrabio\Models\CDs;
use PDO;
class CDs{
    public $id_CDs;
    public $id_acervo;
    public $artista_CDs;
    public $gravadora_CDs;
    public $num_faixas_CDs;
    public $descricao_CDs;
    public $foto_CDs;
    public $preco_CDs;
    public $criado_em;
    public $atualizado_em;
    public $excluido_em;
    public $db;
    // contrutor inicializa a classe e ou atributos
    private function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os Cds read
    function buscarCDs(){
        $sql = "SELECT * FROM tbl_CDs where excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos os CDs por id read
    function buscarCDspor(){
        $sql = "SELECT * FROM tbl_cds where id_CDs  = :id and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id'); 
        $stmt->execute();
    }
    
    // metodo de inserir CDs create
    function inserirLivros($id_CDs, $id_acervo, $artista_CDs, $gravadora_CDs, $num_faixas_CDs, $descricao_CDs, $foto_CDs, $preco_CDs){
        $sql = "INSERT INTO tbl_cds (artista_CDs, gravadora_CDs, num_faixas_CDs, descricao_CDs, foto_CDs, preco_CDs) 
                VALUES (:artista, :gravadora, :num_faixas, :descricao, :foto :preco)"; 
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':artista', $artista_CDs);
        $stmt->bindParam(':gravadora',$gravadora_CDs);
        $stmt->bindParam(':num_faixas', $num_faixas_CDs);
        $stmt->bindParam(':descricao', $descricao_CDs);
        $stmt->bindParam(':foto', $foto_CDs);
        $stmt->bindParam(':preco', $preco_CDs);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    // metodo de atualizar o CDs update
    function atualizarCDs($id_CDs, $id_acervo, $artista_CDs, $gravadora_CDs, $num_faixas_CDs, $descricao_CDs, $foto_CDs, $preco_CDs){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_cds SET artista_CDs = :artista,
         gravadora_CDs = :gravadora,
         num_faixas_CDs  = :num_faixa, 
         descricao_CDs = :descricao,
         foto_CDs = :foto,
          preco_CDs = :preco,
         atualizado_em = :atual
         WHERE id_livros = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_CDs);
        $stmt->bindParam(':artista', $artista_CDs);
        $stmt->bindParam(':gravadora', $gravadora_CDs);
        $stmt->bindParam(':num_faixas', $num_faixas_CDs);
        $stmt->bindParam(':descricao', $descricao_CDs);
        $stmt->bindParam(':foto', $foto_CDs);
        $stmt->bindParam(':preco', $preco_CDs);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de deletar o CD (delete)
    function excluirCDs($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_cds SET
         excluido_em = :atual
         WHERE id_CDs = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function ativarCDs($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_cds SET
         excluido_em = :atual
         WHERE id_CDs = :id";
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