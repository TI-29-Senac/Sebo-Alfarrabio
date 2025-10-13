<?php
namespace App\Sebo_Alfarrabio\Controllers;

use App\Sebo_Alfarrabio\Models\Livros;
use App\Sebo_Alfarrabio\Database\Database;
use App\Sebo_Alfarrabio\Core\View;
use App\Sebo_Alfarrabio\Core\Redirect;
use App\Sebo_Alfarrabio\Controllers\Validadores\UsuarioValidador;
use App\Sebo_Alfarrabio\Core\FileManager;
use Composer\Autoload\ClassLoader;

ClassLoader