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
        $sql = "SELECT 
                    a.*, 
                    a.foto_avaliacao AS foto_principal,
                    GROUP_CONCAT(af.caminho_foto SEPARATOR ',') as fotos_urls
                FROM tbl_avaliacao a
                LEFT JOIN tbl_avaliacao_fotos af ON a.id_avaliacao = af.id_avaliacao
                WHERE a.excluido_em IS NULL
                GROUP BY a.id_avaliacao
                ORDER BY a.id_avaliacao DESC";
                
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
    function inserirAvaliacao($id_item, $id_usuario, $nota_avaliacao, $comentario_avaliacao = null, $data_avaliacao = null, $status_avaliacao = 'inativo', $fotos_avaliacao = [])
    {
        // Validação básica
        if (!is_numeric($nota_avaliacao) || $nota_avaliacao < 1 || $nota_avaliacao > 5) {
            return false;
        }
        $data_avaliacao = $data_avaliacao ?: date('Y-m-d');
        
        // Define main photo (first one) for backward compatibility
        $foto_principal = !empty($fotos_avaliacao[0]) ? $fotos_avaliacao[0] : null;

        $sql = "INSERT INTO tbl_avaliacao (id_item, id_usuario, nota_avaliacao, comentario_avaliacao, data_avaliacao, status_avaliacao, criado_em) 
                VALUES (:id_item, :id_usuario, :nota, :comentario, :data, :status, NOW())";
        
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_item', $id_item, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':nota', $nota_avaliacao, PDO::PARAM_INT);
            $stmt->bindParam(':comentario', $comentario_avaliacao);
            $stmt->bindParam(':data', $data_avaliacao);
            $stmt->bindParam(':status', $status_avaliacao);

            if ($stmt->execute()) {
                $id_avaliacao = $this->db->lastInsertId();
                
                // Insert multiple photos
                if (!empty($fotos_avaliacao)) {
                    $sqlFoto = "INSERT INTO tbl_avaliacao_fotos (id_avaliacao, caminho_foto) VALUES (:id_av, :caminho)";
                    $stmtFoto = $this->db->prepare($sqlFoto);
                    
                    foreach ($fotos_avaliacao as $caminho) {
                        $stmtFoto->bindParam(':id_av', $id_avaliacao, PDO::PARAM_INT);
                        $stmtFoto->bindParam(':caminho', $caminho);
                        $stmtFoto->execute();
                    }
                }
                
                $this->db->commit();
                return $id_avaliacao;
            }
            $this->db->rollBack();
            return false;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("ERRO PDO INSERT: " . $e->getMessage());
            return false;
        }
    }

    // ===== UPDATE =====

    /**
     * Atualiza avaliação existente.
     */
    public function atualizarAvaliacao($id_avaliacao, $nota_avaliacao, $comentario_avaliacao, $data_avaliacao, $status_avaliacao, $novas_fotos = [])
    {
        // Validação nota
        if (!is_numeric($nota_avaliacao) || $nota_avaliacao < 1 || $nota_avaliacao > 5) {
            return false;
        }

        $sql = "UPDATE tbl_avaliacao SET 
                nota_avaliacao = :nota, 
                comentario_avaliacao = :comentario,
                data_avaliacao = :data,
                status_avaliacao = :status,
                atualizado_em = NOW()
                WHERE id_avaliacao = :id AND excluido_em IS NULL";

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id_avaliacao, PDO::PARAM_INT);
            $stmt->bindParam(':nota', $nota_avaliacao, PDO::PARAM_INT);
            $stmt->bindParam(':comentario', $comentario_avaliacao);
            $stmt->bindParam(':data', $data_avaliacao);
            $stmt->bindParam(':status', $status_avaliacao);
            
            $result = $stmt->execute();

            // Insert new photos if any
            if (!empty($novas_fotos)) {
                $sqlFoto = "INSERT INTO tbl_avaliacao_fotos (id_avaliacao, caminho_foto) VALUES (:id_av, :caminho)";
                $stmtFoto = $this->db->prepare($sqlFoto);
                
                foreach ($novas_fotos as $caminho) {
                    $stmtFoto->bindParam(':id_av', $id_avaliacao, PDO::PARAM_INT);
                    $stmtFoto->bindParam(':caminho', $caminho);
                    $stmtFoto->execute();
                }

                // Update foto_avaliacao (single column) to be the first available photo if it was empty, or just keep it synced with latest? 
                // For simplicity, let's leave foto_avaliacao as is, or update it if it was null.
                // A better approach for the legacy column: set it to the first photo from `tbl_avaliacao_fotos` to ensure consistency.
                $sqlUpdateFoto = "UPDATE tbl_avaliacao SET foto_avaliacao = (SELECT caminho_foto FROM tbl_avaliacao_fotos WHERE id_avaliacao = :id_sub LIMIT 1) WHERE id_avaliacao = :id_where";
                $stmtUpdateFoto = $this->db->prepare($sqlUpdateFoto);
                $stmtUpdateFoto->bindParam(':id_sub', $id_avaliacao, PDO::PARAM_INT);
                $stmtUpdateFoto->bindParam(':id_where', $id_avaliacao, PDO::PARAM_INT);
                $stmtUpdateFoto->execute();
            }

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("❌ ERRO PDO UPDATE: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Realiza soft delete da avaliação.
     */
    /**
     * Inativa a avaliação.
     */
    public function deletarAvaliacao($id_avaliacao)
    {
        $sql = "UPDATE tbl_avaliacao SET status_avaliacao = 'inativo', atualizado_em = NOW() WHERE id_avaliacao = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_avaliacao, PDO::PARAM_INT);
        try {
            return $stmt->execute() && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("ERRO INATIVAR: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca fotos de uma avaliação específica.
     */
    public function buscarFotosAvaliacao($id_avaliacao)
    {
        $sql = "SELECT id_foto, caminho_foto FROM tbl_avaliacao_fotos WHERE id_avaliacao = :id ORDER BY id_foto ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_avaliacao, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Exclui uma foto específica de uma avaliação.
     * Retorna o caminho da foto excluída para remoção do disco.
     * @param int $id_foto ID do registro na tbl_avaliacao_fotos
     * @param int $id_avaliacao ID da avaliação (segurança: garante que a foto pertence à avaliação)
     * @return string|false Caminho da foto excluída, ou false em caso de erro
     */
    public function excluirFotoAvaliacao($id_foto, $id_avaliacao)
    {
        try {
            $this->db->beginTransaction();

            // Busca o caminho antes de excluir
            $sqlBusca = "SELECT caminho_foto FROM tbl_avaliacao_fotos WHERE id_foto = :id_foto AND id_avaliacao = :id_avaliacao";
            $stmtBusca = $this->db->prepare($sqlBusca);
            $stmtBusca->bindParam(':id_foto', $id_foto, PDO::PARAM_INT);
            $stmtBusca->bindParam(':id_avaliacao', $id_avaliacao, PDO::PARAM_INT);
            $stmtBusca->execute();
            $caminho = $stmtBusca->fetchColumn();

            if (!$caminho) {
                $this->db->rollBack();
                return false;
            }

            // Remove o registro da foto
            $sqlDelete = "DELETE FROM tbl_avaliacao_fotos WHERE id_foto = :id_foto AND id_avaliacao = :id_avaliacao";
            $stmtDelete = $this->db->prepare($sqlDelete);
            $stmtDelete->bindParam(':id_foto', $id_foto, PDO::PARAM_INT);
            $stmtDelete->bindParam(':id_avaliacao', $id_avaliacao, PDO::PARAM_INT);
            $stmtDelete->execute();

            // Sincroniza coluna legacy foto_avaliacao com a primeira foto restante
            $sqlSync = "UPDATE tbl_avaliacao SET foto_avaliacao = (
                SELECT caminho_foto FROM tbl_avaliacao_fotos WHERE id_avaliacao = :id_sub ORDER BY id_foto ASC LIMIT 1
            ) WHERE id_avaliacao = :id_where";
            $stmtSync = $this->db->prepare($sqlSync);
            $stmtSync->bindParam(':id_sub', $id_avaliacao, PDO::PARAM_INT);
            $stmtSync->bindParam(':id_where', $id_avaliacao, PDO::PARAM_INT);
            $stmtSync->execute();

            $this->db->commit();
            return $caminho;

        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("ERRO excluirFotoAvaliacao: " . $e->getMessage());
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
                    a.foto_avaliacao AS foto_principal,
                    GROUP_CONCAT(af.caminho_foto SEPARATOR ',') as fotos_urls,
                    a.data_avaliacao,
                    a.status_avaliacao,
                    i.titulo_item,
                    i.foto_item,
                    i.preco_item
                FROM tbl_avaliacao a
                LEFT JOIN tbl_itens i ON a.id_item = i.id_item
                LEFT JOIN tbl_avaliacao_fotos af ON a.id_avaliacao = af.id_avaliacao
                WHERE a.id_usuario = :id_usuario AND a.excluido_em IS NULL
                GROUP BY a.id_avaliacao
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

    /**
     * Verifica se o usuário tem uma reserva confirmada ('Reservado') para o item.
     */
    function verificarReservaConfirmada($id_usuario, $id_item)
    {
        $sql = "SELECT COUNT(*) FROM tbl_pedidos p
                JOIN tbl_pedido_itens pi ON p.id_pedidos = pi.pedido_id
                WHERE p.id_usuario = :id_usuario 
                AND pi.item_id = :id_item
                AND p.status = 'Reservado'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_item', $id_item, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Busca avaliações com dados relacionados (JOINs) e estatísticas
     */
    public function getAvaliacoesCompletas($limite = 10, $nota_minima = null)
    {
        $sql = "SELECT 
                    a.id_avaliacao,
                    a.nota_avaliacao,
                    a.comentario_avaliacao,
                    a.data_avaliacao,
                    a.status_avaliacao,
                    a.criado_em,
                    
                    -- Dados do usuário
                    u.id_usuario,
                    u.nome_usuario,
                    u.email_usuario,
                    pu.foto_perfil_usuario AS foto_usuario,
                    
                    -- Dados do item
                    i.id_item,
                    i.titulo_item,
                    i.descricao AS descricao_item,
                    i.preco_item,
                    i.foto_item AS imagem_item,
                    
                    -- Dados opcionais
                    c.nome_categoria,
                    g.nome_generos AS nome_genero,
                    aut.nome_autor
                    
                FROM tbl_avaliacao a
                
                LEFT JOIN tbl_usuario u ON a.id_usuario = u.id_usuario
                LEFT JOIN tbl_perfil_usuario pu ON u.id_usuario = pu.usuario_id
                LEFT JOIN tbl_itens i ON a.id_item = i.id_item
                LEFT JOIN tbl_categorias c ON i.id_categoria = c.id_categoria
                LEFT JOIN tbl_generos g ON i.id_genero = g.id_generos
                LEFT JOIN tbl_autores aut ON aut.id_autor = (SELECT ia.autor_id FROM tbl_item_autores ia WHERE ia.item_id = i.id_item LIMIT 1) 
                
                WHERE a.excluido_em IS NULL";

        if ($nota_minima !== null) {
            $sql .= " AND a.nota_avaliacao >= :nota_minima";
        }

        $sql .= " ORDER BY a.data_avaliacao DESC, a.criado_em DESC LIMIT :limite";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', (int) $limite, PDO::PARAM_INT);
        if ($nota_minima !== null) {
            $stmt->bindValue(':nota_minima', (int) $nota_minima, PDO::PARAM_INT);
        }

        $stmt->execute();
        $avaliacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Calcula estatísticas
        $total = count($avaliacoes);
        $soma_notas = 0;
        $distribuicao = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        foreach ($avaliacoes as $av) {
            $soma_notas += (int) $av['nota_avaliacao'];
            $nota = (int) $av['nota_avaliacao'];
            if (isset($distribuicao[$nota])) {
                $distribuicao[$nota]++;
            }
        }

        $media_notas = $total > 0 ? round($soma_notas / $total, 2) : 0;

        return [
            'avaliacoes' => $avaliacoes,
            'media_notas' => $media_notas,
            'distribuicao' => $distribuicao,
            'total' => $total
        ];
    }
}