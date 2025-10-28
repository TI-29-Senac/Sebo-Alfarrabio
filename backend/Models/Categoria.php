<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Categoria{
    private $id_categoria;
    private $nome_categoria;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
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

    function buscarCategoriaPorId($id_categoria){
        $sql = "SELECT * FROM tbl_categoria WHERE id_categoria = :id_categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
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

    // Conta todas as categorias
    function totalDeCategoria(){
        $sql = "SELECT COUNT(*) as total FROM tbl_categoria";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }

   // Conta apenas categorias inativas (ajuste conforme sua coluna de status)
    function totalDeCategoriaInativos(){
        $sql = "SELECT COUNT(*) as total FROM tbl_categoria WHERE excluido_em is not null";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Conta apenas categorias ativas
    function totalDeCategoriaAtivos(){
        $sql = "SELECT COUNT(*) as total FROM tbl_categoria WHERE excluido_em is null";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



















}