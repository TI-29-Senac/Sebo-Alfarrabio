<?php
namespace Sebo\Alfarrabio\Controllers\Public;  // Namespace público para separar

use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Models\Genero;
use \Sebo\Alfarrabio\Models\Categoria;

class PublicItemController {
    
    private $db;
    private $item;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->item = new Item($this->db);
        $this->generoModel = new Genero($this->db);
        $this->categoriaModel = new Categoria($this->db);
    }

    /**
     * View pública de produtos com paginação e filtros.
     * Copiado/adaptado do ItemController, mas sem herança admin.
     */
    public function viewProdutos($pagina = 1) {
    if (empty($pagina) || $pagina <= 0) {
        $pagina = 1;
    }

    // Ler filtros de $_GET (sanitizado)
    $filtros = [
        'titulo' => trim($_GET['titulo'] ?? ''),
        'autor' => trim($_GET['autor'] ?? ''),
        'genero' => !empty($_GET['genero']) ? (int)$_GET['genero'] : null,
        'categoria' => !empty($_GET['categoria']) ? (int)$_GET['categoria'] : null,
        'tipo' => trim($_GET['tipo'] ?? '')  // Opcional
    ];

    // Remove filtros vazios
    $filtros = array_filter($filtros, fn($v) => !empty($v));

    $dados = $this->item->paginacao($pagina, 12, $filtros);

    // Puxar opções para selects (do banco)
    $generos = $this->generoModel->buscarGeneros();  // Array de ['id_genero' => 'nome']
    $categorias = $this->categoriaModel->buscarCategorias();

    // Mapeamento de filtros visuais (para classes CSS, como antes)
    $mapeamentoFiltros = [
        1 => 'ficcao-cientifica',
        2 => 'fantasia',
        3 => 'romance',
        4 => 'terror',
    ];

    $itensComFiltros = [];
    foreach ($dados['data'] as $item) {
        $classeFiltro = 'todos';
        if (isset($mapeamentoFiltros[$item['id_genero']])) {
            $classeFiltro = $mapeamentoFiltros[$item['id_genero']];
        }

        $itensComFiltros[] = [
            'id' => $item['id_item'],
            'titulo' => htmlspecialchars($item['titulo_item']),
            'descricao' => !empty($item['descricao']) 
                ? (strlen($item['descricao']) > 120 ? substr($item['descricao'], 0, 120) . '...' : $item['descricao'])
                : 'Explore este item incrível do nosso acervo.',
            'imagem' => !empty($item['foto_item']) 
                ? (filter_var($item['foto_item'], FILTER_VALIDATE_URL) 
                    ? $item['foto_item'] 
                    : '/uploads/' . htmlspecialchars($item['foto_item']))
                : '/img/default-livro.jpg',
            'preco' => number_format($item['preco'] ?? 0, 2, ',', '.'),
            'tipo' => ucfirst($item['tipo_item']),
            'estoque' => $item['estoque'] ?? 0,
            'autores' => $item['autores'] ?? 'Autor não informado',
            'filtro_classes' => $classeFiltro
        ];
    }

    $totalItens = $dados['total'];  // Agora vem filtrado

    View::renderPublic("produtos", [
        "itens" => $itensComFiltros,
        "total_itens" => $totalItens,
        'paginacao' => $dados,
        'filtros' => $filtros,  // Para preencher inputs na view
        'generos' => $generos,  // Para select
        'categorias' => $categorias  // Para select
    ]);
}
}