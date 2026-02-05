<?php
namespace Sebo\Alfarrabio\Validadores;

class PerfilValidador
{
    /**
     * Valida dados de entrada para Perfil de Usuário.
     */
    public static function ValidarEntradas($dados)
    {
        $erros = [];
        if (isset($dados['telefone_usuario']) && empty($dados['telefone_usuario'])) {
            $erros[] = "O campo telefone é obrigatório.";
        }
        if (isset($dados['endereco_usuario']) && empty($dados['endereco_usuario'])) {
            $erros[] = "O campo endereço é obrigatório.";
        }
        if (isset($dados['foto_usuario']) && empty($dados['foto_usuario'])) {
            $erros[] = "O campo foto é obrigatório.";
        }

        return $erros;
    }
}