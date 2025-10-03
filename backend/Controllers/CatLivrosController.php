<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\CategoriaLivro;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;

class CategoriaLivroController {
    public $categoria;
    public $db;

    public function __construct() {
        $db = Database::getInstance();
        $this->categoria = new CategoriaLivro($db);
    }

    public function index() {
        $dados = $this->categoria->listarCatLivrosAtivos();
        View::render("catlivros/index", ["categorias" => $dados]);
    }

    public function viewlistarCatLivrosAtivos() {
        $dados = $this->categoria->listarCatLivrosAtivos();
        View::render("usuario/index", ["usuarios" => $dados]);
    }

    public function viewCriarCatlivros() {
        View::render("catlivros/create", []);
    }

    public function viewEditarCatLivros($id) {
        View::render("catlivros/edit", ["id" => $id]);
    }

    public function viewExcluirCatlivros($id) {
        View::render("catlivros/delete", ["id" => $id]);
    }

    public function salvar() {
        $this->categoria->inserirCatLivros($_POST['nome_categoria']);
        header("Location: /catlivros");
    }

    public function atualizar($id) {
        $this->categoria->atualizarCatLivros($id, $_POST['nome_categoria']);
        header("Location: /catlivros");
    }

    public function deletar($id) {
        $this->categoria->excluirCatLivros($id);
        header("Location: /catlivros");
    }
}


