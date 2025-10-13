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
                "/usuario" => "UsuarioConstroller@index",
                "/vendas" => "VendasConstroller@index",
                "/reservas" => "ReservasConstroller@index",
                "/perfil" => "PerfilConstroller@index",
                "/avaliacao" => "AvaliacaoConstroller@index",

            ],
            "POST" => [
                "/usuario/salvar" => "UsuarioController@viewsalvarUsuarios",
                "/usuario/atualizar/{id}" => "UsuarioController@viewdtualizarUsuarios",
                "/usuario/deletar/{id}" => "UsuarioController@viewdeletarUsuarios",

                "/vendas/salvar" => "VendasController@viewsalvarVendas",
                "/vendas/atualizar/{id}" => "VendasController@viewdtualizarVendas",
                "/vendas/deletar/{id}" => "VendasController@viewdeletarVendas",

                "/reservas/salvar" => "ReservasController@viewsalvarReservas",
                "/reservas/atualizar/{id}" => "ReservasController@viewdtualizarReservas",
                "/reservas/deletar/{id}" => "ReservasController@viewdeletarReservas",

                "/perfil/salvar" => "PerfilController@viewsalvarPerfil",
                "/perfil/atualizar/{id}" => "PerfilController@viewdtualizarPerfil",
                "/perfil/deletar/{id}" => "PerfilController@viewdeletarPerfil",

                "/avaliacao/salvar" => "AvaliacaoController@viewsalvarAvaliacao",
                "/avaliacao/atualizar/{id}" => "AvaliacaoController@viewdtualizarAvaliacao",
                "/avaliacao/deletar/{id}" => "AvaliacaoController@viewdeletarAvaliacao",
            ]
            ];
        
    }
}