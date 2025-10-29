<?php
namespace Sebo\Alfarrabio\Validadores;

class AutorValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['nome_autor']) && empty($dados['nome_autor'])){
            $erros[] = "O campo do autor é obrigatório.";
        }
        if(isset($dados['biografia_autor']) && empty($dados['biografia_autor'])){
            $erros[] = "A biografia do autor é obrigatória.";
        }
        
        return $erros;
    }
}