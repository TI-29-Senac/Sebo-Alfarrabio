<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Models\Usuario;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Models\Categoria;
use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Controllers\Admin\AuthenticatedController;
use Sebo\Alfarrabio\Core\Session;
use Sebo\Alfarrabio\Models\Pedidos;

class DashboardControllerCliente extends AuthenticatedController
{
    private $db;
    private $usuario;
    private $categoriaModel;
    private $itemModel;
    private $pedidosModel;
    

     public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->pedidosModel = new Pedidos($this->db);  // Adicione isso!
        $this->categoriaModel = new Categoria($this->db);
        $this->itemModel = new Item($this->db);

     }
        public function index() {
            $session = new Session();
            $usuarioId = $session->get('usuario_id');
    
            if (!$usuarioId) {
                // Se não logado, redirecione para login
                header('Location: /login');
                exit;
            }
    
            // Busca dados do usuário
            $usuario = $this->usuario->buscarUsuarioPorID($usuarioId);
    
            if (!$usuario) {
                die("Usuário não encontrado.");
            }
    
            // Busca pedidos do usuário
            $pedidos = $this->pedidosModel->buscarPedidosPorIDUsuario($usuarioId);
    
            // Renderiza o view com os dados
            View::render('admin/cliente/index', [
                'usuario' => $usuario,
                'pedidos' => $pedidos
            ]);
        }
    
        public function ListarSeuPerfil() {
            // ... (mantenha se precisar)
        }



}

       