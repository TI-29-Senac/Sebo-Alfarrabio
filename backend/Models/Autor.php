<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Autor{
    private $id_autor;
    private $autor_livro;
    private $autor_disco;
    private $diretor_dvds;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    public function __construct($db){
        $this->db = $db;
    }

    function buscarAutor(){
        $sql = "SELECT * FROM tbl_autor";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    function buscarAutorPorId($id_autor){
    $sql = "SELECT * FROM tbl_autor WHERE id_autor = :id_autor";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id_autor', $id_autor, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    function inserirAutor($autor_livro, $autor_disco, $diretor_dvds){
        $sql = "INSERT INTO tbl_autor (autor_livro, autor_disco, diretor_dvds) VALUES (:autor_livro, :autor_disco, :dretor_dvds)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':autor_livro', $autor_livro);
        $stmt->bindParam(':autor_disco', $autor_disco);
         $stmt->bindParam(':diretor_dvds', $diretor_dvds);
        return $stmt->execute();
    }

    function atualizarAutor(){
        $sql = "UPDATE tbl_autor SET autor_livro = :autor_livro, autor_disco = :autor_disco, diretor_dvds = :diretor_dvds WHERE id_autor = :id_autor";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':autor_livro', $this->autor_livro);
        $stmt->bindParam(':autor_disco', $this->autor_disco);
         $stmt->bindParam(':diretor_dvds', $this->diretor_dvds);
        $stmt->bindParam(':id_autor', $this->id_autor);
        return $stmt->execute();
    }

    function excluirAutor($id_autor){
        $sql = "DELETE FROM tbl_autor WHERE id_autor = :id_autor";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_autor', $id_autor);
        return $stmt->execute();
    }
 
     // Conta todos os autores
    function totalDeAutor(){
        $sql = "SELECT COUNT(*) as total FROM tbl_autor";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Conta apenas generos inativos (ajuste conforme sua coluna de status)
    function totalDeAutorInativos(){
       $sql = "SELECT COUNT(*) as total FROM tbl_autor WHERE excluido_em is not null";
       $stmt = $this->db->prepare($sql);
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Conta apenas generos ativos
    function totalDeAutorAtivos(){
       $sql = "SELECT COUNT(*) as total FROM tbl_autor WHERE excluido_em is null";
       $stmt = $this->db->prepare($sql);
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




















}