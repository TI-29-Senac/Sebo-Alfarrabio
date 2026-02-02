<?php
require_once __DIR__ . '/vendor/autoload.php';

use Sebo\Alfarrabio\Database\Database;

try {
    $db = Database::getInstance();

    // Buscar todos usuários
    $stmt = $db->query('SELECT id_usuario, nome_usuario, senha_usuario FROM tbl_usuario');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1>Corrigindo Senhas</h1>";
    echo "<pre>";

    foreach ($users as $u) {
        $senhaAtual = $u['senha_usuario'];
        $needsUpdate = false;

        // Verifica se PARECE um hash bcrypt (começa com $2y$ e tem 60 chars)
        if (strlen($senhaAtual) < 60 || substr($senhaAtual, 0, 4) !== '$2y$') {
            $needsUpdate = true;
        }

        if ($needsUpdate) {
            // Assume que a senha atual é plain text e faz o hash
            // SE for muito curta ou vazia, define uma senha padrão '123456'
            $senhaNova = $senhaAtual;
            if (empty($senhaAtual)) {
                $senhaNova = '123456';
            }

            $hash = password_hash($senhaNova, PASSWORD_DEFAULT);

            $update = $db->prepare('UPDATE tbl_usuario SET senha_usuario = :hash WHERE id_usuario = :id');
            $update->execute([':hash' => $hash, ':id' => $u['id_usuario']]);

            echo "Usuario ID {$u['id_usuario']} ({$u['nome_usuario']}): Senha atualizada (era plain text). Nova senha válida para login.\n";
        } else {
            echo "Usuario ID {$u['id_usuario']} ({$u['nome_usuario']}): Senha já é hash. OK.\n";
        }
    }
    echo "</pre>";
    echo "<h2>Concluído. Tente logar agora.</h2>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
