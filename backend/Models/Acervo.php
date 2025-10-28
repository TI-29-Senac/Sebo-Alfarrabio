<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Acervo{
    private $id_acervo;
    private $titulo_acervo;
    private $data_publicacao;
    private $detalhes_adicionais;
    private $preco_acervo;
    private $estado_conservacao;
    private $disponibilidade_acervo;
    private $estoque_acervo;
    private $foto_acervo;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    // contrutor inicializa a classe e ou atributos
    public function __construct($db){
       $this->db = $db;
    }

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
    function inseriAcervo($titulo, $tipo, $estado, $disponibilidade, $estoque, $data_publicacao, $detalhes_adicionais, $preco, $foto){
        $sql = "INSERT INTO tbl_acervo (titulo_acervo, estado_conservacao, 
        disponibilidade_acervo, estoque_acervo, data_publicacao, preco_acervo, detalhes_adicionais, foto_acervo) ) 
                VALUES (:titulo, :tipo, :estoque, :disponibilidade, :estado, :publicacao, :detaheis, :preco, :foto)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':disponibilidade', $disponibilidade);
        $stmt->bindParam(':estoque', $estoque);
        $stmt->bindParam(':publicacao', $data_publicacao);
        $stmt->bindParam(':detalhes', $detalhes_adicionais);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':foto', $foto);
        
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }else{
            return false;
        }
    }

    // metodo de atualizar o usuario update
    function atualizarAcervo($id, $titulo, $estado, $disponibilidade, $estoque, $data_publicacao, $detalhes_adicionais, $preco){
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_acervo SET titulo_acervo = :nome,

         estado_conservacao = :estado, 
         disponibilidade_acervo = :disponibilidade,
         estoque_acervo = :estoque,
         atualizado_em = :atual
         WHERE id_acervo = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $titulo);
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
function excluirAcervo($id){
    $dataatual = date('Y-m-d H:i:s');
    $sql = "UPDATE tbl_acervo 
            SET excluido_em = :atual 
            WHERE id_acervo = :id AND excluido_em IS NULL"; // evita duplo delete
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':atual', $dataatual);
    return $stmt->execute();
}

function ativarAcervo($id){
    $sql = "UPDATE tbl_acervo 
            SET excluido_em = NULL 
            WHERE id_acervo = :id AND excluido_em IS NOT NULL"; // só reativa se estiver inativo
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
    function totalAcervo(){
        $sql = "SELECT count(*) as total FROM tbl_acervo";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
