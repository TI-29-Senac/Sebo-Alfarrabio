<?php
namespace Sebo\Alfarrabio\Core;

class Env
{
    /**
     * Carrega variáveis do arquivo .env para o ambiente.
     * @param string $diretorio Diretório contendo o arquivo .env
     * @return bool Sucesso ou falha
     */
    public static function carregar(string $diretorio)
    {
        $caminho = rtrim($diretorio, '/') . '/.env';

        if (!file_exists($caminho)) {
            return false;
        }

        $linhas = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($linhas as $linha) {
            // Ignora comentários
            if (strpos(trim($linha), '#') === 0) {
                continue;
            }

            // Divide por "="
            $partes = explode('=', $linha, 2);
            if (count($partes) === 2) {
                $chave = trim($partes[0]);
                $valor = trim($partes[1]);

                // Remove aspas se existirem
                $valor = trim($valor, "\"'");

                // Define no ambiente e em $_ENV
                putenv("{$chave}={$valor}");
                $_ENV[$chave] = $valor;
                $_SERVER[$chave] = $valor;
            }
        }
        return true;
    }

    /**
     * Obtém uma variável de ambiente.
     * @param string $chave Chave da variável
     * @param mixed $padrao Valor padrão caso não exista
     * @return mixed
     */
    public static function get(string $chave, $padrao = null)
    {
        $valor = getenv($chave);
        if ($valor === false) {
            return $_ENV[$chave] ?? $padrao;
        }

        // Converte valores booleanos
        switch (strtolower($valor)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        return $valor;
    }
}
