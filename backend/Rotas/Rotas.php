<?php

namespace Sebo\Alfarrabio\Rotas;

class Rotas
{
    public static function get()
    {
        return [
            "GET" => [
                // o caminho da url   o nome do controller e o metodo de controller

                // Usuario
                "/usuario" => "UsuarioConstroller@index",
                "/usuario/criar" => "UsuarioController@viewCriarUsuarios",
                "/usuario/listar" => "UsuarioController@viewListarUsuarios",
                "/usuario/editar/{id}" => "UsuarioController@viewEditarUsuarios",
                "/usuario/excluir/{id}" => "UsuarioController@viewExcluirUsuarios",

                // Vendas
                "/vendas" => "VendasConstroller@index",
                "/vendas/criar" => "VendasController@viewCriarVendas",
                "/vendas/listar" => "VendasController@viewListarVendas",
                "/vendas/editar/{id}" => "VendasController@viewEditarVendas",
                "/vendas/excluir/{id}" => "VendasController@viewExcluirVendas",

                // Reservas
                "/reservas" => "ReservasConstroller@index",
                "/reservas/criar" => "ReservasController@viewCriarReservas",
                "/reservas/listar" => "ReservasController@viewListarReservas",
                "/reservas/editar/{id}" => "ReservasController@viewEditarReservas",
                "/reservas/excluir/{id}" => "ReservasController@viewExcluirReservas",

                // Perfil
                "/perfil" => "PerfilConstroller@index",
                "/perfil/criar" => "PerfilController@viewCriarPerfil",
                "/perfil/listar" => "PerfilController@viewListarPerfil",
                "/perfil/editar/{id}" => "PerfilController@viewEditarPerfil",
                "/perfil/excluir/{id}" => "PerfilController@viewExcluirPerfil",

                // Avaliação
                "/avaliacao" => "AvaliacaoConstroller@index",
                "/avaliacao/criar" => "AvaliacaoController@viewCriarAvaliacao",
                "/avaliacao/listar" => "AvaliacaoController@viewListarAvaliacao",
                "/avaliacao/editar/{id}" => "AvaliacaoController@viewEditarAvaliacao",
                "/avaliacao/excluir/{id}" => "AvaliacaoController@viewExcluirAvaliacao",


            ],
            "POST" => [

                // usuario
                "/usuario/salvar" => "UsuarioController@viewsalvarUsuarios",
                "/usuario/atualizar/{id}" => "UsuarioController@viewdtualizarUsuarios",
                "/usuario/deletar/{id}" => "UsuarioController@viewdeletarUsuarios",

                //Vendas
                "/vendas/salvar" => "VendasController@viewsalvarVendas",
                "/vendas/atualizar/{id}" => "VendasController@viewdtualizarVendas",
                "/vendas/deletar/{id}" => "VendasController@viewdeletarVendas",

                //Reservas
                "/reservas/salvar" => "ReservasController@viewsalvarReservas",
                "/reservas/atualizar/{id}" => "ReservasController@viewdtualizarReservas",
                "/reservas/deletar/{id}" => "ReservasController@viewdeletarReservas",

                //Perfil Usuario
                "/perfil/salvar" => "PerfilController@viewsalvarPerfil",
                "/perfil/atualizar/{id}" => "PerfilController@viewdtualizarPerfil",
                "/perfil/deletar/{id}" => "PerfilController@viewdeletarPerfil",

                //Avaliação
                "/avaliacao/salvar" => "AvaliacaoController@viewsalvarAvaliacao",
                "/avaliacao/atualizar/{id}" => "AvaliacaoController@viewdtualizarAvaliacao",
                "/avaliacao/deletar/{id}" => "AvaliacaoController@viewdeletarAvaliacao",
            ]
            ];
        
    }
}