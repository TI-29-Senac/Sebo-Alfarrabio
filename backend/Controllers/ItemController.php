<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Models\Autor;
use Sebo\Alfarrabio\Models\Categoria;
use Sebo\Alfarrabio\Models\Genero;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\ItemValidador;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Controllers\Admin\AdminController;

class ItemController extends AdminController
{

    public $db;
    public $item;
    public $autor;
    public $categoria;
    public $genero;

    public function __construct()
    {
        parent::__construct();
        $this->db = Database::getInstance();

        $this->item = new Item($this->db);
        $this->autor = new Autor($this->db);
        $this->categoria = new Categoria($this->db);
        $this->genero = new Genero($this->db);
    }

    /**
     * Exibe a view de listagem com paginação e estatísticas.
     */
    public function viewListarItens($pagina = 1)
    {
        if (empty($pagina) || $pagina <= 0) {
            $pagina = 1;
        }

        // Verifica se há um termo de pesquisa
        $termoPesquisa = $_GET['search'] ?? null;

        // Busca dados paginados
        if ($termoPesquisa) {
            $dados = $this->item->pesquisarItens($termoPesquisa, $pagina, 10);
        } else {
            $dados = $this->item->paginacao($pagina, 10);
        }

        $totalAtivos = $this->item->totalDeItensAtivos();
        $totalInativos = $this->item->totalDeItensInativos();
        $total = $this->item->totalDeItens();

        View::render("item/index", [
            "itens" => $dados['data'],
            "total_itens" => $total,
            "total_inativos" => $totalInativos,
            "total_ativos" => $totalAtivos,
            'paginacao' => $dados,
            'termo_pesquisa' => $termoPesquisa
        ]);
    }

    /**
     * Exibe o formulário de criação.
     */
    public function viewCriarItem()
    {
        $generos = $this->genero->buscarGeneros();
        $categorias = $this->categoria->buscarCategorias();

        View::render("item/create", [
            "generos" => $generos,
            "categorias" => $categorias
        ]);
    }

    /**
     * Exibe o formulário de edição com os dados do item.
     */
    public function viewEditarItem(int $id)
    {
        $item = $this->item->buscarItemPorID($id);

        if (!$item) {
            Redirect::redirecionarComMensagem("/backend/item/listar", "error", "Item não encontrado!");
            return;
        }

        $generos = $this->genero->buscarGeneros();
        $categorias = $this->categoria->buscarCategorias();

        $autoresSelecionados = [];
        if (!empty($item['autores_ids'])) {
            foreach ($item['autores_ids'] as $autor_id) {
                $autor_data = $this->autor->buscarAutorPorID($autor_id);
                if ($autor_data) {
                    $autoresSelecionados[] = $autor_data;
                }
            }
        }

        View::render("item/edit", [
            "item" => $item,
            "generos" => $generos,
            "categorias" => $categorias,
            "autores_selecionados" => $autoresSelecionados
        ]);
    }

    /**
     * Exibe a tela de confirmação de exclusão
     */
    public function viewExcluirItem($id)
    {
        $item = $this->item->buscarItemPorID($id);
        if (!$item) {
            Redirect::redirecionarComMensagem("/backend/item/listar", "error", "Item não encontrado!");
            return;
        }
        View::render("item/delete", [
            "id_item" => $item['id_item'],
            "titulo_item" => $item['titulo_item']
        ]);
    }

    // --- MÉTODOS DE PROCESSAMENTO (POST) ---

    /**
     * Processa o formulário de salvar novo item.
     */
    public function salvarItem()
    {
        $erros = ItemValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            Redirect::redirecionarComMensagem("/backend/item/criar", "error", implode("<br>", $erros));
        }

