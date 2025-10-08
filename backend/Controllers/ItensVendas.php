<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\ItensVenda;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;

class ItensVendaController {
    private $itens;

    public function __construct() {
        $db = Database::getInstance();
        $this->itens = new ItensVenda($db);
    }

    public function index() {
        $dados = $this->itens->listar();
        View::render("itensvenda/index", ["itens" => $dados]);
    }

    public function salvarItemVenda() {
        $this->itens->inserir($_POST['id_venda'], $_POST['id_acervo'], $_POST['quantidade_item'], $_POST['preco_unitario']);
        header("Location: /backend/itensvenda");
    }

    public function atualizarItemVenda($id) {
        $this->itens->atualizar($id, $_POST);
        header("Location: /backend/itensvenda");
    }

    public function deletarItemVenda($id) {
        $this->itens->excluir($id);
        header("Location: /backend/itensvenda");
    }
}

