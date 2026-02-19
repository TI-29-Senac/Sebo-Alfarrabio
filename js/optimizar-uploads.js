/**
 * Script para otimizar todas as imagens da pasta uploads
 * Reduz o tamanho das imagens para melhorar o desempenho do site
 * 
 * Uso: node optimizar-uploads.js
 * 
 * O que faz:
 * - Percorre recursivamente backend/uploads/
 * - Redimensiona imagens maiores que 800px de largura
 * - Comprime JPG com qualidade 80, PNG converte para WebP
 * - Cria backup antes de sobrescrever
 */

const sharp = require('sharp');
const path = require('path');
const fs = require('fs');

// Configurações
const UPLOADS_DIR = path.join(__dirname, 'backend', 'uploads');
const MAX_WIDTH = 800;       // Largura máxima em pixels
const JPEG_QUALITY = 80;     // Qualidade JPEG (1-100)
const WEBP_QUALITY = 80;     // Qualidade WebP (1-100)
const MIN_SIZE_KB = 50;      // Só otimiza arquivos maiores que 50KB
const CRIAR_BACKUP = true;   // Criar pasta de backup antes de otimizar

const EXTENSOES = ['.jpg', '.jpeg', '.png', '.webp'];

let totalOriginal = 0;
let totalOtimizado = 0;
let arquivosProcessados = 0;
let arquivosPulados = 0;

/**
 * Lista todos os arquivos de imagem recursivamente
 */
function listarImagens(dir) {
    let imagens = [];

    if (!fs.existsSync(dir)) {
        console.log(`⚠️  Diretório não encontrado: ${dir}`);
        return imagens;
    }

    const itens = fs.readdirSync(dir, { withFileTypes: true });

    for (const item of itens) {
        const caminhoCompleto = path.join(dir, item.name);

        if (item.name === 'backup_originais') continue; // Ignora pasta de backup

        if (item.isDirectory()) {
            imagens = imagens.concat(listarImagens(caminhoCompleto));
        } else {
            const ext = path.extname(item.name).toLowerCase();
            if (EXTENSOES.includes(ext)) {
                imagens.push(caminhoCompleto);
            }
        }
    }

    return imagens;
}

/**
 * Otimiza uma única imagem
 */
async function otimizarImagem(caminhoImagem) {
    const stats = fs.statSync(caminhoImagem);
    const tamanhoOriginalKB = Math.round(stats.size / 1024);

    // Pula arquivos pequenos
    if (tamanhoOriginalKB < MIN_SIZE_KB) {
        arquivosPulados++;
        return;
    }

    const ext = path.extname(caminhoImagem).toLowerCase();
    const nomeRelativo = path.relative(UPLOADS_DIR, caminhoImagem);

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
        }

        // Arquivo temporário para não corromper o original
        const tempPath = caminhoImagem + '.tmp';

        // Aplica compressão baseada no formato
        if (ext === '.jpg' || ext === '.jpeg') {
            await pipeline
                .jpeg({ quality: JPEG_QUALITY, mozjpeg: true })
                .toFile(tempPath);
        } else if (ext === '.png') {
            // Converte PNG para WebP (muito menor)
            await pipeline
                .webp({ quality: WEBP_QUALITY })
                .toFile(tempPath);
        } else if (ext === '.webp') {
            await pipeline
                .webp({ quality: WEBP_QUALITY })
                .toFile(tempPath);
        }

        const tempStats = fs.statSync(tempPath);
        const tamanhoNovoKB = Math.round(tempStats.size / 1024);

        // Só substitui se ficou menor
        if (tempStats.size < stats.size) {
            // Backup do original
            if (CRIAR_BACKUP) {
                const backupDir = path.join(UPLOADS_DIR, 'backup_originais', path.dirname(nomeRelativo));
                fs.mkdirSync(backupDir, { recursive: true });
                fs.copyFileSync(caminhoImagem, path.join(backupDir, path.basename(caminhoImagem)));
            }

            // Se converteu PNG para WebP, renomeia
            if (ext === '.png') {
                const novoNome = caminhoImagem.replace(/\.png$/i, '.webp');
                fs.renameSync(tempPath, novoNome);
                fs.unlinkSync(caminhoImagem); // Remove o PNG original
                console.log(`✅ ${nomeRelativo} (${tamanhoOriginalKB}KB) → .webp (${tamanhoNovoKB}KB) — ${Math.round((1 - tamanhoNovoKB / tamanhoOriginalKB) * 100)}% menor`);
            } else {
                fs.renameSync(tempPath, caminhoImagem);
                console.log(`✅ ${nomeRelativo} (${tamanhoOriginalKB}KB) → (${tamanhoNovoKB}KB) — ${Math.round((1 - tamanhoNovoKB / tamanhoOriginalKB) * 100)}% menor`);
            }

            totalOriginal += stats.size;
            totalOtimizado += tempStats.size;
            arquivosProcessados++;
        } else {
            // Remove temp se não ficou menor
            fs.unlinkSync(tempPath);
            arquivosPulados++;
            console.log(`⏭️  ${nomeRelativo} (${tamanhoOriginalKB}KB) — já otimizado`);
        }

    } catch (err) {
        console.log(`❌ Erro em ${nomeRelativo}: ${err.message}`);
        // Limpa arquivo temp se existir
        const tempPath = caminhoImagem + '.tmp';
        if (fs.existsSync(tempPath)) fs.unlinkSync(tempPath);
    }
}

/**
 * Função principal
 */
async function main() {
    console.log('🔍 Buscando imagens em backend/uploads/...\n');

    const imagens = listarImagens(UPLOADS_DIR);
    console.log(`📁 Encontradas ${imagens.length} imagens\n`);

    if (imagens.length === 0) {
        console.log('Nenhuma imagem encontrada.');
        return;
    }

    // Processa uma por vez para não sobrecarregar memória
    for (const img of imagens) {
        await otimizarImagem(img);
    }

    // Resumo
    const economiaKB = Math.round((totalOriginal - totalOtimizado) / 1024);
    const economiaMB = (economiaKB / 1024).toFixed(2);

    console.log('\n' + '='.repeat(50));
    console.log('📊 RESUMO DA OTIMIZAÇÃO');
    console.log('='.repeat(50));
    console.log(`✅ Arquivos otimizados: ${arquivosProcessados}`);
    console.log(`⏭️  Arquivos pulados:    ${arquivosPulados}`);
    console.log(`💾 Economia total:      ${economiaKB}KB (${economiaMB}MB)`);

    if (CRIAR_BACKUP) {
        console.log(`\n📂 Backup dos originais em: backend/uploads/backup_originais/`);
    }

    console.log('\n🎉 Otimização concluída!');
}

main().catch(err => {
    console.error('❌ Erro fatal:', err);
    process.exit(1);
});
