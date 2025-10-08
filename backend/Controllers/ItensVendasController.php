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
        $dados = $this->itens->buscarAtivos();
        View::render("itensvenda/index", ["itens" => $dados]);
    }

    public function salvarItemVenda() {
        $this->itens->inserirItensVendas($_POST['id_venda'], $_POST['id_acervo'], $_POST['quantidade_item'], $_POST['preco_unitario']);
        header("Location: /backend/itensvenda");
    }

    public function atualizarItensVendas($id) {
        $this->itens->atualizarItensVendas($id, $_POST);
        header("Location: /backend/itensvenda");
    }

    public function excluirItensVendas($id) {
        $this->itens->excluirItensVendas($id);
        header("Location: /backend/itensvenda");
    }
}

