<?php
/**
 * Router script to support clean URLs with php -S
 * Usage: php -S localhost:2000 backend/router.php
 */

$uri = decode_uri($_SERVER['REQUEST_URI']);
$file = __DIR__ . '/..' . $uri;

// Se o arquivo ou diretório físico existe (e não é o index.php), serve-o diretamente
if ($uri !== '/' && file_exists($file) && !is_dir($file)) {
    return false; // deixa o PHP servir o arquivo estático
}

// Caso contrário, manda tudo para o index.php do backend
require_once __DIR__ . '/index.php';

function decode_uri($uri) {
    return parse_url($uri, PHP_URL_PATH);
}
