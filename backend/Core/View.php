<?php
namespace Sebo\Alfarrabio\Core;

class View{
    public static function render($nomeView, $dados = []){
        // extrair os dados do array para variáveis
        extract($dados);
        require_once __DIR__."/../Views/templates/partials/header.php";
        require_once __DIR__."/../Views/templates/{$nomeView}.php";
        require_once __DIR__."/../Views/templates/partials/footer.php";
    }

    public static function renderPublic($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../Views/public/{$view}.php";
    }
}
