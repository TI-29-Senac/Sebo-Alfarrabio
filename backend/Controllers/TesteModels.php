<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Models/Vendas.php';
require_once __DIR__ . '/../Database/Database.php';

$usuario = new Usuario($db);

$resultado = $usuario->buscarUsuarios();

var_dump($resultado);