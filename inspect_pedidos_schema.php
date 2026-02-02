<?php
require_once __DIR__ . '/backend/Core/Env.php';
\Sebo\Alfarrabio\Core\Env::carregar(__DIR__ . '/backend');

$host = getenv('DB_HOST') ?: 'localhost';
$db = getenv('DB_NAME') ?: 'alfarrabio_novo';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $stmt = $pdo->query("DESCRIBE tbl_pedidos");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<h1>Colunas da tabela tbl_pedidos</h1>";
    echo "<pre>";
    print_r($columns);
    echo "</pre>";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
