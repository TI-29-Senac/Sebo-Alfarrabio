<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Cart;
use Sebo\Alfarrabio\Core\Session;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Models\Pedidos;
use Sebo\Alfarrabio\Database\Database;

class CartController
{
    private $pedidos;
    private $itemModel;
    private $session;

    public function __construct()
    {
        $this->pedidos = new Pedidos(Database::getInstance());
        $this->itemModel = new Item(Database::getInstance());
        $this->session = new Session();
    }

    /**
     * Verifica se o usuário está logado
     * Redireciona para login se não estiver
     */
    private function verificarLogin()
    {
        if (!$this->session->has('usuario_id')) {
            Redirect::redirecionarComMensagem(
                '/backend/login',
                'warning',
                '🔒 Faça login para fazer reservas'
            );
            exit;
        }
    }

    /**
     * Página do carrinho/reservas
     * Rota: GET /carrinho
     */
    public function index()
    {
        $this->verificarLogin();

        View::render('carrinho/index', [
            'titulo' => 'Minhas Reservas',
            'itens' => Cart::get(),
            'total' => Cart::total()
        ]);
    }

    /**
     * Adicionar item ao carrinho
     * Rota: GET /carrinho/adicionar/{id}
     */
    public function adicionar($id_item)
    {
        $this->verificarLogin();

        Cart::add($id_item);

        Redirect::redirecionarComMensagem(
            '/carrinho',
            'success',
            '✓ Item adicionado às reservas!'
        );
    }

