<?php
namespace Sebo\Alfarrabio\Core;

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
 