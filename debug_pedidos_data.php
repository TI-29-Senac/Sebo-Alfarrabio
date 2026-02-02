<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Models\Pedidos;

// Conectar ao banco
$db = Database::getInstance();
$pedidosModel = new Pedidos($db);

// Buscar pedidos
$pedidos = $pedidosModel->buscarPedidos();

echo "<h1>Debug: Dados dos Pedidos</h1>";
echo "<h2>Total de pedidos: " . count($pedidos) . "</h2>";

if (!empty($pedidos)) {
    echo "<h3>Primeiro pedido (completo):</h3>";
    echo "<pre>";
    print_r($pedidos[0]);
    echo "</pre>";

    echo "<h3>Chaves disponíveis:</h3>";
    echo "<pre>";
    print_r(array_keys($pedidos[0]));
    echo "</pre>";

    echo "<h3>Todos os pedidos:</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr>";
    foreach (array_keys($pedidos[0]) as $key) {
        echo "<th>$key</th>";
    }
    echo "</tr>";

    foreach ($pedidos as $p) {
        echo "<tr>";
        foreach ($p as $value) {
            echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Nenhum pedido encontrado.</p>";
}
