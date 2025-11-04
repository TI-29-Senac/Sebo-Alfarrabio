<?php
namespace Sebo\Alfarrabio\Controllers\Admin;

use Sebo\Alfarrabio\Core\Session;
<<<<<<< HEAD
=======
use Sebo\Alfarrabio\Core\Flash;
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
use Sebo\Alfarrabio\Core\Redirect;

abstract class AuthenticatedController{
    protected Session $session;
<<<<<<< HEAD
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

 
=======
    public function __construct() {
        $this->session = new Session();
        if (!$this->session->has('usuario_id')) {
            Redirect::redirecionarComMensagem(
                '/login',
                'error',
                'Você precisa estar logado para acessar esta página.'
                );
        }
    }
}
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
