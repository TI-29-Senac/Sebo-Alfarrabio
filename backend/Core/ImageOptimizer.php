<?php

namespace Sebo\Alfarrabio\Core;

/**
 * Otimiza imagens de upload: redimensiona e converte para WebP.
 */
class ImageOptimizer
{
    private int $larguraMaxima;
    private int $qualidade;

    /**
     * @param int $larguraMaxima Largura máxima da imagem resultante (altura proporcional).
     * @param int $qualidade Qualidade WebP (0–100). Padrão 80.
     */
    public function __construct(int $larguraMaxima = 800, int $qualidade = 80)
    {
        $this->larguraMaxima = $larguraMaxima;
        $this->qualidade = $qualidade;
    }

    /**
     * Otimiza uma imagem: redimensiona se necessário e converte para WebP.
     * O arquivo original é substituído pelo otimizado.
     *
     * @param string $caminhoArquivo Caminho absoluto para o arquivo de imagem.
     * @return string Novo caminho do arquivo (com extensão .webp).
     * @throws \Exception Se a extensão GD não estiver disponível ou formato inválido.
     */
    public function otimizar(string $caminhoArquivo): string
    {
        if (!extension_loaded('gd')) {
            throw new \Exception('Extensão GD não está habilitada no PHP.');
        }

        if (!file_exists($caminhoArquivo)) {
            throw new \Exception("Arquivo não encontrado para otimização: " . basename($caminhoArquivo));
        }

        $imagemOriginal = $this->carregarImagem($caminhoArquivo);

        if (!$imagemOriginal) {
            throw new \Exception("Não foi possível processar a imagem: " . basename($caminhoArquivo) . ". Verifique se o formato é suportado (JPG, PNG ou WebP).");
        }

        // Redimensionar se necessário
        $imagemFinal = $this->redimensionar($imagemOriginal);

        // Definir caminho de saída como .webp
        $info = pathinfo($caminhoArquivo);
        $caminhoWebp = $info['dirname'] . DIRECTORY_SEPARATOR . $info['filename'] . '.webp';

        // Salvar como WebP
        if (!imagewebp($imagemFinal, $caminhoWebp, $this->qualidade)) {
            imagedestroy($imagemFinal);
            if ($imagemFinal !== $imagemOriginal) {
                imagedestroy($imagemOriginal);
            }
            throw new \Exception('Falha ao salvar imagem WebP no servidor.');
        }

        // Limpar memória
        imagedestroy($imagemFinal);
        if ($imagemFinal !== $imagemOriginal) {
            imagedestroy($imagemOriginal);
        }

        // Remover arquivo original se não for .webp
        if (strtolower($info['extension'] ?? '') !== 'webp' && file_exists($caminhoArquivo)) {
            unlink($caminhoArquivo);
        }

        return $caminhoWebp;
    }

    /**
     * Carrega uma imagem de forma robusta, independente da extensão ou MIME.
     */
    private function carregarImagem(string $caminho)
    {
        $conteudo = file_get_contents($caminho);
        if ($conteudo === false) {
            return false;
        }

        $img = @imagecreatefromstring($conteudo);

        if (!$img && strpos($caminho, '.webp') !== false && function_exists('imagecreatefromwebp')) {
            // Backup para WebP se o string falhar (algumas versões de GD têm bugs com string WebP)
            return @imagecreatefromwebp($caminho);
        }

        return $img;
    }

    /**
     * Redimensiona a imagem mantendo proporção se largura > larguraMaxima.
     */
    private function redimensionar($imagem)
    {
        $larguraOriginal = imagesx($imagem);
        $alturaOriginal = imagesy($imagem);

        if ($larguraOriginal <= $this->larguraMaxima) {
            return $imagem; // Não precisa redimensionar
        }

        $proporcao = $this->larguraMaxima / $larguraOriginal;
        $novaLargura = $this->larguraMaxima;
        $novaAltura = (int) round($alturaOriginal * $proporcao);

        $imagemRedimensionada = imagecreatetruecolor($novaLargura, $novaAltura);

        // Preservar transparência
        imagealphablending($imagemRedimensionada, false);
        imagesavealpha($imagemRedimensionada, true);
        $transparente = imagecolorallocatealpha($imagemRedimensionada, 0, 0, 0, 127);
        imagefill($imagemRedimensionada, 0, 0, $transparente);

        imagecopyresampled(
            $imagemRedimensionada,
            $imagem,
            0,
            0,
            0,
            0,
            $novaLargura,
            $novaAltura,
            $larguraOriginal,
            $alturaOriginal
        );

        imagedestroy($imagem);

        return $imagemRedimensionada;
    }
}
