<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Avaliacao;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\AvaliacaoValidador;
use Sebo\Alfarrabio\Core\FileManager;


class AvaliacaoController {
    public $avaliacao;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->avaliacao = new Avaliacao($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

      // index
      public function index() {
        $resultado = $this->avaliacao->buscarAvaliacao();
        var_dump($resultado);
    }
    public function viewListarAvaliacao(){
        $dados = $this->avaliacao->buscarAvaliacao();
        $total_avaliacao = $this->avaliacao->totalDeAvaliacao();
        $total_inativos = $this->avaliacao->totalDeAvaliacaoInativos();
        $total_ativos = $this->avaliacao->totalDeAvaliacaoAtivos();

        View::render("avaliacao/index", 
        [
            "avaliacao"=> $dados, 
            "total_avaliacao"=> $total_avaliacao[0],
            "total_inativos"=> $total_inativos[0],
            "total_ativos"=> $total_ativos[0]
        ]
    );
    }

    public function viewCriarAvaliacao(){
        View::render("avaliacao/create", []);
    }

    public function viewEditarAvaliacao($id_avaliacao){
        $dados = $this->avaliacao->buscarAvaliacaoPorID($id_avaliacao);
        foreach($dados as $avaliacao){
            $dados = $avaliacao;
        }
        View::render("avaliacao/edit", ["avaliacao" => $dados]);
    }

    public function viewExcluirAvaliacao($id_avaliacao){
        View::render("avaliacao/delete", ["id_avaliacao" => $id_avaliacao]);
    }

    public function relatorioAvaliacao($id_avaliacao, $data1, $data2){
        View::render("avaliacao/relatorio",
        ["id"=>$id_avaliacao, "data1"=> $data1, "data2"=> $data2]
    );
    }

    

    public function atualizarAvaliacao(){
        echo "Atualizar Avaliacao";
    }

    public function deletarAvaliacao(){
        echo "Deletar Avaliacao";
    }

}