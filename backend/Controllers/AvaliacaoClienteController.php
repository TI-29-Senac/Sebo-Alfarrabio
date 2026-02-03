<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Avaliacao;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\Session;

/**
 * Controller para gerenciar avaliações do cliente via AJAX
 */
class AvaliacaoClienteController
{
    private $db;
    private $avaliacaoModel;
    private $session;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->avaliacaoModel = new Avaliacao($this->db);
        $this->session = new Session();
    }

    /**
     * Salvar nova avaliação via AJAX
     * Espera POST com: id_item, nota, comentario (opcional)
     */
    public function salvarAvaliacao()
    {
        // Define header JSON
        header('Content-Type: application/json; charset=utf-8');

        try {
            // Verifica se usuário está logado
            $usuarioId = $this->session->get('usuario_id');
            if (!$usuarioId) {
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'message' => 'Usuário não autenticado. Faça login para avaliar.'
                ]);
                return;
            }

            // Obtém dados do POST
            $idItem = filter_input(INPUT_POST, 'id_item', FILTER_VALIDATE_INT);
            $nota = filter_input(INPUT_POST, 'nota', FILTER_VALIDATE_INT);
            $comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_SPECIAL_CHARS);

            // Validação: ID do item obrigatório
            if (!$idItem) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'ID do item é obrigatório.'
                ]);
                return;
            }

            // Validação: Nota obrigatória e entre 1-5
            if (!$nota || $nota < 1 || $nota > 5) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Selecione uma nota de 1 a 5 estrelas.'
                ]);
                return;
            }

            // Validação: Comentário máximo 500 caracteres
            if ($comentario && strlen($comentario) > 500) {
                $comentario = substr($comentario, 0, 500);
            }

            // Verifica se item já foi avaliado por este usuário
            if ($this->avaliacaoModel->verificarSeItemJaAvaliado($usuarioId, $idItem)) {
                http_response_code(409); // Conflict
                echo json_encode([
                    'success' => false,
                    'message' => 'Você já avaliou este item.'
                ]);
                return;
            }

            // Insere avaliação
            $resultado = $this->avaliacaoModel->inserirAvaliacao(
                $idItem,
                $usuarioId,
                $nota,
                $comentario ?: null
            );

            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Avaliação enviada com sucesso!',
                    'id_avaliacao' => $resultado
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao salvar avaliação. Tente novamente.'
                ]);
            }

        } catch (\Exception $e) {
            error_log("Erro em salvarAvaliacao: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Erro interno do servidor.'
            ]);
        }
    }
}
