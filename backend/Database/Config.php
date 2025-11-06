<?php
/**
 * Configuração do Sistema
 * Sebo Alfarrábio Dashboard
 * @version 2.1
 */

namespace Sebo\Alfarrabio\Database;
use PDO;
use PDOException;

// ================================
// CONFIGURAÇÃO PRINCIPAL (OBRIGATÓRIA)
// ================================
class Config
{
    public static function get()
    {
        return [
            'database' => array(
                'driver' => 'mysql',
                'mysql' => array(
                    'host'     => '216.172.172.207',
                    'db_name'  => 'faust537_time4_ti29',
                    'username' => 'faust537_time4_ti29',
                    'password' => 'f9n^dU^a9Z1V',
                    'charset'  => 'utf8',
                    'port'     => '3306',
                ),
            ),
            'app' => [
                'name'  => 'Sebo Alfarrábio',
                'url'   => 'http://localhost/sebo-alfarrabio',
                'email' => 'admin@seboalfarrabio.com'
            ]
        ];
    }
}

