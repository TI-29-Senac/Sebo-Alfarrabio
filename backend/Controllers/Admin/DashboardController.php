<?php
namespace Sebo\Alfarrabio\Controllers\Admin;

use Sebo\Alfarrabio\Controllers\Admin\AuthenticatedController;
use Sebo\Alfarrabio\Core\View;

class DashboardController extends AuthenticatedController{
    public function index(): void{
        View::render('admin/dashboard/index', [
            'nomeUsuario' => $this->session->get('usuario_nome'),
            'Tipo' => $this->session->get('usuario_tipo')
        ]);
    }
}