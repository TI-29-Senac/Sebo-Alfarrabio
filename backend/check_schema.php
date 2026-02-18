<?php
$config = [
    'host' => '69.6.213.160',
    'db_name' => 'hg6c6727_time4_ti29',
    'username' => 'hg6c6727_time4_ti29',
    'password' => 'jeB!O~=l-Zr~',
];

try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['db_name']};charset=utf8", $config['username'], $config['password']);
    $stmt = $pdo->query("DESCRIBE tbl_usuario");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . "|";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
