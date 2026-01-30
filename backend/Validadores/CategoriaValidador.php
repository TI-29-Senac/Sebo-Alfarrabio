<?php
namespace Sebo\Alfarrabio\Validadores;

class CategoriaValidador
{
    public static function ValidarEntradas($dados)
    {
        $erros = [];
        if (isset($dados['nome_categoria']) && empty($dados['nome_categoria'])) {
            $erros[] = "O campo da categoria é obrigatório.";
        }

        return $erros;
    }
}
