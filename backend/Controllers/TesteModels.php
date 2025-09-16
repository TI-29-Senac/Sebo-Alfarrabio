<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Database/Database.php';

$usuario = new Usuario($db);

$resultado = $usuario->buscarUsuarios();
$resultado = $usuario->excluirUsuario();
var_dump($resultado);
