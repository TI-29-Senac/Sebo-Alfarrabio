<?php
 
namespace Sebo\Alfarrabio\Database;
 
class Config
{
    public static function get()
    {
        return [
            'database' => array (
  'driver' => 'mysql',
  'mysql' =>
  array (
    'host' => 'localhost',
    'db_name' => 'sebov2_1',
    'username' => 'root',
    'password' => NULL,
    'charset' => 'utf8',
    'port' => NULL,
  ),
)
        ];
    }
}