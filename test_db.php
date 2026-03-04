<?php
require_once __DIR__ . '/backend/Database/Config.php';

use Sebo\Alfarrabio\Database\Config;

$config = Config::get();
$dbConfig = $config['database']['mysql'];

$host = $dbConfig['host'];
$db_name = $dbConfig['db_name'];
$username = $dbConfig['username'];
$password = $dbConfig['password'];
$charset = $dbConfig['charset'];
$port = $dbConfig['port'];

$dsn = "mysql:host=$host;port=$port;dbname=$db_name;charset=$charset";

try {
    $pdo = new PDO($dsn, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    echo "Conexão com o banco de dados [{$db_name}] no host [{$host}] realizada com SUCESSO!\n";
} catch (PDOException $e) {
    echo "ERRO AO CONECTAR:\n";
    echo $e->getMessage() . "\n";
}
