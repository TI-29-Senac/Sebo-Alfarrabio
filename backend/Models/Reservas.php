<?php
namespace App\Sebo\Alfarrábio\Models;
use PDO;
class Reservas{
    private $id_reserva;
    private $id_usuario;
    private $id_acervo;
    private $data_reserva;
    private $status_reserva;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os usuarios read
    function buscarReservas(){
        $sql = "SELECT * FROM tbl_reservas";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar todos usuario por email read
    function buscarReservasPorData($data_reserva){
        $sql = "SELECT * FROM tbl_reservas where data_reserva = :data";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_reserva); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarReservasPorID($id_reserva){
        $sql = "SELECT * FROM tbl_reservas where id_reserva = :id_reserva";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_reserva', $id_reserva); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarReservasPorIDUsuario($id_usuario){
        $sql = "SELECT * FROM tbl_reservas where id_usuario = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de inserir usuario create
    function inserirReservas($data_reserva, $status_reserva){
        $sql = "INSERT INTO tbl_reservas (data_reserva, status_reserva) 
                VALUES (:data, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':data', $data_reserva);
        $stmt->bindParam(':status', $status_reserva);

        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario update
    function atualizarReservas($id_reserva, $data_reserva, $status_reserva){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_reservas SET data_reservas = :data,
         status_reserva = :status
         WHERE id_reserva = :id_reserva";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_reserva', $id_reserva);
        $stmt->bindParam(':data', $data_reserva);
        $stmt->bindParam(':valort', $status_reserva);
        
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de inativar o usuario delete
    function excluirReservas($id_reserva){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_reservas SET
         excluido_em = :atual
         WHERE id_reserva = :id_reserva";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_reserva', $id_reserva);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
// metodo de ativar o usuario excluido
    function ativarReservas($id_reserva){
        $dataatual = NULL;
        $sql = "UPDATE tbl_reservas SET
         excluido_em = :atual
         WHERE id_reserva = :id_reserva";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_reserva', $id_reserva);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }}
}