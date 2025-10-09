<?php
namespace Sebo\Alfarrábio\Models;
use PDO;
class Vendas{
    private $id_venda;
    private $id_usuario;
    private $data_venda;
    private $valor_total;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;


        public function __construct($db){
        $this->db = $db;
    }
    
    // Buscar todos as vendas
    function buscarVendas(){
        $sql = "SELECT * FROM tbl_vendas";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Buscar vendas por data
    function buscarVendasPorData($data_venda){
        $sql = 'SELECT * FROM tbl_vendas where data_venda = :data';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_venda);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    // Buscar vendas por valor

    function buscarVendasPorValor($valor_total){
        $sql = 'SELECT * FROM tbl_vendas where valor_total = :valor';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':valor', $valor_total);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar vendas por forma de pagamento

    function buscarVendasPorPagamento($forma_pagamento){
        $sql = 'SELECT * FROM tbl_vendas where forma_pagamento = :pagamento';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':pagamento', $forma_pagamento);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Inserir vendas

    function inserirVendas($nome_, $email_, $senha_, $tipo_){
        $sql = 'INSERT INTO tbl_vendas (nome_, email_, 
        senha_, tipo_) 
        VALUES (:nome, :email, :senha, :tipo)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome_);
        $stmt->bindParam(':email', $email_);
        $stmt->bindParam(':senha', $senha_);
        $stmt->bindParam(':tipo', $tipo_);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // Atualizar vendas

    function atualizarVendas($id_, $nome_, $email_, $senha_, $tipo_){
        $senha_ = password_hash($senha_, PASSWORD_DEFAULT);
        $sql = 'UPDATE tbl_vendas
        SET nome_ = :nome,
         email_ = :email,
         senha_ = :senha,
         tipo_ = :tipo
        WHERE id_ = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_);
        $stmt->bindParam(':nome', $nome_);
        $stmt->bindParam(':email', $email_);
        $stmt->bindParam(':senha', $senha_);
        $stmt->bindParam(':tipo', $tipo_);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    // Excluir vendas (soft delete)

    function excluirVendas($id_){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_vendas SET 
        excluido_em = :atual
        WHERE id_ = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
}

}