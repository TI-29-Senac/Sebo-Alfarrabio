<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Usuario;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\UsuarioValidador;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Controllers\Admin\AuthenticatedController;
use Sebo\Alfarrabio\Controllers\Admin\AdminController;

class UsuarioController extends AdminController{
    public $usuario;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }
    public function salvarUsuario(){
       $erros = UsuarioValidador::ValidarEntradas($_POST);
       if(!empty($erros)){
            Redirect::redirecionarComMensagem("usuario/criar","error", implode("<br>", $erros));
       }
       //novo caminho =                                (arquivo          ,subdiretorio)
       $imagem =  $this->gerenciarImagem->salvarArquivo('usuario');
        if($this->usuario->inseriUsuario(
            $_POST["nome_usuario"],
            $_POST["email_usuario"],
            $_POST["senha_usuario"],
            $_POST["tipo_usuario"],
        )){
            Redirect::redirecionarComMensagem("usuario/listar","success","Usuário cadastrado com sucesso!");
        }else{
            Redirect::redirecionarComMensagem("usuario/criar","error","Erro ao cadastrar usuário!");
        }
    }
    public function index() {
        $resultado = $this->usuario->buscarUsuarios();
        var_dump($resultado);
    }  
    public function viewListarUsuarios($pagina=1){
        if(empty($pagina) || $pagina <= 0){
            $pagina = 1;
        }
        $totalAtivos = $this->usuario->totalDeUsuariosAtivos();
        $dados = $this->usuario->paginacao($pagina);
        $total = $this->usuario->totalDeUsuarios();
        $totalInativos = $this->usuario->totalDeUsuariosInativos();
        
        View::render("usuario/index", 
        [
        "usuarios"=> $dados['data'],
         "total_usuarios"=> $total[0],
         "total_inativos" => $totalInativos[0],
         "total_ativos" => $totalAtivos[0],
         'paginacao' => $dados
        ] 
        );
    }
    public function viewCriarUsuarios(){
        View::render("usuario/create");
    }
    public function viewEditarUsuarios(int $id){
        $dados = $this->usuario->buscarUsuariosPorID($id);
        foreach($dados as $usuario){
                $dados = $usuario;
        }
        View::render("usuario/edit", ["usuario"=> $dados ]);
    }
    public function viewExcluirUsuarios($id){
       View::render("usuario/delete", ["id_usuario"=> $id ]);
    }
    public function relatorioUsuario($id, $data1, $data2){
        View::render("usuario/relatorio", 
            ["id"=> $id, "data1"=> $data1, "data2"=> $data2]
        );
    }
    
    public function atualizarUsuario(){
        echo "Atualizar Usuario";
    }
    public function deletarUsuario(){
        echo "Deletar Usuario";
    }

}