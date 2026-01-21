<?php
namespace Sebo\Alfarrabio;
require_once __DIR__.'/../vendor/autoload.php';
use Sebo\Alfarrabio\Rotas\Rotas;
 
use Bramus\Router\Router;
use Sebo\Alfarrabio\Controllers\Api\APIItemController;




// Rotas da API
// GET /backend/api/item - Lista todos os itens com paginação
if ($rota === '/backend/api/item' && $metodo === 'GET') {
    $apiController->listarItens();
    exit;
}

// GET /backend/api/item/{id} - Busca um item específico
if (preg_match('#^/backend/api/item/(\d+)$#', $rota, $matches) && $metodo === 'GET') {
    $apiController->buscarItem($matches[1]);
    exit;
}

// GET /backend/api/item/pesquisar - Pesquisa itens
if ($rota === '/backend/api/item/pesquisar' && $metodo === 'GET') {
    $apiController->pesquisarItens();
    exit;
}

// GET /backend/api/item/tipos - Lista tipos disponíveis
if ($rota === '/backend/api/item/tipos' && $metodo === 'GET') {
    $apiController->listarTipos();
    exit;
}

$router = new Router();
 
 
$rotas = Rotas::get();
$router->setNamespace('Sebo\Alfarrabio\Controllers');
 
foreach ($rotas as $metodoHttp => $rota) {
    foreach ($rota as $uri => $acao){
        $metodoBramus = strtolower($metodoHttp);
        $router->{$metodoBramus}($uri, $acao); // a dor de cabeça começa aqui
    }
}
$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo '404, Rota não encontrada!';
});
 
$router->run();

/**
 * Rotas da API
 * Adicione estas rotas ao seu arquivo de rotas principal
 */

// Exemplo de como registrar as rotas (adapte ao seu sistema de rotas)

use Sebo\Alfarrabio\Controllers\Api\ItemApiController;

// Instancia o controller
