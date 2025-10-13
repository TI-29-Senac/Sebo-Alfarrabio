<?php
namespace App\Sebo\Alfarrabio\Models;
use PDO;
class Vendas{
    private $id_venda;
    private $id_usuario;
    private $data_venda;
    private $valor_total;
    private $forma_pagamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os usuarios read
    function buscarVendas(){
        $sql = "SELECT * FROM tbl_vendas";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar todos usuario por email read
    function buscarVendasPorData($data_venda){
        $sql = "SELECT * FROM tbl_vendas where data_venda = :data";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_venda); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarVendasPorID($id){
        $sql = "SELECT * FROM tbl_vendas where id_venda = :id_venda";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_venda', $id_venda); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarVendasPorIDUsuario($id){
        $sql = "SELECT * FROM tbl_vendas where id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de inserir usuario create
    function inserirUsuario($data_venda, $valor_total, $forma_pagamento){
        $sql = "INSERT INTO tbl_vendas (data_venda, valor_total, 
        forma_pagamento) 
                VALUES (:data, :valort, :fpagamento)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_venda);
        $stmt->bindParam(':valort', $valor_total);
        $stmt->bindParam(':fpagamento', $forma_pagamento);

        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario update
    function atualizarUsuario($id_venda, $data_venda, $valor_total, $forma_pagamento){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_vendas SET data_venda = :data,
         valor_total = :valort, 
         forma_pagamento = :fpagamento, 
         WHERE id_venda = :id_venda";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_venda', $id_venda);
        $stmt->bindParam(':data', $data_venda);
        $stmt->bindParam(':valort', $valor_total);
        $stmt->bindParam(':forma_pagamento', $fpagamento);
        
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de inativar o usuario delete
    function excluirUsuario($id_venda){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_vendas SET
         excluido_em = :atual
         WHERE id_venda = :id_venda";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_venda', $id_venda);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
// metodo de ativar o usuario excluido
    function ativarVendas($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_vendas SET
         excluido_em = :atual
         WHERE id_venda = :id_venda";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_venda', $id_venda);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }}
}