<?php
// backend/dashboard/index.php

// ATIVA ERROS
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CARREGA A CLASSE ROTAS
require_once __DIR__ . '/../Rotas/Rotas.php';

// EXECUTA O MÉTODO GET() PARA PEGAR AS ROTAS
$rotas = \Sebo\Alfarrabio\Rotas\Rotas::get();

// PEGA A ROTA ATUAL
$request = $_SERVER['REQUEST_URI'];
$base = '/backend/dashboard';
$route = str_replace($base, '', $request);
$route = ltrim($route, '/');
$route = $route === '' ? 'dashboard' : $route;

// REMOVE QUERY STRING
if (($pos = strpos($route, '?')) !== false) {
    $route = substr($route, 0, $pos);
}

// DEBUG (descomente para ver a rota)
// echo "Rota solicitada: '$route'"; exit;

// SEPARA MÉTODO HTTP
$method = $_SERVER['REQUEST_METHOD']; // GET ou POST

// BUSCA NA ARRAY CORRETA
if (isset($rotas[$method][$route])) {
    $acao = $rotas[$method][$route];
} else {
    // Tenta com {id}
    $acao = null;
    foreach ($rotas[$method] as $padrao => $controllerMethod) {
        $padraoRegex = preg_replace('#\{id\}#', '(\d+)', $padrao);
        $padraoRegex = '#^' . $padraoRegex . '$#';
        if (preg_match($padraoRegex, $route, $matches)) {
            array_shift($matches);
            $acao = $controllerMethod;
            $params = $matches;
            break;
        }
    }
}

if ($acao) {
    [$controller, $metodo] = explode('@', $acao);
    $controllerFile = __DIR__ . "/../Controllers/{$controller}.php";

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        $obj = new $controller;
        if (isset($params)) {
            call_user_func_array([$obj, $metodo], $params);
        } else {
            call_user_func([$obj, $metodo]);
        }
    } else {
        die("Controller não encontrado: {$controllerFile}");
    }
} else {
    http_response_code(404);
    echo "<h1>404 - Rota não encontrada</h1>";
    echo "<p>Rota: <code>{$method} {$route}</code></p>";
}