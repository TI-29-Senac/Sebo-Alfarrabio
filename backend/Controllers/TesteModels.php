<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../Models/Endereco.php';

$acervo = new Acervo($db);
$endereco = new Endereco($db);
$usuario = new Usuario($db); 
$livros = new Livros($db);   

// $resultado = $usuario->buscarTodosUsuarios();
// $resultado = $usuario->buscarUsuarioPorEmail('eclabburnro@mapquest.com');
// var_dump($resultado);
 $resultado = $usuario->buscarUsuarioPorId(1);
var_dump($resultado);



