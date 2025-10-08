<?php
namespace App\Sebo_Alfarrabio\Models;
use PDO;
class Livros{
    public $id_livros;
    public $id_acervo;
    public $id_cat_livros;
    public $titulo_livro;
    public $autor_livro;
    public $editora_livro;
    public $edicao_livro;
    public $ano_publicacao_livro;
    public $idioma_livro;
    public $descricao_livro;
    public $preco_livro;
    public $foto_livro;
    public $criado_em;
    public $atualizado_em;
    public $excluido_em;
    public $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os usuarios read
    function buscarLivros(){
        $sql = "SELECT * FROM tbl_livros where excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de buscar todos os livros por id read
    function buscarLivrospor(){
        $sql = "SELECT * FROM tbl_livros where id_livros  = :id and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id'); 
        $stmt->execute();
    }
    
    // metodo de inserir usuario create
    function inserirLivros($id_livros, $id_acervo, $id_cat_livros, $titulo_livro, $autor_livro, $editora_livro, $edicao_livro, $ano_publicacao_livro, $idioma_livro, $descricao_livro, $preco_livro, $foto_livro){
        $sql = "INSERT INTO tbl_livros (titulo
        _livro, autor_livro, editora_livro, 
        edicao_livro, ano_publicacao_livro, idioma_livro, descricao_livro, preco_livro, foto_livro) 
                VALUES (:titulo, :autor, :editora, :edicao, :ano_publicacao, :idioma, :descricao, :preco, :foto)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo_livro);
        $stmt->bindParam(':autor',$autor_livro);
        $stmt->bindParam(':editora', $editora_livro);
        $stmt->bindParam(':editora', $editora_livro);
        $stmt->bindParam(':ano_publucacao', $ano_publicacao_livro);
        $stmt->bindParam(':idioma', $idioma_livro);
        $stmt->bindParam(':descricao', $descricao_livro);
        $stmt->bindParam(':preco', $preco_livro);
        $stmt->bindParam(':foto', $foto_livro);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }
    // metodo de atualizar o usuario update
    function atualizarLivros($id_livros, $id_acervo,$id_cat_livros, $titulo_livro, $autor_livro, $editora_livro, $ano_publicacao_livro, $idioma_livro, $descricao_livro, $preco_livro, $foto_livro){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_livros SET titulo_livro = :titulo,
         autor = :autor_livro,
         editora_livro  = :editora, 
         edicao_livro = :edicao,
         ano_publicacao_livro = :ano_publicacao,
         idioma_livro = :idioma,
         descricao_livro = :descricao,
         preco_livro = :preco,
         foto_livro = :foto,
         atualizado_em = :atual
         WHERE id_livros = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_livros);
        $stmt->bindParam(':titulo', $titulo_livro);
        $stmt->bindParam(':autor', $autor_livro);
        $stmt->bindParam(':editora', $editora_livro);
        $stmt->bindParam(':ano_publucacao', $ano_publicacao_livro);
        $stmt->bindParam(':idioma', $idioma_livro);
        $stmt->bindParam(':descricao', $descricao_livro);
        $stmt->bindParam(':preco', $preco_livro);
        $stmt->bindParam(':foto', $foto_livro);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de deletar o livro (delete)
    function excluirLivros($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_livros SET
         excluido_em = :atual
         WHERE id_livros = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function ativarLivros($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_livros SET
         excluido_em = :atual
         WHERE id_livros = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}