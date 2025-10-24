<?php
namespace Sebo\Alfarrabio\Validadores;

class AvaliacaoValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['nota_avaliacao']) && empty($dados['nota_avaliacao'])){
            $erros[] = "O campo telefone é obrigatório.";
        }
        if(isset($dados['comentario_avaliacao']) && empty($dados['comentario_avaliacao'])){
            $erros[] = "O campo endereço é obrigatório.";
        }
        if(isset($dados['data_avaliacao']) && empty($dados['data_avaliacao'])){
            $erros[] = "O campo foto é obrigatório.";
        }
        if(isset($dados['status_avaliacao']) && empty($dados['status_avaliacao'])){
            $erros[] = "O campo foto é obrigatório.";
        }
        
        return $erros;
    }
}