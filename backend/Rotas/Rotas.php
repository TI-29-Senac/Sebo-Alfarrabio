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
                "/" => "Admin\\DashboardController@index",
                "/backend" => "Admin\\DashboardController@index",
                "/categoria" => "CategoriaController@index",
                "/categoria/criar" => "CategoriaController@viewCriarCategoria",
                "/categoria/listar" => "CategoriaController@viewListarCategoria",
                "/categoria/editar/{id}" => "CategoriaController@viewEditarCategoria",
                "/categoria/excluir/{id}" => "CategoriaController@viewExcluirCategoria",
                "/categoria/{id}/relatorio/{dataInicial}/{dataFinal}" => "CategoriaController@relatorioCategoria",

                // Admin Dashboard (acessível por /admin/dashboard e /backend/admin/dashboard)
                "/admin/dashboard" => "Admin\\DashboardController@index",
                "/backend/admin/dashboard" => "Admin\\DashboardController@index",

                //Genero
                "/genero" => "generoConstroller@index",
                "/genero/criar" => "GeneroController@viewCriarGenero",
                "/genero/listar/" => "GeneroController@viewListarGenero",
                "/genero/editar/{id}" => "GeneroController@viewEditarGenero",
                "/genero/excluir/{id}" => "GeneroController@viewExcluirGenero",
                "/genero/{id}/relatorio/{dataInicial}/{dataFinal}" => "GeneroController@relatorioGenero",


                 // --- NOVAS ROTAS DE ITEM (SEBO) ---
                 '/item/listar' => 'ItemController@viewListarItens',
                 '/item/listar/{pagina}' => 'ItemController@viewListarItens',
                 '/item/criar' => 'ItemController@viewCriarItem',
                 '/item/editar/{id}' => 'ItemController@viewEditarItem',
                 '/item/excluir/{id}' => 'ItemController@viewExcluirItem',
 
                 // --- NOVAS ROTAS AJAX (Para formulário de Item) ---
                 '/ajax/buscar/autores' => 'ItemController@ajaxBuscarAutores',
                 '/ajax/buscar/categorias' => 'ItemController@ajaxBuscarCategorias',

                
            ],
            "POST" => [
                //Autor post
                "/autor/salvar" => "AutorController@salvarAutor",
                "/autor/atualizar/{id}" => "AutorController@atualizarAutor",
                "/autor/excluir/{id}" => "AutorController@deletarAutor",

                //Categoria post
                "/categoria/salvar" => "CategoriaController@salvarCategoria",
                "/categoria/atualizar" => "CategoriaController@atualizarCategoria",
                "/categoria/excluir/{id}" => "CategoriaController@deletarCategoria",

                //Genero post
                "/genero/salvar" => "GeneroController@viewsalvarGenero",
                "/genero/atualizar/{id}" => "GeneroController@viewatualizarGenero",
                "/genero/deletar/{id}" => "GeneroController@viewdeletarGenero",

                '/item/salvar' => 'ItemController@salvarItem',
                '/item/atualizar' => 'ItemController@atualizarItem',
                '/item/deletar' => 'ItemController@deletarItem',

            ]
            ];
        
    }
}