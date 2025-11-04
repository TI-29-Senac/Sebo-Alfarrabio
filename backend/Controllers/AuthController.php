<?php
namespace Sebo\Alfarrabio\Controllers;
<<<<<<< HEAD
 
use Sebo\Alfarrabio\Models\Usuario;
use Sebo\Alfarrabio\Core\Flash;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\UsuarioValidador;
use Sebo\Alfarrabio\Core\Session;
 
class AuthController{
    private Usuario $usuarioModel;
    private Session $session;
 
=======

use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Flash;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Models\Usuario;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\Session;
use Sebo\Alfarrabio\Validadores\UsuarioValidador;

class AuthController{
    private Usuario $usuarioModel;
    private Session $session;

>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
    public function __construct(){
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
        $this->session = new Session();
    }
<<<<<<< HEAD
 
    public function login(): void{
        View::render('auth/login');
    }
 
    public function register(): void{
        var_dump(""); 
        View::render ('auth/register');
    }
 
    public function logout(): void {
        $this->session->destroy();
        Redirect::redirecionarComMensagem('/login', 'succes', 'Você saiu com segurança');
    }
 
=======

    public function login(): void {
        View::render('auth/login');
    }

    public function register(): void{
        View::render('auth/register');
    }

    public function logout(): void {
        $this->session->destroy();
        Redirect::redirecionarComMensagem('/login', 'success', 'Você saiu com segurança.');
    }
    
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
    public function authenticar(): void {
        $email = $_POST['email_usuario'] ?? null;
        $senha = $_POST['senha_usuario'] ?? null;
        $usuario = $this->usuarioModel->checarCredenciais($email, $senha);
<<<<<<< HEAD
        if($usuario){
            session_regenerate_id(true);
            $this->session->set('usuario_id', $usuario['id_usuario']);
            $this->session->set('usuario_nome', $usuario['nome_usuario']);
            $this->session->set('usuario_tipo', $usuario['tipo_usuario']);
 
            Redirect::redirecionarPara('admin\dashboard');
        }else{
            Redirect::redirecionarComMensagem('/login', 'error', 'Email ou senha incorretos');
        }
    }
 
=======
        if ($usuario) {
            session_regenerate_id(true);
            $this->session->set('usuario_id', $usuario['id_usuario']);
            $this->session->set('usuario_nome', $usuario['nome_usuario']);
            $this->session->set('usuario_tipo', strtolower($usuario['tipo_usuario']));

            
            Redirect::redirecionarPara('/admin/dashboard'); 
        } else {
            Redirect::redirecionarComMensagem('/backend/login', 'error', 'E-mail ou senha incorretos.');
        }
    }

>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
    public function cadastrarUsuario(): void {
        $erros = UsuarioValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem('/register', 'erros', implode("<br>", $erros));
        }
<<<<<<< HEAD
    
=======
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
        $nome = $_POST['nome_usuario'] ?? null;
        $email = $_POST['email_usuario'] ?? null;
        $senha = $_POST['senha_usuario'] ?? null;
        $senha_confirm = $_POST['senha_confirm'] ?? null;
<<<<<<< HEAD
    
        if ($senha != $senha_confirm) {
            Redirect::redirecionarComMensagem('/register', 'erros', 'As senhas não conferem.');
        }
    
        if (!empty($this->usuarioModel->buscarUsuariosPorEmail($email))) {
            Redirect::redirecionarComMensagem('/register', 'erros', 'Erro ao cadastrar, problema no seu e-mail.');
        }
    
        $novoUsuarioId = $this->usuarioModel->inseriUsuario($nome, $email, $senha, 'usuario', 'Ativo', 'null');
=======
        if ($senha != $senha_confirm) {
            Redirect::redirecionarComMensagem('/register', 'erros', 'As senhas não conferem.');
        }
        
        if (!empty($this->usuarioModel->buscarUsuariosPorEMail($email))){
            Redirect::redirecionarComMensagem('/register', 'erros', 'Erro ao cadastrar, problema no seu e-mail.');
        }
        $novoUsuarioId = $this->usuarioModel->inseriUsuario($nome, $email, $senha, 'Cliente');
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
        if ($novoUsuarioId) {
            Redirect::redirecionarComMensagem('/login', 'success', 'Cadastro realizado! Por favor, faça o login.');
        } else {
            Redirect::redirecionarComMensagem('/register', 'error', 'Erro no servidor. Tente novamente.');
        }
    }
<<<<<<< HEAD
    
}
 
=======

}
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
