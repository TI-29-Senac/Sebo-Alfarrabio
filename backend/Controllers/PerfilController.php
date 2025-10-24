<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Perfil;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\PerfilValidador;
use Sebo\Alfarrabio\Core\FileManager;


class PerfilController {
    public $perfil;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->perfil = new Perfil($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

      // index
      public function index() {
        $resultado = $this->perfil->buscarperfil();
        var_dump($resultado);
    }
    public function viewListarperfil(){
        $dados = $this->perfil->buscarPerfil();
        $total_perfil = $this->perfil->totalDePerfil();
        $total_inativos = $this->perfil->totalDePerfilInativos();
        $total_ativos = $this->perfil->totalDePerfilAtivos();

        View::render("perfil/index", 
        [
            "perfil"=> $dados, 
            "total_perfil"=> $total_perfil[0],
            "total_inativos"=> $total_inativos[0],
            "total_ativos"=> $total_ativos[0]
        ]
    );
    }

    public function viewCriarPerfil(){
        View::render("perfil/create", []);
    }

    public function viewEditarPerfil($id_perfil_usuario){
        $dados = $this->perfil->buscarPerfilPorID($id_perfil_usuario);
        foreach($dados as $perfil){
            $dados = $perfil;
        }
        View::render("perfil/edit", ["perfil" => $dados]);
    }

    public function viewExcluirPerfil($id_perfil_usuario){
        View::render("perfil/delete", ["id_perfil_usuario" => $id_perfil_usuario]);
    }

    public function relatorioPerfil($id_perfil_usuario, $data1, $data2){
        View::render("perfil/relatorio",
        ["id"=>$id_perfil_usuario, "data1"=> $data1, "data2"=> $data2]
    );
    }

    

    public function atualizarPerfil(){
        echo "Atualizar Perfil";
    }

    public function deletarPerfil(){
        echo "Deletar Perfil";
    }

}