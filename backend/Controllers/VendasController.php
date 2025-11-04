<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Vendas;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\VendasValidador;
use Sebo\Alfarrabio\Core\FileManager;
use Sebo\Alfarrabio\Core\Session;

class VendasController {
    private $vendas;
    private $db;
    private $gerenciarImagem;
    private $session;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->vendas = new Vendas($this->db);
        $this->gerenciarImagem = new FileManager('upload');
        $this->session = new Session();
    }

    // ===== LISTAR VENDAS =====
    
    public function viewListarVendas($pagina = 1){
        if(empty($pagina) || $pagina <= 0){
            $pagina = 1;
        }

        $dados = $this->vendas->paginacao($pagina);
        $total = $this->vendas->totalDeVendas();
        $total_inativos = $this->vendas->totalDeVendasInativos();
        $total_ativos = $this->vendas->totalDeVendasAtivos();

        View::render("vendas/index", [
            "vendas" => $dados['data'], 
            "total_vendas" => $total,
            "total_inativos" => $total_inativos,
            "total_ativos" => $total_ativos,
            'paginacao' => $dados
        ]);
    }

    // ===== CRIAR VENDA =====
    
    public function viewCriarVendas(){
        View::render("vendas/create", []);
    }

    public function salvarVendas(){
        $erros = VendasValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            error_log("Erros de validação: " . implode(", ", $erros));
            Redirect::redirecionarComMensagem("/vendas/criar", "error", implode("<br>", $erros));
        }

        // Pegar ID do usuário da sessão
        $id_usuario = $this->session->get('usuario_id');
        if(!$id_usuario){
            error_log("Usuário não autenticado");
            Redirect::redirecionarComMensagem("/vendas/criar", "error", "Usuário não autenticado.");
        }

        $data_venda = $_POST["data_venda"] ?? date('Y-m-d');
        $valor_total = $_POST["valor_total"];
        $forma_pagamento = $_POST["forma_pagamento"];

        error_log("Dados: id_usuario={$id_usuario}, data={$data_venda}, valor={$valor_total}, forma={$forma_pagamento}");

        // Inserir venda
        $id_venda = $this->vendas->inserirVenda($id_usuario, $data_venda, $valor_total, $forma_pagamento);
        
        if($id_venda){
            error_log("Venda cadastrada com ID: {$id_venda}");
            Redirect::redirecionarComMensagem("/vendas/listar", "success", "Venda cadastrada com sucesso! ID: {$id_venda}");
        } else {
            error_log("ERRO ao cadastrar venda");
            Redirect::redirecionarComMensagem("/vendas/criar", "error", "Erro ao cadastrar a venda no banco de dados!");
        }
    }

    // ===== EDITAR VENDA =====
    
    public function viewEditarVendas($id_venda){
        error_log("=== EXIBINDO FORMULÁRIO DE EDIÇÃO ===");
        error_log("ID Venda recebido: {$id_venda}");
        error_log("Tipo do ID: " . gettype($id_venda));

        // Garantir que é inteiro
        $id_venda = (int)$id_venda;
        
        $dados = $this->vendas->buscarVendasPorID($id_venda);
        
        error_log("Dados retornados da busca: " . print_r($dados, true));
        error_log("Tipo de dados: " . gettype($dados));
        error_log("Dados vazios? " . (empty($dados) ? "SIM" : "NÃO"));
        
        if(!$dados || empty($dados)){
            error_log("ERRO: Venda não encontrada no banco - ID {$id_venda}");
            Redirect::redirecionarComMensagem("/vendas/listar", "error", "Venda não encontrada no banco de dados.");
            return;
        }
        
        error_log("Renderizando view com dados: " . json_encode($dados));
        View::render("vendas/edit", ["vendas" => $dados]);
    }

    public function atualizarVendas(){
        // Log detalhado para debug
        error_log("=== ATUALIZANDO VENDA ===");
        error_log("POST recebido: " . print_r($_POST, true));
        error_log("REQUEST METHOD: " . $_SERVER['REQUEST_METHOD']);
        error_log("CONTENT TYPE: " . ($_SERVER['CONTENT_TYPE'] ?? 'não definido'));

        // Verificar se é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("ERRO: Método não é POST");
            Redirect::redirecionarComMensagem("/vendas/listar", "error", "Método inválido.");
        }

        // Verificar se o ID existe
        if (!isset($_POST['id_venda']) || empty($_POST['id_venda'])) {
            error_log("ERRO: ID da venda não foi enviado no POST");
            error_log("POST completo: " . print_r($_POST, true));
            Redirect::redirecionarComMensagem("/vendas/listar", "error", "ID da venda não foi informado!");
        }

        $id_venda = (int)$_POST['id_venda'];
        error_log("ID Venda capturado: {$id_venda}");

        // Validar entradas
        $erros = VendasValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
            error_log("Erros de validação: " . implode(", ", $erros));
            Redirect::redirecionarComMensagem("/vendas/editar/{$id_venda}", "error", implode("<br>", $erros));
        }

        $data_venda = $_POST["data_venda"];
        $valor_total = $_POST["valor_total"];
        $forma_pagamento = $_POST["forma_pagamento"];

        error_log("Dados para atualizar: ID={$id_venda}, Data={$data_venda}, Valor={$valor_total}, Forma={$forma_pagamento}");

        // Tentar atualizar
        try {
            $resultado = $this->vendas->atualizarVenda($id_venda, $data_venda, $valor_total, $forma_pagamento);
            error_log("Resultado da atualização: " . ($resultado ? "SUCESSO" : "FALHA"));

            if($resultado){
                Redirect::redirecionarComMensagem("/vendas/listar", "success", "Venda atualizada com sucesso!");
            } else {
                error_log("ERRO: Update retornou FALSE");
                Redirect::redirecionarComMensagem("/vendas/editar/{$id_venda}", "error", "Erro ao atualizar venda no banco de dados.");
            }
        } catch (\Exception $e) {
            error_log("EXCEÇÃO ao atualizar: " . $e->getMessage());
            Redirect::redirecionarComMensagem("/vendas/editar/{$id_venda}", "error", "Erro: " . $e->getMessage());
        }
    }

    // ===== EXCLUIR VENDA =====
    
    public function viewExcluirVendas($id_venda){
        error_log("=== EXIBINDO CONFIRMAÇÃO DE EXCLUSÃO ===");
        error_log("ID Venda: {$id_venda}");

        $dados = $this->vendas->buscarVendasPorID($id_venda);
        
        if(!$dados){
            error_log("Venda não encontrada: ID {$id_venda}");
            Redirect::redirecionarComMensagem("/vendas/listar", "error", "Venda não encontrada.");
        }
        
        View::render("vendas/delete", ["vendas" => $dados]);
    }

    public function deletarVendas(){
        error_log("=== DELETANDO VENDA ===");
        error_log("POST: " . print_r($_POST, true));

        if (!isset($_POST['id_venda'])) {
            error_log("ERRO: ID não enviado");
            Redirect::redirecionarComMensagem("/vendas/listar", "error", "ID da venda não foi informado!");
        }

        $id_venda = (int)$_POST['id_venda'];
        error_log("ID para deletar: {$id_venda}");
        
        try {
            $resultado = $this->vendas->excluirVenda($id_venda);
            error_log("Resultado exclusão: " . ($resultado ? "SUCESSO" : "FALHA"));

            if($resultado){
                Redirect::redirecionarComMensagem("/vendas/listar", "success", "Venda excluída com sucesso!");
            } else {
                error_log("ERRO: Delete retornou FALSE");
                Redirect::redirecionarComMensagem("/vendas/listar", "error", "Erro ao excluir venda.");
            }
        } catch (\Exception $e) {
            error_log("EXCEÇÃO ao deletar: " . $e->getMessage());
            Redirect::redirecionarComMensagem("/vendas/listar", "error", "Erro: " . $e->getMessage());
        }
    }

    // ===== REATIVAR VENDA =====
    
    public function ativarVenda(){
        error_log("=== REATIVANDO VENDA ===");
        
        $id_venda = (int)$_POST['id_venda'];
        error_log("ID para reativar: {$id_venda}");
        
        if($this->vendas->ativarVenda($id_venda)){
            Redirect::redirecionarComMensagem("/vendas/listar", "success", "Venda reativada com sucesso!");
        } else {
            Redirect::redirecionarComMensagem("/vendas/listar", "error", "Erro ao reativar venda.");
        }
    }

    // ===== RELATÓRIO =====
    
    public function relatorioVendas($id_venda = null, $data1 = null, $data2 = null){
        $vendas = [];
        $total_periodo = 0;

        if($id_venda){
            $vendas[] = $this->vendas->buscarVendasPorID($id_venda);
        } else if($data1 && $data2){
            $vendas = $this->vendas->buscarVendasPorData($data1);
            $total_periodo = $this->vendas->calcularTotalVendasPeriodo($data1, $data2);
        } else {
            $vendas = $this->vendas->buscarVendas();
        }

        View::render("vendas/relatorio", [
            "vendas" => $vendas,
            "data1" => $data1, 
            "data2" => $data2,
            "total_periodo" => $total_periodo
        ]);
    }

    // ===== DEBUG =====
    
    public function index() {
        $resultado = $this->vendas->buscarVendas();
        echo "<pre>";
        print_r($resultado);
        echo "</pre>";
    }
}
?>