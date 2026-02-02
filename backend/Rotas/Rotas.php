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
                "/produtos" => "Public\PublicItemController@viewProdutos",
                "/produtos/{pagina}" => "Public\PublicItemController@viewProdutos",

                // ========================================
                // AUTENTICAÇÃO
                // ========================================

                '/register' => 'AuthController@register',
                '/login' => 'AuthController@login',
                '/logout' => 'AuthController@logout',


                // ========================================
                // CLIENTE
                // ========================================
                '/admin/cliente' => "DashboardControllerCliente@index",

                // ========================================
                // ÁREA ADMINISTRATIVA
                // ========================================

                "/admin/dashboard" => "DashboardController@index",


                // ========================================
                // USUÁRIOS
                // ========================================

                "/usuarios" => "UsuarioController@index",
                "/usuario/criar" => "UsuarioController@viewCriarUsuarios",
                "/usuario/listar" => "UsuarioController@viewListarUsuarios",
                "/usuario/listar/{pagina}" => "UsuarioController@viewListarUsuarios",
                "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
                "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
                "/api/usuarios/{pagina}" => "Api\APIUsarioController@getUsuarios",
                "/api/usuarios" => "Api\APIUsarioController@getUsuarios",

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

                "/pedidos" => "PedidosController@index",
                "/pedidos/criar" => "PedidosController@viewCriarPedidos",
                "/pedidos/listar" => "PedidosController@viewListarPedidos",
                "/pedidos/listar/{pagina}" => "PedidosController@viewListarPedidos",
                "/pedidos/editar/{id}" => "PedidosController@viewEditarPedidos",
                "/pedidos/excluir/{id}" => "PedidosController@viewExcluirPedidos",
                "/pedidos/relatorio" => "PedidosController@relatorioPedidos",
                "/pedidos/relatorio/{id}/{dataInicial}/{dataFinal}" => "PedidosController@relatorioPedidos",

                // ========================================
                // API PÚBLICA / API ITEM
                // ========================================

                "/api/item" => "PublicApiController@getItem",
                "/api/buscaitem" => "PublicApiController@getItem",

                "/api/pedidos" => "Api\APIPedidosController@getPedidos",
                "/api/buscarpedidos" => "Api\APIPedidosController@getPedidos",


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


                "/item/listar" => "ItemController@viewListarItens",
                "/item/listar/{pagina}" => "ItemController@viewListarItens",
                "/item/criar" => "ItemController@viewCriarItem",
                "/item/editar/{id}" => "ItemController@viewEditarItem",
                "/item/excluir/{id}" => "ItemController@viewExcluirItem",



                // ========================================
                // AUTOR    
                // ========================================
                "/autor" => "AutorController@index",
                "/autor/criar" => "AutorController@viewCriarAutor",
                "/autor/listar" => "AutorController@viewListarAutor",
                "/autor/editar/{id}" => "AutorController@viewEditarAutor",
                "/autor/excluir/{id}" => "AutorController@viewExcluirAutor",
                "/autor/{id}/relatorio/{dataInicial}/{dataFinal}" => "AutorController@relatorioAutor",

                // ========================================
                // CATEGORIA
                // ========================================
                "/" => "DashboardController@index",

                "/categoria" => "CategoriaController@index",
                "/categoria/criar" => "CategoriaController@viewCriarCategoria",
                "/categoria/listar" => "CategoriaController@viewListarCategoria",
                "/categoria/editar/{id}" => "CategoriaController@viewEditarCategoria",
                "/categoria/excluir/{id}" => "CategoriaController@viewExcluirCategoria",
                "/categoria/{id}/relatorio/{dataInicial}/{dataFinal}" => "CategoriaController@relatorioCategoria",

                // ========================================
                // GENERO
                // ========================================
                "/genero" => "GeneroController@index",
                "/genero/criar" => "GeneroController@viewCriarGenero",
                "/genero/listar/" => "GeneroController@viewListarGenero",
                "/genero/editar/{id}" => "GeneroController@viewEditarGenero",
                "/genero/excluir/{id}" => "GeneroController@viewExcluirGenero",
                "/genero/{id}/relatorio/{dataInicial}/{dataFinal}" => "GeneroController@relatorioGenero",


                // ========================================
                // AJAX (Busca dinâmica)
                // ========================================

                "/ajax/buscar/autores" => "ItemController@ajaxBuscarAutores",
                "/ajax/buscar/categorias" => "ItemController@ajaxBuscarCategorias",
                "/ajax/buscar/generos" => "ItemController@ajaxBuscarGeneros",

                // ========================================
                // Carrinho de Compras
                // ========================================

                "/carrinho" => "CartController@index",
                "/carrinho/adicionar/{id}" => "CartController@adicionar",
                "/carrinho/remover/{id}" => "CartController@remover",
                "/carrinho/obrigado/{id}" => "CartController@obrigado",

                '/api/avaliacoes' => 'PublicApiController@getAvaliacoes',
            ],


            "POST" => [
                // ========================================
                // AUTENTICAÇÃO (post)
                // ========================================

                "/register" => "AuthController@cadastrarUsuario",
                "/login" => "AuthController@authenticar",

                // ========================================
                // USUÁRIOS (post)
                // ========================================

                "/usuario/salvar" => "UsuarioController@salvarUsuario",
                "/usuario/atualizar" => "UsuarioController@atualizarUsuario",
                "/usuario/deletar" => "UsuarioController@deletarUsuario",


                // ========================================
                // VENDAS (post)
                // ========================================

                "/vendas/salvar" => "VendasController@salvarVendas",
                "/vendas/atualizar" => "VendasController@atualizarVendas",
                "/vendas/deletar" => "VendasController@deletarVendas",
                "/vendas/ativar" => "VendasController@ativarVenda",

                // ========================================
                // Pedidos (post)
                // ========================================
                "/pedidos/salvar" => "PedidosController@salvarPedidos",
                "/pedidos/atualizar" => "PedidosController@atualizarPedidos",
                "/pedidos/deletar" => "PedidosController@deletarPedidos",

                // Opcional: se quiser ativar pedido excluído
                "/pedidos/ativar" => "PedidosController@ativarPedidos",

                // ========================================
                // PERFIL USUÁRIO (post)
                // ========================================

                // PERFIL USUÁRIO (post)
                // ========================================

                "/admin/cliente/foto" => "DashboardControllerCliente@atualizarFotoPerfil",
                "/perfil/salvar" => "PerfilController@salvarPerfil",
                "/perfil/atualizar" => "PerfilController@atualizarPerfil",
                "/perfil/deletar" => "PerfilController@deletarPerfil",
                "/perfil/ativar" => "PerfilController@ativarPerfil",

                // ========================================
                // AVALIAÇÃO (post)
                // ========================================

                "/avaliacao/salvar" => "AvaliacaoController@salvarAvaliacao",
                "/avaliacao/criar" => "AvaliacaoController@viewCriarAvaliacao",
                "/avaliacao/atualizar" => "AvaliacaoController@atualizarAvaliacao",
                "/avaliacao/deletar" => "AvaliacaoController@deletarAvaliacao",
                "/avaliacao/ativar" => "AvaliacaoController@ativarAvaliacao",

                // ========================================
                // ITENS (Livros do acervo)
                // ========================================

                "/item/salvar" => "ItemController@salvarItem",
                "/item/atualizar" => "ItemController@atualizarItem",
                "/item/deletar" => "ItemController@deletarItem",
                "/item/ativar" => "ItemController@ativarItem",

                // ========================================
                // API PÚBLICA (post)
                // ========================================



                // ========================================
                // AUTORES (post)
                // ========================================
                "/autor/salvar" => "AutorController@salvarAutor",
                "/autor/atualizar/{id}" => "AutorController@atualizarAutor",
                "/autor/excluir/{id}" => "AutorController@deletarAutor",

                // ========================================
                // CATEGORIA (post)
                // ========================================
                "/categoria/salvar" => "CategoriaController@salvarCategoria",
                "/categoria/atualizar" => "CategoriaController@atualizarCategoria",
                "/categoria/excluir/{id}" => "CategoriaController@deletarCategoria",

                // ========================================
                // GENERO (post)
                // ========================================
                "/genero/salvar" => "GeneroController@salvarGenero",
                "/genero/atualizar/{id}" => "GeneroController@atualizarGenero",
                "/genero/deletar/{id}" => "GeneroController@deletarGenero",


                // ========================================
                // Carrinho de Compras (post)
                // ========================================

                "/carrinho/atualizar" => "CartController@atualizar",
                "/carrinho/finalizar" => "CartController@finalizar",

            ]
        ];
    }
}