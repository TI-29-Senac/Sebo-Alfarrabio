<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Acervo{
    private $id_acervo;
    private $titulo_acervo;
    private $tipo_item_acervo;
    private $estado_conservacao;
    private $disponibilidade_acervo;
    private $estoque_acervo;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }
    // metodo de buscar todos os usuarios read
    // metodo de buscar todos os usuarios read
    public function paginacao(int $pagina = 1, int $por_pagina = 10): array{
        $totalQuery = "SELECT COUNT(*) FROM `tbl_acervo` WHERE excluido_em IS NULL";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        $offset = ($pagina - 1) * $por_pagina;
        $dataQuery = "SELECT * FROM `tbl_acervo` WHERE excluido_em IS NULL LIMIT :limit OFFSET :offset ";
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

      function buscarAcervoInativos(){
        $sql = "SELECT * FROM tbl_acervo where excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // metodo de buscar todos usuario por email read
    function buscarAcervoPorTitulo($titulo){
        $sql = "SELECT * FROM tbl_acervo where titulo_acervo = :titulo and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     // metodo de buscar todos usuario por id
    function buscarAcervoPorId($id){
        $sql = "SELECT * FROM tbl_acervo where id_acervo = :id_acervo and excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_acervo', $id); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    function buscarPorTituloInativo($titulo){
        $sql = "SELECT * FROM tbl_acervo where titulo_acervo = :titulo and excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo); 
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // metodo de inserir usuario create
    function inseriAcervo($titulo, $tipo, $estado, $disponibilidade, $estoque,){
        $sql = "INSERT INTO tbl_acervo (titulo_acervo, tipo_item_acervo, estado_conservacao, 
        disponibilidade_acervo, estoque_acervo, ) 
                VALUES (:titulo, :tipo, :estoque, :disponibilidade, :estado, )";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':disponibilidade', $disponibilidade);
        $stmt->bindParam(':estoque', $estoque);
        
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario update
    function atualizarAcervo($id, $titulo, $tipo, $estado, $disponibilidade, $estoque){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_acervo SET titulo_acervo = :nome,
         tipo_item_acervo = :tipo, 
         estado_conservacao = :estado, 
         disponibilidade_acervo = :disponibilidade,
         estoque_acervo = :estoque,
         atualizado_em = :atual
         WHERE id_acervo = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':disponibilidade', $disponibilidade);
        $stmt->bindParam(':estoque', $estoque);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // metodo de inativar o usuario delete
    function excluirAcervo($id){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_acervo SET
         excluido_em = :atual
         WHERE id_acervo = :id";
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
    function ativarAcervo($id){
        $dataatual = NULL;
        $sql = "UPDATE tbl_acervo SET
         excluido_em = :atual
         WHERE id_acervo = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataatual);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    function totalAcervo(){
        $sql = "SELECT count(*) as total FROM tbl_acervo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
