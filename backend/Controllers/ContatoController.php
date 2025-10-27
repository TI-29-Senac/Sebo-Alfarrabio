<?php
namespace Sebo\Alfarrabio\Controllers;
use PDO;
use Sebo\Alfarrabio\Models\Contato;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;

class ContatoController {
    public $contato;
    public $db;
    public function __construct() {
        $db = Database::getInstance();
        $this->contato = new Contato($db);
    }

    public function index() {
        $resultado = $this->contato->paginacao();
        return $resultado;
        var_dump($resultado);
    }

    public function viewListarContatos($pagina){
        $dados = $this->contato->paginacao($pagina);
        $total = $this->contato->totalDeContatos();
        View::render("contato/index",
        [
        "contato"=> $dados['data'],
         "total_usuarios"=> $total[0],
         "total_inativos" => 22,
         "Total_ativos" => 12,
         'paginacao' => $dados
        ]
        );
    }

    public function viewCriarContato() {
        View::render("contato/create");
    }

    public function salvarContato() {
        if( $this->contato->inseriContatos(
            $_POST['nome_contato'],
            $_POST['telefone_contato'],
            $_POST['email_contato'], 
            $_POST['assunto_contato'], 
            $_POST['mensagem_contato'], 
            $_POST['status_contato']
            )){
                Redirect::redirecionarComMensagem("contato/listar", "success", "Contato enviado com sucesso!");
            }else{
                Redirect::redirecionarComMensagem("contato/criar", "error", "Erro ao enviado Contato");
            } ;
    }

    public function viewEditarContato($id) {
        View::render("contato/edit", ["id" => $id]);
    }

    public function viewExcluirContato($id) {
        View::render("contato/delete", ["id_contato"=> $id]);
    }

    public function atualizarContato() {
        echo "Atualizar usuario";
    }

    public function deletarContato() {
        echo "Deletar contato";;
    }
}
