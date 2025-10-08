<?php
namespace Sebo\Alfarrabio\Rotas;

class Rotas {
    public static function get(){
        return [
            "GET" => [
                "/backend/usuarios"    => "UsuarioController@index",
                "/backend/acervo"      => "AcervoController@index",
                "/backend/categorias"  => "CategoriaLivroController@index",
                "/backend/musicas"     => "CategoriaMusicaController@index",
                "/backend/contatos"    => "ContatoController@index",
                "/backend/vendas"      => "VendaController@index",
            ],
            "POST" => [
                "/backend/usuarios/salvar"   => "UsuarioController@salvar",
                "/backend/usuarios/atualizar"=> "UsuarioController@atualizar",
                "/backend/usuarios/excluir" => "UsuarioController@excluir",

                "/backend/acervo/salvar"    => "AcervoController@salvar",
                "/backend/acervo/atualizar" => "AcervoController@atualizar",
                "/backend/acervo/excluir"   => "AcervoController@excluir",

                "/backend/categorias/salvar"=> "CategoriaLivroController@salvar",
                "/backend/categorias/excluir"=> "CategoriaLivroController@excluir",

                "/backend/musicas/salvar"   => "CategoriaMusicaController@salvar",
                "/backend/musicas/excluir"  => "CategoriaMusicaController@excluir",

                "/backend/contatos/salvar"  => "ContatoController@salvar",
                "/backend/contatos/excluir" => "ContatoController@excluir",

                "/backend/vendas/salvar"    => "VendaController@salvar",
                "/backend/vendas/excluir"   => "VendaController@excluir",
            ]
        ];
    }
}
