<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Database/Database.php';

$usuario = new Usuario($db);

//$resultado = $usuario->buscarUsuarios();
//$resultado = $usuario->inserirUsuarios("Kezia", "kezia@gmail.com", "senha123", "cliente");
//$resultado = $usuario->atualizarUsuarios("23", "Junior Ferreira", "juniorf@gmail.com", "senha123", "admin");
$resultado = $usuario->excluirUsuario(1);
var_dump($resultado);
