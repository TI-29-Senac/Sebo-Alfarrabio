<?php

namespace App\Sebo\Alfarrabio\Rotas;

class Rotas
{
    public static function get()
    {
        return [
            "GET" => [
                // o caminho da url   o nome do controller e o metodo de controller

                // Usuario
                "/usuarios" => "UsuarioConstroller@index",
                "/usuario/criar" => "UsuarioController@viewCriarUsuarios",
                "/usuario/listar" => "UsuarioController@viewListarUsuarios",
                "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
                "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",
                "/usuario/{id}/relatorio/{dataInicial}/{dataFinal}" => "UsuarioController@relatorioUsuarios",

                 // Vendas
                 "/vendas" => "VendasConstroller@index",
                 "/vendas/criar" => "VendasController@viewCriarVendas",
                 "/vendas/listar" => "VendasController@viewListarVendas",
                 "/vendas/editar/{id}" => "VendasController@viewEditarVendas",
                 "/vendas/excluir/{id}" => "VendasController@viewExcluirVendas",
                 "/vendas/{id}/relatorio/{dataInicial}/{dataFinal}" => "vendasController@relatorioVendas",

                 // Reservas
                 "/reservas" => "ReservasConstroller@index",
                 "/reservas/criar" => "ReservasController@viewCriarReservas",
                 "/reservas/listar" => "ReservasController@viewListarReservas",
                 "/reservas/editar/{id}" => "ReservasController@viewEditarReservas",
                 "/reservas/excluir/{id}" => "ReservasController@viewExcluirReservas",
                 "/reservas/{id}/relatorio/{dataInicial}/{dataFinal}" => "reservasController@relatorioReservas",

                  // Perfil Usuario
                  "/perfil" => "perfilConstroller@index",
                  "/perfil/criar" => "PerfilController@viewCriarPerfil",
                  "/perfil/listar" => "PerfilController@viewListarPerfil",
                  "/perfil/editar/{id}" => "PerfilController@viewEditarPerfil",
                  "/perfil/excluir/{id}" => "PerfilController@viewExcluirPerfil",
                  "/perfil/{id}/relatorio/{dataInicial}/{dataFinal}" => "perfilController@relatorioPerfil",

                  // Avaliacao
                  "/avaliacao" => "AvaliacaoConstroller@index",
                  "/avaliacao/criar" => "AvaliacaoController@viewCriarAvaliacao",
                  "/avaliacao/listar" => "AvaliacaoController@viewListarAvaliacao",
                  "/avaliacao/editar/{id}" => "AvaliacaoController@viewEditarAvaliacao",
                  "/avaliacao/excluir/{id}" => "AvaliacaoController@viewExcluirAvaliacao",
                  "/avaliacao/{id}/relatorio/{dataInicial}/{dataFinal}" => "avaliacaoController@relatorioAvaliacao",


            ],
            "POST" => [
                "/usuario/salvar" => "UsuarioController@viewsalvarUsuarios",
                "/usuario/atualizar/{id}" => "UsuarioController@viewdtualizarUsuarios",
                "/usuario/deletar/{id}" => "UsuarioController@viewdeletarUsuarios",
            ]
            ];
        
    }
}