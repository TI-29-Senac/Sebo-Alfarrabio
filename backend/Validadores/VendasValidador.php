<?php
namespace Sebo\Alfarrabio\Validadores;

class VendasValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['data_venda']) && empty($dados['data_venda'])){
            $erros[] = "O campo data é obrigatório.";
        }
        if(isset($dados['valor_total']) && empty($dados['valor_total'])){
            $erros[] = "O campo valor total é obrigatório.";
        }
        if(isset($dados['forma_pagamento']) && empty($dados['forma_pagamento'])){
            $erros[] = "O campo forma de pagamento é obrigatório.";
        }
        return $erros;
    }
}