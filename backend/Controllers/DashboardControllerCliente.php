<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Models\Usuario;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Models\Categoria;
use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Controllers\Admin\AuthenticatedController;
use Sebo\Alfarrabio\Core\Session;

class DashboardControllerCliente extends AuthenticatedController
{
    private $db;
    private $usuario;
     private $categoriaModel;
     private $itemModel;
    

    public function __construct() {
            parent::__construct();
            $this->db = Database::getInstance();
            $this->usuario = new Usuario($this->db);
            $this->categoriaModel = new Categoria($this->db);
            $this->itemModel = new Item($this->db);
    }
 public function index(){
    View::render('admin/cliente/index', [
    ]);
    $resultado = $this->usuario->buscarUsuarioPorID();
    echo "<pre>"; print_r($resultado); echo "</pre>"; 
    }

    public function ListarSeuPerfil() {
        
    }


}

       