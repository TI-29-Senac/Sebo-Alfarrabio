<?php
class Acervo{
    private $id_acervo;
    private $titulo_acervo;
    private $tipo_item_acervo;
    private $estado_conservacao;
    private $disponibilidade_acervo;
    private $estoque_acervo;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os usuarios read
    function buscarAcervos(){
        $sql = "SELECT * FROM tbl_acervo where excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos usuario por email read
    function buscarAcervoPorId($id){
        $sql = "SELECT * FROM tbl_acervo where id_acervo  = :id and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id); 
        $stmt->execute();
    }
    
    // metodo de inserir usuario create
    function inserirAcervo($id_acervo, $titulo_acervo, $tipo_item_acervo, $estado_conservacao, $disponibilidade_acervo, $estoque_acervo){
        $sql = "INSERT INTO tbl_acervo (titulo_acervo, tipo_item_acervo, 
        estado_conservacao, disponibilidade_acervo, estoque_acervo) 
                VALUES (:titulo, :tipo, :estado, :disponibilidade, :estoque)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo_acervo);
        $stmt->bindParam(':tipo',$tipo_item_acervo);
        $stmt->bindParam(':estado', $estado_conservacao);
        $stmt->bindParam(':disponibilidade', $disponibilidade_acervo);
        $stmt->bindParam(':estoque', $estoque_acervo);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    // metodo de atualizar o usuario update
    function atualizarAcervo($id_acervo, $titulo_acervo, $tipo_item_acervo, $estado_conservacao, $disponibilidade_acervo, $estoque_acervo){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_acervo SET titulo_acervo = :titulo,
         tipo_item_acervo = :tipo, 
         estado_conservacao = :estado, 
         disponibilidade_acervo = :disponibilade,
         estoque_acervo = :estoque,
         atualizado_em = :atual
         WHERE id_acervo = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_acervo);
        $stmt->bindParam(':titulo', $titulo_acervo);
        $stmt->bindParam(':tipo', $tipo_item_acervo);
        $stmt->bindParam(':estado', $estado_conservacao);
        $stmt->bindParam(':disponibilidade', $disponibilidade_acervo);
        $stmt->bindParam(':estoque', $estoque_acervo);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de deletar o usuario delete
    function excluirUsuario($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_acervo SET
         excluido_em = :atual
         WHERE id_acervo = :id";
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