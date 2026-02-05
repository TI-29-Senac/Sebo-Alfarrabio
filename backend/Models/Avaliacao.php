<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
use PDOException;

class Avaliacao
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    /**
     * Busca todas as avaliações ativas.
     */
    function buscarAvaliacao()
    {
        $sql = "SELECT * FROM tbl_avaliacao WHERE excluido_em IS NULL ORDER BY id_avaliacao DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Conta o total de avaliações no sistema.
     */
    function totalDeAvaliacao()
    {
        $sql = "SELECT COUNT(*) FROM tbl_avaliacao";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }

    /**
     * Conta avaliações inativas (excluídas).
     */
    function totalDeAvaliacaoInativos()
    {
        $sql = "SELECT COUNT(*) FROM tbl_avaliacao WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }

    /**
     * Conta avaliações ativas.
     */
    function totalDeAvaliacaoAtivos()
    {
        $sql = "SELECT COUNT(*) FROM tbl_avaliacao WHERE excluido_em IS NULL";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }

    /**
     * Busca avaliação por ID.
     * @param int $id_avaliacao
     */
    function buscarAvaliacaoPorID($id_avaliacao)
    {
        $sql = "SELECT * FROM tbl_avaliacao WHERE id_avaliacao = :id AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_avaliacao, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Single row
    }

    /**
     * Busca avaliações por nota.
     * @param int $nota_avaliacao
     */
    function buscarAvaliacaoPorNota($nota_avaliacao)
    {
        $sql = "SELECT * FROM tbl_avaliacao WHERE nota_avaliacao = :nota AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nota', $nota_avaliacao);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarAvaliacaoPorComentario($comentario_avaliacao)
    {
        $sql = "SELECT * FROM tbl_avaliacao WHERE comentario_avaliacao LIKE :comentario AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':comentario', "%$comentario_avaliacao%");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarAvaliacaoPorData($data_avaliacao)
    {
        $sql = "SELECT * FROM tbl_avaliacao WHERE data_avaliacao = :data AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_avaliacao);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca por status.
     * @param string $status_avaliacao
     */
    function buscarAvaliacaoPorStatus($status_avaliacao)
    {
        $sql = "SELECT * FROM tbl_avaliacao WHERE status_avaliacao = :status AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status', $status_avaliacao);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===== CREATE =====

    /**
     * Insere nova avaliação.
     */
    function inserirAvaliacao($id_item, $id_usuario, $nota_avaliacao, $comentario_avaliacao = null, $data_avaliacao = null, $status_avaliacao = 'ativo')
    {
        // Validação básica (alinhada com DB: nota 1-5, FKs required)
        if (!is_numeric($nota_avaliacao) || $nota_avaliacao < 1 || $nota_avaliacao > 5) {
            error_log("ERRO: Nota inválida: {$nota_avaliacao} (deve ser 1-5)");
            return false;
        }
        if (empty($id_item) || !is_numeric($id_item) || empty($id_usuario) || !is_numeric($id_usuario)) {
            error_log("ERRO: ID item/usuario obrigatório e numérico");
            return false;
        }
        $data_avaliacao = $data_avaliacao ?: date('Y-m-d');  // Default hoje

        $sql = "INSERT INTO tbl_avaliacao (id_item, id_usuario, nota_avaliacao, comentario_avaliacao, data_avaliacao, status_avaliacao, criado_em) 
                VALUES (:id_item, :id_usuario, :nota, :comentario, :data, :status, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_item', $id_item, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':nota', $nota_avaliacao, PDO::PARAM_INT);  // Assuma INT no DB
        $stmt->bindParam(':comentario', $comentario_avaliacao);
        $stmt->bindParam(':data', $data_avaliacao);
        $stmt->bindParam(':status', $status_avaliacao);

        try {
            if ($stmt->execute()) {
                $id = $this->db->lastInsertId();
                error_log("✅ Avaliação #{$id} inserida (item #{$id_item}, user #{$id_usuario})");
                return $id;  // Novo ID
            }
            error_log("❌ INSERT falhou (rowCount=0)");
            return false;
        } catch (PDOException $e) {
            error_log("❌ ERRO PDO INSERT: " . $e->getMessage() . " (Code: " . $e->getCode() . ")");
            return false;
        }
    }

    // ===== UPDATE =====

    /**
     * Atualiza avaliação existente.
     */
    public function atualizarAvaliacao($id_avaliacao, $nota_avaliacao, $comentario_avaliacao, $data_avaliacao, $status_avaliacao)
    {
        // Validação nota
        if (!is_numeric($nota_avaliacao) || $nota_avaliacao < 1 || $nota_avaliacao > 5) {
            error_log("ERRO: Nota inválida na update: {$nota_avaliacao}");
            return false;
        }

        $sql = "UPDATE tbl_avaliacao SET 
                nota_avaliacao = :nota, 
                comentario_avaliacao = :comentario,
                data_avaliacao = :data,
                status_avaliacao = :status, 
                atualizado_em = NOW()
                WHERE id_avaliacao = :id AND excluido_em IS NULL";  // Safe: só ativos

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_avaliacao, PDO::PARAM_INT);
        $stmt->bindParam(':nota', $nota_avaliacao, PDO::PARAM_INT);
        $stmt->bindParam(':comentario', $comentario_avaliacao);
        $stmt->bindParam(':data', $data_avaliacao);
        $stmt->bindParam(':status', $status_avaliacao);

        try {
            if ($stmt->execute() && $stmt->rowCount() > 0) {
                error_log("✅ Avaliação #{$id_avaliacao} atualizada");
                return true;
            }
            error_log("⚠️ Nenhuma linha afetada na update (não existe ou inativa?)");
            return false;
        } catch (PDOException $e) {
            error_log("❌ ERRO PDO UPDATE: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Realiza soft delete da avaliação.
     */
    public function deletarAvaliacao($id_avaliacao)
    {
        $sql = "UPDATE tbl_avaliacao SET excluido_em = NOW(), status_avaliacao = 'inativo' WHERE id_avaliacao = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_avaliacao, PDO::PARAM_INT);
        try {
            return $stmt->execute() && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("ERRO DELETE: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Reativa avaliação excluída.
     */
    public function ativarAvaliacao($id_avaliacao)
    {
        $sql = "UPDATE tbl_avaliacao SET excluido_em = NULL, status_avaliacao = 'ativo', atualizado_em = NOW() WHERE id_avaliacao = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_avaliacao, PDO::PARAM_INT);
        try {
            return $stmt->execute() && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("ERRO ATIVAR: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca todas as avaliações feitas por um usuário específico
     * Retorna dados da avaliação junto com informações do item avaliado
     */
    function buscarAvaliacoesPorIDUsuario($id_usuario)
    {
        $sql = "SELECT 
                    a.id_avaliacao,
                    a.id_item,
                    a.id_usuario,
                    a.nota_avaliacao,
                    a.comentario_avaliacao,
                    a.data_avaliacao,
                    a.status_avaliacao,
                    i.titulo_item,
                    i.foto_item,
                    i.preco_item
                FROM tbl_avaliacao a
                LEFT JOIN tbl_itens i ON a.id_item = i.id_item
                WHERE a.id_usuario = :id_usuario AND a.excluido_em IS NULL
                ORDER BY a.data_avaliacao DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Conta total de avaliações feitas por um usuário
     */
    function totalDeAvaliacaoPorUsuario($id_usuario)
    {
        $sql = "SELECT COUNT(*) FROM tbl_avaliacao WHERE id_usuario = :id_usuario AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Verifica se um item já foi avaliado por um usuário específico
     * @return bool true se já existe avaliação ativa
     */
    function verificarSeItemJaAvaliado($id_usuario, $id_item)
    {
        $sql = "SELECT COUNT(*) FROM tbl_avaliacao 
                WHERE id_usuario = :id_usuario 
                AND id_item = :id_item 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_item', $id_item, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Retorna array com IDs de todos os itens já avaliados por um usuário
     * Útil para verificar múltiplos itens de uma vez
     */
    function buscarItensAvaliadosPorUsuario($id_usuario)
    {
        $sql = "SELECT id_item FROM tbl_avaliacao 
                WHERE id_usuario = :id_usuario 
                AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);  // Retorna array simples [id1, id2, ...]
    }
}