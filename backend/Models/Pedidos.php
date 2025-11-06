<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Pedidos{
    private $id_pedido;
    private $id_usuario;
    private $valor_total;
    private $data_pedido;
    private $status_pedido;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os usuarios read
    function buscarPedidos(){
        $sql = "SELECT * FROM tbl_pedidos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criarPedido(array $itensCarrinho){
        $this->db->beginTransaction();
        try {
            $valorTotalCalculado = 0;
            foreach ($itensCarrinho as $item) {
                $valorTotalCalculado += $item['preco'] * $item['quantidade'];
            }

            $sqlPedido = "INSERT INTO tbl_pedidos (valor_total, data_pedido) VALUES (:valor_total, NOW())";
            $stmtPedido = $this->db->prepare($sqlPedido);
            $stmtPedido->bindParam(':valor_total', $valorTotalCalculado);
            $stmtPedido->execute();
            $idPedido = $this->db->lastInsertId();
            $sqlItem = "INSERT INTO tbl_pedido_itens (id_pedido, id_produto, quantidade, preco_unitario) 
                        VALUES (:id_pedido, :id_produto, :quantidade, :preco_unitario)";
            $stmtItem = $this->db->prepare($sqlItem);
            foreach ($itensCarrinho as $item) {
                $stmtItem->bindParam(':id_pedido', $idPedido, PDO::PARAM_INT);
                $stmtItem->bindParam(':id_produto', $item['id'], PDO::PARAM_INT);
                $stmtItem->bindParam(':quantidade', $item['quantidade'], PDO::PARAM_INT);
                $stmtItem->bindParam(':preco_unitario', $item['preco']);
                $stmtItem->execute();
            }
            $this->db->commit();

            return (int)$idPedido;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    
    function totalDePedidos(){
        $sql = "SELECT count(*) as total FROM tbl_pedidos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    function totalDePedidosInativos(){
        $sql = "SELECT count(*) as total_inativos FROM tbl_pedidos where excluido_em is NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    function totalDePedidosAtivos(){
        $sql = "SELECT count(*) as total_ativos FROM tbl_pedidos where excluido_em is NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


    // metodo de buscar todos usuario por email read
    function buscarPedidosPorData($data_pedido){
        $sql = "SELECT * FROM tbl_pedidos where data_pedido = :data";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_pedido); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarPedidosPorID($id_pedido){
        $sql = "SELECT * FROM tbl_pedidos where id_pedido = :id_pedido";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pedido', $id_pedido); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarPedidosPorIDUsuario($id_usuario){
        $sql = "SELECT * FROM tbl_pedidos where id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de inserir usuario create
    function inserirPedidos($data_pedido, $status_pedido){
        $sql = "INSERT INTO tbl_pedidos (data_pedido, status_pedido) 
                VALUES (:data, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_pedido);
        $stmt->bindParam(':status', $status_pedido);

        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario update
    function atualizarPedidos($id_pedido, $data_pedido, $status_pedido){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_pedidos SET 
        data_pedido = :data,
        status_pedido = :status,
        atualizado_em = :atual
        WHERE id_pedido = :id_pedido";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id_pedido', $id_pedido, PDO::PARAM_INT);
    $stmt->bindParam(':data', $data_pedido);
    $stmt->bindParam(':status', $status_pedido);
    $stmt->bindParam(':atual', $dataatual);
    
    return $stmt->execute();
}
    // metodo de inativar o usuario delete
    function excluirPedidos($id_pedido){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pedidos SET
         excluido_em = :atual
         WHERE id_pedido = :id_pedido";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pedido', $id_pedido);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
// metodo de ativar o usuario excluido
    function ativarPedidos($id_pedido){
        $dataatual = NULL;
        $sql = "UPDATE tbl_pedidos SET
         excluido_em = :atual
         WHERE id_pedido = :id_pedido";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pedido', $id_pedido);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }}
}