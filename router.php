<?php
/**
 * Router script para o servidor embutido do PHP (php -S)
 * Permite que URLs de SEO (/livro-...) e o /sitemap.xml funcionem localmente.
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $uri;

// 1. Se for um arquivo físico (CSS, JS, Imagens, HTML), serve diretamente
if ($uri !== '/' && file_exists($file) && !is_dir($file)) {
    return false;
}

// 2. Rotas Especiais: Redireciona para o backend mantendo a URI original
if ($uri === '/sitemap.xml' || preg_match('/^\/livro-/', $uri)) {
    $_SERVER['SCRIPT_NAME'] = '/backend/index.php';
    require_once __DIR__ . '/backend/index.php';
    return;
}

// 3. Fallback para o index principal (para SPAs ou se necessário)
// Por padrão, se for '/', o PHP serve o index.html se existir.
return false;
