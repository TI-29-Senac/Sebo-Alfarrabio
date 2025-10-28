<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Sebo/Livraria</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Fonte literária -->
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

  <style>
    body {
     
      background-color: #f8f4ec;
    }

    /* Sidebar */
    .sidebar {
      background-color: #4b2e05;
      color: #fff;
      min-height: 100vh;
      padding-top: 20px;
    }

    .sidebar a {
      color: #f1e7d0;
      text-decoration: none;
      display: block;
      padding: 10px 20px;
      border-radius: 8px;
      transition: 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #c09a63;
      color: #4b2e05;
      font-weight: bold;
    }

    /* Cards */
    .card-dashboard {
      border: none;
      border-radius: 15px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
      color: #fff;
    }

    .card-yellow { background-color: #e0a100; }
    .card-blue { background-color: #0077b6; }
    .card-green { background-color: #2a9d8f; }
    .card-orange { background-color: #f77f00; }

    .card-dashboard h2 {
      font-size: 2.5rem;
      font-weight: bold;
    }

    /* Tabela */
    .table-container {
      background-color: #fff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
      margin-top: 20px;
    }

    .table thead {
      background-color: #4b2e05;
      color: #fff;
    }

    .btn-editar {
      background-color: #c09a63;
      border: none;
      color: #fff;
      font-weight: bold;
    }

    .btn-excluir {
      background-color: #a63a3a;
      border: none;
      color: #fff;
      font-weight: bold;
    }

    .btn-editar:hover { background-color: #b88a50; }
    .btn-excluir:hover { background-color: #922e2e; }

    /* Título */
    .dashboard-title {
      color: #4b2e05;
      font-weight: 700;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    
    <!-- Sidebar -->
    <div class="col-md-2 sidebar">
      <h4 class="text-center mb-4">📚 Sebo/Livraria</h4>
      <a href="#" class="active">Dashboard</a>
      <a href="/backend/usuarios/listar/1">Usuários</a>
      <a href="/backend/acervo/listar/1">Acervo</a>
      <a href="#">Categorias</a>
      <a href="/backend/vendas/listar/1">Vendas</a>
      <a href="/backend/contato/listar/1">Contatos</a>
      <a href="#">Histórico</a>
      <a href="#">Configurações</a>
    </div>

    <!-- Main content -->
    <div class="col-md-10 p-4">
      <h3 class="dashboard-title">📊 Meu Dashboard</h3>

    


 
<?php
use Sebo\Alfarrabio\Core\Flash;
$mensagem = Flash::get();
if(isset($mensagem)){
    foreach($mensagem as $key => $value){
        if($key == "type"){
            $tipo = $value == "success" ? "alert-success" : "alert-danger";
            echo "<div class='alert $tipo' role='alert'>";
        }else{
            echo $value;
            echo "</div>";
        }
    }
}
 
?>