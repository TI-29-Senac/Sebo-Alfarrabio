<?php
namespace Sebo\Alfarrabio\Models;
use PDO;

/**
 * Model para gerenciar a tabela tbl_generos
 * Schema Remoto: id_generos, nome_generos, excluido_em
 */
class Genero
{
    private $id_generos;
    private $nome_generos;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // --- MÉTODOS DE LEITURA (READ) ---

    function buscarGeneros()
    {
        $sql = "SELECT * FROM tbl_generos WHERE excluido_em IS NULL ORDER BY nome_generos ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarGenerosInativos()
    {
        $sql = "SELECT * FROM tbl_generos WHERE excluido_em IS NOT NULL ORDER BY nome_generos ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarGeneroPorID(int $id)
    {
        $sql = "SELECT * FROM tbl_generos WHERE id_generos = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function buscarGenerosPorNome(string $termo, int $limite = 10)
    {
        $sql = "SELECT id_generos, nome_generos FROM tbl_generos 
                WHERE nome_generos LIKE :termo AND excluido_em IS NULL 
                ORDER BY nome_generos ASC 
                LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $termoLike = '%' . $termo . '%';
        $stmt->bindParam(':termo', $termoLike);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // --- MÉTODOS DE CONTAGEM (STATS) ---

    function totalDeGeneros()
    {
        $sql = "SELECT count(*) as total FROM tbl_generos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    function totalDeGenerosInativos()
    {
        $sql = "SELECT count(*) as total FROM tbl_generos WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    function totalDeGenerosAtivos()
    {
        $sql = "SELECT count(*) as total FROM tbl_generos WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    // --- MÉTODOS DE PAGINAÇÃO ---

    public function paginacao(int $pagina = 1, int $por_pagina = 10): array
    {
        $totalQuery = "SELECT COUNT(*) FROM `tbl_generos`";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();

        $offset = ($pagina - 1) * $por_pagina;

        $dataQuery = "SELECT * FROM `tbl_generos` ORDER BY nome_generos ASC LIMIT :limit OFFSET :offset";
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

    // --- MÉTODOS DE ESCRITA ---

    function inserirGenero(string $nome)
    {
        $sql = "INSERT INTO tbl_generos (nome_generos) VALUES (:nome)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    function atualizarGenero(int $id, string $nome)
    {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_generos SET 
                  nome_generos = :nome,
                  atualizado_em = :atual
                WHERE id_generos = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':atual', $dataatual);

        return $stmt->execute();
    }

    function excluirGenero(int $id)
    {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_generos SET
                  excluido_em = :atual
                WHERE id_generos = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':atual', $dataatual);

        return $stmt->execute();
    }

    function ativarGenero(int $id)
    {
        $sql = "UPDATE tbl_generos SET
                  excluido_em = NULL
                WHERE id_generos = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}