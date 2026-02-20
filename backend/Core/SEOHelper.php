<?php

namespace Sebo\Alfarrabio\Core;

class SEOHelper
{
    /**
     * Transforma um texto em um slug amigável para URL.
     * Ex: "Teto para Dois" -> "teto-para-dois"
     */
    public static function slugify($text)
    {
        // Substitui caracteres não alfanuméricos por hifen
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // Translitera para ASCII
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // Remove caracteres indesejados
        $text = preg_replace('~[^-\w]+~', '', $text);
        // Remove hifens duplicados
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        // Lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /**
     * Retorna as variações agressivas para um produto.
     */
    public static function getSeoVariations($title)
    {
        $slug = self::slugify($title);
        $base = "livro-" . $slug;

        return [
            $base,
            $base . "-barato",
            $base . "-sebo",
            $base . "-sao-miguel-paulista",
            $base . "-itaim-paulista",
            $base . "-promocao",
            $base . "-usado-conservado"
        ];
    }
}
