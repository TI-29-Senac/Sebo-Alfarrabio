<?php
 
namespace App\Kipedreiro\Rotas;
 
class Rotas
{
    public static function get()
    {
        return [

                "GET" =>[
                    // o caminho da url  o nome do controlle e o metodo do controller
                    "/backend/usuarios" => "UsuarioController@index",
                    "/backend/usuarios/criar" => "UsuarioController@viewCriarUsuarios",
                    "/backend/usuarios/listar" => "UsuarioController@viewListarUsuarios",
                    "/backend/usuarios/editar" => "UsuarioController@viewEditarUsuarios",
                    "/backend/usuarios/excluir" => "UsuarioController@viewExcluirUsuarios",
            
                ],
                "POST" =>[
                    "/backend/usuarios/salvar" => "UsuarioController@salvarUsuario",
                    "/backend/usuarios/atualizar" => "UsuarioController@atualizarUsuario",
                    "/backend/usuarios/deletar" => "UsuarioController@deletarUsuario",
                ]
            
        ];
    }
}