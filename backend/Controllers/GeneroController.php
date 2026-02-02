<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Genero;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\GeneroValidador;
use Sebo\Alfarrabio\Core\FileManager;

class GeneroController
{
    public $id_genero;
    public $nome_genero;
    public $criado_em;
    public $atualizado_em;
    public $excluido_em;
    public $db;
    public $gerenciarImagem;
    public $genero;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->genero = new Genero($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    // --- CRIAR GÊNERO ---
    public function salvarGenero()
    {
        $erros = GeneroValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("/backend/genero/criar", "error", implode("<br>", $erros));
        }

        // Sem imagem na tabela remota
        // $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'genero');

        if ($this->genero->inserirGenero($_POST["nome_genero"])) {
            Redirect::redirecionarComMensagem("/backend/genero/listar", "success", "Gênero cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/backend/genero/criar", "error", "Erro ao cadastrar o gênero!");
        }
    }

    // --- LISTAR TODOS ---
    public function index()
    {
        $resultado = $this->genero->buscarGeneros();
        var_dump($resultado);
    }

    public function viewListarGenero()
    {
        $dados = $this->genero->buscarGeneros();
        $total = $this->genero->totalDeGeneros();
        $total_inativos = $this->genero->totalDeGenerosInativos();
        $total_ativos = $this->genero->totalDeGenerosAtivos();

        View::render("genero/index", [
            "genero" => $dados,
            "total_genero" => $total,
            "total_inativos" => $total_inativos,
            "total_ativos" => $total_ativos
        ]);
    }

    // --- PÁGINA DE CRIAÇÃO ---
    public function viewCriarGenero()
    {
        View::render("genero/create", []);
    }

    // --- EDITAR ---
    public function viewEditarGenero($id_genero)
    {
        $dados = $this->genero->buscarGeneroPorID($id_genero);
        View::render("genero/edit", ["genero" => $dados]);
    }

    // --- EXCLUIR (VIEW) ---
    public function viewExcluirGenero($id_genero)
    {
        View::render("genero/delete", ["id_genero" => $id_genero]);
    }

    // --- RELATÓRIO ---
    public function relatorioGenero($id_genero, $data1, $data2)
    {
        View::render("genero/relatorio", [
            "id" => $id_genero,
            "data1" => $data1,
            "data2" => $data2
        ]);
    }

    // --- ATUALIZAR GÊNERO ---
    public function atualizarGenero()
    {
        $id = $_POST["id_genero"];
        $nome = $_POST["nome_genero"];

        if ($this->genero->atualizarGenero($id, $nome)) {
            Redirect::redirecionarComMensagem("/backend/genero/listar", "success", "Gênero atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/backend/genero/editar/{$id}", "error", "Erro ao atualizar o gênero!");
        }
    }

    // --- DELETAR (SOFT DELETE) ---
    public function deletarGenero()
    {
        $id = $_POST["id_genero"];

        if ($this->genero->excluirGenero($id)) {
            Redirect::redirecionarComMensagem("/backend/genero/listar", "success", "Gênero excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/backend/genero/listar", "error", "Erro ao excluir o gênero!");
        }
    }

    // --- REATIVAR ---
    public function ativarGenero($id_genero)
    {
        if ($this->genero->ativarGenero($id_genero)) {
            Redirect::redirecionarComMensagem("/backend/genero/listar", "success", "Gênero reativado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/backend/genero/listar", "error", "Erro ao reativar o gênero!");
        }
    }
}
