<?php

namespace Sebo\Alfarrabio\Controllers;

use Sebo\Alfarrabio\Models\Item;
use Sebo\Alfarrabio\Database\Database;
use Sebo\Alfarrabio\Core\SEOHelper;

class SEOController
{
    private $db;
    private $itemModel;

    public function __construct()
    {
        $this->db = (new Database())->getConexao();
        $this->itemModel = new Item($this->db);
    }

    /**
     * Gera o Sitemap XML dinâmico com variações agressivas.
     */
    public function generateSitemap()
    {
        $itens = $this->itemModel->buscarItemAtivos();
        $baseUrl = "http://" . $_SERVER['HTTP_HOST'];

        header("Content-Type: application/xml; charset=utf-8");

        echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        // Páginas estáticas principais
        $paginasEstaticas = ['', '/produtos.html', '/sobre.html', '/contato.html'];
        foreach ($paginasEstaticas as $pag) {
            echo '  <url>' . PHP_EOL;
            echo '    <loc>' . $baseUrl . $pag . '</loc>' . PHP_EOL;
            echo '    <priority>1.0</priority>' . PHP_EOL;
            echo '  </url>' . PHP_EOL;
        }

        // Variações dinâmicas para cada produto (SEO Agressivo)
        foreach ($itens as $item) {
            $variacoes = SEOHelper::getSeoVariations($item['titulo_item']);
            foreach ($variacoes as $slug) {
                echo '  <url>' . PHP_EOL;
                echo '    <loc>' . $baseUrl . '/' . $slug . '</loc>' . PHP_EOL;
                echo '    <changefreq>weekly</changefreq>' . PHP_EOL;
                echo '    <priority>0.8</priority>' . PHP_EOL;
                echo '  </url>' . PHP_EOL;
            }
        }

        echo '</urlset>';
        exit;
    }

    /**
     * Resolve a URL amigável e redireciona para a página de produtos.
     * Captura o ID do produto baseado no título contido no slug.
     */
    public function resolveSeoUrl($slug)
    {
        // Limpa sufixos do slug para tentar achar o título base
        $cleanSlug = preg_replace('/-(barato|sebo|sao-miguel-paulista|itaim-paulista|promocao|usado-conservado)$/', '', $slug);
        $cleanSlug = str_replace('livro-', '', $cleanSlug);

        // Busca no banco um item que tenha um slug compatível
        $itens = $this->itemModel->buscarItemAtivos();
        $id_item = null;

        foreach ($itens as $item) {
            if (SEOHelper::slugify($item['titulo_item']) === $cleanSlug) {
                $id_item = $item['id_item'];
                break;
            }
        }

        if ($id_item) {
            // Redireciona para a página de produtos com o parâmetro do item para o JS abrir o modal
            header("Location: /produtos.html?item=" . $id_item . "&seo=" . $slug);
            exit;
        }

        // Se não achar, manda para a vitrine geral
        header("Location: /produtos.html");
        exit;
    }
}
