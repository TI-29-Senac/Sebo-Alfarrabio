/**
 * Script para otimizar todas as imagens da pasta img/
 * Converte PNG/JPG para WebP e comprime para melhorar o PageSpeed
 * 
 * Uso: node optimizar-imagens.js
 * 
 * O que faz:
 * - Percorre a pasta img/
 * - Converte PNG e JPG para WebP (muito menor)
 * - Redimensiona imagens maiores que MAX_WIDTH
 * - Cria backup dos originais em img/backup/
 * - Mostra relatório de economia no final
 */

const sharp = require('sharp');
const path = require('path');
const fs = require('fs');

// ============================================
// CONFIGURAÇÕES
// ============================================
const IMG_DIR = path.join(__dirname, 'img');
const BACKUP_DIR = path.join(IMG_DIR, 'backup');
const MAX_WIDTH = 1200;          // Largura máxima em pixels
const JPEG_QUALITY = 80;         // Qualidade JPEG (1-100)
const WEBP_QUALITY = 80;         // Qualidade WebP (1-100)
const MIN_SIZE_KB = 100;         // Só otimiza arquivos maiores que 100KB
const CRIAR_BACKUP = true;       // Criar backup antes de sobrescrever
const CONVERTER_PARA_WEBP = true; // Converter PNG/JPG para WebP

const EXTENSOES = ['.jpg', '.jpeg', '.png', '.webp'];

// Arquivos para NÃO converter (SVGs, ícones pequenos, etc.)
const IGNORAR = ['backup', 'node_modules'];

let totalOriginal = 0;
let totalOtimizado = 0;
let arquivosProcessados = 0;
let arquivosPulados = 0;
let erros = 0;

// ============================================
// FUNÇÕES
// ============================================

/**
 * Lista todos os arquivos de imagem na pasta
 */
function listarImagens(dir) {
    let imagens = [];

    if (!fs.existsSync(dir)) {
        console.log(`⚠️  Diretório não encontrado: ${dir}`);
        return imagens;
    }

    const itens = fs.readdirSync(dir, { withFileTypes: true });

    for (const item of itens) {
        // Ignora pastas de backup e node_modules
        if (IGNORAR.includes(item.name)) continue;

        const caminhoCompleto = path.join(dir, item.name);

        if (item.isDirectory()) {
            // Não entra em subdiretórios (só img/ raiz)
            continue;
        }

        const ext = path.extname(item.name).toLowerCase();
        if (EXTENSOES.includes(ext)) {
            imagens.push(caminhoCompleto);
        }
    }

    return imagens;
}

/**
 * Formata bytes para leitura humana
 */
function formatarTamanho(bytes) {
    if (bytes < 1024) return `${bytes}B`;
    if (bytes < 1024 * 1024) return `${Math.round(bytes / 1024)}KB`;
    return `${(bytes / (1024 * 1024)).toFixed(2)}MB`;
}

/**
 * Otimiza uma única imagem
 */
