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
$password = ''; // senha vazia no XAMPP
$host = '127.0.0.1'; // use 127.0.0.1 em vez de localhost
$dbname = 'sebov2_1'; // se o nome do seu banco for esse
$port = '3307'; // troque pela porta que você colocou no XAMPP (a que está no my.ini)


        try {
            $this->conexao = new PDO(
                   'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';charset=utf8mb4',
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

    


