<?php
namespace Sebo\Alfarrabio\Validadores;

class GeneroValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['nome_genero']) && empty($dados['nome_genero'])){
            $erros[] = "O campo genero é obrigatório.";
        }
        if(isset($dados['descricao_genero']) && empty($dados['descricao_genero'])){
            $erros[] = "O campo de descrição é obrigatório.";
        }
        
        return $erros;
    }
}