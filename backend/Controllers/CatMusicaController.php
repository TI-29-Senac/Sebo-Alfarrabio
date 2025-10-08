<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\CategoriaMusica;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;

class CategoriaMusicaController {
    private $categoria;

    public function __construct() {
        $db = Database::getInstance();
        $this->categoria = new CategoriaMusica($db);
    }

    public function index() {
        $dados = $this->categoria->listar();
        View::render("catmusica/index", ["categorias" => $dados]);
    }

    public function viewCriarCatmusica() {
        View::render("catmusica/create");
    }

    public function salvarCategoriaMusica() {
        $this->categoria->inserir($_POST['nome_categoria']);
        header("Location: /backend/musicas");
    }

    public function viewEditarCatmusica($id) {
        View::render("catmusica/edit", ["id" => $id]);
    }

    public function atualizarCategoriaMusica($id) {
        $this->categoria->atualizar($id, $_POST['nome_categoria']);
        header("Location: /backend/musicas");
    }

    public function deletarCategoriaMusica($id) {
        $this->categoria->excluir($id);
        header("Location: /backend/musicas");
    }
}
