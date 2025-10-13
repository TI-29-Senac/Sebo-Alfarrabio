<?php
namespace App\Sebo\Alfarrabio\Controllers;

use App\Sebo\Alfarrabio\Models\Usuario;
use App\Sebo\Alfarrabio\Database\Database;
use App\Sebo\Alfarrabio\Core\View;
use App\Sebo\Alfarrabio\Core\Redirect;
use App\Sebo\Alfarrabio\Validadores\UsuarioValidador;
use App\Sebo\Alfarrabio\Core\FileManager;


class UsuarioController {
    public $usuario;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function salvarUsuario(){
        $erros = UsuarioValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
        
             Redirect::redirecionarComMensagem("/usuario/criar","error", implode("<br>", $erros));
        }
        $imagem= $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'usuario');
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
    // index
    public function index() {
        $resultado = $this->usuario->buscarUsuarios();
        var_dump($resultado);
    }
    public function viewListarUsuarios(){
        $dados = $this->usuario->buscarUsuarios();
        $total = $this->usuario->totalDeUsuarios();

        View::render("usuario/index", 
        [
            "usuarios"=> $dados, 
            "total_usuarios"=> $total[0],
            "total_inativos"=> 22,
            "total_ativos"=> 12
        ]
    );
    }

    public function viewCriarUsuarios(){
        View::render("usuario/create", []);
    }

    public function viewEditarUsuarios($id){
        $dados = $this->usuario->buscarUsuariosPorID($id);
        foreach($dados as $usuario){
            $dados = $usuario;
        }
        View::render("usuario/edit", ["usuario" => $dados]);
    }

    public function viewExcluirUsuarios($id){
        View::render("usuario/delete", ["id_usuario" => $id]);
    }

    public function relatorioUsuario($id, $data1, $data2){
        View::render("usuario/relatorio",
        ["id"=>$id, "data1"=> $data1, "data2"=> $data2]
    );
    }

    

    public function atualizarUsuario(){
        echo "Atualizar Usuario";
    }

    public function deletarUsuario(){
        echo "Deletar Usuario";
    }

}