<?php

class Acervo{
    public $id_acervo;
    public $titulo_acervo;
    public $tipo_item_acervo;
    public $estado_conservacao;
    public $disponibilidade_acervo;
    public $estoque_acervo;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

       public function __construct($db){
        $this->db = $db;
    }
     // Buscar todos os usuários não excluídos
    function buscarAcervo(){
        $sql = "SELECT * FROM tbl_acervo WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
     function buscarAcervoInativo(){
        $sql = "SELECT * FROM tbl_acervo WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    // Inserir Itens no Acervo

     function inserirItemAcervo( $titulo_acervo, $tipo_item_acervo, $estado_conservacao, $disponibilidade_acervo, $estoque_acervo){
        $sql = 'INSERT INTO tbl_acervo (titulo_acervo,tipo_item_acervo, estado_conservacao, disponibilidade_acervo, estoque_acervo)
        VALUES (:titulo_acervo, :tipo_item_acervo, :estado_conservacao, :disponibilidade_acervo, :estoque_acervo)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo_acervo', $titulo_acervo);
        $stmt->bindParam(':tipo_item_acervo', $tipo_item_acervo);
        $stmt->bindParam(':estado_conservacao', $estado_conservacao);
        $stmt->bindParam(':disponibilidade_acervo', $disponibilidade_acervo);
        $stmt->bindParam(':estoque_acervo', $estoque_acervo);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    // Atualizar Itens no Acervo
        function atualizarAcervo($id_acervo, $tipo_item_acervo, $email_usuario, $senha_usuario, $tipo_usuario){
        $senha_usuario = password_hash($senha_usuario, PASSWORD_DEFAULT);
        $sql = 'UPDATE tbl_acervo
        SET titulo_acervo = :nome,
         tipo_item_acervo = :email,
         senha_usuario = :senha,
         tipo_usuario = :tipo
        WHERE id_acervo = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_usuario);
        $stmt->bindParam(':titulo_acervo', $titulo_acervo);
        $stmt->bindParam(':email', $email_usuario);
        $stmt->bindParam(':senha', $senha_usuario);
        $stmt->bindParam(':tipo', $tipo_usuario);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}