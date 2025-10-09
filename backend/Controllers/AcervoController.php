<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Usuario;
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
        $this->acervo = new acervo($this->db);
        $this->gerenciarImagem = new FileManager('upload');
        
    }
    // index
    public function index() {
        $resultado = $this->acervo->buscarAcervo();
        return $resultado;
        var_dump($resultado);
    }

    public function viewListarAcervo() {
        $dados = $this->acervo->buscarAcervo();
        View::render("acervo/index", ["acervo" => $dados]);
    }

    public function viewCriarAcervo() {
       View::render("usuario/create");
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
            Redirect::redirecionarComMensagem("acervo/listar", "success", "Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("acervo/criar", "error", "Erro ao cadastrar usuário");
        }
    }

    public function atualizarUsuario() {
        echo "Atualizar usuario";
    }

    public function deletarUsuario() {
        echo "Deletar usuario";
    }
}