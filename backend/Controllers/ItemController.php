<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Models\Autor;
use Sebo\Alfarrabio\Models\Categoria;
use Sebo\Alfarrabio\Models\Genero;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\ItemValidador; // Você precisará criar este validador
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Controllers\Admin\AdminController; // Baseado no seu exemplo

class ItemController extends AdminController {
    
    public $db;
    public $item;
    public $autor;
    public $categoria;
    public $genero;
    // public $gerenciarImagem; // Descomente se os itens tiverem imagens

    public function __construct() {
        parent::__construct();
        $this->db = Database::getInstance();
        
        // Instancia todos os models necessários
        $this->item = new Item($this->db);
        $this->autor = new Autor($this->db);
        $this->categoria = new Categoria($this->db);
        $this->genero = new Genero($this->db);

        // $this->gerenciarImagem = new FileManager('upload'); // Para imagens de itens
    }

    /**
     * Exibe a view de listagem com paginação e estatísticas.
     */
    public function viewListarItens($pagina = 1){
        if(empty($pagina) || $pagina <= 0){
            $pagina = 1;
        }

        // Busca dados paginados já com JOINs (autores, categoria, genero)
        $dados = $this->item->paginacao($pagina, 10); // 10 por página
        
        $totalAtivos = $this->item->totalDeItensAtivos();
        $totalInativos = $this->item->totalDeItensInativos();
        $total = $this->item->totalDeItens();
        
        View::render("item/index", [
            "itens" => $dados['data'],
            "total_itens" => $total,
            "total_inativos" => $totalInativos,
            "total_ativos" => $totalAtivos,
            'paginacao' => $dados
        ]);
    }

    /**
     * Exibe o formulário de criação.
     * Envia os dados de Gêneros e Categorias para preencher os <select>.
     */
    public function viewCriarItem(){
        // Busca gêneros e categorias ativos para os dropdowns
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
    public function viewEditarItem(int $id){
        // Busca o item e os IDs dos seus autores
        $item = $this->item->buscarItemPorID($id);

        if (!$item) {
            Redirect::redirecionarComMensagem("/backend/item/listar","error","Item não encontrado!");
            return;
        }

        // Busca Gêneros e Categorias para os dropdowns
        $generos = $this->genero->buscarGeneros();
        $categorias = $this->categoria->buscarCategorias();

        // Precisamos buscar os dados dos autores já selecionados para a view
        $autoresSelecionados = [];
        if (!empty($item['autores_ids'])) {
            // Este é um loop simples. Se ficar lento, podemos criar um
            // método no AutorModel: buscarAutoresPorIDs(array $ids)
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
            "autores_selecionados" => $autoresSelecionados // Array com [id_autor, nome_autor]
        ]);
    }

    /**
     * Exibe a tela de confirmação de exclusão
     */
    public function viewExcluirItem($id){
       $item = $this->item->buscarItemPorID($id);
       if (!$item) {
            Redirect::redirecionarComMensagem("/backend/item/listar","error","Item não encontrado!");
            return;
       }
       // Passa apenas o necessário para a view de confirmação
       View::render("item/delete", [
           "id_item" => $item['id_item'],
           "titulo_item" => $item['titulo_item']
       ]);
    }

    // --- MÉTODOS DE PROCESSAMENTO (POST) ---

