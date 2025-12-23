<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Cart;
use Sebo\Alfarrabio\Models\Pedidos;

class CartController {
    private $pedidos;

    public function __construct() {
        $this->pedidos = new Pedidos(\Sebo\Alfarrabio\Database\Database::getInstance());
    }

    public function index() {
        View::render('carrinho/index', [
            'itens' => Cart::get(),
            'total' => Cart::total()
        ]);
    }

    public function adicionar($id_item) {
        Cart::add($id_item);
        header('Location: /carrinho');
    }

    public function atualizar() {
        if ($_POST['id_item'] && $_POST['quantidade']) {
            Cart::update($_POST['id_item'], (int)$_POST['quantidade']);
        }
        header('Location: /carrinho');
    }

    public function remover($id_item) {
        Cart::remove($id_item);
        header('Location: /carrinho');
    }

    public function finalizar() {
        $itens = Cart::get();
        if (empty($itens)) {
            header('Location: /carrinho');
            exit;
        }

        // Converte o carrinho para o formato que o model espera
        $itensCarrinho = [];
        foreach ($itens as $item) {
            $itensCarrinho[] = [
                'id' => $item['id_item'],
                'preco' => $item['preco'],
                'quantidade' => $item['quantidade']
            ];
        }

        $idPedido = $this->pedidos->criarPedido($itensCarrinho);

        if ($idPedido) {
            Cart::clear();
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem(
                "/pedidos/obrigado/$idPedido", 
                "success", 
                "Pedido #$idPedido realizado com sucesso!"
            );
        } else {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem(
                "/carrinho", 
                "error", 
                "Erro ao finalizar pedido."
            );
        }
    }

    public function obrigado($id_pedido) {
        View::render('carrinho/obrigado', ['id_pedido' => $id_pedido]);
    }
}