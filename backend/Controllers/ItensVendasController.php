<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\ItensVendas;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;

class ItensVendasController {
    private $itens;
    public $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->itens = new ItensVendas ($this->db);

    }



    public function viewListarItensVendas($pagina){
        $dados = $this->itens->paginacao($pagina);
        $total = $this->itens->totalDeItens();
        View::render("itens/index",
        [
        "itens_vendas"=> $dados['data'],
         "total_itens"=> $total[0],
         "total_inativos" => 22,
         "Total_ativos" => 12,
         'paginacao' => $dados
        ]
        );
    }


    public function viewSalvarItensVendas() {
        $this->itens->CriarItensVendas($_POST['id_venda'], $_POST['id_acervo'], $_POST['quantidade_item'], $_POST['preco_unitario']);
        View::render("itens/create");
    }

    public function viewAtualizarItensVendas($id) {
        $this->itens->atualizarItensVendas($id, $_POST);
        View::render("itens/edit");
    }

    public function viewExcluirItensVendas($id) {
        $this->itens->excluirItensVendas($id);
        View::render("itens/delete");
    }
}

