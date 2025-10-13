<?php
namespace Sebo\Alfarrabio\Validadores;

class UsuarioValidador{
    public static function ValidarEntradas($dados){
        $erros = [];
        if(isset($dados['nome_usuario']) && empty($dados['nome_usuario'])){
            $erros[] = "O campo nome é obrigatório.";
        }
        if(isset($dados['email_usuario']) && empty($dados['email_usuario'])){
            $erros[] = "O campo email é obrigatório.";
        }else if(!filter_var($dados['email_usuario'], FILTER_VALIDATE_EMAIL)){
            $erros[] = "O campo email deve ser um email válido.";
        }
        if(isset($dados['senha_usuario']) && empty($dados['senha_usuario'])){
            $erros[] = "O campo senha é obrigatório.";
        }else if(strlen($dados['senha_usuario']) < 6){
            $erros[] = "O campo senha deve ter no mínimo 6 caracteres.";
        }
        return $erros;
    }
}