<?php
namespace Sebo\Alfarrabio\Controllers;

use App\Kipedreiro\Core\NotificacaoEmail as CoreNotificacaoEmail;
use Sebo\Alfarrabio\Models\Usuario;
use Sebo\Alfarrabio\Core\Flash;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\UsuarioValidador;
use Sebo\Alfarrabio\Core\Session;
use Sebo\Alfarrabio\Core\NotificacaoEmail;

class AuthController
{
    private Usuario $usuarioModel;
    private Session $session;
    public $notificacaoEmail;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->usuarioModel = new Usuario($db);
        $this->session = new Session();
        $this->notificacaoEmail = new NotificacaoEmail();
    }

    /**
     * Renderiza a página de login.
     */
    public function login(): void
    {
        View::render('auth/login');
    }

    /**
     * Renderiza a página de cadastro (registro).
     */
    public function register(): void
    {
        View::render('auth/register');
    }

    /**
     * Realiza o logout do usuário e redireciona para login.
     */
    public function logout(): void
    {
        $this->session->destroy();
        Redirect::redirecionarComMensagem('/backend/login', 'success', 'Você saiu da sua conta! Volte sempre');
    }

    /**
     * Processa a autenticação do usuário (login).
     * Verifica credenciais e cria a sessão.
     */
    public function authenticar(): void
    {
        $email = $_POST['email_usuario'] ?? null;
        $senha = $_POST['senha_usuario'] ?? null;
        $usuario = $this->usuarioModel->checarCredenciais($email, $senha);
        if ($usuario) {
            session_regenerate_id(true);
            $this->session->set('usuario_id', $usuario['id_usuario']);
            $this->session->set('usuario_nome', $usuario['nome_usuario']);
            $this->session->set('usuario_tipo', $usuario['tipo_usuario']);
            $this->session->set('usuario_email', $usuario['email_usuario']);

            // Sincroniza o carrinho da sessão com o banco de dados
            \Sebo\Alfarrabio\Core\Cart::sync($usuario['id_usuario']);

            if ($usuario['tipo_usuario'] === 'Cliente') {
                Redirect::redirecionarPara('/backend/admin/cliente');
            }
            else {
                Redirect::redirecionarPara('/backend/admin/dashboard');
            }
        }
        else {
            Redirect::redirecionarComMensagem('/backend/login', 'error', 'Email ou senha incorretos');
        }
    }

    /**
     * Processa o cadastro de um novo usuário.
     * Valida senhas e unicidade de email.
     */
    public function cadastrarUsuario(): void
    {
        // $erros = UsuarioValidador::ValidarEntradas($_POST);
        // if (!empty($erros)) {
        //     Redirect::redirecionarComMensagem('/register', 'erros', implode("<br>", $erros));
        // }

        $nome = $_POST['nome_usuario'] ?? null;
        $email = $_POST['email_usuario'] ?? null;
        $senha = $_POST['senha_usuario'] ?? null;
        $senha_confirm = $_POST['senha_confirm'] ?? null;

        if ($senha != $senha_confirm) {
            Redirect::redirecionarComMensagem('/backend/register', 'erros', 'As senhas não conferem.');
        }

        if (!empty($this->usuarioModel->buscarUsuariosPorEmail($email))) {
            Redirect::redirecionarComMensagem('/backend/register', 'erros', 'Erro ao cadastrar, problema no seu e-mail.');
        }

        $novoUsuarioId = $this->usuarioModel->inseriUsuario($nome, $email, $senha, 'Cliente');
        if ($novoUsuarioId) {
            $this->notificacaoEmail->boasVindas($email, $nome);
            Redirect::redirecionarComMensagem('/backend/login', 'success', 'Cadastro realizado! Por favor, faça o login.');
        }
        else {
            Redirect::redirecionarComMensagem('/backend/register', 'error', 'Erro no servidor. Tente novamente.');
        }
    }

}
