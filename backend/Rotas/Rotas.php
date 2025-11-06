<?php

namespace Sebo\Alfarrabio\Rotas;

class Rotas
{
    public static function get()
    {
        return [
            "GET" => [
                // ========================================
                // ROTAS PÚBLICAS
                // ========================================
                
                // Produtos públicos (catálogo)
                '/produtos' => 'Public\PublicItemController@viewProdutos',
                '/produtos/{pagina}' => 'Public\PublicItemController@viewProdutos',
                
                // ========================================
                // AUTENTICAÇÃO
                // ========================================
                
                '/register' => 'AuthController@register',
                '/login' => 'AuthController@login',
                '/logout' => 'AuthController@logout',
                
                // ========================================
                // ÁREA ADMINISTRATIVA
                // ========================================
                
                "/" => "Admin\DashboardController@index",
                '/admin/dashboard' => 'Admin\DashboardController@index',
                
                // ========================================
                // USUÁRIOS
                // ========================================
                
                
                // ========================================
                // VENDAS
                // ========================================
                
                "/vendas" => "VendasController@index",
                "/vendas/criar" => "VendasController@viewCriarVendas",
                "/vendas/listar" => "VendasController@viewListarVendas",
                "/vendas/listar/{pagina}" => "VendasController@viewListarVendas",
                "/vendas/editar/{id}" => "VendasController@viewEditarVendas",
                "/vendas/excluir/{id}" => "VendasController@viewExcluirVendas",
                "/vendas/relatorio" => "VendasController@relatorioVendas",
                "/vendas/relatorio/{id}/{dataInicial}/{dataFinal}" => "VendasController@relatorioVendas",
                
                // ========================================
                // RESERVAS
                // ========================================
                
                "/reservas" => "ReservasController@index",
                "/reservas/criar" => "ReservasController@viewCriarReservas",
                "/reservas/listar" => "ReservasController@viewListarReservas",
                "/reservas/listar/{pagina}" => "ReservasController@viewListarReservas",
                "/reservas/editar/{id}" => "ReservasController@viewEditarReservas",
                "/reservas/excluir/{id}" => "ReservasController@viewExcluirReservas",
                "/reservas/relatorio" => "ReservasController@relatorioReservas",
                "/reservas/relatorio/{id}/{dataInicial}/{dataFinal}" => "ReservasController@relatorioReservas",
                
                // ========================================
                // PERFIL USUÁRIO
                // ========================================
                
                "/perfil" => "PerfilController@index",
                "/perfil/criar" => "PerfilController@viewCriarPerfil",
                "/perfil/listar" => "PerfilController@viewListarPerfil",
                "/perfil/listar/{pagina}" => "PerfilController@viewListarPerfil",
                "/perfil/editar/{id}" => "PerfilController@viewEditarPerfil",
                "/perfil/excluir/{id}" => "PerfilController@viewExcluirPerfil",
                "/perfil/relatorio" => "PerfilController@relatorioPerfil",
                "/perfil/relatorio/{id}/{dataInicial}/{dataFinal}" => "PerfilController@relatorioPerfil",
                
                // ========================================
                // AVALIAÇÃO
                // ========================================
                
                "/avaliacao" => "AvaliacaoController@index",
                "/avaliacao/criar" => "AvaliacaoController@viewCriarAvaliacao",
                "/avaliacao/listar" => "AvaliacaoController@viewListarAvaliacao",
                "/avaliacao/listar/{pagina}" => "AvaliacaoController@viewListarAvaliacao",
                "/avaliacao/editar/{id}" => "AvaliacaoController@viewEditarAvaliacao",
                "/avaliacao/deletar/{id}" => "AvaliacaoController@viewExcluirAvaliacao",
                "/avaliacao/relatorio" => "AvaliacaoController@relatorioAvaliacao",
                "/avaliacao/relatorio/{id}/{dataInicial}/{dataFinal}" => "AvaliacaoController@relatorioAvaliacao",
                
                // ========================================
                // ITENS (Livros do acervo)
                // ========================================
                
                '/item/listar' => 'ItemController@viewListarItens',
                '/item/listar/{pagina}' => 'ItemController@viewListarItens',
                '/item/criar' => 'ItemController@viewCriarItem',
                '/item/editar/{id}' => 'ItemController@viewEditarItem',
                '/item/excluir/{id}' => 'ItemController@viewExcluirItem',
                
                // ========================================
                // AJAX (Busca dinâmica)
                // ========================================
                
                '/ajax/buscar/autores' => 'ItemController@ajaxBuscarAutores',
                '/ajax/buscar/categorias' => 'ItemController@ajaxBuscarCategorias',
                '/ajax/buscar/generos' => 'ItemController@ajaxBuscarGeneros',
                
                // ========================================
                // API PÚBLICA
                // ========================================
                
                '/api/item' => 'PublicApiController@getItem',
            ],
            
            "POST" => [
                // ========================================
                // AUTENTICAÇÃO
                // ========================================
                
                '/register' => 'AuthController@cadastrarUsuario',
                '/login' => 'AuthController@authenticar',
                
                // ========================================
                // USUÁRIOS
                // ========================================
                

                
                // ========================================
                // VENDAS
                // ========================================
                
                "/vendas/salvar" => "VendasController@salvarVendas",
                "/vendas/atualizar" => "VendasController@atualizarVendas",
                "/vendas/deletar" => "VendasController@deletarVendas",
                "/vendas/ativar" => "VendasController@ativarVenda",
                
                // ========================================
                // RESERVAS
                // ========================================
                
                "/reservas/salvar" => "ReservasController@salvarReservas",
                "/reservas/atualizar" => "ReservasController@atualizarReservas",
                "/reservas/deletar" => "ReservasController@deletarReservas",
                "/reservas/ativar" => "ReservasController@ativarReserva",
                
                // ========================================
                // PERFIL USUÁRIO
                // ========================================
                
                "/perfil/salvar" => "PerfilController@salvarPerfil",
                "/perfil/atualizar" => "PerfilController@atualizarPerfil",
                "/perfil/deletar" => "PerfilController@deletarPerfil",
                "/perfil/ativar" => "PerfilController@ativarPerfil",
                
                // ========================================
                // AVALIAÇÃO
                // ========================================
                
                "/avaliacao/salvar" => "AvaliacaoController@salvarAvaliacao",
                "/avaliacao/atualizar" => "AvaliacaoController@atualizarAvaliacao",
                "/avaliacao/deletar" => "AvaliacaoController@deletarAvaliacao",
                "/avaliacao/ativar" => "AvaliacaoController@ativarAvaliacao",
                
                // ========================================
                // ITENS (Livros do acervo)
                // ========================================
                
                '/item/salvar' => 'ItemController@salvarItem',
                '/item/atualizar' => 'ItemController@atualizarItem',
                '/item/deletar' => 'ItemController@deletarItem',
                '/item/ativar' => 'ItemController@ativarItem',
                
                // ========================================
                // API PÚBLICA
                // ========================================
                
                '/api/reservas' => 'PublicApiController@salvarReservas',
            ]
        ];
    }
}