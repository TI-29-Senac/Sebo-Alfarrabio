<?php
namespace Sebo\Alfarrabio\Controllers\Admin;

use Sebo\Alfarrabio\Core\Session;
use Sebo\Alfarrabio\Core\Redirect;

abstract class AuthenticatedController{
    protected Session $session;
    public function _construct() {
        $this->session = new Session();
        if (!$this->session->has('usuario_id')) {
            Redirect::redirecionarComMensagem(
                'login',
                'error',
                'Você precisa estar logado para acessar esta página.'
            );
        }
    }
}

 