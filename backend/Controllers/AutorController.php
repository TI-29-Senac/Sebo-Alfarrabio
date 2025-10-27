<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Autor;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\AutorValidador;
use Sebo\Alfarrabio\Core\FileManager;


class AutorController {
    public $autor;
    public $criado_em;
    public $atualizado_em;
    public $excluido_em;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->autor = new Autor($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function salvarVendas(){
        $erros = AutorValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
        
             Redirect::redirecionarComMensagem("/autor/criar","error", implode("<br>", $erros));
        }
        $imagem= $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'autor');
         if($this->autor->inserirUsuario(
             $_POST["nome_autor"],
             $_POST["biografia"],
           
         )){
             Redirect::redirecionarComMensagem("autor/listar", "success", "Autor cadastrado com sucesso!");
         }else{
             Redirect::redirecionarComMensagem("autor/criar", "error", "Erro ao cadastrar o autor!");
         }
     }
      // index
      public function index() {
        $resultado = $this->autor->buscarAutor();
        var_dump($resultado);
    }
    public function viewListarAutor(){
        $dados = $this->autor->buscarAutor();
        $total = $this->autor->totalDeAutor();
        $total_inativos = $this->autor->totalDeAutorInativos();
        $total_ativos = $this->autor->totalDeAutorAtivos();

        View::render("autor/index", 
        [
            "autor"=> $dados, 
            "total_autor"=> $total[0],
            "total_inativos"=> $total_inativos[0],
            "total_ativos"=> $total_ativos[0]
        ]
    );
    }

    public function viewCriarAutor(){
        View::render("autor/create", []);
    }

    public function viewEditarAutor($id_autor){
        $dados = $this->autor->buscarAutorPorID($id_autor);
        foreach($dados as $autor){
            $dados = $autor;
        }
        View::render("autor/edit", ["autor" => $dados]);
    }

    public function viewExcluirAutor($id_autor){
        View::render("autor/delete", ["id_autor" => $id_autor]);
    }

    public function relatorioAutor($id_autor, $data1, $data2){
        View::render("autor/relatorio",
        ["id"=>$id_autor, "data1"=> $data1, "data2"=> $data2]
    );
    }

    

    public function atualizarAutor(){
        echo "Atualizar Autor";
    }

    public function deletarAutor(){
        echo "Deletar Autor";
    }

}