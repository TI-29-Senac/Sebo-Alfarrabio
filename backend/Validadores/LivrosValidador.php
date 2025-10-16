<?php
namespace Sebo\Alfarrabio\Validadores;

class AcervoValidador {
    public static function ValidarEntradas($dados) {
        $erros = [];

        if (isset($dados['titulo_acervo']) && empty($dados['titulo_acervo'])) {
            $erros[] = "O campo título do acervo é obrigatório.";
        }

        if (isset($dados['tipo_item_acervo']) && empty($dados['tipo_item_acervo'])) {
            $erros[] = "O campo tipo do item é obrigatório.";
        }

        if (isset($dados['estado_conservacao']) && empty($dados['estado_conservacao'])) {
            $erros[] = "O campo estado de conservação é obrigatório.";
        }

        if (isset($dados['disponibilidade_acervo']) && empty($dados['disponibilidade_acervo'])) {
            $erros[] = "O campo disponibilidade é obrigatório.";
        }

        if (isset($dados['estoque_acervo'])) {
            if ($dados['estoque_acervo'] === '' || !is_numeric($dados['estoque_acervo'])) {
                $erros[] = "O campo estoque deve conter um número válido.";
            } elseif ($dados['estoque_acervo'] < 0) {
                $erros[] = "O estoque não pode ser negativo.";
            }
        }

        return $erros;
    }
}