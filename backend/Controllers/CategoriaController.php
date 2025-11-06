<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Categoria;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\CategoriaValidador;
use Sebo\Alfarrabio\Core\FileManager;

class CategoriaController {
    public $categoria;
    public $criado_em;
    public $atualizado_em;
    public $excluido_em;
    public $db;
    public $gerenciarImagem; 

    public function __construct() {
        $this->db = Database::getInstance();
        $this->categoria = new Categoria($this->db);
        $this->gerenciarImagem = new FileManager('upload'); 
    }

    public function salvarCategoria() {
        $erros = CategoriaValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("/categoria/criar", "error", implode("<br>", $erros));
        }

      //  $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'categoria');

        if ($this->categoria->inserirCategoria(
            $_POST["nome_categoria"])) {
            Redirect::redirecionarComMensagem("categoria/listar", "success", "Categoria cadastrada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("categoria/criar", "error", "Erro ao cadastrar a categoria!");
        }
    }

    public function index() {
        $resultado = $this->categoria->buscarCategorias();
        var_dump($resultado);
    }

    public function viewListarCategoria() {
        $dados = $this->categoria->buscarCategorias();
        $total = $this->categoria->totalDeCategorias();
        $total_inativos = $this->categoria->totalDeCategoriasInativas();
        $total_ativos = $this->categoria->totalDeCategoriasAtivas();

        View::render("categoria/index", [
            "categorias" => $dados,
            "total_categoria" => $total,
            "total_inativos" => $total_inativos,
            "total_ativos" => $total_ativos
        ]);
    }

    public function viewCriarCategoria() {
        View::render("categoria/create", []);
    }

    public function viewEditarCategoria($id_categoria) {
        $dados = $this->categoria->buscarCategoriaPorID($id_categoria);
        View::render("categoria/edit", ["categoria" => $dados]);
    }

    public function viewExcluirCategoria($id_categoria) {
        View::render("categoria/delete", ["id_categoria" => $id_categoria]);
    }

    public function relatorioCategoria($id_categoria, $data1, $data2) {
        View::render("categoria/relatorio", [
            "id" => $id_categoria,
            "data1" => $data1,
            "data2" => $data2
        ]);
    }

    public function atualizarCategoria() {
        $id = $_POST["id_categoria"];
        $nome = $_POST["nome_categoria"];
        $descricao = $_POST["descricao_categoria"];

        if ($this->categoria->atualizarCategoria($id, $nome, $descricao)) {
            Redirect::redirecionarComMensagem("categoria/listar", "success", "Categoria atualizada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("categoria/editar/{$id}", "error", "Erro ao atualizar a categoria!");
        }
    }

    public function deletarCategoria() {
        $id = $_POST["id_categoria"];

        if ($this->categoria->excluirCategoria($id)) {
            Redirect::redirecionarComMensagem("categoria/listar", "success", "Categoria excluída com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("categoria/listar", "error", "Erro ao excluir a categoria!");
        }
    }
}
