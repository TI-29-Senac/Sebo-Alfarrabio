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

    /**
     * Salva um novo pedido no banco de dados.
     * Recebe dados via POST.
     */
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

    /**
     * Debug: exibe dump de pedidos.
     */
    public function index()
    {
        $resultado = $this->pedidos->buscarPedidos();
        var_dump($resultado);
    }
    /**
     * Renderiza a listagem de pedidos.
     */
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

    /**
     * Renderiza o formulário de criação de pedidos (Admin).
     */
    public function viewCriarPedidos()
    {
        View::render("pedidos/create", []);
    }

    /**
     * Renderiza a edição de um pedido.
     * @param int $id_pedido
     */
    public function viewEditarPedidos($id_pedido)
    {
        $pedido = $this->pedidos->buscarPedidosPorID($id_pedido);
        
        if (!$pedido) {
             Redirect::redirecionarComMensagem("/backend/pedidos/listar", "error", "Pedido não encontrado.");
             return;
        }

        View::render("pedidos/edit", ["pedidos" => $pedido]);
    }



    /**
     * Gera relatório de pedido (placeholder).
     */
    public function relatorioPedidos($id_pedido, $data1, $data2)
    {
        View::render(
            "pedidos/relatorio",
            ["id" => $id_pedido, "data1" => $data1, "data2" => $data2]
        );
    }



    /**
     * Atualiza os dados de um pedido existente.
     */
    public function atualizarPedidos()
    {
        // Agora atualizamos apenas o status, ignorando data e valor que são readonly
        if (
            !$this->pedidos->atualizarStatus(
                $_POST['id_pedido'],
                $_POST['status_pedido']
            )
        ) {
            Redirect::redirecionarComMensagem("/backend/pedidos/listar", "error", "Erro ao atualizar status do pedido.");
            return;
        }
        Redirect::redirecionarComMensagem("/backend/pedidos/listar", "success", "Status do pedido atualizado com sucesso!");
    }

    /**
     * Mostra a tela de confirmação de exclusão
     */
    public function viewExcluirPedidos($id_pedido)
    {
        $pedido = $this->pedidos->buscarPedidosPorID($id_pedido);

        if (empty($pedido)) {
            Redirect::redirecionarComMensagem("/backend/pedidos/listar", "error", "Pedido não encontrado.");
            return;
        }

        if (!empty($pedido['excluido_em'])) {
            Redirect::redirecionarComMensagem("/backend/pedidos/listar", "info", "Este pedido já está desativado.");
            return;
        }

        View::render("pedidos/delete", [
            "pedido" => $pedido   // ← agora é um array simples com os dados
        ]);
    }

    /**
     * Realiza a exclusão (soft delete) do pedido.
     */
    public function deletarPedidos()
    {
        $id = $_POST['id_pedido'] ?? null;
        if (!$id) {
            Redirect::redirecionarComMensagem("/backend/pedidos/listar", "error", "ID do pedido não informado.");
            return;
        }

        if ($this->pedidos->excluirPedidos($id)) {
            Redirect::redirecionarComMensagem("/backend/pedidos/listar", "success", "Pedido excluído com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/backend/pedidos/listar", "error", "Erro ao excluir o pedido.");
        }
    }
}
