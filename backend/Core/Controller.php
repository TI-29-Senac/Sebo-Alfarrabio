<?php

namespace Sebo\Alfarrabio\Core;

class Controller
{
    protected function view($view, $data = [])
    {
        // Extrai variáveis
        extract($data);

        // Caminho da view
        $viewPath = __DIR__ . "/../../Views/{$view}.php";

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            die("View não encontrada: {$view}");
        }
    }
}