async function otimizarImagem(caminhoImagem) {
    const stats = fs.statSync(caminhoImagem);
    const tamanhoOriginalKB = Math.round(stats.size / 1024);
    const nomeArquivo = path.basename(caminhoImagem);
    const ext = path.extname(caminhoImagem).toLowerCase();

    // Pula arquivos pequenos
    if (tamanhoOriginalKB < MIN_SIZE_KB) {
        arquivosPulados++;
        console.log(`⏭️  ${nomeArquivo} (${formatarTamanho(stats.size)}) — muito pequeno, pulando`);
        return;
    }

    try {
        // Lê metadados da imagem
        const metadata = await sharp(caminhoImagem).metadata();

        // Configura o pipeline do sharp
        let pipeline = sharp(caminhoImagem);

        // Redimensiona apenas se for maior que MAX_WIDTH
        if (metadata.width && metadata.width > MAX_WIDTH) {
            pipeline = pipeline.resize(MAX_WIDTH, null, {
                fit: 'inside',
                withoutEnlargement: true
            });
            console.log(`   📐 Redimensionando de ${metadata.width}px → ${MAX_WIDTH}px`);
        }

        // Arquivo temporário
        const tempPath = caminhoImagem + '.tmp';

        // Define o formato de saída
        if (CONVERTER_PARA_WEBP && (ext === '.png' || ext === '.jpg' || ext === '.jpeg')) {
            // Converte para WebP
            await pipeline
                .webp({ quality: WEBP_QUALITY })
                .toFile(tempPath);
        } else if (ext === '.webp') {
            // Re-comprime WebP
            await pipeline
                .webp({ quality: WEBP_QUALITY })
                .toFile(tempPath);
        } else if (ext === '.jpg' || ext === '.jpeg') {
            // Comprime JPEG
            await pipeline
                .jpeg({ quality: JPEG_QUALITY, mozjpeg: true })
                .toFile(tempPath);
        } else if (ext === '.png') {
            // Comprime PNG
            await pipeline
                .png({ quality: WEBP_QUALITY, compressionLevel: 9 })
                .toFile(tempPath);
        }

        const tempStats = fs.statSync(tempPath);

        // Só substitui se ficou menor
        if (tempStats.size < stats.size) {
            // Backup do original
            if (CRIAR_BACKUP) {
                fs.mkdirSync(BACKUP_DIR, { recursive: true });
                fs.copyFileSync(caminhoImagem, path.join(BACKUP_DIR, nomeArquivo));
            }

            // Se converteu para WebP, salva com extensão .webp
            if (CONVERTER_PARA_WEBP && (ext === '.png' || ext === '.jpg' || ext === '.jpeg')) {
                const novoNome = caminhoImagem.replace(/\.(png|jpg|jpeg)$/i, '.webp');

                // Move o arquivo temporário para o novo nome
                fs.renameSync(tempPath, novoNome);

                // Remove o original (PNG/JPG)
                if (novoNome !== caminhoImagem) {
                    fs.unlinkSync(caminhoImagem);
                }

                const economia = Math.round((1 - tempStats.size / stats.size) * 100);
                console.log(`✅ ${nomeArquivo} (${formatarTamanho(stats.size)}) → ${path.basename(novoNome)} (${formatarTamanho(tempStats.size)}) — ${economia}% menor`);
            } else {
                fs.renameSync(tempPath, caminhoImagem);
                const economia = Math.round((1 - tempStats.size / stats.size) * 100);
                console.log(`✅ ${nomeArquivo} (${formatarTamanho(stats.size)}) → (${formatarTamanho(tempStats.size)}) — ${economia}% menor`);
            }

            totalOriginal += stats.size;
            totalOtimizado += tempStats.size;
            arquivosProcessados++;
        } else {
            // Remove temp se não ficou menor
            fs.unlinkSync(tempPath);
            arquivosPulados++;
            console.log(`⏭️  ${nomeArquivo} (${formatarTamanho(stats.size)}) — já otimizado`);
        }

    } catch (err) {
        erros++;
        console.log(`❌ Erro em ${nomeArquivo}: ${err.message}`);
        // Limpa arquivo temp se existir
        const tempPath = caminhoImagem + '.tmp';
        if (fs.existsSync(tempPath)) fs.unlinkSync(tempPath);
    }
}

// ============================================
// EXECUÇÃO
// ============================================
async function main() {
    console.log('');
    console.log('📸 OTIMIZADOR DE IMAGENS — Sebo Alfarrabio');
    console.log('='.repeat(50));
    console.log(`📁 Pasta: ${IMG_DIR}`);
    console.log(`📏 Largura máxima: ${MAX_WIDTH}px`);
    console.log(`🎨 Qualidade WebP: ${WEBP_QUALITY}%`);
    console.log(`🔄 Converter para WebP: ${CONVERTER_PARA_WEBP ? 'Sim' : 'Não'}`);
    console.log(`💾 Backup: ${CRIAR_BACKUP ? 'Sim' : 'Não'}`);
    console.log('='.repeat(50));
    console.log('');

    const imagens = listarImagens(IMG_DIR);
    console.log(`🔍 Encontradas ${imagens.length} imagens\n`);

    if (imagens.length === 0) {
        console.log('Nenhuma imagem encontrada.');
        return;
    }

    // Ordena por tamanho (maiores primeiro)
    imagens.sort((a, b) => {
        return fs.statSync(b).size - fs.statSync(a).size;
    });

    // Processa uma por vez
    for (const img of imagens) {
        await otimizarImagem(img);
    }

    // Resumo
    const economiaBytes = totalOriginal - totalOtimizado;

    console.log('\n' + '='.repeat(50));
    console.log('📊 RESUMO DA OTIMIZAÇÃO');
    console.log('='.repeat(50));
    console.log(`✅ Arquivos otimizados: ${arquivosProcessados}`);
    console.log(`⏭️  Arquivos pulados:    ${arquivosPulados}`);
    console.log(`❌ Erros:               ${erros}`);
    console.log(`💾 Economia total:      ${formatarTamanho(economiaBytes)}`);

    if (totalOriginal > 0) {
        const porcentagem = Math.round((1 - totalOtimizado / totalOriginal) * 100);
        console.log(`📉 Redução:             ${porcentagem}%`);
    }

    if (CRIAR_BACKUP) {
        console.log(`\n📂 Backup dos originais em: img/backup/`);
    }

    console.log('\n⚠️  ATENÇÃO: Se converteu PNG/JPG para WebP, atualize as referências nos HTML/CSS!');
    console.log('\n🎉 Otimização concluída!');
}

main().catch(err => {
    console.error('❌ Erro fatal:', err);
    process.exit(1);
});
