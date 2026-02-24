<?php
namespace Sebo\Alfarrabio;

ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_error.log');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

// Configuração de Sessão Persistente (1 dia)
$lifetime = 86400; // 24 horas
ini_set('session.gc_maxlifetime', $lifetime);
session_set_cookie_params([
    'lifetime' => $lifetime,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Core/helpers.php';

// Carrega variáveis de ambiente (.env)
\Sebo\Alfarrabio\Core\Env::carregar(__DIR__);

use Sebo\Alfarrabio\Rotas\Rotas;
use Bramus\Router\Router;

$router = new Router();

// Define o base path dinamicamente
$scriptName = $_SERVER['SCRIPT_NAME'];
$requestUri = $_SERVER['REQUEST_URI'];

// Se a requisição vem da raiz (ex: /sitemap.xml ou /livro-...) 
// e o scriptName é backend/index.php, o basePath deve ser vazio.
if (strpos($requestUri, '/backend/') === false && (strpos($scriptName, '/backend/') !== false)) {
    $basePath = '';
} else {
    $basePath = str_replace('\\', '/', dirname($scriptName));
    if ($basePath === '/' || $basePath === '.') {
        $basePath = '';
    }
}

$router->setBasePath($basePath);

$rotas = Rotas::get();
$router->setNamespace('Sebo\Alfarrabio\Controllers');

foreach ($rotas as $metodoHttp => $rota) {
    foreach ($rota as $uri => $acao) {
        $metodoBramus = strtolower($metodoHttp);
        $router->{$metodoBramus}($uri, $acao);
    }
}

$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo '404, Rota não encontrada!';
});

try {
    $router->run();
} catch (\Throwable $e) {
    http_response_code(500);

    // Loga o erro completo (caminhos, stack trace) apenas no log do servidor
    error_log("ERRO FATAL: {$e->getMessage()} em {$e->getFile()}:{$e->getLine()}");
    error_log("Stack trace: {$e->getTraceAsString()}");

    // Verifica se é uma requisição API ou espera JSON
    $isApi = (strpos($_SERVER['REQUEST_URI'] ?? '', '/api/') !== false);
    $acceptsJson = (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);
    $isJsonRequest = (strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false);

    if ($isApi || $acceptsJson || $isJsonRequest) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'status' => 'error',
            'message' => 'Erro interno no servidor. Tente novamente mais tarde.'
        ]);
        exit;
    }

    echo "<div style='background: #fee; border: 2px solid red; padding: 20px; font-family: sans-serif; text-align: center;'>";
    echo "<h1>❌ Erro Interno</h1>";
    echo "<p>Desculpe, ocorreu um erro inesperado. Por favor, tente novamente mais tarde.</p>";
    echo "</div>";
}