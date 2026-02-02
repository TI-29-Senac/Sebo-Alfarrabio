<?php
require_once __DIR__ . '/backend/Core/Env.php';
require_once __DIR__ . '/backend/Database/Config.php';

use Sebo\Alfarrabio\Database\Config;

// Carrega variáveis de ambiente (se necessário, mas Config.php já tem os valores hardcoded agora)
\Sebo\Alfarrabio\Core\Env::carregar(__DIR__ . '/backend');

echo "<h1>Teste de Conexão com Banco de Dados</h1>";

$config = Config::get();
$dbConfig = $config['database']['mysql'];

echo "<p><strong>Host:</strong> {$dbConfig['host']}</p>";
echo "<p><strong>Database:</strong> {$dbConfig['db_name']}</p>";
echo "<p><strong>User:</strong> {$dbConfig['username']}</p>";

try {
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['db_name']};charset={$dbConfig['charset']};port={$dbConfig['port']}";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h2 style='color:green'>✅ Conexão bem-sucedida!</h2>";

    // Listar tabelas
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "<h3>Tabelas Encontradas (" . count($tables) . "):</h3>";
    echo "<ul>";
    foreach ($tables as $table) {
        // Contar registros em cada tabela
        $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        echo "<li>$table (<strong>$count</strong> registros)</li>";
    }
    echo "</ul>";

    // Verificar especificamente tbl_usuario e admin
    if (in_array('tbl_usuario', $tables)) {
        echo "<h3>Verificando Admin em tbl_usuario:</h3>";
        $stmtAdmin = $pdo->query("SELECT id_usuario, nome_usuario, email_usuario, tipo_usuario FROM tbl_usuario WHERE tipo_usuario = 'Admin' OR email_usuario LIKE '%admin%'");
        $admins = $stmtAdmin->fetchAll(PDO::FETCH_ASSOC);

        if (count($admins) > 0) {
            echo "<table border='1'><tr><th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th></tr>";
            foreach ($admins as $admin) {
                echo "<tr><td>{$admin['id_usuario']}</td><td>{$admin['nome_usuario']}</td><td>{$admin['email_usuario']}</td><td>{$admin['tipo_usuario']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color:red'>❌ Nenhum usuário 'Admin' encontrado!</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Tabela tbl_usuario não encontrada!</p>";
    }

} catch (PDOException $e) {
    echo "<h2 style='color:red'>❌ Erro na conexão:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
