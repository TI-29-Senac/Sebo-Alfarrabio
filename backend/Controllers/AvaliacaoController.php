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
        $avaliacao = $this->avaliacao->buscarPorID($id);
        if (!$avaliacao) {
            Redirect::redirecionarComMensagem("/avaliacao/listar", "error", "Serviço não encontrado.");
        }

        View::render("/avaliacao/delete", ["avaliacao" => $avaliacao]);
    }

    public function relatorioAvaliacao($id_avaliacao, $data1, $data2){
        View::render("avaliacao/relatorio",
        ["id"=>$id_avaliacao, "data1"=> $data1, "data2"=> $data2]
    );
    }

    

    public function atualizarAvaliacao(){
        $id_avaliacao = (int)$_POST['id_avaliacao'];
        $nota = $_POST['nota_avaliacao'];
        $comentario = $_POST['comentario_avaliacao'];
        $data = $_POST['data_avaliacao'];
        $status = $_POST['status_avaliacao'];

        if ($this->avaliacao->atualizarAvaliacao($id_avaliacao, $nota, $comentario, $data, $status)) {
            Redirect::redirecionarComMensagem("/avaliacao/listar", "success", "Avaliação atualizada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/avaliacao/editar/" . $id_avaliacao, "error", "Erro ao atualizar avaliação.");
        }
    }

    public function deletarAvaliacao(){
        echo "Deletar Avaliacao";
    }

}