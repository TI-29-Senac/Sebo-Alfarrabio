<?php
namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Reservas;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\View;
use Sebo\Alfarrabio\Core\Redirect;
use Sebo\Alfarrabio\Validadores\ReservasValidador;
use Sebo\Alfarrabio\Core\FileManager;


class ReservasController {
    public $reservas;
    public $db;
    public $gerenciarImagem;
    public function __construct() {
        $this->db = Database::getInstance();
        $this->reservas = new Reservas($this->db);
        $this->gerenciarImagem = new FileManager('upload');
    }

    public function salvarReservas(){
        $erros = ReservasValidador::ValidarEntradas($_POST);
        if(!empty($erros)){
        
             Redirect::redirecionarComMensagem("/reservas/criar","error", implode("<br>", $erros));
        }
        $imagem= $this->gerenciarImagem->salvarArquivo($_FILES['imagem'], 'reservas');
         if($this->reservas->inserirReservas(
             $_POST["data_venda"],
             $_POST["valor_total"],
             $_POST["forma_pagamento"],
         )){
             Redirect::redirecionarComMensagem("reservas/listar", "success", "Venda cadastrada com sucesso!");
         }else{
             Redirect::redirecionarComMensagem("reservas/criar", "error", "Erro ao cadastrar a venda!");
         }
     }
      // index
      public function index() {
        $resultado = $this->reservas->buscarReservas();
        var_dump($resultado);
    }
    public function viewListarReservas(){
        $dados = $this->reservas->buscarReservas();
        $total_reservas = $this->reservas->totalDeReservas();
        $total_inativos = $this->reservas->totalDeReservasInativos();
        $total_ativos = $this->reservas->totalDeReservasAtivos();

        View::render("reservas/index", 
        [
            "reservas"=> $dados, 
            "total_reservas"=> $total_reservas[0],
            "total_inativos"=> $total_inativos[0],
            "total_ativos"=> $total_ativos[0]
        ]
    );
    }

    public function viewCriarReservas(){
        View::render("reservas/create", []);
    }

    public function viewEditarReservas($id_reserva){
        $dados = $this->reservas->buscarReservasPorID($id_reserva);
        foreach($dados as $reservas){
            $dados = $reservas;
        }
        View::render("reservas/edit", ["reservas" => $dados]);
    }

    public function viewExcluirReservas($id_reserva){
        View::render("reservas/delete", ["id_reserva" => $id_reserva]);
    }

    public function relatorioReservas($id_reserva, $data1, $data2){
        View::render("reservas/relatorio",
        ["id"=>$id_reserva, "data1"=> $data1, "data2"=> $data2]
    );
    }

    

    public function atualizarReservas(){
        echo "Atualizar Reservas";
    }

    public function deletarReservas(){
        echo "Deletar Reservas";
    }

}