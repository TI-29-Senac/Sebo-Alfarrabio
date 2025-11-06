<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Pedidos;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\PedidosValidador;
use Sebo\Alfarrabio\Core\FileManager;


class PedidosController {
    public $pedidos;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->pedidos = new Pedidos($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function salvarPedidos(){
        $erros = PedidosValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
        
             Redirect::redirecionarComMensagem("/pedidos/criar","error", implode("<br>", $erros));
        }
        $imagem= $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'Pedidos');
         if($this->Pedidos->inserirPedidos(
             $_POST["valor_total"],
             $_POST["data_pedido"],
             $_POST["status_pedido"],
         )){
             Redirect::redirecionarComMensagem("pedidos/listar", "success", "Venda cadastrada com sucesso!");
         }else{
             Redirect::redirecionarComMensagem("pedidos/criar", "error", "Erro ao cadastrar a venda!");
         }
     }
      // index
      public function index() {
        $resultado = $this->Pedidos->buscarPedidos();
        var_dump($resultado);
    }
    public function viewListarPedidos(){
        $dados = $this->pedidos->buscarPedidos();

        View::render("pedidos/index", 
        [
            "pedidos"=> $dados, 
        ]
    );
    }

    public function viewCriarPedidos(){
        View::render("pedidos/create", []);
    }

    public function viewEditarPedidos($id_pedido){
        $dados = $this->pedidos->buscarPedidosPorID($id_pedido);
        foreach($dados as $pedidos){
            $dados = $pedidos;
        }
        View::render("pedidos/edit", ["pedidos" => $dados]);
    }

    public function viewExcluirPedidos($id_pedido){
        View::render("pedidos/delete", ["id_pedido" => $id_pedido]);
    }

    public function relatorioPedidos($id_pedido, $data1, $data2){
        View::render("pedidos/relatorio",
        ["id"=>$id_pedido, "data1"=> $data1, "data2"=> $data2]
    );
    }

    

    public function atualizarPedidos(){
        echo "Atualizar Pedidos";
    }

    public function deletarPedidos(){
        echo "Deletar Pedidos";
    }

}