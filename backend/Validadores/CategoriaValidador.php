<?php
namespace Sebo\Alfarrabio\Validadores;

class CategoriaValidador {
    /**
     * Valida entradas do formulário de categoria.
     * Retorna um array de mensagens de erro (vazio se válido).
     *
     * @param array $dados
     * @return array
     */
    public static function ValidarEntradas(array $dados): array {
        $erros = [];

        // nome_categoria é obrigatório
        if(!isset($dados['nome_categoria']) || trim($dados['nome_categoria']) === ''){
            $erros[] = "O campo da categoria é obrigatório.";
        }

        // descricao_categoria é opcional, mas se estiver presente deve ter conteúdo
        if(isset($dados['descricao_categoria']) && trim($dados['descricao_categoria']) === ''){
            $erros[] = "O campo de descrição é obrigatório.";
        }

        return $erros;
    }
}
