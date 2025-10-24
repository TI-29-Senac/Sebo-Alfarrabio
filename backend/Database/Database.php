<?php
namespace Sebo\Alfarrabio\Database;
use PDO;
use PDOException;
use Sebo\Alfarrabio\Database\Config;

class Database {
    public $conexao;

    public function __construct() {
        $username = 'root';
        $password = '';
        $host = 'localhost';
        $dbname = 'sebov2_backup';

        try {
            $this->conexao = new PDO(
                'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8mb4',
                $username,
                $password,
                [
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        } catch (PDOException $e) {
            die("Erro na conexão com o banco: " . $e->getMessage());
        }
    }
}
