<?php
namespace Sebo\Alfarrabio\Models;
use PDO;
use PDOException;

class Usuario {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // ===== LEITURA (READ) =====
    
    function buscarUsuarios() {
        $sql = "SELECT * FROM tbl_usuario WHERE excluido_em IS NULL ORDER BY id_usuario DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function totalDeUsuarios() {
        $sql = "SELECT COUNT(*) FROM tbl_usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    function totalDeUsuariosInativos() {
        $sql = "SELECT COUNT(*) FROM tbl_usuario WHERE excluido_em IS NOT NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function totalDeUsuariosAtivos() {
        $sql = "SELECT COUNT(*) FROM tbl_usuario WHERE excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function buscarUsuariosPorEMail($email) {
        $sql = "SELECT * FROM tbl_usuario WHERE email_usuario = :email AND excluido_em IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function buscarUsuariosPorID($id) {
        $sql = "SELECT * FROM tbl_usuario WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function paginacao(int $pagina = 1, int $por_pagina = 10): array {
        $totalQuery = "SELECT COUNT(*) FROM tbl_usuario WHERE excluido_em IS NULL";
        $totalStmt = $this->db->query($totalQuery);
        $total_de_registros = $totalStmt->fetchColumn();
        
        $offset = ($pagina - 1) * $por_pagina;
        
        $dataQuery = "SELECT * FROM tbl_usuario 
                      WHERE excluido_em IS NULL 
                      ORDER BY id_usuario DESC 
                      LIMIT :limit OFFSET :offset";
        
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

    // ===== CRIAÇÃO (CREATE) =====
    
    function inserirUsuario($nome, $email, $senha, $tipo) {
        // Validar tipo (deve ser Cliente, Funcionario ou Admin)
        $tiposValidos = ['Cliente', 'Funcionario', 'Admin'];
        if (!in_array($tipo, $tiposValidos)) {
            error_log("ERRO: Tipo '{$tipo}' inválido. Deve ser: " . implode(', ', $tiposValidos));
            return false;
        }

        // Hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        // SQL minimalista: deixa criado_em e atualizado_em automáticos
        $sql = "INSERT INTO tbl_usuario (nome_usuario, email_usuario, senha_usuario, tipo_usuario) 
                VALUES (:nome, :email, :senha, :tipo)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':tipo', $tipo);
        
        try {
            error_log("=== INSERINDO USUÁRIO ===");
            error_log("Nome: {$nome}, Email: {$email}, Tipo: {$tipo}");
            
            if ($stmt->execute()) {
                $id = $this->db->lastInsertId();
                error_log("✅ Usuário criado com ID: {$id}");
                return $id;
            } else {
                error_log("❌ Execute retornou FALSE");
                return false;
            }
        } catch (PDOException $e) {
            error_log("❌ ERRO PDO ao inserir: " . $e->getMessage());
            error_log("SQL State: " . $e->getCode());
            return false;
        }
    }

    // ===== ATUALIZAÇÃO (UPDATE) =====
    
    function atualizarUsuario($id, $nome, $email, $senha = null, $tipo) {
        // Validar tipo
        $tiposValidos = ['Cliente', 'Funcionario', 'Admin'];
        if (!in_array($tipo, $tiposValidos)) {
            error_log("ERRO: Tipo '{$tipo}' inválido");
            return false;
        }

        // Se tiver senha, incluir no UPDATE
        if (!empty($senha)) {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "UPDATE tbl_usuario SET 
                    nome_usuario = :nome, 
                    email_usuario = :email, 
                    senha_usuario = :senha, 
                    tipo_usuario = :tipo 
                    WHERE id_usuario = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':senha', $senha_hash);
        } else {
            // Sem senha: não atualizar
            $sql = "UPDATE tbl_usuario SET 
                    nome_usuario = :nome, 
                    email_usuario = :email, 
                    tipo_usuario = :tipo 
                    WHERE id_usuario = :id";
            
            $stmt = $this->db->prepare($sql);
        }
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':tipo', $tipo);
        
        try {
            error_log("=== ATUALIZANDO USUÁRIO #{$id} ===");
            error_log("Nome: {$nome}, Email: {$email}, Tipo: {$tipo}, Senha: " . ($senha ? "SIM" : "NÃO"));
            
            if ($stmt->execute()) {
                $linhas = $stmt->rowCount();
                error_log("✅ Linhas afetadas: {$linhas}");
                return true;
            } else {
                error_log("❌ Execute retornou FALSE");
                return false;
            }
        } catch (PDOException $e) {
            error_log("❌ ERRO PDO ao atualizar: " . $e->getMessage());
            return false;
        }
    }

    // ===== EXCLUSÃO SOFT DELETE =====
    
    function excluirUsuario($id) {
        $dataatual = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_usuario SET excluido_em = :atual WHERE id_usuario = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':atual', $dataatual);
        
        try {
            error_log("=== DESATIVANDO USUÁRIO #{$id} ===");
            
            if ($stmt->execute()) {
                $linhas = $stmt->rowCount();
                error_log("✅ Usuário desativado. Linhas: {$linhas}");
                return true;
            } else {
                error_log("❌ Falha ao desativar");
                return false;
            }
        } catch (PDOException $e) {
            error_log("❌ ERRO PDO ao excluir: " . $e->getMessage());
            return false;
        }
    }

    function ativarUsuario($id) {
        $sql = "UPDATE tbl_usuario SET excluido_em = NULL WHERE id_usuario = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        try {
            error_log("=== REATIVANDO USUÁRIO #{$id} ===");
            
            if ($stmt->execute()) {
                error_log("✅ Usuário reativado");
                return true;
            } else {
                error_log("❌ Falha ao reativar");
                return false;
            }
        } catch (PDOException $e) {
            error_log("❌ ERRO PDO ao ativar: " . $e->getMessage());
            return false;
        }
    }

    // ===== AUTENTICAÇÃO =====

    public function checarCredenciais(string $email, string $senha) {
        $usuarios = $this->buscarUsuariosPorEMail($email);
        
        if (count($usuarios) !== 1) {
            error_log("Usuário não encontrado ou duplicado: {$email}");
            return false;
        }
        
        $usuario = $usuarios[0];
        
        if (password_verify($senha, $usuario['senha_usuario'])) {
            error_log("Login bem-sucedido: {$email}");
            return $usuario;
        }
        
        error_log("Senha incorreta para: {$email}");
        return false;
    }
}