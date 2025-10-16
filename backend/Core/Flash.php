<?php
namespace Sebo\Alfarrabio\Core;
class Flash
{
    public static function set($type, $message){
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
       
    }
 
    public static function get(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }
}