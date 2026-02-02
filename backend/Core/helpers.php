<?php

if (!function_exists('base_path')) {
    function base_path($path = '')
    {
        // Go up from backend/Core to root
        return __DIR__ . '/../../' . ($path ? ltrim($path, '/') : '');
    }
}

if (!function_exists('public_path')) {
    function public_path($path = '')
    {
        return base_path($path);
    }
}

if (!function_exists('storage_path')) {
    function storage_path($path = '')
    {
        return base_path('backend/uploads/' . ($path ? ltrim($path, '/') : ''));
    }
}

if (!function_exists('view')) {
    function view($name, $data = [])
    {
        \Sebo\Alfarrabio\Core\View::render($name, $data);
    }
}

if (!function_exists('url')) {
    function url($path = '')
    {
        $baseUrl = getenv('APP_URL') ?: 'http://localhost/sebo-alfarrabio';
        $baseUrl = rtrim($baseUrl, '/');
        return $baseUrl . '/' . ltrim($path, '/');
    }
}

if (!function_exists('base_url')) {
    function base_url($path = '')
    {
        $appUrl = getenv('APP_URL') ?: 'http://localhost/sebo-alfarrabio';
        $parsedUrl = parse_url($appUrl);
        $basePath = $parsedUrl['path'] ?? '';
        return rtrim($basePath, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
        die();
    }
}
