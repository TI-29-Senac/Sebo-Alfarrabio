<?php
namespace Sebo\Alfarrabio\Config;

class Mail{
    public static function get(){
        return [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username'=> 'cristinenathaly5@gmail.com',
            'password'=> 'urxk icxz avyj gxyh',
            'encryption'=> 'tls',
            'from_address'=> 'noreply@kipedreiro.com',
            'from_name'=> 'Sebo-Alfarrabio',
            
        ];
    }
}