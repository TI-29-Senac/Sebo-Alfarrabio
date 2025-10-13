<?php
    namespace Sebo\Alfarrabio\Models;
    use PDO;
class CatLivros {
    private $id_cat_livros;
    private $nome_categoria;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_cat_livros` WHERE excluido_em IS NULL";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_cat_livros` WHERE excluido_em IS NULL LIMIT :limit OFFSET :offset ";
        $dataStmt = $this->db->prepare($dataQuery);
        $dataStmt->bindValue(':limit', $por_pagina, PDO::PARAM_INT);
        $dataStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $dataStmt->execute();
        $dados = $dataStmt->fetchAll(PDO::FETCH_ASSOC);
        $lastPage = ceil($total_de_registros / $por_pagina);
 
        return [
            'data' => $dados,
            'total' => (int) $total_de_registros,
            'por_pagina' => (int) $por_pagina,
            'pagina_atual' => (int) $pagina,
            'ultima_pagina' => (int) $lastPage,
            'de' => $offset + 1,
            'para' => $offset + count($dados)
        ];
    }

     // metodo de buscar todos usuario por id
 function buscarCatLivrosPorId($id){
    $sql = "SELECT * FROM tbl_cat_livros where id_cat_livros = :id_cat_livros and excluido_em IS NULL";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id_cat_livros', $id); 
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
   // metodo de inserir usuario create
   function inserirCatLivros($nome){
    $sql = "INSERT INTO tbl_cat_livros (nome_categoria)  VALUES (:nome)";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    if($stmt->execute()){
        return $this->db->lastInsertId();
    }else{
        return false;
    }
}

// metodo de atualizar o usuario update
function atualizarCatLivros($id, $nome){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_cat_livros SET nome_categoria = :nome,
     WHERE id_cat_livros = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':nome', $nome);
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}
// metodo de inativar o usuario delete
function excluirCatLivros($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_cat_livros SET
     excluido_em = :atual
     WHERE id_usuario = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}
// metodo de ativar o usuario excluido
function ativarUsuario($id){
    $dataatual = NULL;
    $sql = "UPDATE tbl_cat_livros SET
     excluido_em = :atual
     WHERE id_usuario = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':atual', $dataatual);
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}

function totalCatLivros(){
    $sql = "SELECT count(*) as total FROM tbl_cat_livros";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
}



