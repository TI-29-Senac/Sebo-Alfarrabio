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
use Sebo\Alfarrabio\Models\Avaliacao;

class DashboardControllerCliente extends AuthenticatedController
{
    private $db;
    private $usuario;
    private $categoriaModel;
    private $itemModel;
    private $pedidosModel;
    private $perfil;
    private $fileManager;
    private $avaliacaoModel;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();
        $this->usuario = new Usuario($this->db);
        $this->pedidosModel = new Pedidos($this->db);
        $this->categoriaModel = new Categoria($this->db);
        $this->itemModel = new Item($this->db);
        $this->perfil = new \Sebo\Alfarrabio\Models\Perfil($this->db);
        $this->fileManager = new \Sebo\Alfarrabio\Core\FileManager('uploads');
        $this->avaliacaoModel = new Avaliacao($this->db);
    }

    /**
     * Exibe o painel do cliente com seus pedidos e estatísticas.
     */
    public function index()
    {
        $session = new \Sebo\Alfarrabio\Core\Session();
        $usuarioId = $session->get('usuario_id');

        if (!$usuarioId) {
            header('Location: /login');
            exit;
        }

        // Busca dados do usuário (login/nome)
        $usuario = $this->usuario->buscarUsuarioPorID($usuarioId);

        if (!$usuario) {
            die("Usuário não encontrado.");
        }

        // Busca dados do perfil (foto, endereço...)
        $perfilData = $this->perfil->buscarPerfilPorIDUsuario($usuarioId);
        $perfil = $perfilData ? $perfilData[0] : null;

        // Mescla dados para a view
        $dadosView = array_merge($usuario, $perfil ?? []);

        // Busca pedidos do usuário
        $pedidos = $this->pedidosModel->buscarPedidosPorIDUsuario($usuarioId);

        // Verifica se pedidos tem itens (caso o model buscarPedidosPorIDUsuario não traga itens por padrão)
        foreach ($pedidos as &$pedido) {
            // Garante uso do ID correto (id_pedidos)
            $idPedido = $pedido['id_pedidos'] ?? $pedido['id'];

            // Busca itens se não existirem
            if (!isset($pedido['itens'])) {
                // Query manual pois buscarPedidosPorIDUsuario pode não ter sido atualizado com join
                // Idealmente atualizar PedidosModel::buscarPedidosPorIDUsuario também
                $sqlItens = "SELECT i.id_item, i.titulo_item, i.foto_item, pi.quantidade 
                             FROM tbl_pedido_itens pi 
                             JOIN tbl_itens i ON pi.item_id = i.id_item 
                             WHERE pi.pedido_id = :id";
                $stmtItens = $this->db->prepare($sqlItens);
                $stmtItens->bindValue(':id', $idPedido);
                $stmtItens->execute();
                $pedido['itens'] = $stmtItens->fetchAll(\PDO::FETCH_ASSOC);
            }
        }

        // ====== CONTADORES DINÂMICOS ======

        // Total de pedidos do usuário
        $total_pedidos = count($pedidos);

        // Total de avaliações do usuário
        $total_avaliacoes = $this->avaliacaoModel->totalDeAvaliacaoPorUsuario($usuarioId);

        // Lista de IDs de itens já avaliados (para controlar botão de avaliar)
        $itensAvaliados = $this->avaliacaoModel->buscarItensAvaliadosPorUsuario($usuarioId);

        // Total de favoritos do usuário (verifica se a tabela existe)
        $total_favoritos = 0;
        try {
            $sqlFavoritos = "SELECT COUNT(*) FROM tbl_favoritos WHERE id_usuario = :id";
            $stmtFavoritos = $this->db->prepare($sqlFavoritos);
            $stmtFavoritos->bindValue(':id', $usuarioId);
            $stmtFavoritos->execute();
            $total_favoritos = (int)$stmtFavoritos->fetchColumn();
        }
        catch (\PDOException $e) {
            // Tabela não existe ou erro, mantém 0
            $total_favoritos = 0;
        }

        \Sebo\Alfarrabio\Core\View::render('admin/cliente/index', [
            'usuario' => $dadosView,
            'pedidos' => $pedidos,
            'usuarioNome' => $usuario['nome_usuario'],
            'usuarioEmail' => $usuario['email_usuario'],
            'total_pedidos' => $total_pedidos,
            'total_avaliacoes' => $total_avaliacoes,
            'total_favoritos' => $total_favoritos,
            'itensAvaliados' => $itensAvaliados
        ]);
    }

    /**
     * Processa o upload e atualização da foto de perfil do cliente.
     */
    public function atualizarFotoPerfil()
    {
        $session = new \Sebo\Alfarrabio\Core\Session();
        $usuarioId = $session->get('usuario_id');

        if (!$usuarioId || empty($_FILES['foto_usuario'])) {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/backend/admin/cliente", "error", "Nenhuma imagem enviada.");
            return;
        }

        // Busca perfil atual para saber se já existe
        $perfilData = $this->perfil->buscarPerfilPorIDUsuario($usuarioId);
        $perfilExistente = $perfilData ? $perfilData[0] : null;

        try {
            $nomeArquivo = $this->fileManager->salvarArquivo($_FILES['foto_usuario'], 'perfis');
            $caminhoFoto = '/backend/uploads/' . $nomeArquivo; // Ex: /backend/uploads/perfis/nome.jpg
        }
        catch (\Exception $e) {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/backend/admin/cliente", "error", "Erro ao salvar imagem: " . $e->getMessage());
            return;
        }

        if (!$caminhoFoto) {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/backend/admin/cliente", "error", "Erro ao salvar imagem.");
            return;
        }

        // Caminho já definido no try/catch acima

        if ($perfilExistente) {
            // Atualiza
            // Nota: Perfil::atualizarPerfil requer id_perfil_usuario, telefone, endereco, foto
            // Vamos manter os dados antigos de telefone/endereço
            $this->perfil->atualizarPerfil(
                $perfilExistente['id_perfil_usuario'],
                $perfilExistente['telefone'],
                $perfilExistente['endereco'],
                $caminhoFoto
            );
        }
        else {
            // Cria novo perfil
            $this->perfil->inserirPerfil(
                $usuarioId,
                '', // telefone
                '', // endereco
                $caminhoFoto
            );
        }

        \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/backend/admin/cliente", "success", "Foto atualizada com sucesso!");
    }

    /**
     * Exibe a página de avaliações do cliente
     */
    public function avaliacoes()
    {
        $session = new \Sebo\Alfarrabio\Core\Session();
        $usuarioId = $session->get('usuario_id');

        if (!$usuarioId) {
            header('Location: /login');
            exit;
        }

        // Busca dados do usuário
        $usuario = $this->usuario->buscarUsuarioPorID($usuarioId);

        if (!$usuario) {
            die("Usuário não encontrado.");
        }

        // Busca dados do perfil
        $perfilData = $this->perfil->buscarPerfilPorIDUsuario($usuarioId);
        $perfil = $perfilData ? $perfilData[0] : null;

        // Mescla dados para a view
        $dadosView = array_merge($usuario, $perfil ?? []);

        // Busca avaliações do usuário
        $avaliacoes = $this->avaliacaoModel->buscarAvaliacoesPorIDUsuario($usuarioId);
        $total_avaliacoes = count($avaliacoes);

        \Sebo\Alfarrabio\Core\View::render('admin/cliente/avaliacoes', [
            'usuario' => $dadosView,
            'avaliacoes' => $avaliacoes,
            'total_avaliacoes' => $total_avaliacoes,
            'usuarioNome' => $usuario['nome_usuario'],
        ]);
    }

    public function cancelarPedido()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método inválido.']);
            return;
        }

        if (!Session::get('usuario_id')) {
            echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
            return;
        }

        $idPedido = $_POST['id_pedido'] ?? null;

        if (!$idPedido) {
            echo json_encode(['success' => false, 'message' => 'ID do pedido não informado.']);
            return;
        }

        $db = Database::getInstance();
        $pedidoModel = new Pedidos($db);

        // Verifica se o pedido pertence ao usuário
        $pedido = $pedidoModel->buscarPedidosPorID($idPedido);
        if (!$pedido || $pedido['usuario_id'] != Session::get('usuario_id')) {
            echo json_encode(['success' => false, 'message' => 'Pedido não encontrado ou não pertence a você.']);
            return;
        }

        // Verifica se já não está cancelado
        $statusAtual = strtolower($pedido['status']);
        if (strpos($statusAtual, 'cancel') !== false) {
            echo json_encode(['success' => false, 'message' => 'Este pedido já está cancelado.']);
            return;
        }

        // Atualiza status
        if ($pedidoModel->atualizarStatus($idPedido, 'Cancelado')) {
            echo json_encode(['success' => true, 'message' => 'Reserva cancelada com sucesso.']);
        }
        else {
            echo json_encode(['success' => false, 'message' => 'Erro ao cancelar reserva. Tente novamente.']);
        }
    }
}

