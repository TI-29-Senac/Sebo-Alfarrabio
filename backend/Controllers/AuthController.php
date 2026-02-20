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

    // ===== ESQUECI A SENHA =====

    /**
     * Renderiza o formulário de "Esqueci a senha".
     */
    public function forgotPassword(): void
    {
        View::render('auth/forgot_password');
    }

    /**
     * Processa o envio do link de recuperação de senha.
     * Gera token seguro, salva hash no banco, envia email com token raw.
     * Usa mensagem genérica para evitar enumeração de emails.
     */
    public function enviarLinkReset(): void
    {
        $email = trim($_POST['email_usuario'] ?? '');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Redirect::redirecionarComMensagem('/backend/forgot-password', 'error', 'Informe um email válido.');
            return;
        }

        // Mensagem genérica (anti-enumeração) — sempre a mesma independente de o email existir
        $mensagemSucesso = 'Se o email informado estiver cadastrado, você receberá um link de recuperação em breve.';

        try {
            $usuarios = $this->usuarioModel->buscarUsuariosPorEMail($email);

            if (count($usuarios) === 1) {
                // Gera token criptograficamente seguro
                $tokenRaw = bin2hex(random_bytes(32));
                $tokenHash = hash('sha256', $tokenRaw);
                $expiraEm = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // Salva o HASH do token no banco (não o token raw)
                $this->usuarioModel->salvarTokenReset($email, $tokenHash, $expiraEm);

                // Envia o token RAW por email (o link conterá o token original)
                try {
                    $this->notificacaoEmail->esqueciASenha($email, $tokenRaw);
                } catch (\Throwable $eEmail) {
                    error_log("AVISO: Falha ao enviar email de reset para $email: " . $eEmail->getMessage());
                }
            }
            // Se não encontrou o email, não faz nada mas retorna mesma mensagem

        } catch (\Throwable $e) {
            error_log("ERRO em enviarLinkReset: " . $e->getMessage());
        }

        Redirect::redirecionarComMensagem('/backend/forgot-password', 'success', $mensagemSucesso);
    }

    /**
     * Renderiza o formulário de redefinição de senha.
     * Valida o token antes de exibir o formulário.
     */
    public function resetPassword(): void
    {
        $token = $_GET['token'] ?? '';

        if (empty($token)) {
            Redirect::redirecionarComMensagem('/backend/forgot-password', 'error', 'Token inválido ou ausente.');
            return;
        }

        // Valida o hash do token no banco
        $tokenHash = hash('sha256', $token);
        $resetData = $this->usuarioModel->validarTokenReset($tokenHash);

        if (!$resetData) {
            Redirect::redirecionarComMensagem('/backend/forgot-password', 'error', 'Token inválido ou expirado. Solicite um novo link.');
            return;
        }

        View::render('auth/reset_password', ['token' => $token]);
    }

    /**
     * Processa a redefinição de senha.
     * Valida token, verifica senhas, atualiza no banco e invalida o token.
     */
    public function processarResetPassword(): void
    {
        $token = $_POST['token'] ?? '';
        $senhaNova = $_POST['senha_nova'] ?? '';
        $senhaConfirm = $_POST['senha_confirm'] ?? '';

        if (empty($token)) {
            Redirect::redirecionarComMensagem('/backend/forgot-password', 'error', 'Token inválido.');
            return;
        }

        // Validação de senha
        if (empty($senhaNova) || strlen($senhaNova) < 6) {
            Redirect::redirecionarComMensagem(
                '/backend/redefinir-senha?token=' . urlencode($token),
                'error',
                'A senha deve ter pelo menos 6 caracteres.'
            );
            return;
        }

        if ($senhaNova !== $senhaConfirm) {
            Redirect::redirecionarComMensagem(
                '/backend/redefinir-senha?token=' . urlencode($token),
                'error',
                'As senhas não conferem.'
            );
            return;
        }

        // Valida o hash do token
        $tokenHash = hash('sha256', $token);
        $resetData = $this->usuarioModel->validarTokenReset($tokenHash);

        if (!$resetData) {
            Redirect::redirecionarComMensagem('/backend/forgot-password', 'error', 'Token inválido ou expirado. Solicite um novo link.');
            return;
        }

        // Busca o usuário pelo email do token
        $usuarios = $this->usuarioModel->buscarUsuariosPorEMail($resetData['email']);

        if (count($usuarios) !== 1) {
            Redirect::redirecionarComMensagem('/backend/forgot-password', 'error', 'Erro ao localizar a conta.');
            return;
        }

        $usuario = $usuarios[0];

        // Atualiza a senha
        $atualizado = $this->usuarioModel->atualizarSenha((int)$usuario['id_usuario'], $senhaNova);

        if ($atualizado) {
            // Invalida todos os tokens deste email
            $this->usuarioModel->deletarTokensReset($resetData['email']);
            Redirect::redirecionarComMensagem('/backend/login', 'success', 'Senha redefinida com sucesso! Faça o login com sua nova senha.');
        } else {
            Redirect::redirecionarComMensagem('/backend/forgot-password', 'error', 'Erro ao redefinir a senha. Tente novamente.');
        }
    }
}
