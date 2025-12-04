<?php
namespace Sebo\Alfarrabio\Controllers\Admin;
use Sebo\Alfarrabio\Core\Redirect;

abstract class AdminController extends AuthenticatedController{
    public function __construct() {
        parent::__construct();
        if ($this->session->get('usuario_tipo') !== 'Admin') {
            Redirect::redirecionarComMensagem(
                '/admin/cliente',
                'error',
                'Você não tem permissão para acessar esta área.'
            );
        }
    }
}
