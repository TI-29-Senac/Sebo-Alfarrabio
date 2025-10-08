<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Acervo;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;

class AcervoController {
    private $acervo;
    public function __construct(){ $this->acervo=new Acervo(Database::getInstance()); }

    public function index(){
        $dados=$this->acervo->buscarAtivos();
        View::render("acervo/index",["acervo"=>$dados]);
    }

    public function salvar(){
        $this->acervo->inserirItem($_POST['titulo'],$_POST['tipo'],$_POST['estado'],$_POST['disp'],$_POST['estoque']);
        header("Location:/backend/acervo");
    }

    public function atualizar($id){
        $this->acervo->atualizarItem($id,$_POST);
        header("Location:/backend/acervo");
    }

    public function excluir($id){
        $this->acervo->excluirItem($id);
        header("Location:/backend/acervo");
    }
}
