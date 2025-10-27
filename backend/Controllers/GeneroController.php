<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Genero;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\ReservasValidador; 
use Sebo\Alfarrabio\Validadores\GeneroValidador;
use Sebo\Alfarrabio\Core\FileManager;


class GeneroControllerController {
    public $genero;
    public $criado_em;
    public $atualizado_em;
    public $excluido_em;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->genero = new Genero($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function salvarGenero(){
        $erros = GeneroValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
        
             Redirect::redirecionarComMensagem("/genero/criar","error", implode("<br>", $erros));
        }
        $imagem= $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'categoria');
         if($this->genero->inserirCategoria(
             $_POST["nome_genero"],
             $_POST["descricao_genero"],
           
         )){
             Redirect::redirecionarComMensagem("genero/listar", "success", "Genero cadastrado com sucesso!");
         }else{
             Redirect::redirecionarComMensagem("genero/criar", "error", "Erro ao cadastrar o Genero!");
         }
     }
      // index
      public function index() {
        $resultado = $this->genero->buscarGenero();
        var_dump($resultado);
    }
    public function viewListarGenero(){
        $dados = $this->genero->buscarGenero();
        $total = $this->genero->totalDeGenero();
        $total_inativos = $this->genero->totalDeGeneroInativos();
        $total_ativos = $this->genero->totalDeGeneroAtivos();

        View::render("genero/index", 
        [
            "genero"=> $dados, 
            "total_genero"=> $total[0],
            "total_inativos"=> $total_inativos[0],
            "total_ativos"=> $total_ativos[0]
        ]
    );
    }

    public function viewCriarGenero(){
        View::render("genero/create", []);
    }

    public function viewEditarGenero($id_genero){
        $dados = $this->genero->buscarGeneroPorID($id_genero);
        foreach($dados as $genero){
            $dados = $genero;
        }
        View::render("genero/edit", ["genero" => $dados]);
    }

    public function viewExcluirGenero($id_genero){
        View::render("genero/delete", ["id_genero" => $id_genero]);
    }

    public function relatorioGenero($id_genero, $data1, $data2){
        View::render("genero/relatorio",
        ["id"=>$id_genero, "data1"=> $data1, "data2"=> $data2]
    );
    }

    

    public function atualizarGenero(){
        echo "Atualizar Genero";
    }

    public function deletarGenero(){
        echo "Deletar Genero";
    }

}