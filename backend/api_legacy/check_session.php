<?php
// Endpoint para verificar status da sessão via AJAX
// Retorna JSON com dados do usuário logado ou authenticated: false

// Ajuste o path do autoload conforme a estrutura de diretórios
// Se este arquivo está em /backend/api/check_session.php
// O autoload deve estar em /backend/vendor/autoload.php
require_once __DIR__ . '/../../vendor/autoload.php';

use Sebo\Alfarrabio\Core\Session;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Models\Perfil;
use Sebo\Alfarrabio\Models\Usuario;

// Header JSON
header('Content-Type: application/json; charset=utf-8');

try {
    $session = new Session();
    $usuarioId = $session->get('usuario_id');

    if ($usuarioId) {
        $db = Database::getInstance();
        
        // 1. Busca dados básicos (nome, tipo) da sessão ou banco
        $nome = $session->get('usuario_nome');
        $tipo = $session->get('usuario_tipo');
        $email = $session->get('usuario_email');

        // Se não tiver na sessão (por algum motivo), busca no banco
        if (!$nome || !$tipo) {
            $usuarioModel = new Usuario($db);
            $user = $usuarioModel->buscarUsuarioPorID($usuarioId);
            if ($user) {
                $nome = $user['nome_usuario'];
                $tipo = $user['tipo_usuario'];
                $email = $user['email_usuario'];
            }
        }

        // 2. Busca foto de perfil (geralmente em tbl_perfil ou similar)
        // DashboardControllerCliente usa Perfil::buscarPerfilPorIDUsuario
        $perfilModel = new Perfil($db);
        $perfilData = $perfilModel->buscarPerfilPorIDUsuario($usuarioId);
        $foto = '/img/avatar_placeholder.png'; // Default
        
        if ($perfilData && !empty($perfilData[0]['foto_perfil_usuario'])) {
            $foto = $perfilData[0]['foto_perfil_usuario'];
        }

        echo json_encode([
            'authenticated' => true,
            'user' => [
                'id' => $usuarioId,
                'name' => $nome,
                'email' => $email,
                'role' => $tipo, // 'Cliente', 'Admin', etc.
                'avatar' => $foto
            ]
        ]);
    } else {
        echo json_encode([
            'authenticated' => false
        ]);
    }

} catch (Exception $e) {
    // Em caso de erro, retorna não autenticado
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'authenticated' => false,
        'error' => $e->getMessage()
    ]);
}
