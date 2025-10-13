<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\CatLivros;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Core\Redirect;

class CatLivrosController {
    public $catlivros;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->catlivros = new Catlivros($this->db);
        
        
    }

    public function index() {
        $resultado = $this->catlivros->paginacao();
        return $resultado;
        var_dump($resultado);
    }
    public function viewListarCatLivros($pagina =1){
        $dados = $this->catlivros->paginacao($pagina);
        $total = $this->catlivros->totalCatLivros(); 
        View::render("categorialivros/index",
        [
        "catlivros"=> $dados['data'],
         "total_catlivros"=> $total[0],
         "total_inativos" => 22,
         "Total_ativos" => 12,
         'paginacao' => $dados
        ]
        );
    }


    public function viewCriarAcervo() {
       View::render("catlivros/create");
    }

    public function viewEditarAcervo($id) {
       $dados = $this->catlivros->buscarcatlivrosPorId($id);
       foreach($dados as $catlivros){
        $dados = $catlivros;
       }
        View::render("catlivros/edit", ["catlivros"=> $dados ]);
    }

    public function viewExcluircatlivros($id) {
        View::render("catlivros/delete", ["id_catlivros"=> $id]);
    }

    public function viewrelatoriocatlivros($id, $data1, $data2) {
        View::render("catlivros/relatorio",
         ["id"=> $id, "data1"=> $data1, "data2"=> $data2]
        );
    }

    public function salvarCatLivros() {
        var_dump($_POST);
        echo "salvar catlivros";
    }

    public function atualizarcatlivros() {
        var_dump($_POST);
        echo "Atualizar catlivros";
    }

    public function deletarcatlivros() {
        echo "Deletar catlivros";
    }
}