        // === UPLOAD DA FOTO (automático) ===
        $fotoPath = null;
        if (!empty($_FILES['foto_item']) && $_FILES['foto_item']['error'] === 0) {
            $extensoes = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = strtolower(pathinfo($_FILES['foto_item']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $extensoes) && $_FILES['foto_item']['size'] <= 5000000) {
                $nome = 'item_' . time() . '_' . uniqid() . '.' . $ext;
                $pasta = 'uploads';
                if (!is_dir($pasta))
                    mkdir($pasta, 0777, true);
                $caminho = $pasta . $nome;
                if (move_uploaded_file($_FILES['foto_item']['tmp_name'], $caminho)) {
                    $fotoPath = '/' . $caminho;
                }
            }
        }

        $dadosItem = [
            'titulo_item' => $_POST['titulo_item'],
            'tipo_item' => $_POST['tipo_item'],
            'id_genero' => (int) $_POST['id_genero'],
            'id_categoria' => (int) $_POST['id_categoria'],
            'descricao' => $_POST['descricao'] ?? null,
            'ano_publicacao' => !empty($_POST['ano_publicacao']) ? (int) $_POST['ano_publicacao'] : null,
            'editora_gravadora' => $_POST['editora_gravadora'] ?? null,
            'estoque' => (int) ($_POST['estoque'] ?? 1),
            'preco_item' => !empty($_POST['preco_item']) ? (float) $_POST['preco_item'] : 0.00,
            'isbn' => $_POST['isbn'] ?? null,
            'duracao_minutos' => !empty($_POST['duracao_minutos']) ? (int) $_POST['duracao_minutos'] : null,
            'numero_edicao' => !empty($_POST['numero_edicao']) ? (int) $_POST['numero_edicao'] : null,
            'foto_item' => $fotoPath,
        ];

        $autores_ids = $_POST['autores_ids'] ?? [];
        $autores_ids = array_map('intval', $autores_ids);

