<?php
use Sebo\Alfarrabio\Controllers\{
    AuthController,
    DashboardController,
    ItemController,
    CategoriaController,
    GeneroController,
    AutorController,
    AvaliacaoController,
    PerfilController,
    UsuarioController
};

// Definição de rotas do sistema Sebo Alfarrábio
return [

    // ======= AUTENTICAÇÃO =======
    '/'                     => [DashboardController::class, 'index'],
    '/login'                => [AuthController::class, 'login'],
    '/logout'               => [AuthController::class, 'logout'],
    '/register'             => [AuthController::class, 'register'],

    // ======= DASHBOARD =======
    '/dashboard'            => [DashboardController::class, 'index'],

    // ======= ITENS / PRODUTOS =======
    '/item/listar'          => [ItemController::class, 'index'],
    '/item/novo'            => [ItemController::class, 'create'],
    '/item/salvar'          => [ItemController::class, 'store'],
    '/item/editar'          => [ItemController::class, 'edit'],
    '/item/atualizar'       => [ItemController::class, 'update'],
    '/item/excluir'         => [ItemController::class, 'delete'],

    // ======= CATEGORIAS =======
    '/categoria/listar'     => [CategoriaController::class, 'index'],
    '/categoria/novo'       => [CategoriaController::class, 'create'],
    '/categoria/salvar'     => [CategoriaController::class, 'store'],
    '/categoria/editar'     => [CategoriaController::class, 'edit'],
    '/categoria/atualizar'  => [CategoriaController::class, 'update'],
    '/categoria/excluir'    => [CategoriaController::class, 'delete'],

    // ======= GÊNEROS =======
    '/genero/listar'        => [GeneroController::class, 'index'],
    '/genero/novo'          => [GeneroController::class, 'create'],
    '/genero/salvar'        => [GeneroController::class, 'store'],
    '/genero/editar'        => [GeneroController::class, 'edit'],
    '/genero/atualizar'     => [GeneroController::class, 'update'],
    '/genero/excluir'       => [GeneroController::class, 'delete'],

    // ======= AUTORES =======
    '/autor/listar'         => [AutorController::class, 'index'],
    '/autor/novo'           => [AutorController::class, 'create'],
    '/autor/salvar'         => [AutorController::class, 'store'],
    '/autor/editar'         => [AutorController::class, 'edit'],
    '/autor/atualizar'      => [AutorController::class, 'update'],
    '/autor/excluir'        => [AutorController::class, 'delete'],

    // ======= AVALIAÇÕES =======
    '/avaliacao/listar'     => [AvaliacaoController::class, 'index'],
    '/avaliacao/novo'       => [AvaliacaoController::class, 'create'],
    '/avaliacao/salvar'     => [AvaliacaoController::class, 'store'],
    '/avaliacao/excluir'    => [AvaliacaoController::class, 'delete'],

    // ======= PERFIL =======
    '/perfil'               => [PerfilController::class, 'index'],
    '/perfil/editar'        => [PerfilController::class, 'edit'],
    '/perfil/salvar'        => [PerfilController::class, 'update'],

    // ======= USUÁRIOS =======
    '/usuario/listar'       => [UsuarioController::class, 'index'],
    '/usuario/novo'         => [UsuarioController::class, 'create'],
    '/usuario/salvar'       => [UsuarioController::class, 'store'],
    '/usuario/editar'       => [UsuarioController::class, 'edit'],
    '/usuario/atualizar'    => [UsuarioController::class, 'update'],
    '/usuario/excluir'      => [UsuarioController::class, 'delete'],


    
    
];
