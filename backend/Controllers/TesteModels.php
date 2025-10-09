<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../Models/Vendas.php';
$db = new Database();
$usuario = new Usuario($db);
$vendas = new Vendas($db);

// Buscar Usuários

$resultado = $vendas->buscarVendas();
//$resultado = $vendas->buscarVendasPorData($data_venda = '2025-09-01 10:00:00');
//$resultado = $usuario->buscarUsuariosPorID($id_usuario = 17);
//$resultado = $usuario->buscarUsuariosPorTipo($tipo_usuario = 'Funcionario');

//Inserir e Atualizar Usuários

//$resultado = $usuario->inserirUsuarios("pedro", "pedro@gmail.com", "senha123", "cliente");
//$resultado = $usuario->atualizarUsuarios("24", "carlos Ferreira", "carlosf@gmail.com", "senha123", "admin");

//Excluir Usuários

//$resultado = $usuario->excluirUsuarios($id_usuario = 14);
var_dump($resultado);


