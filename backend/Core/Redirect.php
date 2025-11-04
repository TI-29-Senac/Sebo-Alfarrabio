<?php
namespace Sebo\Alfarrabio\Core;
<<<<<<< HEAD

class Redirect {
    public static function redirecionarPara($url) {
        // Garante sempre /backend/
        $url = '/backend/' . ltrim($url, '/');
        header("Location: " . $url);
        exit;
    }

    public static function redirecionarComMensagem($url, $tipo, $mensagem) {
        // Garante sempre /backend/
        $url = '/backend/' . ltrim($url, '/');

        // Salva a mensagem na sessão (ou flash se usar)
        $_SESSION['flash'][$tipo] = $mensagem;

        header("Location: " . $url);
        exit;
    }
}
 
=======
use Sebo\Alfarrabio\Core\Flash;

class Redirect {
    public static function redirecionarPara($url){
        header("Location:"."/backend". $url);
        exit;
    }
    public static function redirecionarComMensagem($url, $type, $message){
        Flash::set($type, $message);
        self::redirecionarPara($url);
    }
    public static function voltarPaginaAnteriorComMensagem($type, $message){
        $url = $_SERVER['HTTP_REFERER'] ?? '/';
        self::redirecionarComMensagem($url, $type, $message);
    }
}
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
