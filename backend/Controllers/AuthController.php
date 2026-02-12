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
            } else {
                Redirect::redirecionarPara('/backend/admin/dashboard');
            }
        } else {
            Redirect::redirecionarComMensagem('/backend/login', 'error', 'Email ou senha incorretos');
        }
    }

    /**
     * Processa o cadastro de um novo usuário.
     * Valida senhas e unicidade de email.
     */
    public function cadastrarUsuario()
    {
        try {
            // $erros = UsuarioValidador::ValidarEntradas($_POST);
            // if (!empty($erros)) {
            //     Redirect::redirecionarComMensagem('/register', 'erros', implode("<br>", $erros));
            // }

            $nome = $_POST['nome_usuario'] ?? null;
            $email = $_POST['email_usuario'] ?? null;
            $senha = $_POST['senha_usuario'] ?? null;
            $senha_confirm = $_POST['senha_confirm'] ?? null;

            if ($senha != $senha_confirm) {
                return Redirect::redirecionarComMensagem('/backend/register', 'erros', 'As senhas não conferem.');
            }

            if (!empty($this->usuarioModel->buscarUsuariosPorEMail($email))) {
                return Redirect::redirecionarComMensagem('/backend/register', 'erros', 'Erro ao cadastrar, problema no seu e-mail.');
            }

            $novoUsuarioId = $this->usuarioModel->inseriUsuario($nome, $email, $senha, 'Cliente');
            
            if ($novoUsuarioId) {
                try {
                    $this->notificacaoEmail->boasVindas($email, $nome);
                } catch (\Throwable $eEmail) {
                    error_log("AVISO: Falha ao enviar email de boas-vindas para $email: " . $eEmail->getMessage());
                    // Não impede o cadastro, apenas loga o erro
                }
                
                Redirect::redirecionarComMensagem('/backend/login', 'success', 'Cadastro realizado! Por favor, faça o login.');
            } else {
                error_log("ERRO AO INSERIR USUÁRIO: inseriUsuario retornou false para $email");
                Redirect::redirecionarComMensagem('/backend/register', 'error', 'Erro no servidor ao criar conta. Tente novamente.');
            }

        } catch (\Throwable $e) {
            error_log("EXCEÇÃO CRÍTICA EM cadastrarUsuario: " . $e->getMessage());
            error_log($e->getTraceAsString());
            Redirect::redirecionarComMensagem('/backend/register', 'error', 'Erro interno no servidor. Detalhes foram logados.');
        }
    }

    /**
     * Verifica o status da sessão (API).
     * Retorna JSON com dados do usuário ou authenticated: false.
     */
    public function checkSession(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $usuarioId = $this->session->get('usuario_id');

        if ($usuarioId) {
            $nome = $this->session->get('usuario_nome');
            $tipo = $this->session->get('usuario_tipo');
            $email = $this->session->get('usuario_email');

            // Busca foto do perfil
            $db = Database::getInstance();
            $perfilModel = new \Sebo\Alfarrabio\Models\Perfil($db);
            $perfilData = $perfilModel->buscarPerfilPorIDUsuario($usuarioId);
            $foto = '/img/avatar_placeholder.png';

            if ($perfilData && !empty($perfilData[0]['foto_perfil_usuario'])) {
                $foto = $this->corrigirCaminhoImagem($perfilData[0]['foto_perfil_usuario']);
            }

            echo json_encode([
                'authenticated' => true,
                'user' => [
                    'id' => $usuarioId,
                    'name' => $nome,
                    'email' => $email,
                    'role' => $tipo,
                    'avatar' => $foto
                ]
            ]);
        } else {
            echo json_encode([
                'authenticated' => false
            ]);
        }
    }

    /**
     * Corrige o caminho da imagem para garantir que funcione no frontend.
     */
    private function corrigirCaminhoImagem($caminho)
    {
        if (empty($caminho)) {
            return '/img/avatar_placeholder.png';
        }

        if (strpos($caminho, 'http') === 0) {
            return $caminho;
        }

        // Se o caminho já for absoluto (começar com /) e não for /backend, adiciona /backend
        if (strpos($caminho, '/') === 0) {
            if (strpos($caminho, '/backend') === 0) {
                return $caminho;
            }
            return '/backend' . $caminho;
        }

        // Se for um caminho relativo, assume que está dentro de backend
        return '/backend/' . $caminho;
    }
}
