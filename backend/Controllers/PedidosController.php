<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Pedidos;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\PedidosValidador;
use Sebo\Alfarrabio\Core\FileManager;


class PedidosController
{
    public $pedidos;
    public $db;
    public $gerenciarImagem;
    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->pedidos = new Pedidos($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function salvarPedidos()
    {
        $erros = PedidosValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("/backend/pedidos/criar", "error", implode("<br>", $erros));
            return;
        }

        // Salvar imagem (se houver)
        $imagem = null;
        if (!empty($_FILES['imagem']['name'])) {
            $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'pedidos');
        }

        $sucesso = $this->pedidos->inserirPedidos(
            $_SESSION['usuario_id'],
            $_POST["valor_total"],
            $_POST["data_pedido"],
            $_POST["status_pedido"]
        );

        if ($sucesso) {
            Redirect::redirecionarComMensagem("/backend/pedidos/listar", "success", "Pedido cadastrado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/backend/pedidos/criar", "error", "Erro ao cadastrar o pedido!");
        }
    }

    // index
    public function index()
    {
        $resultado = $this->pedidos->buscarPedidos();
        var_dump($resultado);
    }
    public function viewListarPedidos()
    {
        $dados = $this->pedidos->buscarPedidos();

        View::render(
            "pedidos/index",
            [
                "pedidos" => $dados,
            ]
        );
    }

    public function viewCriarPedidos()
    {
        View::render("pedidos/create", []);
    }

    public function viewEditarPedidos($id_pedido)
    {
        $resultados = $this->pedidos->buscarPedidosPorID($id_pedido);
        $pedido = count($resultados) > 0 ? $resultados[0] : null;

        View::render("pedidos/edit", ["pedidos" => $pedido]);
    }



    public function relatorioPedidos($id_pedido, $data1, $data2)
    {
        View::render(
            "pedidos/relatorio",
            ["id" => $id_pedido, "data1" => $data1, "data2" => $data2]
        );
    }



    public function atualizarPedidos()
    {
        if (
            !$this->pedidos->atualizarPedidos(
                $_POST['id_pedido'],
                $_POST['data_pedido'],
                $_POST['status_pedido']
            )
        ) {
            Redirect::redirecionarComMensagem("/backend/pedidos/listar", "error", "Erro ao atualizar pedido.");
            return;
        }
        Redirect::redirecionarComMensagem("/backend/pedidos/listar", "success", "Pedido atualizado com sucesso!");
    }

    // Mostra a tela de confirmação de exclusão
    public function viewExcluirPedidos($id_pedido)
    {
        $resultado = $this->pedidos->buscarPedidosPorID($id_pedido);

        if (empty($resultado)) {
            Redirect::redirecionarComMensagem("/backend/pedidos/listar", "error", "Pedido não encontrado.");
            return;
        }

        // PEGA O PRIMEIRO (E ÚNICO) REGISTRO DA LISTA
        $pedido = $resultado[0];

        if (!empty($pedido['excluido_em'])) {
            Redirect::redirecionarComMensagem("/backend/pedidos/listar", "info", "Este pedido já está desativado.");
            return;
        }

        View::render("pedidos/delete", [
            "pedido" => $pedido   // ← agora é um array simples com os dados
        ]);
    }
}