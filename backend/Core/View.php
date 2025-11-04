<?php
namespace Sebo\Alfarrabio\Core;
<<<<<<< HEAD
=======

>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
class View{
    public static function render($nomeView, $dados = []){
        // extrair os dados do array para variáveis
        extract($dados);
<<<<<<< HEAD
        // incluir o arquivo da view
        require_once __DIR__ . "/../Views/templates/partials/header.php";
        require_once __DIR__ . "/../Views/templates/{$nomeView}.php";
        require_once __DIR__ . "/../Views/templates/partials/footer.php";
        
    }

}
=======
        require_once __DIR__."/../Views/templates/partials/header.php";
        require_once __DIR__."/../Views/templates/{$nomeView}.php";
        require_once __DIR__."/../Views/templates/partials/footer.php";
    }

    public static function renderPublic($view, $data = []) {
        extract($data);
        require_once __DIR__ . "/../Views/public/{$view}.php";
    }
}
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
