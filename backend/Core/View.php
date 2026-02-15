<?php
namespace Sebo\Alfarrabio\Core;
class View
{
    /**
     * Renderiza uma view.
     * @param string $nomeView Nome da view (ex: 'home/index')
     * @param array $dados Dados a serem passados para a view.
     */
    public static function render(string $nomeView, array $dados = [])
    {
        // Proteção contra LFI: Sanitiza o nome da view removendo tentativas de traversal
        $nomeView = str_replace(['../', '..\\'], '', $nomeView);
        $caminhoView = __DIR__ . "/../Views/templates/{$nomeView}.php";

        if (!file_exists($caminhoView)) {
            throw new \Exception("A view '{$nomeView}' não foi encontrada.");
        }

        extract($dados);

        // Verifica tipo de usuário para carregar o header correto
        if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'Cliente') {
            require_once __DIR__ . "/../Views/templates/admin/cliente/partials/header.php";
        } else {
            require_once __DIR__ . "/../Views/templates/partials/header.php";
        }

        require_once $caminhoView;

        require_once __DIR__ . "/../Views/templates/partials/footer.php";
    }

}
