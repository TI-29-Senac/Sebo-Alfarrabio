<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Pedidos
{
    private $id_pedido;
    private $id_usuario;
    private $valor_total;
    private $data_pedido;
    private $status_pedido;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db)
    {
        $this->db = $db;
    }
    // metodo de buscar todos os usuarios read
    function buscarPedidos()
    {
        $sql = "SELECT * FROM tbl_pedidos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criarPedido(array $itensCarrinho)
    {
        $this->db->beginTransaction();
        try {
            $valorTotalCalculado = 0;
            foreach ($itensCarrinho as $item) {
                $valorTotalCalculado += $item['preco'] * $item['quantidade'];
            }

            // IMPORTANTE: id_usuario deve vir da sessão ou parâmetro
            // Por enquanto, assumindo que virá da sessão
            // TODO: Ajustar para receber id_usuario como parâmetro ou da sessão
            if (!isset($_SESSION['usuario_id'])) {
                throw new \Exception("Usuário não autenticado. id_usuario é obrigatório.");
            }
            $idUsuario = $_SESSION['usuario_id'];

            $sqlPedido = "INSERT INTO tbl_pedidos (id_usuario, valor_total, data_pedido) VALUES (:id_usuario, :valor_total, NOW())";
            $stmtPedido = $this->db->prepare($sqlPedido);
            $stmtPedido->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmtPedido->bindParam(':valor_total', $valorTotalCalculado);
            $stmtPedido->execute();
            $idPedido = $this->db->lastInsertId();
            $sqlItem = "INSERT INTO tbl_pedido_itens (pedido_id, item_id, quantidade) 
                        VALUES (:pedido_id, :item_id, :quantidade)";
            $stmtItem = $this->db->prepare($sqlItem);
            foreach ($itensCarrinho as $item) {
                $stmtItem->bindParam(':pedido_id', $idPedido, PDO::PARAM_INT);
                $stmtItem->bindParam(':item_id', $item['id'], PDO::PARAM_INT);
                $stmtItem->bindParam(':quantidade', $item['quantidade'], PDO::PARAM_INT);
                $stmtItem->execute();
            }
            $this->db->commit();

            return (int) $idPedido;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // metodo de buscar todos usuario por email read
    function buscarPedidosPorData($data_pedido)
    {
        $sql = "SELECT * FROM tbl_pedidos where data_pedido = :data";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_pedido);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarPedidosPorID($id_pedido)
    {
        $sql = "SELECT * FROM tbl_pedidos where id_pedidos = :id_pedidos";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pedidos', $id_pedido);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarPedidosPorIDUsuario($id_usuario)
    {
        $sql = "SELECT * FROM tbl_pedidos where id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de inserir usuario create
    function inserirPedidos($id_usuario, $valor_total, $data_pedido, $status)
    {
        $sql = "INSERT INTO tbl_pedidos (id_usuario, valor_total, data_pedido, status) 
                VALUES (:id_usuario, :valor_total, :data, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':valor_total', $valor_total);
        $stmt->bindParam(':data', $data_pedido);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    // metodo de atualizar o usuario update
    function atualizarPedidos($id_pedido, $data_pedido, $status)
    {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pedidos SET 
            data_pedido = :data,
            status = :status,
            atualizado_em = :atual
            WHERE id_pedidos = :id_pedidos";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id_pedidos', $id_pedido, PDO::PARAM_INT);
        $stmt->bindParam(':data', $data_pedido, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':atual', $dataatual, PDO::PARAM_STR);

        return $stmt->execute(); // agora funciona porque os binds estão certos
    }
    // metodo de inativar o usuario delete
    function excluirPedidos($id_pedido)
    {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_pedidos SET
         excluido_em = :atual
         WHERE id_pedidos = :id_pedidos";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pedidos', $id_pedido);
        $stmt->bindParam(':atual', $dataatual);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // metodo de ativar o usuario excluido
    function ativarPedidos($id_pedido)
    {
        $dataatual = NULL;
        $sql = "UPDATE tbl_pedidos SET
         excluido_em = :atual
         WHERE id_pedidos = :id_pedidos";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_pedidos', $id_pedido);
        $stmt->bindParam(':atual', $dataatual);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}