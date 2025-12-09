<?php
namespace Sebo\Alfarrabio\Config;

class Mail{
    public static function get(){
        return [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username'=> 'seboalfarrabioteste@gmail.com',
            'password'=> 'krrw qlap iyre ypvs',
            'encryption'=> 'tls',
            'from_address'=> 'noreply@kipedreiro.com',
            'from_name'=> 'Sebo-Alfarrabio',
            
        ];
    }
}