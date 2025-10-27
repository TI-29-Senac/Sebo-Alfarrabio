<?php

namespace Sebo\Alfarrabio\Rotas;

class Rotas
{
    public static function get()
    {
        return [
            "GET" => [
                // o caminho da url   o nome do controller e o metodo de controller

                //Autor
                "/autor" => "autorController@index",
                "/autor/criar" => "autorController@viewCriarAutor",
                "/autor/listar" => "autorController@viewListarAutor",
                "/autor/editar/{id}" => "autorController@viewEditarAutor",
                "/autor/excluir/{id}" => "autorController@viewExcluirAutor",
                "/autor/{id}/relatorio/{dataInicial}/{dataFinal}" => "autorController@relatorioAutor",

                //Categoria
                "/categoria" => "categoriaConstroller@index",
                "/categoria/criar" => "categoriaController@viewCriarCategoria",
                "/categoria/listar" => "categoriaController@viewListarCategoria",
                "/categoria/editar/{id}" => "categoriaController@viewEditarCategoria",
                "/categoria/excluir/{id}" => "categoriaController@viewExcluirCategoria",
                "/categoria/{id}/relatorio/{dataInicial}/{dataFinal}" => "categoriaController@relatorioCategoria",

                //Genero
                "/genero" => "generoConstroller@index",
                "/genero/criar" => "generoController@viewCriarGenero",
                "/genero/listar" => "generoController@viewListarGenero",
                "/genero/editar/{id}" => "generoController@viewEditarGenero",
                "/genero/excluir/{id}" => "generoController@viewExcluirGenero",
                "/genero/{id}/relatorio/{dataInicial}/{dataFinal}" => "generoController@relatorioGenero",

                
            ],
            "POST" => [
                //Autor post
                "/autor/salvar" => "autorController@viewsalvarAutor",
                "/autor/atualizar/{id}" => "autorController@viewatualizarAutor",
                "/autor/deletar/{id}" => "autorController@viewdeletarAutor",

                //Categoria post
                "/categoria/salvar" => "categoriaController@viewsalvarCategoria",
                "/categoria/atualizar/{id}" => "categoriaController@viewatualizarCategoria",
                "/categoria/deletar/{id}" => "categoriaController@viewdeletarCategoria",

                //Genero post
                "/genero/salvar" => "generoController@viewsalvarGenero",
                "/genero/atualizar/{id}" => "generoController@viewatualizarGenero",
                "/genero/deletar/{id}" => "generoController@viewdeletarGenero",

            ]
            ];
        
    }
}