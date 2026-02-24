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
                'host' => getenv('DB_HOST') ?: '69.6.213.160',
                'db_name' => getenv('DB_NAME') ?: 'hg6c6727_time4_ti29',
                'username' => getenv('DB_USER') ?: 'hg6c6727_time4_ti29',
                'password' => getenv('DB_PASS') ?: 'jeB!O~=l-Zr~',
                'charset' => 'utf8',
                'port' => getenv('DB_PORT') ?: '3306',
                ),
            ),
            'app' => [
                'name'  => getenv('APP_NAME') ?: 'Sebo Alfarrábio',
                'url'   => getenv('APP_URL') ?: 'http://localhost/sebo-alfarrabio',
                'email' => getenv('APP_EMAIL') ?: 'admin@seboalfarrabio.com'
            ]
        ];
    }
}

