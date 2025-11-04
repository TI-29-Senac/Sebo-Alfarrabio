<?php
namespace Sebo\Alfarrabio;
require_once __DIR__.'/../vendor/autoload.php';
use Sebo\Alfarrabio\Rotas\Rotas;
<<<<<<< HEAD
 
use Bramus\Router\Router;
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
=======

use Bramus\Router\Router;
$router = new Router();


$rotas = Rotas::get();
$router->setNamespace("Sebo\Alfarrabio\Controllers");

foreach($rotas as $metodoHttp => $rota){
    foreach($rota as $uri => $acao){
        $metodoBramus = strtolower($metodoHttp);
        $router->{$metodoBramus}($uri, $acao);
    }
}
$router->set404(function() {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo '404, rota não encontrada!';
});

$router->run();
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
