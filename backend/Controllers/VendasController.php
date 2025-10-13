<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Vendas;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\VendasValidador;
use Sebo\Alfarrabio\Core\FileManager;


class VendasController {
    public $usuario;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->usuario = new Vendas($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function salvarVendas(){
        $erros = VendasValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
        
             Redirect::redirecionarComMensagem("/vendas/criar","error", implode("<br>", $erros));
        }
        $imagem= $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'vendas');
         if($this->usuario->inserirUsuario(
             $_POST["data_venda"],
             $_POST["valor_total"],
             $_POST["forma_pagamento"],
         )){
             Redirect::redirecionarComMensagem("vendas/listar", "success", "Usuário cadastrado com sucesso!");
         }else{
             Redirect::redirecionarComMensagem("vendas/criar", "error", "Erro ao cadastrar usuário");
         }
     }
    // index
    public function index() {
        $resultado = $this->usuario->buscarUsuarios();
        var_dump($resultado);
    }
    public function viewListarUsuarios(){
        $dados = $this->usuario->buscarUsuarios(); 
        
        View::render("usuario/index", 
        [
            "usuarios"=> $dados
        ]
    );
    }

    public function viewCriarUsuarios(){
        View::render("usuario/create", []);
    }

    public function viewEditarUsuarios($id){
        $dados = $this->usuario->buscarUsuariosPorID($id_usuario);
        foreach($dados as $usuario){
            $dados = $usuario;
        }
        View::render("usuario/edit", ["usuario" => $dados]);
    }

    public function viewExcluirUsuarios($id){
        View::render("usuario/delete", ["id_usuario" => $id_usuario]);
    }

    public function relatorioUsuario($id_usuario, $data1, $data2){
        View::render("usuario/relatorio",
        ["id"=>$id_usuario, "data1"=> $data1, "data2"=> $data2]
    );
    }

    

    public function atualizarUsuario(){
        echo "Atualizar Usuario";
    }

    public function deletarUsuario(){
        echo "Deletar Usuario";
    }

}