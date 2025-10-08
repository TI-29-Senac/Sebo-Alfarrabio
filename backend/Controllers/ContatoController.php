<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Contato;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;

class ContatoController {
    private $contato;

    public function __construct() {
        $db = Database::getInstance();
        $this->contato = new Contato($db);
    }

    public function index() {
        $dados = $this->contato->buscarAtivos();
        View::render("contato/index", ["contatos" => $dados]);
    }

    public function viewCriarContato() {
        View::render("contato/create");
    }

    public function salvarContato() {
        $this->contato->inserir($_POST['nome_contato'], $_POST['telefone_contato'], $_POST['email_contato'], $_POST['assunto_contato'], $_POST['mensagem_contato'], $_POST['status_contato']);
        header("Location: /backend/contatos");
    }

    public function viewEditarContato($id) {
        View::render("contato/edit", ["id" => $id]);
    }

    public function atualizarContato($id) {
        $this->contato->atualizar($id, $_POST);
        header("Location: /backend/contatos");
    }

    public function deletarContato($id) {
        $this->contato->excluir($id);
        header("Location: /backend/contatos");
    }
}
