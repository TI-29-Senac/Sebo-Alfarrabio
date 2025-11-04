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
<<<<<<< HEAD
       
    }
 
=======
        
    }

>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
    public static function get(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(isset($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
<<<<<<< HEAD
            
=======
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
        }
        return null;
    }
}