<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Usuario;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;

class UsuarioController {
    public $usuario;
    public $db;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
    }
    // index
    public function index() {
        $resultado = $this->usuario->buscarUsuarios();
        return $resultado;
        var_dump($resultado);
    }

    public function viewListarUsuarios() {
        $dados = $this->usuario->buscarUsuarios();
        View::render("usuario/index", ["usuarios" => $dados]);
    }

    public function viewCriarUsuarios() {
       View::render("usuario/create", []);
    }

    public function viewEditarUsuarios() {
        View::render("usuario/edit", []);
    }

    public function viewExcluirUsuarios() {
        View::render("usuario/delete", []);
    }

    public function salvarUsuario() {
        var_dump($_POST);
        echo "Salvar usuario";
    }

    public function atualizarUsuario() {
        echo "Atualizar usuario";
    }

    public function deletarUsuario() {
        echo "Deletar usuario";
    }


}