    /**
     * API: Buscar itens do carrinho
     * GET /api/carrinho
     */
    public function getCartApi()
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'itens' => Cart::get(),
            'total' => Cart::total(),
            'count' => Cart::count()
        ]);
        exit;
    }

    /**
     * API: Adicionar item ao carrinho
     * POST /api/carrinho/adicionar
     */
    public function adicionarApi()
    {
        header('Content-Type: application/json');

        $json = file_get_contents('php://input');
        $dados = json_decode($json, true);
        $id_item = $dados['id_item'] ?? null;
        $quantidade = $dados['quantidade'] ?? 1;

        if (!$id_item) {
            echo json_encode(['success' => false, 'message' => 'Item não informado']);
            exit;
        }

        if (!$this->session->has('usuario_id')) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Autenticação necessária']);
            exit;
        }

        // Validação de Estoque
        $item = $this->itemModel->buscarItemPorID($id_item);
        if (!$item) {
            echo json_encode(['success' => false, 'message' => 'Item não encontrado']);
            exit;
        }

        $estoqueDisponivel = (int) $item['estoque'];
        $quantidadeNoCarrinho = Cart::getItemQuantity($id_item);
        $totalDesejado = $quantidadeNoCarrinho + $quantidade;

        if ($totalDesejado > $estoqueDisponivel) {
            echo json_encode([
                'success' => false,
                'message' => "Desculpe, temos apenas {$estoqueDisponivel} unid. em estoque deste item."
            ]);
            exit;
        }

        Cart::add($id_item, (int) $quantidade);

        echo json_encode([
            'success' => true,
            'message' => 'Item adicionado!',
            'count' => Cart::count()
        ]);
        exit;
    }

    /**
     * Atualizar quantidade de item
     * Rota: POST /carrinho/atualizar
     */
    public function atualizar()
    {
        $this->verificarLogin();

        if (isset($_POST['id_item']) && isset($_POST['quantidade'])) {
            $quantidade = (int) $_POST['quantidade'];

            if ($quantidade > 0) {
                // Validação de estoque para atualização manual
                $item = $this->itemModel->buscarItemPorID($_POST['id_item']);
                if ($item && $quantidade > (int) $item['estoque']) {
                    Redirect::redirecionarComMensagem(
                        '/carrinho',
                        'error',
                        "Ops! Temos apenas {$item['estoque']} unid. em estoque deste item."
                    );
                    return;
                }

                Cart::update($_POST['id_item'], $quantidade);
                Redirect::redirecionarComMensagem(
                    '/carrinho',
                    'success',
                    '✓ Quantidade atualizada!'
                );
            } else {
                // Se quantidade for 0, remove o item
                Cart::remove($_POST['id_item']);
                Redirect::redirecionarComMensagem(
                    '/carrinho',
                    'info',
                    '🗑️ Item removido das reservas'
                );
            }
        } else {
            Redirect::redirecionarComMensagem(
                '/carrinho',
                'error',
                'Dados inválidos.'
            );
        }
    }

    /**
     * Remover item do carrinho
     * Rota: GET /carrinho/remover/{id}
     */
    public function remover($id_item)
    {
        $this->verificarLogin();

        Cart::remove($id_item);

        Redirect::redirecionarComMensagem(
            '/carrinho',
            'info',
            '🗑️ Item removido das reservas'
        );
    }

    /**
     * API: Remover item do carrinho
     * POST /api/carrinho/remover
     */
    public function removerApi()
    {
        header('Content-Type: application/json');

        $json = file_get_contents('php://input');
        $dados = json_decode($json, true);
        $id_item = $dados['id_item'] ?? null;

        if (!$id_item) {
            echo json_encode(['success' => false, 'message' => 'Item não informado']);
            exit;
        }

        if (!$this->session->has('usuario_id')) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Autenticação necessária']);
            exit;
        }

        Cart::remove($id_item);

        echo json_encode([
            'success' => true,
            'message' => 'Item removido!',
            'count' => Cart::count()
        ]);
        exit;
    }

    /**
     * Finalizar pedido/reserva (POST - via formulário)
     * Rota: POST /carrinho/finalizar
     */
    public function finalizar()
    {
        $this->verificarLogin();

        // Se vier como JSON (via AJAX)
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (strpos($contentType, 'application/json') !== false) {
            $this->finalizarAjax();
            return;
        }

        // Se vier como POST normal (formulário)
        $itens = Cart::get();

        if (empty($itens)) {
            Redirect::redirecionarComMensagem(
                '/carrinho',
                'warning',
                '⚠️ Você não tem reservas pendentes!'
            );
            exit;
        }

        try {
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

                Redirect::redirecionarComMensagem(
                    "/carrinho/obrigado/$idPedido",
                    "success",
                    "🎉 Reserva #$idPedido confirmada com sucesso!"
                );
            } else {
                Redirect::redirecionarComMensagem(
                    "/carrinho",
                    "error",
                    "❌ Erro ao confirmar reserva"
                );
            }
        } catch (\Exception $e) {
            error_log("Erro ao finalizar pedido: " . $e->getMessage());
            Redirect::redirecionarComMensagem(
                "/carrinho",
                "error",
                "❌ Erro ao processar reserva: " . $e->getMessage()
            );
        }
    }

    /**
     * Finalizar pedido via AJAX (JSON)
     * Usado pelo JavaScript da página de produtos
     */
    public function finalizarAjax()
    {
        header('Content-Type: application/json');

        // Pega dados do POST JSON
        $json = file_get_contents('php://input');
        $dados = json_decode($json, true);

        if (empty($dados['itens'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Você não tem reservas pendentes'
            ]);
            exit;
        }

        try {
            // Formata itens para o método criarPedido
            $itensCarrinho = [];
            foreach ($dados['itens'] as $item) {
                $itensCarrinho[] = [
                    'id' => $item['id_item'],
                    'quantidade' => $item['quantidade'],
                    'preco' => $item['preco_item']
                ];
            }

            // Cria o pedido usando o model Pedidos com status 'Pendente'
            $idPedido = $this->pedidos->criarPedido($itensCarrinho, 'Pendente');

            if ($idPedido) {
                // Limpa o carrinho
                Cart::clear();

                echo json_encode([
                    'success' => true,
                    'id_pedido' => $idPedido,
                    'message' => 'Reserva confirmada com sucesso!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao criar reserva'
                ]);
            }
        } catch (\Exception $e) {
            error_log("Erro ao finalizar pedido via AJAX: " . $e->getMessage());

            echo json_encode([
                'success' => false,
                'message' => 'Erro ao processar reserva: ' . $e->getMessage()
            ]);
        }

        exit;
    }

    /**
     * Página de confirmação/obrigado
     * Rota: GET /carrinho/obrigado/{id}
     */
    public function obrigado($id_pedido)
    {
        $this->verificarLogin();

        // Busca dados do pedido
        $pedido = $this->pedidos->buscarPedidosPorID($id_pedido);

        if (empty($pedido)) {
            Redirect::redirecionarComMensagem(
                '/produtos',
                'error',
                'Pedido não encontrado.'
            );
            return;
        }

        View::render('carrinho/obrigado', [
            'pedido' => $pedido[0],
            'id_pedido' => $id_pedido
        ]);
    }
}