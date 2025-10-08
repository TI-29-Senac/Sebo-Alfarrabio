<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Usuario;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Validadores\UsuarioValidador;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Core\Redirect;

class UsuarioController {
    public $usuario;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->gerenciarImagem = new FileManager('upload');
        
    }
    // index
    public function index() {
        $resultado = $this->usuario->buscarUsuarios();
        return $resultado;
        var_dump($resultado);
    }

    public function viewListarUsuarios() {
        $dados = $this->usuario->buscarUsuarios();
        View::render("usuario/index", ["usuarios" => $dados]);
    }

    public function viewCriarUsuarios() {
       View::render("usuario/create");
    }

    public function viewEditarUsuarios($id) {
       $dados = $this->usuario->buscarUsuariosPorId($id);
       foreach($dados as $usuario){
        $dados = $usuario;
       }
        View::render("usuario/edit", ["usuario"=> $dados ]);
    }

    public function viewExcluirUsuarios($id) {
        View::render("usuario/delete", ["id_usuario"=> $id]);
    }

    public function viewrelatorioUsuario($id, $data1, $data2) {
        View::render("usuario/relatorio",
         ["id"=> $id, "data1"=> $data1, "data2"=> $data2]
        );
    }


    public function salvarUsuario() {
        $erros = UsuarioValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            Redirect::redirecionarComMensagem("usuario/criar","error", implode("<br>", $erros));
        }
        //novo caminho = 
        $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'usuario');
        if($this->usuario->inseriUsuario(
            $_POST["nome_usuario"],
            $_POST["email_usuario"],
            $_POST["senha_usuario"],
            $_POST["tipo_usuario"],
            "Ativo",
            $imagem
        )){
            Redirect::redirecionarComMensagem("usuario/listar", "success", "Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("usuario/criar", "error", "Erro ao cadastrar usuário");
        }
    }

    public function atualizarUsuario() {
        echo "Atualizar usuario";
    }

    public function deletarUsuario() {
        echo "Deletar usuario";
    }

}