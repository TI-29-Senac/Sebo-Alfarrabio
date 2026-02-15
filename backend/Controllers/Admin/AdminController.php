<?php
namespace Sebo\Alfarrabio\Controllers\Admin;
use Sebo\Alfarrabio\Core\Redirect;

abstract class AdminController extends AuthenticatedController
{
    public function __construct()
    {

        parent::__construct();
        if (strcasecmp($this->session->get('usuario_tipo') ?? '', 'Admin') !== 0) {
            Redirect::redirecionarComMensagem(
                '/backend/admin/cliente',
                'success',
                'Bem vindo (a)!! Essa é a sua área de cliente.'
            );
        }
    }
}
