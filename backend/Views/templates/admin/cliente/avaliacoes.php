<?php
// View de avaliações do cliente
// Variáveis esperadas: $usuario, $usuarioNome, $usuarioEmail, $avaliacoes, $total_avaliacoes
?>

<style>
    :root {
        --color-bg-primary: #F8F5F1;
        --color-card-bg: #FFFFFF;
        --color-text-primary: #3D3D3D;
        --color-text-secondary: #8C8C8C;
        --color-accent: #C8B896;
        --color-vintage-brown: #8B7355;
        --color-star: #F5A623;
        --shadow-soft: 0 10px 40px rgba(139, 115, 85, 0.08);
        --radius-main: 30px;
        --radius-sm: 15px;
    }

    body {
        font-family: 'Outfit', 'Inter', sans-serif;
        background: var(--color-bg-primary);
        color: var(--color-text-primary);
        margin: 0;
        padding: 0;
    }

    .avaliacoes-main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px 20px 40px;
    }

    /* Header da página */
    .avaliacoes-header {
        background: white;
        border-radius: var(--radius-main);
        padding: 35px 40px;
        box-shadow: var(--shadow-soft);
        margin-bottom: 30px;
    }

    .avaliacoes-header h1 {
        font-size: 28px;
        font-weight: 800;
        margin: 0 0 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avaliacoes-header h1 i {
        color: var(--color-vintage-brown);
    }

    .avaliacoes-header .subtitle {
        color: var(--color-text-secondary);
        font-size: 15px;
        margin: 0;
    }

    .avaliacoes-count {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #F5EFE6;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        color: var(--color-vintage-brown);
        margin-top: 15px;
    }

    /* Container de avaliações */
    .avaliacoes-container {
        background: white;
        border-radius: var(--radius-main);
        padding: 40px;
        box-shadow: var(--shadow-soft);
    }

    /* Card de avaliação */
    .avaliacao-card {
        border: 1px solid #F0ECE4;
        border-radius: 18px;
        padding: 25px;
        margin-bottom: 20px;
        display: flex;
        gap: 25px;
        transition: all 0.3s ease;
    }

    .avaliacao-card:hover {
        border-color: var(--color-accent);
        box-shadow: 0 5px 20px rgba(139, 115, 85, 0.1);
    }

    .avaliacao-card:last-child {
        margin-bottom: 0;
    }

    /* Imagem do item */
    .avaliacao-item-image {
        width: 100px;
        height: 140px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
    }

    .avaliacao-item-placeholder {
        width: 100px;
        height: 140px;
        background: linear-gradient(135deg, #F5EFE6 0%, #E8DCCF 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .avaliacao-item-placeholder i {
        font-size: 32px;
        color: var(--color-vintage-brown);
        opacity: 0.5;
    }

    /* Conteúdo da avaliação */
    .avaliacao-content {
        flex: 1;
    }

    .avaliacao-item-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--color-vintage-brown);
        margin: 0 0 8px;
        text-decoration: none;
    }

    .avaliacao-item-title:hover {
        text-decoration: underline;
    }

    .avaliacao-date {
        font-size: 13px;
        color: var(--color-text-secondary);
        margin-bottom: 12px;
    }

    .avaliacao-date i {
        margin-right: 5px;
    }

    /* Estrelas */
    .avaliacao-stars {
        display: flex;
        gap: 4px;
        margin-bottom: 12px;
    }

    .avaliacao-stars i {
        font-size: 18px;
        color: #DDD;
    }

    .avaliacao-stars i.filled {
        color: var(--color-star);
    }

    .avaliacao-nota-text {
        font-size: 13px;
        font-weight: 600;
        color: var(--color-text-secondary);
        margin-left: 10px;
    }

    /* Comentário */
    .avaliacao-comentario {
        background: #FDFBF7;
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 14px;
        line-height: 1.6;
        color: var(--color-text-primary);
        border-left: 4px solid var(--color-accent);
    }

    .avaliacao-comentario.empty {
        color: var(--color-text-secondary);
        font-style: italic;
        border-left-color: #E0E0E0;
    }

    /* Estado vazio */
    .avaliacoes-empty {
        text-align: center;
        padding: 60px 20px;
    }

    .avaliacoes-empty i {
        font-size: 64px;
        color: #E0D8CC;
        margin-bottom: 20px;
    }

    .avaliacoes-empty h3 {
        font-size: 22px;
        font-weight: 700;
        color: var(--color-text-primary);
        margin: 0 0 10px;
    }

    .avaliacoes-empty p {
        color: var(--color-text-secondary);
        font-size: 15px;
        max-width: 400px;
        margin: 0 auto 25px;
    }

    .btn-explorar {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        background: var(--color-vintage-brown);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-explorar:hover {
        background: #6B5235;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 115, 85, 0.3);
    }

    /* Botão voltar */
    .btn-voltar {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: white;
        color: var(--color-text-primary);
        border: 1px solid #E0E0E0;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-bottom: 20px;
    }

    .btn-voltar:hover {
        background: #F5EFE6;
        border-color: var(--color-accent);
    }

    @media (max-width: 768px) {
        .avaliacao-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .avaliacao-item-image,
        .avaliacao-item-placeholder {
            width: 80px;
            height: 110px;
        }

        .avaliacoes-header {
            padding: 25px;
        }

        .avaliacoes-container {
            padding: 25px;
        }
    }
</style>

<div class="avaliacoes-main-container">

    <!-- Botão Voltar -->
    <a href="/backend/admin/cliente" class="btn-voltar">
        <i class="fa fa-arrow-left"></i> Voltar ao Perfil
    </a>

    <!-- Header -->
    <div class="avaliacoes-header">
        <h1>
            <i class="fa fa-star"></i>
            Suas Avaliações
        </h1>
        <p class="subtitle">Veja todas as avaliações que você fez para os itens do acervo</p>
        <div class="avaliacoes-count">
            <i class="fa fa-comment"></i>
            <?= $total_avaliacoes ?? 0 ?> avaliação(ões) realizada(s)
        </div>
    </div>

    <!-- Container de Avaliações -->
    <div class="avaliacoes-container">
        <?php if (!empty($avaliacoes)): ?>
            <?php foreach ($avaliacoes as $avaliacao): ?>
                <div class="avaliacao-card">
                    <!-- Imagem do Item -->
                    <?php 
                    $fotoItem = $avaliacao['foto_item'];
                    // Ajuste de caminho para imagens se necessário (servidor embutido)
                    if (!empty($fotoItem) && strpos($fotoItem, '/uploads') === 0 && strpos($fotoItem, '/backend') === false) {
                        $fotoItem = '/backend' . $fotoItem;
                    }
                    ?>
                    <?php if (!empty($fotoItem)): ?>
                        <img src="<?= htmlspecialchars($fotoItem) ?>" 
                             alt="<?= htmlspecialchars($avaliacao['titulo_item'] ?? 'Item') ?>" 
                             class="avaliacao-item-image">
                    <?php else: ?>
                        <div class="avaliacao-item-placeholder">
                            <i class="fa fa-book"></i>
                        </div>
                    <?php endif; ?>

                    <!-- Conteúdo -->
                    <div class="avaliacao-content">
                        <h3 class="avaliacao-item-title">
                            <?= htmlspecialchars($avaliacao['titulo_item'] ?? 'Item #' . $avaliacao['id_item']) ?>
                        </h3>

                        <div class="avaliacao-date">
                            <i class="fa fa-calendar"></i>
                            Avaliado em <?= date('d/m/Y', strtotime($avaliacao['data_avaliacao'])) ?>
                        </div>

                        <!-- Estrelas -->
                        <div class="avaliacao-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fa fa-star <?= $i <= $avaliacao['nota_avaliacao'] ? 'filled' : '' ?>"></i>
                            <?php endfor; ?>
                            <span class="avaliacao-nota-text">
                                <?= $avaliacao['nota_avaliacao'] ?>/5
                            </span>
                        </div>

                        <!-- Comentário -->
                        <?php if (!empty($avaliacao['comentario_avaliacao'])): ?>
                            <div class="avaliacao-comentario">
                                <?= nl2br(htmlspecialchars($avaliacao['comentario_avaliacao'])) ?>
                            </div>
                        <?php else: ?>
                            <div class="avaliacao-comentario empty">
                                <i class="fa fa-quote-left"></i> Nenhum comentário adicionado
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Estado vazio -->
            <div class="avaliacoes-empty">
                <i class="fa fa-star-o"></i>
                <h3>Você ainda não fez nenhuma avaliação</h3>
                <p>Após comprar um item, você poderá avaliá-lo e compartilhar sua opinião com outros leitores.</p>
                <a href="/produtos.html" class="btn-explorar">
                    <i class="fa fa-search"></i> Explorar Acervo
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
