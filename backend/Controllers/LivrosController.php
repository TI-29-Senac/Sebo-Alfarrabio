<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Livros;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Core\Redirect;

class CatLivrosController {
    public $livros;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->livros = new Livros($this->db);
        
        
    }

    public function index() {
        $resultado = $this->livros->paginacao();
        return $resultado;
        var_dump($resultado);
    }
    public function viewListarLivros($pagina =1){
        $dados = $this->livros->paginacao($pagina);
        $total = $this->livros->totalLivros(); 
        View::render("livros/index",
        [
        "livros"=> $dados['data'],
         "total_livros"=> $total[0],
         "total_inativos" => 22,
         "Total_ativos" => 12,
         'paginacao' => $dados
        ]
        );
    }


    public function viewCriarAcervo() {
       View::render("livros/create");
    }

    public function viewEditarAcervo($id) {
       $dados = $this->livros->buscarLivrosPorId($id);
       foreach($dados as $livros){
        $dados = $livros;
       }
        View::render("livros/edit", ["livros"=> $dados ]);
    }

    public function viewExcluirLivros($id) {
        View::render("livros/delete", ["id_livros"=> $id]);
    }

    public function viewrelatorioLivros($id, $data1, $data2) {
        View::render("livros/relatorio",
         ["id"=> $id, "data1"=> $data1, "data2"=> $data2]
        );
    }

    public function salvarLivros() {
        var_dump($_POST);
        echo "salvar livros";
    }

    public function atualizarLivros() {
        var_dump($_POST);
        echo "Atualizar livros";
    }

    public function deletarLivros() {
        echo "Deletar livros";
    }
}