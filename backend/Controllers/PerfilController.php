<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Perfil;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\PerfilValidador;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Core\ImageOptimizer;
use Sebo\Alfarrabio\Core\Session;


class PerfilController
{
    public $perfil;
    public $db;
    public $gerenciarImagem;
    public $otimizador;

    private const TIPOS_IMAGEM = ['image/jpeg', 'image/png', 'image/webp'];

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->perfil = new Perfil($this->db);
        // Usar caminho absoluto para evitar confusão entre root/uploads e backend/uploads
        $diretorioUploads = dirname(__DIR__) . '/uploads';
        $this->gerenciarImagem = new FileManager($diretorioUploads);
        $this->otimizador = new ImageOptimizer(800, 80);
    }

    // index

    /**
     * Renderiza a listagem de perfis.
     */
    public function index()
    {
        $this->viewListarperfil();
    }
    /**
     * Renderiza a listagem de perfis de usuário.
     */
    public function viewListarperfil()
    {
        $dados = $this->perfil->buscarPerfil();
        $total_perfil = $this->perfil->totalDePerfil();
        $total_inativos = $this->perfil->totalDePerfilInativos();
        $total_ativos = $this->perfil->totalDePerfilAtivos();

        View::render(
            "perfil/index",
            [
                "perfil" => $dados,
                "total_perfil" => $total_perfil[0],
                "total_inativos" => $total_inativos[0],
                "total_ativos" => $total_ativos[0]
            ]
        );
    }

    /**
     * Renderiza o formulário de criação de perfil.
     */
    public function viewCriarPerfil()
    {
        View::render("perfil/create", []);
    }

    /**
     * Renderiza o formulário de edição de perfil.
     * @param int $id_perfil_usuario
     */
    public function viewEditarPerfil($id_perfil_usuario)
    {
        $dados = $this->perfil->buscarPerfilPorID($id_perfil_usuario);
        foreach ($dados as $perfil) {
            $dados = $perfil;
        }
        View::render("perfil/edit", ["perfil" => $dados]);
    }

    /**
     * Renderiza a confirmação de exclusão de perfil.
     */
    public function viewExcluirPerfil($id_perfil_usuario)
    {
        View::render("perfil/delete", ["id_perfil_usuario" => $id_perfil_usuario]);
    }

    /**
     * Gera relatório de perfil.
     */
    public function relatorioPerfil($id_perfil_usuario, $data1, $data2)
    {
        View::render(
            "perfil/relatorio",
            ["id" => $id_perfil_usuario, "data1" => $data1, "data2" => $data2]
        );
    }


    /**
     * Salva um novo perfil com upload de foto WebP.
     */
    public function salvarPerfil()
    {
        $session = new Session();
        $usuarioId = $session->get('usuario_id');

        $telefone = $_POST['telefone_usuario'] ?? '';
        $endereco = $_POST['endereco_usuario'] ?? '';
        $foto = '';

        if (!empty($_FILES['foto_usuario']['name'])) {
            try {
                $caminhoRelativo = $this->gerenciarImagem->salvarArquivo(
                    $_FILES['foto_usuario'],
                    'perfis',
                    self::TIPOS_IMAGEM
                );
                // Otimizar: redimensionar e converter para WebP
                $baseDir = dirname(__DIR__); // Pasta 'backend'
                $caminhoAbsoluto = $baseDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $caminhoRelativo);
                $this->otimizador->otimizar($caminhoAbsoluto);

                // Caminho relativo para o navegador (sempre com barras para frente)
                $infoArquivo = pathinfo($caminhoRelativo);
                $foto = '/backend/uploads/' . str_replace('\\', '/', $infoArquivo['dirname']) . '/' . $infoArquivo['filename'] . '.webp';
            } catch (\Exception $e) {
                Redirect::redirecionarComMensagem("/backend/perfil/criar", "error", "Erro no upload: " . $e->getMessage());
                return;
            }
        }

        if ($this->perfil->inserirPerfil($usuarioId, $telefone, $endereco, $foto)) {
            Redirect::redirecionarComMensagem("/backend/perfil/listar", "success", "Perfil criado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/backend/perfil/criar", "error", "Erro ao criar perfil.");
        }
    }

    /**
     * Atualiza os dados do perfil, incluindo upload de nova foto.
     */
    public function atualizarPerfil()
    {
        $id = (int) $_POST['id_perfil_usuario'];
        $telefone = $_POST['telefone_usuario'];
        $endereco = $_POST['endereco_usuario'];

        // Upload de foto (se houver)
        $foto_atual = $_POST['foto_atual'] ?? '';
        $foto = $foto_atual;

        if (!empty($_FILES['foto_usuario']['name'])) {
            $caminhoRelativo = $this->gerenciarImagem->salvarArquivo(
                $_FILES['foto_usuario'],
                'perfis',
                self::TIPOS_IMAGEM
            );
            // Otimizar: redimensionar e converter para WebP
            $baseDir = dirname(__DIR__); // Pasta 'backend'
            $caminhoAbsoluto = $baseDir . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $caminhoRelativo);
            $this->otimizador->otimizar($caminhoAbsoluto);

            $infoArquivo = pathinfo($caminhoRelativo);
            $foto = '/backend/uploads/' . str_replace('\\', '/', $infoArquivo['dirname']) . '/' . $infoArquivo['filename'] . '.webp';
            // Deletar foto antiga se existir
            if (!empty($foto_atual)) {
                $this->gerenciarImagem->delete($foto_atual);
            }
        }

        if ($this->perfil->atualizarPerfil($id, $telefone, $endereco, $foto)) {
            Redirect::redirecionarComMensagem("/perfil/listar", "success", "Perfil atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/perfil/editar/" . $id, "error", "Erro ao atualizar perfil.");
        }
    }

    public function deletarPerfil()
    {
        $id = (int) $_POST['id_perfil_usuario'];

        if ($this->perfil->excluirPerfil($id)) {
            Redirect::redirecionarComMensagem("/perfil/listar", "success", "Perfil excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/perfil/listar", "error", "Erro ao excluir perfil.");
        }
    }

}