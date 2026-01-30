<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Autor;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\AutorValidador;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Controllers\Admin\AdminController;

class AutorController extends AdminController
{
    private $autor;
    private $db;
    private $gerenciarImagem;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->autor = new Autor($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    // --- CRIAR (CREATE) ---
    public function salvarAutor()
    {
        $erros = AutorValidador::validarEntradas($_POST);

        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("/backend/autor/criar", "error", implode(", ", $erros));
        }

        $nome = $_POST['nome_autor'] ?? '';
        $biografia = $_POST['biografia'] ?? '';

        if ($this->autor->inserirAutor($nome, $biografia)) {
            Redirect::redirecionarComMensagem("/backend/autor/listar", "success", "Autor cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/backend/autor/criar", "error", "Erro ao cadastrar autor.");
        }
    }

    // --- LER (READ) ---
    public function index()
    {
        $resultado = $this->autor->buscarAutores();
        var_dump($resultado);
    }

    public function viewListarAutor()
    {
        $dados = $this->autor->buscarAutores();
        $total = $this->autor->totalDeAutores();
        $total_inativos = $this->autor->totalDeAutoresInativos();
        $total_ativos = $this->autor->totalDeAutoresAtivos();

        View::render("autor/index", [
            "autores" => $dados,
            "total_autores" => $total,
            "total_inativos" => $total_inativos,
            "total_ativos" => $total_ativos
        ]);
    }

    public function viewCriarAutor()
    {
        View::render("autor/create", []);
    }

    public function viewEditarAutor($id_autor)
    {
        $dados = $this->autor->buscarAutorPorID($id_autor);

        if (!$dados) {
            Redirect::redirecionarComMensagem("/backend/autor/listar", "error", "Autor não encontrado.");
        }

        View::render("autor/edit", ["autor" => $dados]);
    }

    public function viewExcluirAutor($id_autor)
    {
        View::render("autor/delete", ["id_autor" => $id_autor]);
    }

    public function relatorioAutor($id_autor, $data1, $data2)
    {
        View::render("autor/relatorio", [
            "id" => $id_autor,
            "data1" => $data1,
            "data2" => $data2
        ]);
    }

    // --- 🔍 BUSCAR POR NOME (AJAX / AUTOCOMPLETE) ---
    public function buscarAutoresPorNome()
    {
        $termo = $_GET['q'] ?? ''; // Exemplo: /autor/buscar?q=Machado
        $limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 10;

        if (empty($termo)) {
            echo json_encode([]);
            return;
        }

        $resultado = $this->autor->buscarAutoresPorNome($termo, $limite);

        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    // --- ATUALIZAR (UPDATE) ---
    public function atualizarAutor()
    {
        $id = $_POST['id_autor'] ?? null;
        $nome = $_POST['nome_autor'] ?? '';
        $biografia = $_POST['biografia'] ?? '';

        if (!$id) {
            Redirect::redirecionarComMensagem("/backend/autor/listar", "error", "ID do autor não informado.");
        }

        $erros = AutorValidador::validarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("/backend/autor/editar/$id", "error", implode(", ", $erros));
        }

        if ($this->autor->atualizarAutor($id, $nome, $biografia)) {
            Redirect::redirecionarComMensagem("/backend/autor/listar", "success", "Autor atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("backend/autor/editar/$id", "error", "Erro ao atualizar o autor.");
        }
    }

    // --- EXCLUIR (SOFT DELETE) ---
    public function deletarAutor()
    {
        $id = $_POST['id_autor'] ?? null;

        if (!$id) {
            Redirect::redirecionarComMensagem("/backend/autor/listar", "error", "ID do autor não informado.");
        }

        if ($this->autor->excluirAutor($id)) {
            Redirect::redirecionarComMensagem("/backend/autor/listar", "success", "Autor excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/backend/autor/listar", "error", "Erro ao excluir autor.");
        }
    }


}