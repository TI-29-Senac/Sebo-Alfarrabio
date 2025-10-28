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
                "/api/acervo" => "PublicApiController@getAcervo",
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

                "/itens" => "ItensVendasController@index",
                "/itens/listar/{pagina}" => "ItensVendasController@viewListarItensVendas",
                "/itens/criar" => "ItensVendasController@salvarItenVendas",
                "/itens/editar/{id}" => "ItensVendasController@viewEditarItensVendas",
                "/itens/excluir/{id}" => "ItensVendasController@viewExcluirItensVendas",

                
                "/contato" => "ContatoController@index",
                "/contato/listar/{pagina}" => "ContatoController@viewListarContatos",
                "/contato/criar" => "ContatoController@viewCriarContato",
                "/contato/editar/{id}" => "ContatoController@viewEditarContato",
                "/contato/excluir/{id}" => "ContatoController@viewExcluirContato",

                //vendas
                "/vendas" => "vendasConstroller@index",
                "/vendas/criar" => "vendasController@viewCriarVendas",
                "/vendas/listar/{pagina}" => "vendasController@viewListarVendas",
                "/vendas/editar/{id}" => "vendasController@viewEditarVendas",
                "/vendas/excluir/{id}" => "vendasController@viewExcluirVendas",
                "/vendas/{id}/relatorio/{dataInicial}/{dataFinal}" => "vendasController@relatorioVendas",
                "/backend/vendas/grafico → VendasController@getVendasDiariasJson",


            ],
             
                "POST" =>[
                    "/usuario/salvar" => "UsuarioController@salvarUsuario",
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
  

                    "/itens/salvar" => "ItensVendasController@viewSalvarItensVendas",
                    "/itens/atualizar/{id}" => "ItensVendasController@atualizarItensVendas",
                    "/itens/deletar/{id}" => "ItensVendasController@excluirItensVendas",

                    "/contato/salvar" => "ContatoController@salvarContato",
                    "/contato/excluir/{id}" => "ContatoController@ExcluirContato",
                    "/contato/atualizar/{id}" => "ContatoController@atualizarContato",

                     //vendas post
                    "/vendas/salvar" => "vendasController@viewsalvarVendas",
                    "/vendas/atualizar/{id}" => "vendasController@viewatualizarVendas",
                    "/vendas/deletar/{id}" => "vendasController@viewdeletarVendas",

                    ]
            
        ];
    }
}