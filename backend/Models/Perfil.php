<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
class Perfil
{
    private $id_perfil_usuario;
    private $id_usuario;
    private $telefone_usuario;
    private $endereco_usuario;
    private $foto_usuario;
    private $criado_em;
    private $atualizado_em;
    private $excluido_em;
    private $db;
    /**
     * Construtor da classe Perfil.
     * @param PDO $db Conexão com o banco.
     */
    public function __construct($db)
    {
        $this->db = $db;
    }
    /**
     * Busca todos os perfis de usuário.
     */
    function buscarPerfil()
    {
        $sql = "SELECT * FROM tbl_perfil_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Contagem total de perfis.
     */
    function totalDePerfil()
    {
        $sql = "SELECT count(*) as total FROM tbl_perfil_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Contagem de perfis inativos.
     */
    function totalDePerfilInativos()
    {
        $sql = "SELECT count(*) as total_inativos FROM tbl_perfil_usuario where excluido_em is NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Contagem de perfis ativos.
     */
    function totalDePerfilAtivos()
    {
        $sql = "SELECT count(*) as total_ativos FROM tbl_perfil_usuario where excluido_em is NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


    /**
     * Busca perfil por telefone.
     */
    function buscarPerfilPorTelefone($telefone_usuario)
    {
        $sql = "SELECT * FROM tbl_perfil_usuario where telefone_usuario = :telefone";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':telefone', $telefone_usuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarPerfilPorEndereco($endereco_usuario)
    {
        $sql = "SELECT * FROM tbl_perfil_usuario where endereco_usuario = :endereco";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':endereco', $endereco_usuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca perfil por ID do perfil.
     */
    function buscarPerfilPorID($id_perfil_usuario)
    {
        $sql = "SELECT * FROM tbl_perfil_usuario where id_perfil_usuario = :id_perfil_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_perfil_usuario', $id_perfil_usuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca perfil pelo ID do usuário associado.
     */
    function buscarPerfilPorIDUsuario($id_usuario)
    {
        $sql = "SELECT * FROM tbl_perfil_usuario where usuario_id = :id_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cria um novo perfil de usuário.
     */
    function inserirPerfil($usuario_id, $telefone, $endereco, $foto)
    {
        $sql = "INSERT INTO tbl_perfil_usuario (usuario_id, telefone, endereco, 
        foto_perfil_usuario) 
                VALUES (:uid, :telefone, :endereco, :foto)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':uid', $usuario_id);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':foto', $foto);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * Atualiza um perfil existente.
     */
    function atualizarPerfil($id_perfil_usuario, $telefone, $endereco, $foto)
    {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_perfil_usuario SET 
        telefone = :telefone,
        endereco = :endereco, 
        foto_perfil_usuario = :foto,
        atualizado_em = :atual
        WHERE id_perfil_usuario = :id_perfil_usuario";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_perfil_usuario', $id_perfil_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':atual', $dataatual);

        return $stmt->execute();
    }
    // metodo de inativar o usuario delete
    /**
     * Inativa (soft delete) um perfil.
     */
    function excluirPerfil($id_perfil_usuario)
    {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_perfil_usuario SET
         excluido_em = :atual
         WHERE id_perfil_usuario = :id_perfil_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_perfil_usuario', $id_perfil_usuario);
        $stmt->bindParam(':atual', $dataatual);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // metodo de ativar o usuario excluido
    /**
     * Reativa um perfil inativado.
     */
    function ativarVendas($id_perfil_usuario)
    {
        $dataatual = NULL;
        $sql = "UPDATE tbl_perfil_usuario SET
         excluido_em = :atual
         WHERE id_perfil_usuario = :id_perfil_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_perfil_usuario', $id_perfil_usuario);
        $stmt->bindParam(':atual', $dataatual);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}