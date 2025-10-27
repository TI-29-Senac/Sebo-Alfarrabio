<?php
namespace Sebo\Alfarrabio\Validadores;

class CategoriaValidadorValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['nome_categoria']) && empty($dados['nome_categoria'])){
            $erros[] = "O campo da categoria é obrigatório.";
        }
        if(isset($dados['descricao_categoria']) && empty($dados['descricao_categoria'])){
            $erros[] = "O campo de descrição é obrigatório.";
        }
        
        return $erros;
    }
}
