<?php
namespace Sebo\Alfarrabio\Core;
class View{
    public static function render($nomeView, $dados = []){
        // extrair os dados do array para variáveis
        extract($dados);
        // incluir o arquivo da view
        //require_once __DIR__ . "/../Views/templates/partials/header.php";
        if(isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Cliente'){
            require_once __DIR__ . "/../Views/templates/admin/cliente/partials/header.php";
        } else {
            require_once __DIR__ . "/../Views/templates/partials/header.php";
        }

        require_once __DIR__ . "/../Views/templates/{$nomeView}.php";
        require_once __DIR__ . "/../Views/templates/partials/footer.php";
        
    }

}
