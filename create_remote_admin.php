<?php
require_once __DIR__ . '/backend/Database/Config.php';
use Sebo\Alfarrabio\Database\Config;

$config = Config::get();
$dbConfig = $config['database']['mysql'];

try {
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['db_name']};charset={$dbConfig['charset']};port={$dbConfig['port']}";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);

    // Check if user exists
    $email = 'admin@alfarrabio.com';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_usuario WHERE email_usuario = ?");
    $stmt->execute([$email]);

    if ($stmt->fetchColumn() > 0) {
        $newPass = 'admin123';
        $hash = password_hash($newPass, PASSWORD_DEFAULT);
        $stmtUpdate = $pdo->prepare("UPDATE tbl_usuario SET senha_usuario = ?, tipo_usuario = 'Admin' WHERE email_usuario = ?");
        $stmtUpdate->execute([$hash, $email]);
        echo "✅ Usuário $email já existia. Senha atualizada para 'admin123' e tipo garantido como 'Admin'.";
    } else {
        $senha = password_hash('admin123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbl_usuario (nome_usuario, email_usuario, senha_usuario, tipo_usuario) VALUES (?, ?, ?, ?)";
        $stmtInsert = $pdo->prepare($sql);
        $stmtInsert->execute(['Administrador Remoto', $email, $senha, 'Admin']);
        echo "✅ Usuário Admin ($email) criado com sucesso no banco remoto! Senha: admin123";
    }

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
