<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Avaliacao{
    private $id_avaliacao;
    private $id_acervo;
    private $id_usuario;
    private $nota_avaliacao;
    private $comentario_avaliacao;
    private $data_avaliacao;
    private $status_avaliacao;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os usuarios read
    function buscarAvaliacao(){
        $sql = "SELECT * FROM tbl_avaliacao";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function totalDeAvaliacao(){
        $sql = "SELECT count(*) as total_avaliacao FROM tbl_avaliacao";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    function totalDeAvaliacaoInativos(){
        $sql = "SELECT count(*) as total_inativos FROM tbl_avaliacao where excluido_em is NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    function totalDeAvaliacaoAtivos(){
        $sql = "SELECT count(*) as total_ativos FROM tbl_avaliacao where excluido_em is NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // metodo de buscar todos usuario por email read
    function buscarAvaliacaoPorNota($nota_avaliacao){
        $sql = "SELECT * FROM tbl_avaliacao where nota_avaliacao = :nota";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nota', $nota_avaliacao); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarAvaliacaoPorComentario($comentario_avaliacao){
        $sql = "SELECT * FROM tbl_avaliacao where comentario_avaliacao = :comentario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':comentario', $comentario_avaliacao); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarAvaliacaoPorData($data_avaliacao){
        $sql = "SELECT * FROM tbl_avaliacao where data_avaliacao = :data";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_avaliacao); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarAvaliacaoPorStatus($status_avaliacao){
        $sql = "SELECT * FROM tbl_avaliacao where status_avaliacao = :status";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status_avaliacao); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarAvaliacaoPorID($id_avaliacao){
        $sql = "SELECT * FROM tbl_avaliacao where id_avaliacao = :id_avaliacao";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_avaliacao', $id_avaliacao); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarAvaliacaoPorIDAcervo($id_acervo){
        $sql = "SELECT * FROM tbl_avaliacao where id_acervo = :id_acervo";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_acervo', $id_acervo); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function buscarAvaliacaoPorIDUsuario($id_usuario){
        $sql = "SELECT * FROM tbl_avaliacao where id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // metodo de inserir usuario create
    function inserirAvaliacao($nota_avaliacao, $comentario_avaliacao, $data_avaliacao, $status_avaliacao){
        $sql = "INSERT INTO tbl_avaliacao (nota_avaliacao, comentario_avaliacao, 
        data_avaliacao, status_avaliacao) 
                VALUES (:nota, :comentario, :data, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nota', $nota_avaliacao);
        $stmt->bindParam(':comentario', $comentario_avaliacao);
        $stmt->bindParam(':data', $data_avaliacao);
        $stmt->bindParam(':status', $status_avaliacao);

        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario update
    public function atualizarAvaliacao(int $id_avaliacao, string $nota_avaliacao, 
    string $comentario_avaliacao, string $data_avaliacao, string $status_avaliacao){
        $sql = "UPDATE tbl_avaliacao SET 
                    nota_avaliacao = :nota, 
                    comentario_avaliacao = :comentario,
                    data_avaliacao = :data,
                    status_avaliacao = :status, 

                    atualizado_em = NOW()";
        
        $sql .= " WHERE id_avaliacao = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_avaliacao, PDO::PARAM_INT);
        $stmt->bindParam(':nota', $nota_avaliacao);
        $stmt->bindParam(':comentario', $comentario_avaliacao);
        $stmt->bindParam(':data', $data_avaliacao);
        $stmt->bindParam(':status', $status_avaliacao);
        return $stmt->execute();
    }
    
    public function deletarAvaliacao(int $id_avaliacao){
        $dados = $this->buscarAvaliacaoPorID($id_avaliacao);
        if (empty($dados)) return false;
        $novoStatus = ($dados[0]['status_avaliacao'] == 'ativo') ? 'Inativo' : 'ativo';
    
        $sql = "UPDATE tbl_avaliacao SET status_avaliacao = :status WHERE id_avaliacao = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_avaliacao, PDO::PARAM_INT);
        $stmt->bindParam(':status', $novoStatus); 
        return $stmt->execute();}

    // metodo de ativar o usuario excluido
    function ativarAvaliacao($id_avaliacao){
        $dataatual = NULL;
        $sql = "UPDATE tbl_avaliacao SET
         excluido_em = :atual
         WHERE id_avaliacao = :id_avaliacao";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_avaliacao', $id_avaliacao);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }}
}


