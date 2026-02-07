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

<<<<<<< HEAD
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
=======
    /**
     * Exibe a página de reservas do cliente (apenas não canceladas)
     */
    public function reservas()
    {
        $session = new \Sebo\Alfarrabio\Core\Session();
        $usuarioId = $session->get('usuario_id');

        if (!$usuarioId) {
            header('Location: /login');
            exit;
        }

        // Busca dados do usuário
        $usuario = $this->usuario->buscarUsuarioPorID($usuarioId);
        $perfilData = $this->perfil->buscarPerfilPorIDUsuario($usuarioId);
        $perfil = $perfilData ? $perfilData[0] : null;
        $dadosView = array_merge($usuario, $perfil ?? []);

        // Busca pedidos
        $pedidos = $this->pedidosModel->buscarPedidosPorIDUsuario($usuarioId);

        // Filtra apenas NÃO cancelados e enriquece com dados do item
        $pedidosAtivos = [];
        foreach ($pedidos as $pedido) {
            $statusRaw = strtolower($pedido['status'] ?? '');
            if (strpos($statusRaw, 'cancel') !== false) {
                continue; // Pula cancelados
            }

            $idPedido = $pedido['id_pedidos'] ?? $pedido['id'];
            
            // Busca itens com detalhes (descrição, preço)
            $sqlItens = "SELECT i.id_item, i.titulo_item, i.foto_item, i.descricao, i.preco_item, pi.quantidade 
                         FROM tbl_pedido_itens pi 
                         JOIN tbl_itens i ON pi.item_id = i.id_item 
                         WHERE pi.pedido_id = :id";
            $stmtItens = $this->db->prepare($sqlItens);
            $stmtItens->bindValue(':id', $idPedido);
            $stmtItens->execute();
            $pedido['itens'] = $stmtItens->fetchAll(\PDO::FETCH_ASSOC);

            $pedidosAtivos[] = $pedido;
        }

        \Sebo\Alfarrabio\Core\View::render('admin/cliente/reservas', [
            'usuario' => $dadosView,
            'pedidos' => $pedidosAtivos,
            'usuarioNome' => $usuario['nome_usuario'],
            'usuarioEmail' => $usuario['email_usuario'],
        ]);
    }

    /**
     * Exibe a página de notificações (última reserva + novos livros)
     */
    public function notificacoes()
    {
        $session = new \Sebo\Alfarrabio\Core\Session();
        $usuarioId = $session->get('usuario_id');

        if (!$usuarioId) {
            header('Location: /login');
            exit;
        }

        // Busca dados do usuário
        $usuario = $this->usuario->buscarUsuarioPorID($usuarioId);
        $perfilData = $this->perfil->buscarPerfilPorIDUsuario($usuarioId);
        $perfil = $perfilData ? $perfilData[0] : null;
        $dadosView = array_merge($usuario, $perfil ?? []);

        // 1. Busca APENAS a última reserva
        $sql = "SELECT p.*, 
                       i.titulo_item, 
                       i.foto_item, 
                       i.preco_item, 
                       i.descricao,
                       pi.quantidade,
                       u.nome_usuario,
                       u.email_usuario
                FROM tbl_pedidos p
                JOIN tbl_pedido_itens pi ON p.id_pedidos = pi.pedido_id
                JOIN tbl_itens i ON pi.item_id = i.id_item
                JOIN tbl_usuario u ON p.id_usuario = u.id_usuario
                WHERE p.id_usuario = :id
                ORDER BY p.data_pedido DESC
                LIMIT 1";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $usuarioId);
        $stmt->execute();
        $ultimaReserva = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Ajuste de imagem da reserva
        if ($ultimaReserva && !empty($ultimaReserva['foto_item'])) {
            if (strpos($ultimaReserva['foto_item'], '/uploads') === 0 && strpos($ultimaReserva['foto_item'], '/backend') === false) {
                $ultimaReserva['foto_item'] = '/backend' . $ultimaReserva['foto_item'];
            }
        }

        // 2. Busca os últimos 4 livros cadastrados
        $sqlNovos = "SELECT 
                        i.id_item, 
                        i.titulo_item, 
                        i.foto_item, 
                        i.criado_em,
                        (SELECT GROUP_CONCAT(a.nome_autor SEPARATOR ', ') 
                         FROM tbl_item_autores ia 
                         JOIN tbl_autores a ON ia.autor_id = a.id_autor 
                         WHERE ia.item_id = i.id_item) AS autor
                     FROM tbl_itens i 
                     WHERE i.excluido_em IS NULL 
                     ORDER BY i.criado_em DESC 
                     LIMIT 4";
        $stmtNovos = $this->db->prepare($sqlNovos);
        $stmtNovos->execute();
        $novosLivros = $stmtNovos->fetchAll(\PDO::FETCH_ASSOC);

        // Ajuste de imagem dos livros
        foreach ($novosLivros as &$livro) {
             if (!empty($livro['foto_item']) && strpos($livro['foto_item'], '/uploads') === 0 && strpos($livro['foto_item'], '/backend') === false) {
                $livro['foto_item'] = '/backend' . $livro['foto_item'];
            }
        }

        \Sebo\Alfarrabio\Core\View::render('admin/cliente/notificacoes', [
            'usuario' => $dadosView,
            'ultimaReserva' => $ultimaReserva,
            'novosLivros' => $novosLivros,
            'usuarioNome' => $usuario['nome_usuario'],
            'usuarioEmail' => $usuario['email_usuario'],
        ]);
    }

    /**
     * Cancela uma reserva do cliente
     */
    public function cancelarReserva()
    {
        $session = new \Sebo\Alfarrabio\Core\Session();
        $usuarioId = $session->get('usuario_id');

        if (!$usuarioId) {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/login", "error", "Usuário não autenticado.");
            return;
        }

        // Valida ID do pedido
        $idPedido = $_POST['id_pedido'] ?? null;
        if (!$idPedido || !is_numeric($idPedido)) {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/backend/admin/cliente", "error", "ID do pedido inválido.");
            return;
        }

        // Busca o pedido
        $pedido = $this->pedidosModel->buscarPedidosPorID($idPedido);

        if (!$pedido) {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/backend/admin/cliente", "error", "Pedido não encontrado.");
            return;
        }

        // Verifica se o pedido pertence ao usuário
        if ($pedido['id_usuario'] != $usuarioId) {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/backend/admin/cliente", "error", "Você não tem permissão para cancelar este pedido.");
            return;
        }

        // Verifica se o pedido já está cancelado
        $statusAtual = strtolower($pedido['status']);
        if (strpos($statusAtual, 'cancel') !== false) {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/backend/admin/cliente", "info", "Este pedido já está cancelado.");
            return;
        }

        // Verifica se o pedido já foi entregue
        if (strpos($statusAtual, 'entreg') !== false) {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/backend/admin/cliente", "error", "Não é possível cancelar um pedido já entregue.");
            return;
        }

        // Atualiza o status para "Cancelado"
        $resultado = $this->pedidosModel->atualizarStatus($idPedido, 'Cancelado');

        if ($resultado) {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/backend/admin/cliente", "success", "Reserva cancelada com sucesso!");
        } else {
            \Sebo\Alfarrabio\Core\Redirect::redirecionarComMensagem("/backend/admin/cliente", "error", "Erro ao cancelar a reserva.");
>>>>>>> 7521938f1d89d060478154920affadc8d18b9721
        }
    }
}

