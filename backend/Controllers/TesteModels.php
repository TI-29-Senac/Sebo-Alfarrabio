<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Models/Acervo.php';
require_once __DIR__ . '/../Database/Database.php';

$usuario = new Usuario($db);
$acervo = new Acervo($db);

//$resultado = $usuario->buscarUsuarios();
//var_dump($resultado);

//$resultado = $acervo->buscarAcervo();
//var_dump($resultado);

//$resultado = $acervo->buscarAcervoInativo();
//var_dump($resultado);

// Inserir Acervo
$resultado = $acervo->inserirItemAcervo( 'A Bela e a Fera', 'Livro', 'Novo', 'Em estoque', 5);
var_dump($resultado);