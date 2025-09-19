<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Database/Database.php';

$usuario = new Usuario($db);

// Buscar Usuários

//$resultado = $usuario->buscarUsuarios();
//$resultado = $usuario->buscarUsuariosPorEmail($email_usuario = 'fabio.alves@email.com');
//$resultado = $usuario->buscarUsuariosPorID($id_usuario = 17);
//$resultado = $usuario->buscarUsuariosPorTipo($tipo_usuario = 'Funcionario');

//Inserir e Atualizar Usuários

//$resultado = $usuario->inserirUsuarios("pedro", "pedro@gmail.com", "senha123", "cliente");
//$resultado = $usuario->atualizarUsuarios("24", "carlos Ferreira", "carlosf@gmail.com", "senha123", "admin");

//Excluir Usuários

//$resultado = $usuario->excluirUsuarios($id_usuario = 14);
var_dump($resultado);
