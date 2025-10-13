<?php


require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../Models/CDs.php';
require_once __DIR__ . '/../Models/Discos.php';
require_once __DIR__ . '/../Models/DVDs.php';
require_once __DIR__ . '/../Models/Livros.php';
require_once __DIR__ . '/../Models/Revistas.php';

use Models\Revistas;


$db = new Database();

$cds = new CDs($db);
$discos = new Discos($db);
$dvds = new DVDs($db);
$livros = new Livros($db);  
$revistas = new Revistas($db);


// $resultado = $usuario->buscarTodosUsuarios();
// $resultado = $usuario->buscarUsuarioPorEmail('eclabburnro@mapquest.com');
// var_dump($resultado);
 $resultado = $usuario->buscarUsuarioPorId(1);
var_dump($resultado);



