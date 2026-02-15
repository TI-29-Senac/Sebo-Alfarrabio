<?php
namespace Sebo\Alfarrabio\Validadores;

class AutorValidador
{
    /**
     * Valida dados de entrada para Autor.
     * @param array $dados
     * @return array Lista de erros
     */
    public static function ValidarEntradas($dados)
    {
        $erros = [];
        if (isset($dados['nome_autor']) && empty($dados['nome_autor'])) {
            $erros[] = "O campo do autor é obrigatório.";
        }
        return $erros;
    }
}