<?php

namespace Sebo\Alfarrabio\Rotas;

class Rotas
{
    public static function get()
    {
        return [
            "GET" => [
                // o caminho da url   o nome do controller e o metodo de controller

                //vendas
                "/vendas" => "vendasConstroller@index",
                "/vendas/criar" => "vendasController@viewCriarVendas",
                "/vendas/listar" => "vendasController@viewListarVendas",
                "/vendas/editar/{id}" => "vendasController@viewEditarVendas",
                "/vendas/excluir/{id}" => "vendasController@viewExcluirVendas",
                "/vendas/{id}/relatorio/{dataInicial}/{dataFinal}" => "vendasController@relatorioVendas",

                //reservas
                "/reservas" => "reservasConstroller@index",
                "/reservas/criar" => "reservasController@viewCriarReservas",
                "/reservas/listar" => "reservasController@viewListarReservas",
                "/reservas/editar/{id}" => "reservasController@viewEditarReservas",
                "/reservas/excluir/{id}" => "reservasController@viewExcluirReservas",
                "/reservas/{id}/relatorio/{dataInicial}/{dataFinal}" => "reservasController@relatorioReservas",

                //perfil usuário
                "/perfil" => "perfilConstroller@index",
                "/perfil/criar" => "perfilController@viewCriarPerfil",
                "/perfil/listar" => "perfilController@viewListarPerfil",
                "/perfil/editar/{id}" => "perfilController@viewEditarPerfil",
                "/perfil/excluir/{id}" => "perfilController@viewExcluirPerfil",
                "/perfil/{id}/relatorio/{dataInicial}/{dataFinal}" => "perfilController@relatorioPerfil",

                //Avaliacao
                "/avaliacao" => "AvaliacaoConstroller@index",
                "/avaliacao/criar" => "AvaliacaoController@viewCriarAvaliacao",
                "/avaliacao/listar" => "AvaliacaoController@viewListarAvaliacao",
                "/avaliacao/editar/{id}" => "AvaliacaoController@viewEditarAvaliacao",
                "/avaliacao/excluir/{id}" => "AvaliacaoController@viewExcluirAvaliacao",
                "/avaliacao/{id}/relatorio/{dataInicial}/{dataFinal}" => "AvaliacaoController@relatorioAvaliacao",
            ],
            "POST" => [
                //vendas post
                "/vendas/salvar" => "vendasController@viewsalvarVendas",
                "/vendas/atualizar/{id}" => "vendasController@viewatualizarVendas",
                "/vendas/deletar/{id}" => "vendasController@viewdeletarVendas",

                //reservas post
                "/reservas/salvar" => "reservasController@viewsalvarReservas",
                "/reservas/atualizar/{id}" => "reservasController@viewatualizarReservas",
                "/reservas/deletar/{id}" => "reservasController@viewdeletarReservas",

                //perfil usuário post
                "/perfil/salvar" => "perfilController@viewsalvarPerfil",
                "/perfil/atualizar/{id}" => "perfilController@viewatualizarPerfil",
                "/perfil/deletar/{id}" => "perfilController@viewdeletarPerfil",

                // avaliacao post
                "/avaliacao/salvar" => "AvaliacaoController@viewsalvarAvaliacao",
                "/avaliacao/atualizar/{id}" => "AvaliacaoController@viewatualizarAvaliacao",
                "/avaliacao/deletar/{id}" => "AvaliacaoController@viewdeletarAvaliacao",

            ]
            ];
        
    }
}
