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
                "/autor/criar" => "AutorController@viewCriarAutor",
                "/autor/listar" => "AutorController@viewListarAutor",
                "/autor/editar/{id}" => "AutorController@viewEditarAutor",
                "/autor/excluir/{id}" => "AutorController@viewExcluirAutor",
                "/autor/{id}/relatorio/{dataInicial}/{dataFinal}" => "AutorController@relatorioAutor",

                //Categoria
                "/categoria" => "CategoriaConstroller@index",
                "/categoria/criar" => "CategoriaController@viewCriarCategoria",
                "/categoria/listar" => "CategoriaController@viewListarCategoria",
                "/categoria/editar/{id}" => "CategoriaController@viewEditarCategoria",
                "/categoria/excluir/{id}" => "CategoriaController@viewExcluirCategoria",
                "/categoria/{id}/relatorio/{dataInicial}/{dataFinal}" => "CategoriaController@relatorioCategoria",

                //Genero
                "/genero" => "generoConstroller@index",
                "/genero/criar" => "GeneroController@viewCriarGenero",
                "/genero/listar/" => "GeneroController@viewListarGenero",
                "/genero/editar/{id}" => "GeneroController@viewEditarGenero",
                "/genero/excluir/{id}" => "GeneroController@viewExcluirGenero",
                "/genero/{id}/relatorio/{dataInicial}/{dataFinal}" => "GeneroController@relatorioGenero",

                
            ],
            "POST" => [
                //Autor post
                "/autor/salvar" => "AutorController@viewsalvarAutor",
                "/autor/atualizar/{id}" => "AutorController@viewatualizarAutor",
                "/autor/deletar/{id}" => "AutorController@viewdeletarAutor",

                //Categoria post
                "/categoria/salvar" => "CategoriaController@viewsalvarCategoria",
                "/categoria/atualizar/{id}" => "CategoriaController@viewatualizarCategoria",
                "/categoria/deletar/{id}" => "CategoriaController@viewdeletarCategoria",

                //Genero post
                "/genero/salvar" => "GeneroController@viewsalvarGenero",
                "/genero/atualizar/{id}" => "GeneroController@viewatualizarGenero",
                "/genero/deletar/{id}" => "GeneroController@viewdeletarGenero",

            ]
            ];
        
    }
}