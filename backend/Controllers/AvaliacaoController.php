<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Avaliacao;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\AvaliacaoValidador;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Models\Item;


class AvaliacaoController {
    public $avaliacao;
    public $item;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->avaliacao = new Avaliacao($this->db);
        $this->item = new Item($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

      

public function index() {
    $this->viewListarAvaliacao();  // Redirecione pra listar
}

public function viewListarAvaliacao() {
    $dados = $this->avaliacao->buscarAvaliacao();
    View::render("avaliacao/index", [
        "avaliacao" => $dados,
        "total_avaliacao" => $this->avaliacao->totalDeAvaliacao(),  // ← Scalar agora
        "total_inativos" => $this->avaliacao->totalDeAvaliacaoInativos(),
        "total_ativos" => $this->avaliacao->totalDeAvaliacaoAtivos()
    ]);
}

public function viewCriarAvaliacao() {
    $itens = $this->item->buscarItens();  // ← Popule dropdown
    View::render("avaliacao/create", ["itens" => $itens]);
}

public function salvarAvaliacao() {
    // Validação básica (expanda com AvaliacaoValidador depois)
    $erros = [];
    if (empty($_POST["nota_avaliacao"]) || !is_numeric($_POST["nota_avaliacao"]) || $_POST["nota_avaliacao"] < 1 || $_POST["nota_avaliacao"] > 5) {
        $erros[] = "Nota deve ser entre 1 e 5.";
    }
    if (empty($_POST["id_item"]) || !is_numeric($_POST["id_item"])) {
        $erros[] = "Selecione um item válido.";
    }
    if (!empty($erros)) {
        Redirect::redirecionarComMensagem("/avaliacao/criar", "error", implode("<br>", $erros));
        return;
    }

    $id_item = (int) $_POST['id_item'];
    $id_usuario = (int) ($_POST['id_usuario'] ?? $_SESSION['id_usuario']);

    $id = $this->avaliacao->inserirAvaliacao(  // ← Agora com FKs
        $id_item,
        $id_usuario,
        $_POST["nota_avaliacao"],
        $_POST["comentario_avaliacao"] ?? null,
        $_POST["data_avaliacao"] ?? date('Y-m-d'),
        $_POST["status_avaliacao"] ?? 'ativo'
    );

    if ($id > 0) {
        Redirect::redirecionarComMensagem("/avaliacao/listar", "success", "Avaliação #{$id} cadastrada com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("/avaliacao/criar", "error", "Erro ao cadastrar (veja logs).");
    }
}

public function viewEditarAvaliacao($id_avaliacao) {
    $dados = $this->avaliacao->buscarAvaliacaoPorID($id_avaliacao);
    if (!$dados) {
        Redirect::redirecionarComMensagem("/avaliacao/listar", "error", "Avaliação não encontrada.");
    }
    
    // ← AQUI: Busque itens ativos pra dropdown
    $itemModel = new Item($this->db);  // Instancie model Item (passe $db)
    $itens = $itemModel->buscarItemAtivos();  // Método que lista itens (veja abaixo se não existe)
    
    View::render("avaliacao/edit", [
        "avaliacao" => $dados,
        "itens" => $itens  // ← Passe aqui!
    ]);
}

public function atualizarAvaliacao() {
    $id_avaliacao = (int) $_POST['id_avaliacao'];
    $erros = AvaliacaoValidador::ValidarEntradas($_POST);
    if (!empty($erros)) {
        Redirect::redirecionarComMensagem("/avaliacao/editar/{$id_avaliacao}", "error", implode("<br>", $erros));
    }

    $sucesso = $this->avaliacao->atualizarAvaliacao(
        $id_avaliacao,
        $_POST['nota_avaliacao'],
        $_POST['comentario_avaliacao'],
        $_POST['data_avaliacao'],
        $_POST['status_avaliacao']
    );

    if ($sucesso) {
        Redirect::redirecionarComMensagem("/avaliacao/listar", "success", "Atualizada!");
    } else {
        Redirect::redirecionarComMensagem("/avaliacao/editar/{$id_avaliacao}", "error", "Erro ao atualizar.");
    }
}


public function viewExcluirAvaliacao($id_avaliacao) {  // Removi int – PHP infere
    $avaliacao = $this->avaliacao->buscarAvaliacaoPorID($id_avaliacao);  // Agora single
    if (!$avaliacao) {
        Redirect::redirecionarComMensagem("/avaliacao/listar", "error", "Avaliação não encontrada.");  // ← Msg específica
    }

    View::render("avaliacao/delete", ["avaliacao" => $avaliacao]);  // ← Sem / extra
}

public function deletarAvaliacao() {
    $id_avaliacao = (int) $_POST['id_avaliacao'];
    if ($this->avaliacao->deletarAvaliacao($id_avaliacao)) {  // Agora soft-delete
        Redirect::redirecionarComMensagem("/avaliacao/listar", "success", "Avaliação inativada com sucesso!");
    } else {
        Redirect::redirecionarComMensagem("/avaliacao/listar", "error", "Erro ao inativar avaliação.");
    }
}

// Bônus: Adicione ativarAvaliacao() se link na listagem
public function ativarAvaliacao() {
    $id_avaliacao = (int) ($_POST['id_avaliacao'] ?? $_GET['id'] ?? 0);
    if ($this->avaliacao->ativarAvaliacao($id_avaliacao)) {
        Redirect::redirecionarComMensagem("/avaliacao/listar", "success", "Avaliação reativada!");
    } else {
        Redirect::redirecionarComMensagem("/avaliacao/listar", "error", "Erro ao reativar.");
    }
}
}