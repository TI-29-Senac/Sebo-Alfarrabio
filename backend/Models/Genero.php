<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Genero{
    private $id_genero;
    private $nome_genero_livro;
    private $nome_genero_musica;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    public function __construct($db){
        $this->db = $db;
    }

    function buscarGenero(){
        $sql = "SELECT * FROM tbl_genero";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarGeneroPorId($id_genero){
    $sql = "SELECT * FROM tbl_autor WHERE id_genero = :id_genero";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id_genero', $id_genero, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    function inserirGenero($nome_genero_livro, $nome_genero_musica){
        $sql = "INSERT INTO tbl_genero (nome_genero_livro, nome_genero_musica) VALUES (:nome_livro, :nome_musica)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome_livro', $nome_genero_livro);
        $stmt->bindParam(':nome_musica', $nome_genero_musica);
        return $stmt->execute();
    }

    function atualizarGenero(){
        $sql = "UPDATE tbl_genero SET nome_genero_livro = :nome_livro, nome_genero_musica = :nome_musica WHERE id_genero = :id_genero";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome_livro', $this->nome_genero_livro);
        $stmt->bindParam(':nome_musica', $this->nome_genero_musica);
        $stmt->bindParam(':id_genero', $this->id_genero);
        return $stmt->execute();
    }

    function excluirGenero($id_genero){
        $sql = "DELETE FROM tbl_genero WHERE id_genero = :id_genero";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_genero', $id_genero);
        return $stmt->execute();
    }


    // Conta todas os generos
    function totalDeGenero(){
        $sql = "SELECT COUNT(*) as total FROM tbl_genero";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Conta apenas generos inativos (ajuste conforme sua coluna de status)
    function totalDeGeneroInativos(){
       $sql = "SELECT COUNT(*) as total FROM tbl_genero WHERE excluido_em is not null";
       $stmt = $this->db->prepare($sql);
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Conta apenas generos ativos
    function totalDeGeneroAtivos(){
       $sql = "SELECT COUNT(*) as total FROM tbl_genero WHERE excluido_em is null";
       $stmt = $this->db->prepare($sql);
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

















}