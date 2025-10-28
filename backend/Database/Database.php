<?php
namespace Sebo\Alfarrabio\Database;
use PDO;
use PDOException;
use Exception;
use Sebo\Alfarrabio\Database\Config;

class Database {
    public $conexao;

    public function __construct() {
        $username = 'root';
        $password = '';
        $host = 'localhost';
        $dbname = 'sebov2.1';

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
    public static function getInstance() {
        static $instance = null;
        if ($instance === null) {
            $instance = new Database();
        }
        return $instance->conexao;
    }
}

    


