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
                "/usuarios/listar/{pagina}" => "UsuarioController@viewListarUsuarios",
                "/usuarios/editar/{id}" => "UsuarioController@viewEditarUsuarios",
                "/usuarios/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
                "/usuarios/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuario",

                // Acervo
                "/acervo" => "AcervoController@index",
                "/acervo/listar/{pagina}" => "AcervoController@viewListarAcervo",
                "/acervo/criar" => "AcervoController@viewCriarAcervo",
                "/acervo/editar/{id}" => "AcervoController@viewEditarAcervo",
                "/acervo/excluir/{id}" => "AcervoController@viewExcluirAcervo",
                "/acervo/{id}/relatorio/{dataInicial}/{dataFinal}" => "AcervoController@viewRelatorioAcervo",
            ],
             
                "POST" =>[
                    "/usuarios/salvar" => "UsuarioController@salvarUsuario",
                    "/usuarios/atualizar/{id}" => "UsuarioController@atualizarUsuario",
                    "/usuarios/deletar/{id}" => "UsuarioController@deletarUsuario",

                    "/acervo/salvar" => "AcervoController@salvarAcervo",
                    "/acervo/atualizar/{id}" => "AcervoController@atualizarAcervo",
                    "/acervo/deletar/{id}" => "AcervoController@deletarAcervo",

                ]
            
        ];
    }
}