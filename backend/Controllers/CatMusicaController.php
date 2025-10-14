<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\CatMusica;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Core\Redirect;

class CatMusicaController {
    public $catmusica;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->catmusica = new CatMusica($this->db);
        
        
    }

    public function index() {
        $resultado = $this->catmusica->paginacao();
        return $resultado;
        var_dump($resultado);
    }
    public function viewListarCatMusica($pagina =1){
        $dados = $this->catmusica->paginacao($pagina);
        $total = $this->catmusica->totalCatMusica(); 
        View::render("categoriamusica/index",
        [
        "catmusica"=> $dados['data'],
         "total_catlivros"=> $total[0],
         "total_inativos" => 22,
         "Total_ativos" => 12,
         'paginacao' => $dados
        ]
        );
    }


    public function viewCriarCatMusica() {
       View::render("catmusica/create");
    }

    public function viewEditarCatMusica($id) {
       $dados = $this->catmusica->buscarCatMusicaPorId($id);
       foreach($dados as $catmusica){
        $dados = $catmusica;
       }
        View::render("categoriamusica/edit", ["catmusica"=> $dados ]);
    }

    public function viewExcluirCatMusica($id) {
        View::render("categoriamusica/delete", ["id_catlivros"=> $id]);
    }

    public function viewrelatorioCatMusica($id, $data1, $data2) {
        View::render("categoriamusica/relatorio",
         ["id"=> $id, "data1"=> $data1, "data2"=> $data2]
        );
    }

    public function salvarCatMusica() {
        var_dump($_POST);
        echo "salvar catmusica";
    }

    public function atualizarCatMusica() {
        var_dump($_POST);
        echo "Atualizar catmusica";
    }

    public function deletarCatMusica() {
        echo "Deletar catmusica";
    }
}