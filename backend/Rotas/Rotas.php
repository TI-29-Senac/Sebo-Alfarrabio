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

                // Categorias de Livros
                "/catlivros" => "CatLivrosController@index",
                "/catlivros/listar/{pagina}" => "CatLivrosController@viewListarCatLivros",
                "/catlivros/criar" => "CatLivrosController@viewCriarCatLivros",
                "/catlivros/editar/{id}" => "CatLivrosController@viewEditarCatLivros",
                "/catlivros/excluir/{id}" => "CatLivrosController@viewExcluirCatLivros",
                "/catlivros/{id}/relatorio/{dataInicial}/{dataFinal}" => "CatLivrosController@viewRelatorioCatLivros",

                "/catmusica" => "CatMusicaController@index",
                "/catmusica/listar/{pagina}" => "CatMusicaController@viewListarCatMusica",
                "/catmusica/criar" => "CatMusicaController@viewCriarCatMusica",
                "/catmusica/editar/{id}" => "CatMusicaController@viewEditarCatMusica",
                "/catmusica/excluir/{id}" => "CatMusicaController@viewExcluirCatMusica",
                "/catmusica/{id}/relatorio/{dataInicial}/{dataFinal}" => "CatMusicaController@viewRelatorioCatMusica",

                '/register' => 'AuthController@register',
                '/login' => 'AuthController@login',
                '/logout' => 'AuthController@logout',
                '/admin/dashboard' => 'Adimin\DashboardController@index',

                "/itensvenda" => "ItensVendasController@index",
                "/itensvenda/listar/{pagina}" => "ItensVendasController@viewListarItensVendas",
                "/itensvenda/criar" => "ItensVendasController@salvarItenVenda",
                "/itensvenda/editar/{id}" => "ItensVendasController@viewEditarItensVendas",
                "/itensvenda/excluir/{id}" => "ItensVendasController@viewExcluirItensVendas",

            
            ],
             
                "POST" =>[
                    "/usuarios/salvar" => "UsuarioController@salvarUsuario",
                    "/usuarios/atualizar/{id}" => "UsuarioController@atualizarUsuario",
                    "/usuarios/deletar/{id}" => "UsuarioController@deletarUsuario",

                    "/acervo/salvar" => "AcervoController@salvarAcervo",
                    "/acervo/atualizar/{id}" => "AcervoController@atualizarAcervo",
                    "/acervo/deletar/{id}" => "AcervoController@deletarAcervo",

                    "/catlivros/salvar" => "CatLivrosController@salvarCatLivros",
                    "/catlivros/atualizar/{id}" => "CatLivrosController@atualizarCatLivros",
                    "/catlivros/deletar/{id}" => "CatLivrosController@deletarCatLivros",

                    
                    "/catmusica/salvar" => "CatMusicaController@salvarCatMusica",
                    "/catmusica/atualizar/{id}" => "CatMusicaController@atualizarCatMusica",
                    "/catmusica/deletar/{id}" => "CatMusicaController@deletarCatMusica",
                   
                    '/register' => 'AuthController@cadastrarUsuario',
                    '/login' => 'AuthController@authenticar',
  

                    "/itensvenda/salvar" => "ItensVendasController@salvarItenVenda",
                    "/itensvenda/atualizar/{id}" => "ItensVendasController@atualizarItensVendas",
                    "/itensvenda/deletar/{id}" => "ItensVendasController@excluirItensVendas",
                    ]
            
        ];
    }
}