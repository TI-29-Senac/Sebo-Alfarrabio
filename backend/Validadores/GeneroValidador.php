<?php
namespace Sebo\Alfarrabio\Validadores;

class GeneroValidador
{
    /**
     * Valida dados de entrada para Gênero.
     */
    public static function ValidarEntradas($dados)
    {
        $erros = [];
        if (isset($dados['nome_genero']) && empty($dados['nome_genero'])) {
            $erros[] = "O campo genero é obrigatório.";
        }
        return $erros;
    }
}