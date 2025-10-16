<?php

namespace Sebo\Alfarrabio\Rotas;

class Rotas
{
    public static function get()
    {
        return [
            "GET" => [
                // o caminho da url   o nome do controller e o metodo de controller
                "/vendas" => "vendasConstroller@index",
                "/vendas/criar" => "vendasController@viewCriarVendas",
                "/vendas/listar" => "vendasController@viewListarVendas",
                "/vendas/editar/{id}" => "vendasController@viewEditarVendas",
                "/vendas/excluir/{id}" => "vendasController@viewExcluirVendas",
                "/vendas/{id}/relatorio/{dataInicial}/{dataFinal}" => "vendasController@relatorioVendas",

                '/register' => 'AuthController@register',
                '/login' => 'AuthController@login',
                '/logout' => 'AuthController@logout',
                '/admin/dashboard' => 'Admin\DashboardController@index',
            ],
            "POST" => [
                "/vendas/salvar" => "vendasController@viewsalvarVendas",
                "/vendas/atualizar/{id}" => "vendasController@viewdtualizarVendas",
                "/vendas/deletar/{id}" => "vendasController@viewdeletarVendas",

                '/register' => 'AuthController@cadastrarvendas',
                '/login' => 'AuthController@authenticar',
            ]
            ];
        
    }
}
