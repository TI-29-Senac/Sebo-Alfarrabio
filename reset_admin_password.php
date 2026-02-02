<?php
require_once __DIR__ . '/backend/Core/Env.php';
\Sebo\Alfarrabio\Core\Env::carregar(__DIR__ . '/backend');

$host = getenv('DB_HOST') ?: 'localhost';
$db = getenv('DB_NAME') ?: 'alfarrabio_novo';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

    $email = 'admin@alfarrabio.com';
    $newPass = 'admin123';
    $hash = password_hash($newPass, PASSWORD_DEFAULT);

    $sql = "UPDATE tbl_usuario SET senha_usuario = :hash WHERE email_usuario = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':hash' => $hash, ':email' => $email]);

    if ($stmt->rowCount() > 0) {
        echo "✅ Senha do admin ($email) resetada para: <strong>$newPass</strong>";
    } else {
        echo "⚠️ Nenhum usuário encontrado com email $email ou a senha já é essa.";
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
