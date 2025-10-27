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

    public function salvarAvaliacao() {
        if (empty($_POST["nota_avaliacao"])) {
            Redirect::redirecionarComMensagem("/avaliacao/criar", "error", "Nota é obrigatória.");
        }

        if ($this->avaliacao->inserirAvaliacao(
            $_POST["nota_avaliacao"],
            $_POST["comentario_avaliacao"],
            $_POST["data_avaliacao"],
            $_POST["status_avaliacao"],
        )) {
            Redirect::redirecionarComMensagem("/avaliacao/listar", "success", "Serviço cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/avaliacao/criar", "error", "Erro ao cadastrar serviço.");
        }
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

    public function deletarAvaliacao(int $id){
        $status = $this->buscarAvaliacaoPorID($id);
        $status = $status['status_avaliacao'] == 'ativo' ? 'Inativo' : 'ativo';

        $sql = "UPDATE tbl_avaliacao SET status_avaliacao = :status WHERE id_avaliacao = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function relatorioAvaliacao($id_avaliacao, $data1, $data2){
        View::render("avaliacao/relatorio",
        ["id"=>$id_avaliacao, "data1"=> $data1, "data2"=> $data2]
    );
    }

    

    public function atualizarAvaliacao(){
        $id_avaliacao = (int)$_POST['id_avaliacao'];
        $nota_avaliacao = $_POST['nota_avaliacao'];
        $comentario_avaliacao = $_POST['comentario_avaliacao'];
        $data_avaliacao = $_POST['data_avaliacao'];
        $status_avaliacao = $_POST['status_avaliacao'];

        if ($this->avaliacao->atualizarAvaliacao($id_avaliacao, $nota_avaliacao, $comentario_avaliacao, $data_avaliacao, $status_avaliacao)) {
            Redirect::redirecionarComMensagem("/avaliacao/listar", "success", "Avaliação atualizada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/avaliacao/editar/" . $id_avaliacao, "error", "Erro ao atualizar avaliação.");
        }
    }

}