    /**
     * Processa o formulário de salvar novo item.
     */
    public function salvarItem(){
        // === UPLOAD DA FOTO (automático) ===
        $fotoPath = null;
        if (!empty($_FILES['foto_item']) && $_FILES['foto_item']['error'] === 0) {
            $extensoes = ['jpg','jpeg','png','webp'];
            $ext = strtolower(pathinfo($_FILES['foto_item']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $extensoes) && $_FILES['foto_item']['size'] <= 5000000) {
                $nome = 'item_' . time() . '_' . uniqid() . '.' . $ext;
                $pasta = 'uploads/itens/';
                if (!is_dir($pasta)) mkdir($pasta, 0777, true);
                $caminho = $pasta . $nome;
                if (move_uploaded_file($_FILES['foto_item']['tmp_name'], $caminho)) {
                    $fotoPath = '/' . $caminho;
                }
            }
        }
    
        $dadosItem = [
            'titulo_item'       => $_POST['titulo_item'],
            'tipo_item'         => $_POST['tipo_item'],
            'id_genero'         => (int)$_POST['id_genero'],
            'id_categoria'      => (int)$_POST['id_categoria'],
            'descricao'         => $_POST['descricao'] ?? null,
            'ano_publicacao'    => !empty($_POST['ano_publicacao']) ? (int)$_POST['ano_publicacao'] : null,
            'editora_gravadora' => $_POST['editora_gravadora'] ?? null,
            'estoque'           => (int)($_POST['estoque'] ?? 1),
            'isbn'              => $_POST['isbn'] ?? null,
            'duracao_minutos'   => !empty($_POST['duracao_minutos']) ? (int)$_POST['duracao_minutos'] : null,
            'numero_edicao'     => !empty($_POST['numero_edicao']) ? (int)$_POST['numero_edicao'] : null,
            'foto_item'         => $fotoPath, // ← a mágica acontece aqui
        ];
    
        $autores_ids = $_POST['autores_ids'] ?? [];
        $autores_ids = array_map('intval', $autores_ids);
    
        if($this->item->inserirItem($dadosItem, $autores_ids)){
            Redirect::redirecionarComMensagem("/backend/item/listar","success","Item cadastrado com sucesso!");
        } else {
            if ($fotoPath && file_exists(ltrim($fotoPath,'/'))) unlink(ltrim($fotoPath,'/'));
            Redirect::redirecionarComMensagem("/backend/item/criar","error","Erro ao salvar item.");
        }
    }

    /**
     * Processa o formulário de atualização de item.
     */
    public function atualizarItem(){
        // 1. Validação (similar ao salvar)
        
        // 2. Preparar dados
        $id_item = (int)$_POST["id_item"];
        if (empty($id_item)) {
             Redirect::redirecionarComMensagem("/backend/item/listar","error","ID do item inválido.");
             return;
        }

        $dadosItem = [
            'titulo_item' => $_POST["titulo_item"],
            'tipo_item' => $_POST["tipo_item"],
            'id_genero' => $_POST["id_genero"],
            'id_categoria' => $_POST["id_categoria"],
            'descricao' => $_POST["descricao"] ?? null,
            'ano_publicacao' => $_POST["ano_publicacao"] ? (int)$_POST["ano_publicacao"] : null,
            'editora_gravadora' => $_POST["editora_gravadora"] ?? null,
            'estoque' => $_POST["estoque"] ? (int)$_POST["estoque"] : 1,
            'isbn' => $_POST["isbn"] ?? null,
            'duracao_minutos' => $_POST["duracao_minutos"] ? (int)$_POST["duracao_minutos"] : null,
            'numero_edicao' => $_POST["numero_edicao"] ? (int)$_POST["numero_edicao"] : null,
            'foto_item' => $_POST["foto_item"] ?? null,
        ];

        $autores_ids = $_POST["autores_ids"] ?? [];
        $autores_ids = array_map('intval', $autores_ids);
        
        // 3. Chamar o Model (que usa transação)
        if($this->item->atualizarItem($id_item, $dadosItem, $autores_ids)){
            Redirect::redirecionarComMensagem("/backend/item/editar/$id_item","success","Item atualizado com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/backend/item/editar/$id_item","error","Erro ao atualizar item. A operação foi revertida.");
        }
    }

    /**
     * Processa a exclusão (soft delete)
     */
    public function deletarItem(){
        $id_item = (int)$_POST["id_item"];
         if($this->item->excluirItem($id_item)){
            Redirect::redirecionarComMensagem("/backend/item/listar","success","Item movido para a lixeira.");
        }else{
            Redirect::redirecionarComMensagem("/backend/item/listar","error","Erro ao excluir item.");
        }
    }

    // --- MÉTODOS AJAX (Para o formulário) ---

    /**
     * AJAX: Busca Autores por nome (para autocomplete)
     */
    public function ajaxBuscarAutores(){
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
    public function ajaxBuscarCategorias(){
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