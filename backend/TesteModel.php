<?php
require_once __DIR__ . '/Models/Acervo.php';
require_once __DIR__ . '/Database/Database.php';

$acervo = new Acervo($db);


// $acervo->inserirAcervo(
//     $id_acervo,
//     $titulo_acervo,
//     $tipo_item_acervo,
//     $estado_conservacao,
//     $disponibilidade_acervo,
//     $estoque_acervo
// );


//$resultado = $usuario->buscarUsuarios();
//$resultado = $usuario->buscarUsuariosPorEMail('william.reis@emailpro.com');
//$resultado = $acervo->buscarAcervos();
 //$resultado = $acervo->buscarAcervoPorId(3);
//$resultado = $acervo->inserirAcervo($id_acervo, $titulo_acervo, $tipo_item_acervo, $estado_conservacao, $disponibilidade_acervo, $estoque_acervo);
// // Definindo valores de teste
// $id_acervo = null; // geralmente o ID é auto_increment no banco, então pode deixar null
// $titulo_acervo = "Dom Casmurro";
// $tipo_item_acervo = "Livro";
// $estado_conservacao = "Bom";
// $disponibilidade_acervo = "Disponível";
// $estoque_acervo = 5;

// // Agora sim você pode chamar o método
// $resultado = $acervo->inserirAcervo(
//     $id_acervo,
//     $titulo_acervo,
//     $tipo_item_acervo,
//     $estado_conservacao,
//     $disponibilidade_acervo,
//     $estoque_acervo
// );
// $resultado = $acervo->atualizarAcervo($id_acervo, $titulo_acervo, $tipo_item_acervo, $estado_conservacao, $disponibilidade_acervo, $estoque_acervo);
// Definindo valores de teste
$id_acervo = 1; // esse precisa existir no banco, senão não vai atualizar
$titulo_acervo = "Dom Casmurro (Edição Revisada)";
$tipo_item_acervo = "Livro";
$estado_conservacao = "Usado";
$disponibilidade_acervo = "Indisponível";
$estoque_acervo = 2;

// Agora sim chama o método
$resultado = $acervo->atualizarAcervo(
    $id_acervo,
    $titulo_acervo,
    $tipo_item_acervo,
    $estado_conservacao,
    $disponibilidade_acervo,
    $estoque_acervo
);

var_dump($resultado);



