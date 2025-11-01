<?php
/**
 * Configuração do Sistema
 * Sebo Alfarrábio Dashboard
 * @version 2.1
 */

namespace Sebo\Alfarrabio\Database;
use PDO;
use PDOException;

// ================================
// CONFIGURAÇÃO PRINCIPAL (OBRIGATÓRIA)
// ================================
class Config
{
    public static function get()
    {
        return [
            'database' => array(
                'driver' => 'mysql',
                'mysql' => array(
                    'host'     => 'localhost',
                    'db_name'  => 'sebov2_1',
                    'username' => 'root',
                    'password' => NULL,
                    'charset'  => 'utf8',
                    'port'     => NULL,
                ),
            ),
            'app' => [
                'name'  => 'Sebo Alfarrábio',
                'url'   => 'http://localhost/sebo-alfarrabio',
                'email' => 'admin@seboalfarrabio.com'
            ]
        ];
    }
}

// ================================
// TIMEZONE E SESSÃO
// ================================
date_default_timezone_set('America/Sao_Paulo');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ================================
// CONEXÃO PDO (usa Config::get())
// ================================
class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $cfg = Config::get()['database']['mysql'];

        $dsn = "mysql:host={$cfg['host']};dbname={$cfg['db_name']};charset={$cfg['charset']}";
        if ($cfg['port']) {
            $dsn .= ";port={$cfg['port']}";
        }

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->conn = new PDO($dsn, $cfg['username'], $cfg['password'], $options);
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

// ================================
// FUNÇÕES AUXILIARES DE AUTENTICAÇÃO
// ================================
function isLoggedIn()
{
    return isset($_SESSION['user_id']) && isset($_SESSION['user_tipo']);
}

function admin()
{
    return isLoggedIn() && $_SESSION['user_tipo'] === 'admin';
}

function funcionario()
{
    return isLoggedIn() && $_SESSION['user_tipo'] === 'funcionario';
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function requireAdmin()
{
    requireLogin();
    if (!admin()) {
        header('Location: dashboard.php');
        exit;
    }
}

// ================================
// FUNÇÕES ÚTEIS
// ================================
function sanitize($data)
{
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function formatarData($data)
{
    return date('d/m/Y', strtotime($data));
}

function formatarMoeda($valor)
{
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

// ================================
// CONSTANTES DO SISTEMA (para compatibilidade)
// ================================
define('SITE_NAME', Config::get()['app']['name']);
define('SITE_URL', Config::get()['app']['url']);
define('ADMIN_EMAIL', Config::get()['app']['email']);