        if ($this->item->inserirItem($dadosItem, $autores_ids)) {
            Redirect::redirecionarComMensagem("/backend/item/listar", "success", "Item cadastrado com sucesso!");
        } else {
            if ($fotoPath && file_exists(ltrim($fotoPath, '/')))
                unlink(ltrim($fotoPath, '/'));
            Redirect::redirecionarComMensagem("/backend/item/criar", "error", "Erro ao salvar item.");
        }
    }

    /**
     * Processa o formulário de atualização de item.
     */
    public function atualizarItem()
    {
        $erros = ItemValidador::ValidarEntradas($_POST);
        if (!empty($erros)) {
            // Redireciona para editar com o ID se disponível, ou lista
            $id = $_POST['id_item'] ?? '';
            $url = $id ? "/backend/item/editar/{$id}" : "/backend/item/listar";
            Redirect::redirecionarComMensagem($url, "error", implode("<br>", $erros));
        }

        $id_item = (int) ($_POST["id_item"] ?? 0);
        if ($id_item <= 0) {
            Redirect::redirecionarComMensagem("/backend/item/listar", "error", "ID do item inválido.");
            return;
        }

        // =======================================
        //   TRATAMENTO DO UPLOAD DA FOTO
        // =======================================
        $fotoPath = $_POST['foto_item_atual'] ?? null;

        if (!empty($_FILES['foto_item']) && $_FILES['foto_item']['error'] === UPLOAD_ERR_OK) {
            $extensoes = ['jpg', 'jpeg', 'png', 'webp'];
            $ext = strtolower(pathinfo($_FILES['foto_item']['name'], PATHINFO_EXTENSION));

            if (in_array($ext, $extensoes) && $_FILES['foto_item']['size'] <= 5000000) {
                $nome = 'item_' . time() . '_' . uniqid() . '.' . $ext;
                $pasta = 'uploads/itens/';
                if (!is_dir($pasta)) {
                    mkdir($pasta, 0777, true);
                }
                $caminho = $pasta . $nome;

                if (move_uploaded_file($_FILES['foto_item']['tmp_name'], $caminho)) {
                    $fotoPath = '/' . $caminho;

                    // Apagar foto antiga se existir de forma segura (apenas dentro da pasta itens)
                    if (!empty($_POST['foto_item_atual'])) {
                        $arquivoAntigo = basename($_POST['foto_item_atual']);
                        $caminhoAntigo = 'uploads/itens/' . $arquivoAntigo;
                        if (file_exists($caminhoAntigo)) {
                            @unlink($caminhoAntigo);
                        }
                    }
                }
            }
        }

        // =======================================
        //          DADOS DO ITEM
        // =======================================
        $dadosItem = [
            'titulo_item' => $_POST["titulo_item"] ?? '',
            'tipo_item' => $_POST["tipo_item"] ?? '',
            'id_genero' => (int) ($_POST["id_genero"] ?? 0),
            'id_categoria' => (int) ($_POST["id_categoria"] ?? 0),
            'descricao' => $_POST["descricao"] ?? null,
            'ano_publicacao' => !empty($_POST["ano_publicacao"]) ? (int) $_POST["ano_publicacao"] : null,
            'editora_gravadora' => $_POST["editora_gravadora"] ?? null,
            'estoque' => (int) ($_POST["estoque"] ?? 1),
            'preco_item' => !empty($_POST["preco_item"]) ? (float) $_POST["preco_item"] : 0.00,
            'isbn' => $_POST["isbn"] ?? null,
            'duracao_minutos' => !empty($_POST["duracao_minutos"]) ? (int) $_POST["duracao_minutos"] : null,
            'numero_edicao' => !empty($_POST["numero_edicao"]) ? (int) $_POST["numero_edicao"] : null,
            'foto_item' => $fotoPath,
        ];

        $autores_ids = $_POST["autores_ids"] ?? [];
        $autores_ids = array_map('intval', $autores_ids);

        if ($this->item->atualizarItem($id_item, $dadosItem, $autores_ids)) {
            Redirect::redirecionarComMensagem("/backend/item/listar", "success", "Item atualizado com sucesso!");
        } else {
            // Se deu erro e subiu foto nova
            if ($fotoPath && $fotoPath !== ($_POST['foto_item_atual'] ?? null) && file_exists(ltrim($fotoPath, '/'))) {
                @unlink(ltrim($fotoPath, '/'));
            }
            Redirect::redirecionarComMensagem("/backend/item/editar/$id_item", "error", "Erro ao atualizar item.");
        }
    }

    /**
     * Processa a exclusão (soft delete)
     */
    public function deletarItem()
    {
        $id_item = (int) $_POST["id_item"];
        if ($this->item->excluirItem($id_item)) {
            Redirect::redirecionarComMensagem("/backend/item/listar", "success", "Item movido para a lixeira.");
        } else {
            Redirect::redirecionarComMensagem("/backend/item/listar", "error", "Erro ao excluir item.");
        }
    }

    // --- MÉTODOS AJAX ---

    /**
     * AJAX: Pesquisa rápida de itens (para listagem dinâmica)
     */
    public function ajaxPesquisarItens()
    {
        $termo = $_GET['term'] ?? '';

        if (empty($termo) || strlen($termo) < 2) {
            echo json_encode([]);
            exit;
        }

        $resultados = $this->item->pesquisarItensSimples($termo);

        header('Content-Type: application/json');
        echo json_encode($resultados);
        exit;
    }

    /**
     * AJAX: Busca Autores por nome (para autocomplete)
     */
    public function ajaxBuscarAutores()
    {
        $termo = $_GET['term'] ?? '';

        if (empty($termo) || strlen($termo) < 2) {
            echo json_encode([]);
            exit;
        }

        $resultados = $this->autor->buscarAutoresPorNome($termo);

        header('Content-Type: application/json');
        echo json_encode($resultados);
        exit;
    }

    /**
     * AJAX: Busca Categorias por nome (para autocomplete)
     */
    public function ajaxBuscarCategorias()
    {
        $termo = $_GET['term'] ?? '';

        if (empty($termo) || strlen($termo) < 2) {
            echo json_encode([]);
            exit;
        }

        $resultados = $this->categoria->buscarCategoriasPorNome($termo);

        header('Content-Type: application/json');
        echo json_encode($resultados);
        exit;
    }
}