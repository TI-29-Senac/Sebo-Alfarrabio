<?php
namespace Sebo\Alfarrabio\Validadores;

class AutorValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['nome_autor']) && empty($dados['tipo_genero'])){
            $erros[] = "O campo do autor é obrigatório.";
        }
        if(isset($dados['biografia_autor']) && empty($dados['descricao_autor'])){
            $erros[] = "A biografia do autor é obrigatória.";
        }
        
        return $erros;
    }
}