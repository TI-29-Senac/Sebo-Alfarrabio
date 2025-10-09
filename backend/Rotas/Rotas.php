<?php
namespace Sebo\Alfarrabio\Rotas;

 
class Rotas
{
    public static function get()
    {
        return [
            "GET" => [
                // Usuários
                "/usuarios" => "UsuarioController@index",
                "/usuarios/criar" => "UsuarioController@viewCriarUsuarios",
                "/usuarios/listar" => "UsuarioController@viewListarUsuarios",
                "/usuarios/editar/{id}" => "UsuarioController@viewEditarUsuarios",
                "/usuarios/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
                "/usuarios/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuario",

                // Acervo
                "/acervo" => "AcervoController@index",
                "/acervo/listar" => "AcervoController@viewListarAcervo",
                "/acervo/criar" => "AcervoController@viewCriarAcervo",
                "/acervo/editar/{id}" => "AcervoController@viewEditarAcervo",
                "/acervo/excluir/{id}" => "AcervoController@viewExcluirAcervo",
                "/acervo/{id}/relatorio/{dataInicial}/{dataFinal}" => "AcervoController@viewRelatorioAcervo",
            ],
                "GET" =>[
                    // o caminho da url  o nome do controlle e o metodo do controller
                    "/usuarios" => "UsuarioController@index",
                    "/usuarios/criar" => "UsuarioController@viewCriarUsuarios",
                    "/usuarios/listar" => "UsuarioController@viewListarUsuarios",
                    "/usuarios/editar/{id}" => "UsuarioController@viewEditarUsuarios",
                    "/usuarios/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
                    "/usuarios/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuario",
            
                ],
                "POST" =>[
                    "/usuarios/salvar" => "UsuarioController@salvarUsuario",
                    "/usuarios/atualizar/{id}" => "UsuarioController@atualizarUsuario",
                    "/usuarios/deletar/{id}" => "UsuarioController@deletarUsuario",
                ]
            
        ];
    }
}