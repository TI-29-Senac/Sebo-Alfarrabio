<?php
namespace Sebo\Alfarrabio\Models;
use PDO;

class Vendas
{
    private $id_venda;
    private $id_usuario;
    private $data_venda;
    private $valor_total;
    private $forma_pagamento;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // ===== MÉTODOS DE LEITURA (READ) =====

    function buscarVendas()
    {
        $sql = "SELECT * FROM tbl_vendas WHERE excluido_em IS NULL ORDER BY data_venda ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function totalDeVendas()
    {
        $sql = "SELECT count(*) as total FROM tbl_vendas";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    function totalDeVendasInativos()
    {
        $sql = "SELECT count(*) as total_inativos FROM tbl_vendas WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    function totalDeVendasAtivos()
    {
        $sql = "SELECT count(*) as total_ativos FROM tbl_vendas WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    function buscarVendasPorData($data_venda)
    {
        $sql = "SELECT * FROM tbl_vendas WHERE data_venda = :data AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_venda);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarVendasPorID($id_venda)
    {
        $sql = "SELECT * FROM tbl_vendas WHERE id_vendas = :id_vendas";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_vendas', $id_venda, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debug log
        error_log("buscarVendasPorID({$id_venda}): " . print_r($resultado, true));

        return $resultado;
    }

    function buscarVendasPorIDUsuario($id_usuario)
    {
        $sql = "SELECT * FROM tbl_vendas WHERE id_usuario = :id_usuario AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===== MÉTODOS DE ESCRITA (CREATE) =====

    function inserirVenda($id_usuario, $data_venda, $valor_total, $forma_pagamento)
    {
        $sql = "INSERT INTO tbl_vendas (id_usuario, data_venda, valor_total, forma_pagamento, criado_em, atualizado_em) 
            VALUES (:id_usuario, :data, :valort, :fpagamento, NOW(), NOW())";  // ← Adicione timestamps automáticos

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':data', $data_venda);  // Formato: 'YYYY-MM-DD'
        $stmt->bindParam(':valort', $valor_total, PDO::PARAM_STR);  // ← Bind completo: valor como string pra decimais (ex: '120.00')
        $stmt->bindParam(':fpagamento', $forma_pagamento, PDO::PARAM_STR);

        try {
            $stmt->execute();
            return $this->db->lastInsertId();  // ← Retorna o ID novo (int), não boolean
        } catch (PDOException $e) {
            error_log("Erro ao inserir venda: " . $e->getMessage());
            return false;
        }
    }

    // ===== MÉTODOS DE ATUALIZAÇÃO (UPDATE) =====

    function atualizarVenda($id_venda, $data_venda, $valor_total, $forma_pagamento)
    {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_vendas SET 
                data_venda = :data,
                valor_total = :valort, 
                forma_pagamento = :fpagamento,
                atualizado_em = :atual
                WHERE id_vendas = :id_vendas";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_vendas', $id_venda, PDO::PARAM_INT);
        $stmt->bindParam(':data', $data_venda);
        $stmt->bindParam(':valort', $valor_total);
        $stmt->bindParam(':fpagamento', $forma_pagamento);
        $stmt->bindParam(':atual', $dataatual);

        return $stmt->execute();
    }

    // ===== MÉTODOS DE EXCLUSÃO (SOFT DELETE) =====

    function excluirVenda($id_venda)
    {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_vendas SET
                excluido_em = :atual
                WHERE id_vendas = :id_vendas";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_vendas', $id_venda, PDO::PARAM_INT);
        $stmt->bindParam(':atual', $dataatual);

        return $stmt->execute();
    }

    function ativarVenda($id_venda)
    {
        $sql = "UPDATE tbl_vendas SET
                excluido_em = NULL,
                atualizado_em = NOW()
                WHERE id_vendas = :id_vendas";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_vendas', $id_venda, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // ===== MÉTODOS EXTRAS =====

    function calcularTotalVendasPeriodo($data_inicio, $data_fim)
    {
        $sql = "SELECT SUM(valor_total) as total 
                FROM tbl_vendas 
                WHERE data_venda BETWEEN :inicio AND :fim 
                AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':inicio', $data_inicio);
        $stmt->bindParam(':fim', $data_fim);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_COLUMN) ?? 0;
    }

    function paginacao(int $pagina = 1, int $por_pagina = 10): array
    {
        $totalQuery = "SELECT COUNT(*) FROM tbl_vendas WHERE excluido_em IS NULL";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();

        $offset = ($pagina - 1) * $por_pagina;

        $dataQuery = "SELECT * FROM tbl_vendas 
                      WHERE excluido_em IS NULL 
                      ORDER BY data_venda ASC
                      LIMIT :limit OFFSET :offset";

        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();
        $dados = $dataStmt->fetchAll(PDO::FETCH_ASSOC);

        $lastPage = ceil($total_de_registros / $por_pagina);

        return [
            'data' => $dados,
            'total' => (int) $total_de_registros,
            'por_pagina' => (int) $por_pagina,
            'pagina_atual' => (int) $pagina,
            'ultima_pagina' => (int) $lastPage,
            'de' => $offset + 1,
            'para' => $offset + count($dados)
        ];
    }
}
