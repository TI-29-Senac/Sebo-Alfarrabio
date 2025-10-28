<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Categoria;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\CategoriaValidador;
use Sebo\Alfarrabio\Core\FileManager;


class CategoriaController {
    public $categoria;
    public $criado_em;
    public $atualizado_em;
    public $excluido_em;
    public $db;
    public $gerenciarImagem; 
    public function __construct() {
        $this->db = Database::getInstance();
        $this->categoria = new Categoria($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function salvarCategoria(){
        $erros = CategoriaValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
        
             Redirect::redirecionarComMensagem("/categoria/criar","error", implode("<br>", $erros));
        }
        $imagem= $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'categoria');
         if($this->categoria->inserirCategoria(
             $_POST["nome_categoria"],
             $_POST["descricao_categoria"],
           
         )){
             Redirect::redirecionarComMensagem("categoria/listar", "success", "Categoria cadastrada com sucesso!");
         }else{
             Redirect::redirecionarComMensagem("categoria/criar", "error", "Erro ao cadastrar a Categoria!");
         }
     }
     
public function index() {
        $resultado = $this->categoria->buscarCategoria();
        var_dump($resultado);
}


public function viewListarCategoria(){
        $dados = $this->categoria->buscarcategoria();
        $total = $this->categoria->totalDeCategoria();
        $total_inativos = $this->categoria->totalDeCategoriaInativos();
        $total_ativos = $this->categoria->totalDeCategoriaAtivos();

        View::render("categoria/index", 
        [
            "categoria"=> $dados, 
            "total_categoria"=> $total[0],
            "total_inativos"=> $total_inativos[0],
            "total_ativos"=> $total_ativos[0]
        ]
    );
}

public function viewCriarCategoria(){
        View::render("categoria/create", []);
}

public function viewEditarCategoria($id_categoria){
        $dados = $this->categoria->buscarCategoriaPorID($id_categoria);
        foreach($dados as $categoria){
            $dados = $categoria;
        }
        View::render("categoria/edit", ["categoria" => $dados]);
}

public function viewExcluirCategoria($id_categoria){
        View::render("categoria/delete", ["id_categoria" => $id_categoria]);
}

public function relatorioCategoria($id_categoria, $data1, $data2){
        View::render("categoria/relatorio",
        ["id"=>$id_categoria, "data1"=> $data1, "data2"=> $data2]
    );
}

    

public function atualizarCategoria(){
        echo "Atualizar Categoria";
}

public function deletarCategoria(){
        echo "Deletar categoria";
}

}