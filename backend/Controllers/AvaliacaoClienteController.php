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

<<<<<<< HEAD
=======
            // Verifica se o usuário possui reserva com status 'Reservado' para este item
            if (!$this->avaliacaoModel->verificarReservaConfirmada($usuarioId, $idItem)) {
                http_response_code(403); // Forbidden
                echo json_encode([
                    'success' => false,
                    'message' => "Você só pode avaliar itens com reservas no status 'reservado'."
                ]);
                return;
            }

            // Processa Upload de Imagem
            // Processa Upload de Imagens (Múltiplo)
            $caminhosFotos = [];

            // Check if files exist and structure is array
            if (isset($_FILES['fotos_avaliacao'])) {
                $files = $_FILES['fotos_avaliacao'];
                $count = is_array($files['name']) ? count($files['name']) : 0;

                // Validação: máximo 5 fotos por avaliação
                if ($count > 5) {
                    http_response_code(400);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Você pode enviar no máximo 5 imagens por avaliação.'
                    ]);
                    return;
                }

                if ($count > 0) {
                    // Tipos de imagem permitidos e tamanho máximo (5MB)
                    $tiposImagem = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    $tamanhoMax = 5 * 1024 * 1024; // 5MB

                    // Reorganize $_FILES array for cleaner iteration
                    for ($i = 0; $i < $count; $i++) {
                        if ($files['error'][$i] === UPLOAD_ERR_OK) {
                            $fileItem = [
                                'name' => $files['name'][$i],
                                'type' => $files['type'][$i],
                                'tmp_name' => $files['tmp_name'][$i],
                                'error' => $files['error'][$i],
                                'size' => $files['size'][$i]
                            ];

                            try {
                                $nomeArquivo = $this->fileManager->salvarArquivo($fileItem, 'avaliacoes', $tiposImagem, $tamanhoMax);
                                $caminhosFotos[] = '/backend/uploads/' . $nomeArquivo;
                            } catch (\Exception $e) {
                                error_log("Erro no upload múltiplo ($i): " . $e->getMessage());
                                http_response_code(400);
                                echo json_encode([
                                    'success' => false,
                                    'message' => 'Erro no upload da imagem: ' . $e->getMessage()
                                ]);
                                return;
                            }
                        }
                    }
                }
            }

>>>>>>> 88f33ccca9a60de74d6c207e9a47fee21676363c
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

    public function atualizarAvaliacao()
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $usuarioId = $this->session->get('usuario_id');
            if (!$usuarioId) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Login necessário']);
                return;
            }

            // Usa $_POST diretamente (filter_input pode falhar com FormData)
            $id = isset($_POST['id_avaliacao']) ? intval($_POST['id_avaliacao']) : 0;
            $nota = isset($_POST['nota']) ? intval($_POST['nota']) : 0;
            $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : '';

            error_log("[ATUALIZAR] id=$id, nota=$nota, comentario=$comentario, user=$usuarioId");

            if (!$id || $nota < 1 || $nota > 5) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Dados inválidos. Nota deve ser de 1 a 5.']);
                return;
            }

            if (strlen($comentario) > 500) {
                $comentario = substr($comentario, 0, 500);
            }

            $av = $this->avaliacaoModel->buscarAvaliacaoPorID($id);
            if (!$av) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Avaliação não encontrada']);
                return;
            }

            if ($av['id_usuario'] != $usuarioId) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Permissão negada']);
                return;
            }

<<<<<<< HEAD
=======
            // Processa Upload de Imagem (se houver nova)
            // Processa Upload de Imagens (Múltiplo)
            $caminhosFotos = [];

            if (isset($_FILES['fotos_avaliacao'])) {
                $files = $_FILES['fotos_avaliacao'];
                $count = is_array($files['name']) ? count($files['name']) : 0;

                // Verifica quantidade total de fotos (existentes + novas)
                $fotosExistentes = $this->avaliacaoModel->buscarFotosAvaliacao($id);
                $totalFotos = count($fotosExistentes) + $count;

                if ($totalFotos > 5) {
                    http_response_code(400);
                    echo json_encode([
                        'success' => false,
                        'message' => "Limite de 5 fotos atingido. Você já tem " . count($fotosExistentes) . " foto(s)."
                    ]);
                    return;
                }

                if ($count > 0) {
                    // Tipos de imagem permitidos e tamanho máximo (5MB)
                    $tiposImagem = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    $tamanhoMax = 5 * 1024 * 1024; // 5MB

                    for ($i = 0; $i < $count; $i++) {
                        if ($files['error'][$i] === UPLOAD_ERR_OK) {
                            $fileItem = [
                                'name' => $files['name'][$i],
                                'type' => $files['type'][$i],
                                'tmp_name' => $files['tmp_name'][$i],
                                'error' => $files['error'][$i],
                                'size' => $files['size'][$i]
                            ];

                            try {
                                $nomeArquivo = $this->fileManager->salvarArquivo($fileItem, 'avaliacoes', $tiposImagem, $tamanhoMax);
                                $caminhosFotos[] = '/backend/uploads/' . $nomeArquivo;
                            } catch (\Exception $e) {
                                error_log("Erro no upload update ($i): " . $e->getMessage());
                                http_response_code(400);
                                echo json_encode([
                                    'success' => false,
                                    'message' => 'Erro no upload da imagem: ' . $e->getMessage()
                                ]);
                                return;
                            }
                        }
                    }
                }
            }

>>>>>>> 88f33ccca9a60de74d6c207e9a47fee21676363c
            $resultado = $this->avaliacaoModel->atualizarAvaliacao(
                $id,
                $nota,
                $comentario ?: null,
                $av['data_avaliacao'],
                $av['status_avaliacao']
            );

            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Avaliação atualizada com sucesso!']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Erro ao atualizar avaliação no banco.']);
            }

        } catch (\Exception $e) {
            error_log("Erro atualizarAvaliacao: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erro interno do servidor.']);
        }
    }

    public function deletarAvaliacao()
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $usuarioId = $this->session->get('usuario_id');
            if (!$usuarioId) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Login necessário']);
                return;
            }

            // Usa $_POST diretamente (filter_input pode falhar com FormData)
            $id = isset($_POST['id_avaliacao']) ? intval($_POST['id_avaliacao']) : 0;

            error_log("[DELETAR] id=$id, user=$usuarioId");

            if (!$id) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'ID da avaliação inválido.']);
                return;
            }

            $av = $this->avaliacaoModel->buscarAvaliacaoPorID($id);
            if (!$av) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Avaliação não encontrada']);
                return;
            }

            if ($av['id_usuario'] != $usuarioId) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Permissão negada']);
                return;
            }

            if ($this->avaliacaoModel->deletarAvaliacao($id)) {
                echo json_encode(['success' => true, 'message' => 'Avaliação excluída com sucesso.']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Erro ao excluir avaliação no banco.']);
            }

        } catch (\Exception $e) {
            error_log("Erro deletarAvaliacao: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erro interno do servidor.']);
        }
    }
}
