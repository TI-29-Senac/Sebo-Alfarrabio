<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Controllers\Admin\AuthenticatedController;

class DashboardController extends AuthenticatedController {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $titulo = "Dashboard Administrativo";
        $totalAutores = 42;
        $totalCategorias = 18;
        $totalGeneros = 7;

        require_once __DIR__ . '/../Views/templates/admin/dashboard/index.php';
    }
}