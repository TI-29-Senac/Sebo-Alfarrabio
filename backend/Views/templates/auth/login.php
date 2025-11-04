<<<<<<< HEAD
<?php
/**
 * LOGIN.PHP - Página de Login do Sistema Sebo
 * Este arquivo NÃO usa header.php porque tem design próprio
 */

// Inicia sessão
session_start();

// Configurações do Banco de Dados - CONFIGURE AQUI (igual no header.php)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sebo_database');

// Redireciona se já estiver logado
if (isset($_SESSION['usuario_logado'])) {
    header('Location: dashboard.php');
    exit;
}

// Processa o login
$erro = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conexão com banco
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    
    if ($email && $senha) {
        $stmt = $conn->prepare("
            SELECT u.id_usuario, u.nome_usuario, u.email_usuario, u.senha_usuario, 
                   u.tipo_usuario, p.foto_usuario
            FROM tbl_usuario u
            LEFT JOIN tbl_perfil_usuario p ON u.id_usuario = p.id_usuario
            WHERE u.email_usuario = ? AND u.excluido_em IS NULL
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            
            // Verifica a senha (suporta hash ou texto plano para teste)
            if (password_verify($senha, $usuario['senha_usuario']) || $senha === $usuario['senha_usuario']) {
                // Login bem-sucedido
                $_SESSION['usuario_logado'] = true;
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                $_SESSION['email_usuario'] = $usuario['email_usuario'];
                $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
                $_SESSION['foto_usuario'] = $usuario['foto_usuario'];
                
                // Flash message
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Login realizado com sucesso! Bem-vindo(a), ' . $usuario['nome_usuario']
                ];
                
                header('Location: dashboard.php');
                exit;
            } else {
                $erro = 'Email ou senha incorretos!';
            }
        } else {
            $erro = 'Email ou senha incorretos!';
        }
        
        $conn->close();
    } else {
        $erro = 'Preencha todos os campos!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistema Sebo</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html,body {
            font-family: "Raleway", sans-serif; 
            height: 100%;
            margin: 0;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #d4b896 0%, #c8a882 100%);
            padding: 20px;
        }
        .login-box {
            max-width: 500px;
            width: 100%;
        }
        .logo-icon {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 48px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .btn-login {
            background: linear-gradient(135deg, #d4b896 0%, #c8a882 100%);
            color: white;
            transition: all 0.3s;
        }
        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="w3-card-4 w3-white w3-round-large w3-animate-zoom">
                <div class="w3-container w3-center w3-padding-32">
                    <div class="logo-icon">📚</div>
                    <h2 style="color: #5a4a3a; margin: 10px 0;">Sistema Sebo</h2>
                    <p style="color: #8a7a6a; margin: 0;">Onde cada livro tem uma nova chance de ser descoberto</p>
                </div>
                
                <form class="w3-container w3-padding" method="POST">
                    <?php if ($erro): ?>
                        <div class="w3-panel w3-red w3-round w3-display-container">
                            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-red w3-large w3-display-topright">&times;</span>
                            <p><i class="fa fa-exclamation-triangle"></i> <?php echo htmlspecialchars($erro); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <p>
                        <label class="w3-text-grey"><b><i class="fa fa-envelope"></i> Email</b></label>
                        <input class="w3-input w3-border w3-round" type="email" name="email" required placeholder="seu@email.com" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                    </p>
                    
                    <p>
                        <label class="w3-text-grey"><b><i class="fa fa-lock"></i> Senha</b></label>
                        <input class="w3-input w3-border w3-round" type="password" name="senha" required placeholder="••••••••">
                    </p>
                    
                    <p>
                        <label>
                            <input class="w3-check" type="checkbox" name="lembrar">
                            <span class="w3-text-grey"> Lembrar-me</span>
                        </label>
                    </p>
                    
                    <p>
                        <button class="w3-button w3-block w3-round btn-login w3-padding" type="submit">
                            <i class="fa fa-sign-in"></i> <b>Entrar no Sistema</b>
                        </button>
                    </p>
                </form>
                
                <div class="w3-container w3-center w3-padding-16 w3-light-grey">
                    <p style="margin: 5px 0;">
                        <a href="#" style="color: #d4b896; text-decoration: none;">
                            <i class="fa fa-question-circle"></i> Esqueceu a senha?
                        </a>
                    </p>
                    <p style="margin: 5px 0; color: #8a7a6a; font-size: 12px;">
                        © <?php echo date('Y'); ?> Sistema Sebo - Todos os direitos reservados
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
=======
    <div class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin w3-center">
    <h1>Login</h1>
     <form action="/backend/login" method="POST" class="w3-panel w3-center">
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="email_usuario" type="email" placeholder="Email" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="senha_usuario" type="password" placeholder="Senha" required>
            </div>
        </div>
        <button type="submit" class="w3-button w3-blue">Entrar</button>
    </form>
    <a href="/backend/register">Não tenho conta</a>
</div>
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
