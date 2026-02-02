<?php
require_once __DIR__ . '/backend/Database/Config.php';
use Sebo\Alfarrabio\Database\Config;

$config = Config::get();
$dbConfig = $config['database']['mysql'];

try {
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['db_name']};charset={$dbConfig['charset']};port={$dbConfig['port']}";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);

    $stmt = $pdo->query("DESCRIBE tbl_itens");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1>Colunas da tabela tbl_itens (Remoto)</h1>";
    echo "<pre>";
    print_r($columns);
    echo "</pre>";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
