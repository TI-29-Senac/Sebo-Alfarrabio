<?php
namespace Sebo\Alfarrabio\Validadores;

class AutorValidador
{
    public static function ValidarEntradas($dados)
    {
        $erros = [];
        if (isset($dados['nome_autor']) && empty($dados['nome_autor'])) {
            $erros[] = "O campo do autor é obrigatório.";
        }
        return $erros;
    }
}