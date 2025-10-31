<?php
/**
 * HEADER.PHP - Cabeçalho Completo do Sistema Sebo
 * Inclui: Configurações, Conexão, Funções, Verificação de Login, HTML Header e Menu
 */

// ============================================
// CONFIGURAÇÕES E SESSÃO
// ============================================
session_start();

// Configurações do Banco de Dados - CONFIGURE AQUI
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sebo_database');

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Conexão com o banco de dados
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Define charset para UTF-8
$conn->set_charset("utf8mb4");

// ============================================
// FUNÇÕES GLOBAIS
// ============================================

/**
 * Função para limpar dados de entrada
 */
function limpar_entrada($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Função para formatar datas
 */
function formatar_data($data, $formato = 'd/m/Y') {
    if (empty($data)) return '-';
    $timestamp = strtotime($data);
    return date($formato, $timestamp);
}

/**
 * Função para formatar valores monetários
 */
function formatar_moeda($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

/**
 * Sistema de Flash Messages
 */
class Flash {
    public static function set($type, $message) {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }
    
    public static function get() {
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
}

// ============================================
// VERIFICAÇÃO DE LOGIN
// ============================================
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?> - Sistema Sebo</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
        .stat-card {
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
    <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();">
        <i class="fa fa-bars"></i> Menu
    </button>
    <span class="w3-bar-item w3-right">Sistema Sebo - <?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
    <div class="w3-container w3-row">
        <div class="w3-col s4">
            <div class="w3-circle" style="width:46px; height:46px; background: linear-gradient(135deg, #d4b896, #c8a882); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 20px;">
                <?php echo strtoupper(substr($_SESSION['nome_usuario'], 0, 1)); ?>
            </div>
        </div>
        <div class="w3-col s8 w3-bar">
            <span>Bem-vindo, <strong><?php echo htmlspecialchars($_SESSION['nome_usuario']); ?></strong></span><br>
            <small><?php echo ucfirst($_SESSION['tipo_usuario']); ?></small><br>
            <a href="logout.php" class="w3-bar-item w3-button w3-small" title="Sair">
                <i class="fa fa-sign-out"></i> Sair
            </a>
        </div>
    </div>
    <hr>
    <div class="w3-container">
        <h5><b><i class="fa fa-dashboard"></i> Menu Principal</b></h5>
    </div>
    <div class="w3-bar-block">
        <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="Fechar Menu">
            <i class="fa fa-remove fa-fw"></i> Fechar Menu
        </a>
        <a href="dashboard.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-dashboard fa-fw"></i> Dashboard
        </a>
        <a href="acervo.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'acervo.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-book fa-fw"></i> Acervo
        </a>
        <a href="categorias.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'categorias.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-tags fa-fw"></i> Categorias
        </a>
        <a href="autores.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'autores.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-user-circle fa-fw"></i> Autores
        </a>
        <a href="generos.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'generos.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-list fa-fw"></i> Gêneros
        </a>
        <hr>
        <a href="reservas.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'reservas.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-bookmark fa-fw"></i> Reservas
        </a>
        <a href="vendas.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'vendas.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-shopping-cart fa-fw"></i> Vendas
        </a>
        <hr>
        <a href="usuarios.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'usuarios.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-users fa-fw"></i> Usuários
        </a>
        <a href="avaliacoes.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'avaliacoes.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-star fa-fw"></i> Avaliações
        </a>
        <a href="contatos.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'contatos.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-envelope fa-fw"></i> Contatos
        </a>
        <hr>
        <a href="relatorios.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'relatorios.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-bar-chart fa-fw"></i> Relatórios
        </a>
        <a href="configuracoes.php" class="w3-bar-item w3-button w3-padding <?php echo (basename($_SERVER['PHP_SELF']) == 'configuracoes.php') ? 'w3-blue' : ''; ?>">
            <i class="fa fa-cog fa-fw"></i> Configurações
        </a>
    </div>
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="Fechar menu lateral" id="myOverlay"></div>

<!-- Main content -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

<?php
// Exibe mensagens flash
$flash = Flash::get();
if ($flash) {
    $alert_class = $flash['type'] == 'success' ? 'w3-green' : 'w3-red';
    echo "<div class='w3-panel {$alert_class} w3-display-container w3-round'>";
    echo "<span onclick=\"this.parentElement.style.display='none'\" class='w3-button w3-large w3-display-topright'>&times;</span>";
    echo "<p><strong>" . htmlspecialchars($flash['message']) . "</strong></p>";
    echo "</div>";
}
?>