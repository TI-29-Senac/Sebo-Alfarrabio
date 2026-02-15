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
                 'host' => '69.6.213.160',
                'db_name' => 'hg6c6727_time4_ti29',
                'username' => 'hg6c6727_time4_ti29',
                'password' => 'jeB!O~=l-Zr~',
                'charset' => 'utf8',
                'port' =>  '3306',
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

