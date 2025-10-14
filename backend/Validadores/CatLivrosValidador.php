<?php
namespace Sebo\Alfarrabio\Validadores;

class CategoriaValidador
{
    public static function ValidarEntradas(array $dados): array
    {
        $erros = [];

        // 🧠 Valida se o campo está presente e não vazio
        if (!isset($dados['nome_categoria']) || trim($dados['nome_categoria']) === '') {
            $erros[] = "O campo <b>nome da categoria</b> é obrigatório.";
        }


        // 🔍 (opcional) valida caracteres especiais
        if (isset($dados['nome_categoria']) && !preg_match('/^[\p{L}\s0-9]+$/u', $dados['nome_categoria'])) {
            $erros[] = "O nome da categoria contém caracteres inválidos.";
        }

        return $erros;
    }
}
