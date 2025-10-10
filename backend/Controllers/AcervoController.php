<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Acervo;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Validadores\AcervoValidador;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Core\Redirect;

class AcervoController {
    public $acervo;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->acervo = new Acervo($this->db);
        $this->gerenciarImagem = new FileManager('upload');
        
    }
    // index
     // index
     public function index() {
        $resultado = $this->acervo->paginacao();
        return $resultado;
        var_dump($resultado);
    }

   // public function viewListarUsuarios() {
       // $dados = $this->usuario->buscarUsuarios();
        //View::render("usuario/index", ["usuarios" => $dados]);
    //}

    public function viewListarAcervo($pagina){
        $dados = $this->acervo->paginacao($pagina);
        $total = $this->acervo->totalAcervo();
        View::render("acervo/index",
        [
        "acervos"=> $dados['data'],
         "total_acervo"=> $total[0],
         "total_inativos" => 22,
         "Total_ativos" => 12,
         'paginacao' => $dados
        ]
        );
    }

    public function viewCriarAcervo() {
       View::render("acervo/create");
    }

    public function viewEditarAcervo($id) {
       $dados = $this->acervo->buscarAcervoPorId($id);
       foreach($dados as $acervo){
        $dados = $acervo;
       }
        View::render("acervo/edit", ["acervo"=> $dados ]);
    }

    public function viewExcluirAcervo($id) {
        View::render("acervo/delete", ["id_acervo"=> $id]);
    }

    public function viewrelatorioAcervo($id, $data1, $data2) {
        View::render("acervo/relatorio",
         ["id"=> $id, "data1"=> $data1, "data2"=> $data2]
        );
    }


    public function salvarAcervo() {
        $erros = AcervoValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("acervo/criar","error", implode("<br>", $erros));
        }
        //novo caminho = 
        $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'acervo');
        if($this->acervo->inseriAcervo(
            $_POST["titulo_acervo"],
            $_POST["tipo_item_acervo"],
            $_POST["estado_conservacao"],
            $_POST["disponibilidade_acervo"],
            $_POST["estoque_acervo"],
            "Ativo",
            $imagem
        )){
            Redirect::redirecionarComMensagem("acervo/listar", "success", "Acervo cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("acervo/criar", "error", "Erro ao cadastrar Acervo");
        }
    }

    public function atualizarAcervo() {
        var_dump($_POST);
        echo "Atualizar acervo";
    }

    public function deletarAcervo() {
        echo "Deletar acervo";
    }
}