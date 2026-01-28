<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Usuario;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\UsuarioValidador;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Controllers\Admin\AdminController;

class UsuarioController extends AdminController {
    private $usuario;
    private $db;
    private $gerenciarImagem;

    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function salvarUsuario() {
    $erros = UsuarioValidador::ValidarEntradas($_POST);
    if (!empty($erros)) {
        // Se for erro de validação, volta para o registro
        Redirect::redirecionarComMensagem("/backend/register", "error", implode("<br>", $erros));
        return;
    }

    // Se o tipo_usuario não vier no POST (como no registro público), define como 'Cliente'
    $tipo = $_POST["tipo_usuario"] ?? 'Cliente';

    $id = $this->usuario->inseriUsuario(
        $_POST["nome_usuario"],
        $_POST["email_usuario"],
        $_POST["senha_usuario"],
        $tipo
    );

    if ($id !== false && $id > 0) {
        // Cadastro com sucesso! Redireciona para o login
        Redirect::redirecionarComMensagem("/backend/login", "success", "Conta criada com sucesso! Faça seu login.");
    } else {
        Redirect::redirecionarComMensagem("/backend/register", "error", "Erro ao processar cadastro no banco de dados.");
    }
}

    public function index() {
        $resultado = $this->usuario->buscarUsuarios();
        echo "<pre>"; print_r($resultado); echo "</pre>";
    }  

    public function viewListarUsuarios($pagina = 1) {
        if (empty($pagina) || $pagina <= 0) $pagina = 1;
        $dados = $this->usuario->paginacao($pagina);
        $total = $this->usuario->totalDeUsuarios();  // Scalar
        $totalInativos = $this->usuario->totalDeUsuariosInativos();
        $totalAtivos = $this->usuario->totalDeUsuariosAtivos();

        View::render("usuario/index", [
            "usuarios" => $dados['data'],
            "total_usuarios" => $total,
            "total_inativos" => $totalInativos,
            "total_ativos" => $totalAtivos,
            'paginacao' => $dados
        ]);
    }

    public function viewCriarUsuarios() {
        View::render("usuario/create", []);
    }

    public function viewEditarUsuarios(int $id) {
        $dados = $this->usuario->buscarUsuarioPorID($id);
        if (!$dados) {
            Redirect::redirecionarComMensagem("/usuario/listar", "error", "Usuário não encontrado.");
        }
        View::render("usuario/edit", ["usuario" => $dados]);
    }

    public function viewExcluirUsuarios($id) {
        $dados = $this->usuario->buscarUsuarioPorID($id);
        if (!$dados) {
            Redirect::redirecionarComMensagem("/usuario/listar", "error", "Usuário não encontrado.");
        }
        View::render("usuario/delete", ["usuario" => $dados]);  // Dados full
    }

    public function relatorioUsuario($id = null, $data1 = null, $data2 = null) {
        $usuarios = $id ? [$this->usuario->buscarUsuarioPorID($id)] : $this->usuario->buscarUsuarios();
        View::render("usuario/relatorio", ["usuarios" => $usuarios, "id" => $id, "data1" => $data1, "data2" => $data2]);
    }
    
    public function atualizarUsuario() {
        $id = (int) $_POST['id_usuario'];
        $erros = UsuarioValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("/usuario/editar/{$id}", "error", implode("<br>", $erros));
        }

        $sucesso = $this->usuario->atualizarUsuario(
            $id,
            $_POST["nome_usuario"],
            $_POST["email_usuario"],
            !empty($_POST["senha_usuario"]) ? $_POST["senha_usuario"] : null,
            $_POST["tipo_usuario"]
        );

        if ($sucesso) {
            Redirect::redirecionarComMensagem("/usuario/listar", "success", "Usuário #{$id} atualizado!");
        } else {
            Redirect::redirecionarComMensagem("/usuario/editar/{$id}", "error", "Erro ao atualizar.");
        }
    }

    public function deletarUsuario() {
        $id = (int) $_POST['id_usuario'];
        if ($this->usuario->excluirUsuario($id)) {
            Redirect::redirecionarComMensagem("/usuario/listar", "success", "Usuário #{$id} desativado!");
        } else {
            Redirect::redirecionarComMensagem("/usuario/listar", "error", "Erro ao desativar.");
        }
    }

    public function ativarUsuario() {
        $id = (int) ($_POST['id_usuario'] ?? $_GET['id'] ?? 0);
        if ($this->usuario->ativarUsuario($id)) {
            Redirect::redirecionarComMensagem("/usuario/listar", "success", "Usuário #{$id} reativado!");
        } else {
            Redirect::redirecionarComMensagem("/usuario/listar", "error", "Erro ao reativar.");
        }
    }
}
