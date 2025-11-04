<?php
namespace Sebo\Alfarrabio\Controllers\Admin;
<<<<<<< HEAD
=======

use Sebo\Alfarrabio\Core\Flash;
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
use Sebo\Alfarrabio\Core\Redirect;

abstract class AdminController extends AuthenticatedController{
    public function __construct() {
<<<<<<< HEAD
        parent:: __construct();
        if ($this->session->get('usuario_tipo') !== 'admin') {
            Redirect::redirecionarComMensagem(
                'admin/dashboard',
                'error',
                'Você não tem permissão para acessar esta área.'
            );
        }
    }
}
=======
        parent::__construct();
        if ($this->session->get('usuario_tipo') !== 'admin') {
            Redirect::redirecionarComMensagem(
                '/admin/dashboard',
                'error',
                 'Você não tem permissão para acessar esta área.'
                ); 
        }
    }
}
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
