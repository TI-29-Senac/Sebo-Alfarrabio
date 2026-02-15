<?php
namespace Sebo\Alfarrabio\Validadores;

class ItemValidador
{
    /**
     * Valida dados de entrada para Item (Livro/CD/DVD).
     */
    public static function ValidarEntradas($dados)
    {
        $erros = [];
        if (empty($dados['titulo_item'])) {
            $erros[] = "O título do item é obrigatório.";
        }
        if (empty($dados['preco_item'])) {
            $erros[] = "O preço do item é obrigatório.";
        }
        if (empty($dados['id_genero'])) {
            $erros[] = "O gênero é obrigatório.";
        }
        if (empty($dados['id_categoria'])) {
            $erros[] = "A categoria é obrigatória.";
        }

        return $erros;
    }
}
