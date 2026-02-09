<?php
/**
 * API Direta de Avaliações (Bypass Router)
 * Útil quando o servidor não suporta rewrite ou rotas complexas falham.
 */

// Headers CORS e JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// OPTIONS request (pre-flight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    // Tenta carregar autoload ou classes manualmente
    $vendorPath = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($vendorPath)) {
        require_once $vendorPath;
    } else {
        // Fallback manual se vendor não existir
        require_once __DIR__ . '/Database/Config.php';
        require_once __DIR__ . '/Database/Database.php';
    }

    // Carrega helpers se necessário (para Env)
    if (file_exists(__DIR__ . '/Core/Env.php')) {
        require_once __DIR__ . '/Core/helpers.php'; // Se existir
        require_once __DIR__ . '/Core/Env.php';
        if (class_exists('Sebo\Alfarrabio\Core\Env')) {
            \Sebo\Alfarrabio\Core\Env::carregar(__DIR__);
        }
    }

    // Instancia banco
    $db = \Sebo\Alfarrabio\Database\Database::getInstance();

    // Parâmetros
    $limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 10;
    $nota_minima = isset($_GET['nota_minima']) ? (int) $_GET['nota_minima'] : null;

    // Query (mesma do PublicApiController corrigido)
    // Contagem para debug
    $countStmt = $db->query("SELECT COUNT(*) as total FROM tbl_avaliacao WHERE excluido_em IS NULL");
    $totalNoBanco = (int) ($countStmt->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0);

    $sql = "SELECT 
                a.id_avaliacao,
                a.nota_avaliacao,
                a.comentario_avaliacao,
                a.data_avaliacao,
                a.status_avaliacao,
                a.criado_em,
                
                -- Dados do usuário
                u.id_usuario,
                u.nome_usuario,
                u.email_usuario,
                pu.foto_perfil_usuario AS foto_usuario,
                
                -- Dados do item
                i.id_item,
                i.titulo_item,
                i.descricao AS descricao_item,
                i.preco_item,
                i.foto_item AS imagem_item,
                
                -- Dados opcionais
                c.nome_categoria,
                g.nome_generos AS nome_genero,
                aut.nome_autor
                
            FROM tbl_avaliacao a
            
            LEFT JOIN tbl_usuario u 
                ON a.id_usuario = u.id_usuario
            
            LEFT JOIN tbl_perfil_usuario pu 
                ON u.id_usuario = pu.usuario_id
            
            LEFT JOIN tbl_itens i 
                ON a.id_item = i.id_item
            
            LEFT JOIN tbl_categorias c 
                ON i.id_categoria = c.id_categoria
            
            LEFT JOIN tbl_generos g 
                ON i.id_genero = g.id_generos
            
            LEFT JOIN tbl_autores aut 
                ON aut.id_autor = (SELECT ia.autor_id FROM tbl_item_autores ia WHERE ia.item_id = i.id_item LIMIT 1) 
            
            WHERE a.excluido_em IS NULL";

    if ($nota_minima !== null) {
        $sql .= " AND a.nota_avaliacao >= :nota_minima";
    }

    $sql .= " ORDER BY a.data_avaliacao DESC, a.criado_em DESC LIMIT :limite";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':limite', $limite, \PDO::PARAM_INT);
    if ($nota_minima !== null) {
        $stmt->bindValue(':nota_minima', $nota_minima, \PDO::PARAM_INT);
    }
    $stmt->execute();
    $avaliacoes = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    // Processamento
    $total = count($avaliacoes);
    $soma_notas = 0;
    $distribuicao = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

    foreach ($avaliacoes as $av) {
        $soma_notas += (int) $av['nota_avaliacao'];
        $nota = (int) $av['nota_avaliacao'];
        if (isset($distribuicao[$nota])) {
            $distribuicao[$nota]++;
        }
    }

    $media_notas = $total > 0 ? round($soma_notas / $total, 2) : 0;

    // Helper para tempo
    $calcularTempo = function ($data) {
        $agora = new DateTime();
        $data_av = new DateTime($data);
        $diff = $agora->diff($data_av);
        if ($diff->y > 0)
            return $diff->y . ' ano' . ($diff->y > 1 ? 's' : '') . ' atrás';
        if ($diff->m > 0)
            return $diff->m . ' mês' . ($diff->m > 1 ? 'es' : '') . ' atrás';
        if ($diff->d > 0)
            return $diff->d . ' dia' . ($diff->d > 1 ? 's' : '') . ' atrás';
        if ($diff->h > 0)
            return $diff->h . ' hora' . ($diff->h > 1 ? 's' : '') . ' atrás';
        return 'Recentemente';
    };

    // Helper imagem (simplificado)
    $corrigirImagem = function ($img, $tipo) {
        if (empty($img))
            return $tipo == 'user' ? '/img/usuarios/default.png' : '/img/livros/default.png';
        if (preg_match('/^(http|\/)/', $img))
            return $img;
        return '/backend/uploads/' . $img;
    };

    $avaliacoes_formatadas = array_map(function ($av) use ($calcularTempo, $corrigirImagem) {
        return [
            'id' => (int) $av['id_avaliacao'],
            'nota' => (int) $av['nota_avaliacao'],
            'comentario' => $av['comentario_avaliacao'],
            'data' => date('d/m/Y', strtotime($av['data_avaliacao'])),
            'usuario' => [
                'id' => (int) $av['id_usuario'],
                'nome' => $av['nome_usuario'],
                'foto' => $corrigirImagem($av['foto_usuario'] ?? '', 'user'),
                'iniciais' => strtoupper(substr($av['nome_usuario'] ?? 'Anonimo', 0, 2))
            ],
            'item' => [
                'id' => (int) $av['id_item'],
                'titulo' => $av['titulo_item'],
                'imagem' => $corrigirImagem($av['imagem_item'] ?? '', 'item'),
                'autor' => $av['nome_autor'] ?? ''
            ],
            'tempo_decorrido' => $calcularTempo($av['criado_em'])
        ];
    }, $avaliacoes);

    echo json_encode([
        'success' => true,
        'total' => $total,
        'total_no_banco' => $totalNoBanco,
        'media_notas' => $media_notas,
        'distribuicao' => $distribuicao,
        'avaliacoes' => $avaliacoes_formatadas
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], JSON_UNESCAPED_UNICODE);
}
