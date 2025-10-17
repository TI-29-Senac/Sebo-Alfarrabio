<?php
namespace Sebo\Alfarrabio\Rotas;

 
class Rotas
{
    public static function get()
    {
        return [
            "GET" => [
                // Livros
                "/livros" => "LivrosController@index",
                "/livros/criar" => "UsuarioController@viewCriarLivros",
                "/livros/listar" => "LivrosController@viewListarLivros",
                "/livros/editar/{id}" => "UsuarioController@viewEditarlivros",
                "/livros/excluir/{id}" => "UsuarioController@viewExcluirLivros",
                "/livros/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuario",

                // DVDs
                "/dvds" => "dvdsController@index",
                "/dvds/listar/{pagina}" => "DVDsController@viewListarDVDs",
                "/dvds/criar" => "DVDsController@viewCriardvds",
                "/dvds/editar/{id}" => "dvdsController@viewEditardvds",
                "/dvds/excluir/{id}" => "dvdsController@viewExcluirdvds",
                "/dvds/{id}/relatorio/{dataInicial}/{dataFinal}" => "dvdsController@viewRelatoriodvds",

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

                "/livros"
            
            ],
             
                "POST" =>[
                    "/livros/salvar" => "UsuarioController@salvarUsuario",
                    "/livros/atualizar/{id}" => "UsuarioController@atualizarUsuario",
                    "/livros/deletar/{id}" => "UsuarioController@deletarUsuario",

                    "/dvds/salvar" => "dvdsController@salvardvds",
                    "/dvds/atualizar/{id}" => "dvdsController@atualizardvds",
                    "/dvds/deletar/{id}" => "dvdsController@deletardvds",

                    "/catlivros/salvar" => "CatLivrosController@salvarCatLivros",
                    "/catlivros/atualizar/{id}" => "CatLivrosController@atualizarCatLivros",
                    "/catlivros/deletar/{id}" => "CatLivrosController@deletarCatLivros",

                    
                    "/catmusica/salvar" => "CatMusicaController@salvarCatMusica",
                    "/catmusica/atualizar/{id}" => "CatMusicaController@atualizarCatMusica",
                    "/catmusica/deletar/{id}" => "CatMusicaController@deletarCatMusica",
                   

                ]
            
        ];
    }
}