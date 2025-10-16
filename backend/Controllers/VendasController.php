<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Vendas;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\VendasValidador;
use Sebo\Alfarrabio\Core\FileManager;


class VendasController {
    public $vendas;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->vendas = new Vendas($this->db);
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
             Redirect::redirecionarComMensagem("vendas/listar", "success", "Venda cadastrada com sucesso!");
         }else{
             Redirect::redirecionarComMensagem("vendas/criar", "error", "Erro ao cadastrar a venda!");
         }
     }
    // index
    public function index() {
        $resultado = $this->vendas->buscarVendas();
        var_dump($resultado);
    }
    public function viewListarVendas(){
        $dados = $this->vendas->buscarVendas(); 
        
        View::render("vendas/index", 
        [
            "vendas"=> $dados
        ]
    );
    }

    public function viewCriarVendas(){
        View::render("vendas/create", []);
    }

    public function viewEditarVendas($id_venda){
        $dados = $this->vendas->buscarVendasPorID($id_venda);
        foreach($dados as $vendas){
            $dados = $vendas;
        }
        View::render("vendas/edit", ["vendas" => $dados]);
    }

    public function viewExcluirVendas($id_venda){
        View::render("vendas/delete", ["id_venda" => $id_venda]);
    }

    public function relatorioVendas($id_venda, $data1, $data2){
        View::render("vendas/relatorio",
        ["id"=>$id_venda, "data1"=> $data1, "data2"=> $data2]
    );
    }

    

    public function atualizarVendas(){
        echo "Atualizar Vendas";
    }

    public function deletarVendas(){
        echo "Deletar Vendas";
    }

}