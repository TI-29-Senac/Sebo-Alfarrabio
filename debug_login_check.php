<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Models\Usuario;

try {
    $db = Database::getInstance();
    $usuarioModel = new Usuario($db);

    echo "<h1>Debug Login</h1>";

    // Tenta simular o login com o usuário Carla (ID 3)
    $email = 'carla.menezes@email.com';
    $senha = '123456'; // Senha que definimos no fix_login.php se a original estivesse vazia, ou a hash da original

    echo "<h2>Testando usuario: $email</h2>";

    // 1. Verificar o que está no banco
    $stmt = $db->prepare('SELECT * FROM tbl_usuario WHERE email_usuario = :email');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "❌ Usuário não encontrado no banco.<br>";
    } else {
        echo "✅ Usuário encontrado. ID: " . $user['id_usuario'] . "<br>";
        echo "Hash no banco: " . $user['senha_usuario'] . "<br>";

        // 2. Tentar password_verify com 'senha123' (senha original do seed)
        echo "<h3>Tentativa 1: senha 'senha123'</h3>";
        if (password_verify('senha123', $user['senha_usuario'])) {
            echo "✅ SUCESSO! A senha é 'senha123'.<br>";
        } else {
            echo "❌ Falha. Não é 'senha123'.<br>";
        }

        // 3. Tentar password_verify com '123456'
        echo "<h3>Tentativa 2: senha '123456'</h3>";
        if (password_verify('123456', $user['senha_usuario'])) {
            echo "✅ SUCESSO! A senha é '123456'.<br>";
        } else {
            echo "❌ Falha. Não é '123456'.<br>";
        }
    }

    echo "<hr>";
    echo "<h3>Verificando se houve trigger ou erro no update anterior</h3>";
    // Listar todos usuarios novamente
    $stmt = $db->query('SELECT nome_usuario, email_usuario, senha_usuario FROM tbl_usuario LIMIT 5');
    echo "<pre>";
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    echo "</pre>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
