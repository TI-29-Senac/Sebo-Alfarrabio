<?php
namespace Sebo\Alfarrabipo\Models;
use PDO;
class Categoria{
    private $id_categoria;
    private $nome_categoria;
    private $db;
    public function __construct($db){
        $this->db = $db;
    }

    function buscarCategoria(){
        $sql = "SELECT * FROM tbl_categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarCategoriaPorId(){
        $sql = "SELECT COUNT(*) as total FROM tbl_categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function inserirCategoria($nome_categoria){
        $sql = "INSERT INTO tbl_autor (nome_categoria) VALUES (:nome_categoria)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome_categoria', $nome_categoria);
        return $stmt->execute();
    }

    function atualizarCategoria(){
        $sql = "UPDATE tbl_categoria SET nome_categoria = :nome_categoria WHERE id_categoria = :id_categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome_categoria', $this->nome_categoria);
        $stmt->bindParam(':id_categoria', $this->id_categoria);
        return $stmt->execute();
    }

    function excluirCategoria($id_categoria){
        $sql = "DELETE FROM tbl_categoria WHERE id_categoria = :id_categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria);
        return $stmt->execute();
    }




















}