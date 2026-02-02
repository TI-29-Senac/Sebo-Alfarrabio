<?php
require_once __DIR__ . '/backend/Core/Env.php';
\Sebo\Alfarrabio\Core\Env::carregar(__DIR__ . '/backend');

$host = getenv('DB_HOST') ?: 'localhost';
$db = getenv('DB_NAME') ?: 'alfarrabio_novo';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $stmt = $pdo->query("SELECT id_usuario, nome_usuario, email_usuario, tipo_usuario, senha_usuario FROM tbl_usuario");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1>Lista de Usuários</h1>";
    echo "<table border='1'><tr><th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th><th>Hash Senha (Início)</th></tr>";
    foreach ($users as $u) {
        echo "<tr>";
        echo "<td>{$u['id_usuario']}</td>";
        echo "<td>{$u['nome_usuario']}</td>";
        echo "<td>{$u['email_usuario']}</td>";
        echo "<td>'{$u['tipo_usuario']}'</td>"; // Quotes to check whitespace
        echo "<td>" . substr($u['senha_usuario'], 0, 10) . "...</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
