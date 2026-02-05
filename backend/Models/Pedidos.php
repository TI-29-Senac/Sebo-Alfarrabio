<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Pedidos
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // LISTAR TODOS (Read)
    function buscarPedidos()
    {
        $sql = "SELECT * FROM tbl_pedidos ORDER BY data_pedido DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($pedidos as &$pedido) {
            // Garante uso do ID correto (id_pedidos)
            $id = $pedido['id_pedidos'] ?? $pedido['id'];

            $sqlItens = "SELECT i.titulo_item, i.foto_item, pi.quantidade 
                         FROM tbl_pedido_itens pi 
                         JOIN tbl_itens i ON pi.item_id = i.id_item 
                         WHERE pi.pedido_id = :id";
            $stmtItens = $this->db->prepare($sqlItens);
            $stmtItens->bindValue(':id', $id);
            $stmtItens->execute();
            $pedido['itens'] = $stmtItens->fetchAll(PDO::FETCH_ASSOC);
        }

        return $pedidos;
    }

    // CRIAR PEDIDO (Create)
    public function criarPedido(array $itensCarrinho, $status = 'Pendente')
    {
        $this->db->beginTransaction();
        try {
            $valorTotalCalculado = 0;

            // Validar estoque antes de criar o pedido
            foreach ($itensCarrinho as $item) {
                // O banco usa id_item, não id
                $id_item = $item['id_item'] ?? $item['id'];
                $sqlEstoque = "SELECT estoque FROM tbl_itens WHERE id_item = :id";
                $stmtEstoque = $this->db->prepare($sqlEstoque);
                $stmtEstoque->bindParam(':id', $id_item, PDO::PARAM_INT);
                $stmtEstoque->execute();
                $itemBanco = $stmtEstoque->fetch(PDO::FETCH_ASSOC);

                if (!$itemBanco || $itemBanco['estoque'] < $item['quantidade']) {
                    throw new \Exception("Item indisponível ou estoque insuficiente.");
                }

                // Previne erro se item['preco'] vier string formatada
                $preco = is_numeric($item['preco']) ? $item['preco'] : 0;
                $valorTotalCalculado += $preco * $item['quantidade'];
            }

            if (!isset($_SESSION['usuario_id'])) {
                throw new \Exception("Usuário não autenticado.");
            }
            $usuarioId = $_SESSION['usuario_id'];

            // Schema: id, usuario_id, total, data_pedido, status
            $sqlPedido = "INSERT INTO tbl_pedidos (id_usuario, valor_total, data_pedido, status) VALUES (:usuario_id, :total, NOW(), :status)";
            $stmtPedido = $this->db->prepare($sqlPedido);
            $stmtPedido->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
            $stmtPedido->bindParam(':total', $valorTotalCalculado);
            $stmtPedido->bindParam(':status', $status);
            $stmtPedido->execute();

            $idPedido = $this->db->lastInsertId();

            // Itens do pedido
            // Tabela: tbl_pedido_itens (pedido_id, item_id, quantidade)
            $sqlItem = "INSERT INTO tbl_pedido_itens (pedido_id, item_id, quantidade) 
                        VALUES (:pedido_id, :item_id, :quantidade)";
            $stmtItem = $this->db->prepare($sqlItem);

            foreach ($itensCarrinho as $item) {
                // Suporta id_item (padrão) ou id (legado)
                $id_item = $item['id_item'] ?? $item['id'];
                $stmtItem->bindParam(':pedido_id', $idPedido, PDO::PARAM_INT);
                $stmtItem->bindParam(':item_id', $id_item, PDO::PARAM_INT);
                $stmtItem->bindParam(':quantidade', $item['quantidade'], PDO::PARAM_INT);
                $stmtItem->execute();
            }

            $this->db->commit();
            return (int) $idPedido;

        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Erro ao criar pedido: " . $e->getMessage());
            return false;
        }
    }

    function buscarPedidosPorData($data_pedido)
    {
        $sql = "SELECT * FROM tbl_pedidos where DATE(data_pedido) = :data";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_pedido);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarPedidosPorID($id)
    {
        $sql = "SELECT * FROM tbl_pedidos where id_pedidos = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // O erro estava aqui: coluna id_usuario não existe, é usuario_id
    function buscarPedidosPorIDUsuario($usuario_id)
    {
        // Corrigido para id_usuario e adicionado busca de itens
        $sql = "SELECT * FROM tbl_pedidos where id_usuario = :usuario_id ORDER BY data_pedido DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($pedidos as &$pedido) {
            // Busca os itens deste pedido (Joined with Item details)
            $sqlItens = "SELECT i.id_item, i.titulo_item, i.foto_item, pi.quantidade 
                         FROM tbl_pedido_itens pi 
                         JOIN tbl_itens i ON pi.item_id = i.id_item 
                         WHERE pi.pedido_id = :pedido_id";

            $stmtItens = $this->db->prepare($sqlItens);
            $stmtItens->bindValue(':pedido_id', $pedido['id_pedidos']);
            $stmtItens->execute();
            $itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

            // Corrige caminho da imagem
            foreach ($itens as &$item) {
                $item['foto_item'] = \Sebo\Alfarrabio\Models\Item::corrigirCaminhoImagem($item['foto_item']);
            }

            $pedido['itens'] = $itens;
        }

        return $pedidos;
    }

    function inserirPedidos($usuario_id, $total, $data_pedido, $status)
    {
        $sql = "INSERT INTO tbl_pedidos (id_usuario, valor_total, data_pedido, status) 
                VALUES (:usuario_id, :total, :data, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':data', $data_pedido);
        $stmt->bindParam(':status', $status);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    function atualizarPedidos($id, $data_pedido, $status, $total)
    {
        // Se a tabela tiver data_atualizacao com ON UPDATE CURRENT_TIMESTAMP, não precisa atualizar manual
        // Mas vamos manter compatível
        $sql = "UPDATE tbl_pedidos SET 
            data_pedido = :data,
            status = :status,
            valor_total = :total
            WHERE id_pedidos = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':data', $data_pedido, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':total', $total);

        return $stmt->execute();
    }

    // Soft delete? A estrutura mostrou 'excluido_em'? Não vi na estrutura acima (dump).
    // O dump mostrou: id, usuario_id, total, data_pedido, status, observacao, data_cadastro, data_atualizacao
    // NÃO TEM excluido_em no dump!
    // Então Excluir deve ser DELETE mesmo ou precisamos adicionar a coluna.
    // Vou mudar para DELETE real para evitar erro 'Column not found: excluido_em'
    function excluirPedidos($id)
    {
        $sql = "DELETE FROM tbl_pedidos WHERE id_pedidos = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Sem coluna excluido_em, não dá pra reativar. Método removido ou deixado vazio.
    function ativarPedidos($id)
    {
        return false;
    }
}