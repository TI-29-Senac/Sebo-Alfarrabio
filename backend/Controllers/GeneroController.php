<?php
namespace Sebo\Alfarrabio\Controllers;

use LDAP\Result;
use Sebo\Alfarrabio\Models\Genero;
use Sebo\Alfarrabio\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\ReservasValidador; 
use Sebo\Alfarrabio\Core\FileManager;


class GeneroController{
    public $genero;
    public $db;
    public $gerenciarimagem;
    public function __construct(){
        $this->db = Database::getInstance();
        $this->genero = new Genero($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function salvarGenero(){
        $erros = GeneroValidador::ValidarEntradas($_POST);
        if(!empty($erros)){

            Redirect::redirecionarComMensagem("/genero/criar","error", implode("<br>", $erros));
        }
        $imagem = $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'genero');
        if($this->genero->inserirGenero(
            $_POST["nome"],
            $_POST["descricao"],
            )){
                Redirect::redirecionarComMensagem("genero/listar", "sucess", "Genero cadastrado com sucesso!");
            }else{
                Redirect::redirecionarComMensagem("genero/criar", "error", "Erro ao cadastrar o genero!");
            }
        }


        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        }
































}





