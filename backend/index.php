<?php
namespace Sebo\Alfarrabio;
ini_set('display_errors', 1);
ini_set('error_log', __DIR__ . '/php_error.log');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Core/helpers.php';

// Carrega variáveis de ambiente (.env)
\Sebo\Alfarrabio\Core\Env::carregar(__DIR__);
use Sebo\Alfarrabio\Rotas\Rotas;

use Bramus\Router\Router;
use Sebo\Alfarrabio\Controllers\Api\APIItemController;




// Rotas da API
// GET /backend/api/item - Lista todos os itens com paginação
// if ($rota === '/backend/api/item' && $metodo === 'GET') {
//     $apiController->listarItens();
//     exit;
// }

// // GET /backend/api/item/{id} - Busca um item específico
// if (preg_match('#^/backend/api/item/(\d+)$#', $rota, $matches) && $metodo === 'GET') {
//     $apiController->buscarItem($matches[1]);
//     exit;
// }

// // GET /backend/api/item/pesquisar - Pesquisa itens
// if ($rota === '/backend/api/item/pesquisar' && $metodo === 'GET') {
//     $apiController->pesquisarItens();
//     exit;
// }

// // GET /backend/api/item/tipos - Lista tipos disponíveis
// if ($rota === '/backend/api/item/tipos' && $metodo === 'GET') {
//     $apiController->listarTipos();
//     exit;
// }

$router = new Router();
// Define o base path dinamicamente
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$router->setBasePath($basePath);


$rotas = Rotas::get();
$router->setNamespace('Sebo\Alfarrabio\Controllers');

foreach ($rotas as $metodoHttp => $rota) {
    foreach ($rota as $uri => $acao) {
        $metodoBramus = strtolower($metodoHttp);
        $router->{$metodoBramus}($uri, $acao); // a dor de cabeça começa aqui
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
    echo "<div style='background: #fee; border: 2px solid red; padding: 20px; font-family: monospace;'>";
    echo "<h1>❌ Erro Fatal no Sistema</h1>";
    echo "<p><strong>Mensagem:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Arquivo:</strong> " . $e->getFile() . " (Linha " . $e->getLine() . ")</p>";
    echo "<h3>Stack Trace:</h3>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
}

/**
 * Rotas da API
 * Adicione estas rotas ao seu arquivo de rotas principal
 */

// Exemplo de como registrar as rotas (adapte ao seu sistema de rotas)

use Sebo\Alfarrabio\Controllers\Api\ItemApiController;

// Instancia o controller
