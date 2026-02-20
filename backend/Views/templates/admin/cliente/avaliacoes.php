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
        position: relative;
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
        display: block;
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
        margin-bottom: 15px;
    }

    .avaliacao-comentario.empty {
        color: var(--color-text-secondary);
        font-style: italic;
        border-left-color: #E0E0E0;
    }

    /* Ações (Editar / Excluir) */
    .avaliacao-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn-acao-avaliacao {
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s;
        background: white;
    }

    .btn-acao-editar {
        color: var(--color-vintage-brown);
        border-color: #E0E0E0;
    }

    .btn-acao-editar:hover {
        background: #F5EFE6;
        border-color: var(--color-vintage-brown);
    }

    .btn-acao-excluir {
        color: #D32F2F;
        border-color: #ffebee;
    }

    .btn-acao-excluir:hover {
        background: #ffebee;
        border-color: #D32F2F;
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

    /* ============== MODAL ============== */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(3px);
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        padding: 35px;
        max-width: 480px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease-out;
        position: relative;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-30px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-close {
        position: absolute;
        top: 15px;
        right: 20px;
        background: none;
        border: none;
        font-size: 24px;
        color: #999;
        cursor: pointer;
    }

    .modal-close:hover {
        color: #333;
    }

    /* Estrelas no Modal */
    .star-rating {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
    }

    .star-rating .star {
        font-size: 32px;
        color: #DDD;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .star-rating .star:hover,
    .star-rating .star.active {
        color: #F5A623;
        transform: scale(1.1);
    }

    .star-rating .star.hover {
        color: #F5A623;
    }

    .rating-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--color-text-secondary);
        margin-bottom: 10px;
    }

    .rating-text {
        font-size: 14px;
        font-weight: 600;
        color: var(--color-vintage-brown);
        margin-top: 8px;
        min-height: 20px;
    }

    .modal-textarea {
        width: 100%;
        height: 100px;
        padding: 15px;
        border: 1px solid #E6E0D5;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        resize: none;
        margin-bottom: 8px;
    }

    .modal-textarea:focus {
        outline: none;
        border-color: var(--color-vintage-brown);
    }

    .char-counter {
        font-size: 12px;
        color: var(--color-text-secondary);
        text-align: right;
        margin-bottom: 20px;
    }

    .modal-buttons {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .btn-modal {
        padding: 12px 28px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-modal.primary {
        background: var(--color-vintage-brown);
        color: white;
    }

    .btn-modal.primary:hover {
        background: #6B5235;
    }

    .btn-modal.danger {
        background: #D32F2F;
        color: white;
    }

    .btn-modal.danger:hover {
        background: #B71C1C;
    }

    .btn-modal.secondary {
        background: white;
        color: var(--color-text-primary);
        border: 1px solid #E0E0E0;
    }

    .btn-modal.secondary:hover {
        background: #F5F5F5;
    }

    /* ========================================
       FOTOS EXISTENTES NO MODAL DE EDIÇÃO
       ======================================== */
    .fotos-existentes-container {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 15px;
    }

    .foto-existente-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 10px;
        overflow: visible;
    }

    .foto-existente-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #E6E0D5;
        transition: all 0.2s ease;
    }

    .foto-existente-wrapper:hover img {
        border-color: var(--color-vintage-brown);
        opacity: 0.85;
    }

    .foto-existente-actions {
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 4px;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .foto-existente-wrapper:hover .foto-existente-actions {
        opacity: 1;
    }

    .btn-foto-acao {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 1px solid #ddd;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    .btn-foto-excluir {
        background: #fff;
        color: #D32F2F;
    }

    .btn-foto-excluir:hover {
        background: #D32F2F;
        color: #fff;
        border-color: #D32F2F;
    }

    .btn-foto-substituir {
        background: #fff;
        color: var(--color-vintage-brown);
    }

    .btn-foto-substituir:hover {
        background: var(--color-vintage-brown);
        color: #fff;
        border-color: var(--color-vintage-brown);
    }

    .fotos-existentes-vazio {
        color: var(--color-text-secondary);
        font-size: 13px;
        font-style: italic;
    }

    /* ========================================
       TEMA ESCURO — AVALIAÇÕES
       ======================================== */
    [data-theme="dark"] .avaliacoes-main-container {
        color: #f5f1e8;
    }

    [data-theme="dark"] .foto-existente-wrapper img {
        border-color: rgba(212, 165, 116, 0.2);
    }

    [data-theme="dark"] .btn-foto-acao {
        background: #2a1f14;
        border-color: rgba(212, 165, 116, 0.2);
    }

    [data-theme="dark"] .avaliacoes-header {
        background: #221a10;
    }

    [data-theme="dark"] .avaliacoes-header h1 {
        color: #f5f1e8;
    }

    [data-theme="dark"] .avaliacoes-container {
        background: #221a10;
    }

    [data-theme="dark"] .avaliacoes-container h2 {
        color: #f5f1e8;
    }

    [data-theme="dark"] .avaliacao-card {
        border-color: rgba(212, 165, 116, 0.1);
        background: #2a1f14;
    }

    [data-theme="dark"] .avaliacao-card:hover {
        border-color: rgba(212, 165, 116, 0.2);
    }

    [data-theme="dark"] .avaliacao-item-title {
        color: #f5f1e8;
    }

    [data-theme="dark"] .avaliacao-item-placeholder {
        background: #33261a;
        color: #a89880;
    }

    [data-theme="dark"] .avaliacao-comentario {
        background: #33261a;
        color: #d4c5a9;
    }

    [data-theme="dark"] .avaliacao-data {
        color: #a89880;
    }

    [data-theme="dark"] .btn-acao-avaliacao {
        background: #33261a;
        color: #d4c5a9;
        border-color: rgba(212, 165, 116, 0.2);
    }

    [data-theme="dark"] .btn-acao-avaliacao:hover {
        background: #d4a574;
        color: #1a1209;
    }

    [data-theme="dark"] .btn-voltar {
        color: #a89880;
    }

    [data-theme="dark"] .btn-voltar:hover {
        color: #d4a574;
    }

    [data-theme="dark"] .modal-content {
        background: #221a10;
        color: #f5f1e8;
    }

    [data-theme="dark"] .modal-content textarea {
        background: #33261a;
        color: #f5f1e8;
        border-color: rgba(212, 165, 116, 0.15);
    }

    [data-theme="dark"] .empty-state {
        color: #a89880;
        background: #2a1f14;
    }

    /* ========================================
       RESPONSIVO
       ======================================== */
    @media (max-width: 768px) {
        .avaliacoes-main-container {
            padding: 15px 10px 30px;
        }

        .avaliacao-card {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .avaliacao-item-image,
        .avaliacao-item-placeholder {
            width: 80px;
            height: 110px;
        }

        .avaliacoes-header {
            padding: 25px 20px;
            border-radius: 20px;
        }

        .avaliacoes-header h1 {
            font-size: 22px;
        }

        .avaliacoes-container {
            padding: 20px 15px;
            border-radius: 20px;
        }

        .avaliacao-item-title {
            font-size: 16px;
        }

        .avaliacao-comentario {
            padding: 12px 15px;
            font-size: 13px;
        }

        .avaliacao-actions {
            flex-wrap: wrap;
            width: 100%;
        }

        .btn-acao-avaliacao {
            flex: 1;
            min-width: 120px;
            text-align: center;
        }

        .btn-voltar {
            font-size: 12px;
            padding: 8px 16px;
        }

        /* Modal */
        .modal-content {
            padding: 25px 20px;
            width: 95%;
            border-radius: 16px;
        }

        .modal-buttons {
            flex-direction: column;
        }

        .btn-modal {
            width: 100%;
            text-align: center;
        }

        .star-rating .star {
            font-size: 28px;
        }

        .avaliacao-photos img {
            width: 80px !important;
            height: 80px !important;
        }
    }

    @media (max-width: 480px) {
        .avaliacoes-header h1 {
            font-size: 20px;
            gap: 8px;
        }

        .avaliacao-card {
            padding: 15px;
        }

        .avaliacao-item-image,
        .avaliacao-item-placeholder {
            width: 70px;
            height: 95px;
        }

        .avaliacao-stars i {
            font-size: 16px;
        }

        .btn-acao-avaliacao {
            font-size: 11px;
            padding: 6px 12px;
        }

        .avaliacao-photos img {
            width: 60px !important;
            height: 60px !important;
        }
    }
</style>

<?php
// Monta mapa JSON de fotos existentes por avaliação para uso no JavaScript
// Cada avaliação pode ter múltiplas fotos na tbl_avaliacao_fotos
$fotosMap = [];
if (!empty($avaliacoes)) {
    $avaliacaoModel = new \Sebo\Alfarrabio\Models\Avaliacao(\Sebo\Alfarrabio\Database\Database::getInstance());
    foreach ($avaliacoes as $av) {
        $fotosMap[$av['id_avaliacao']] = $avaliacaoModel->buscarFotosAvaliacao($av['id_avaliacao']);
    }
}
?>
<script>
    // Mapa de fotos existentes indexado por id_avaliacao
    // Cada entrada é um array de {id_foto, caminho_foto}
    const fotosExistentesMap = <?= json_encode($fotosMap, JSON_UNESCAPED_UNICODE) ?>;
</script>

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
                <div class="avaliacao-card" id="card-avaliacao-<?= $avaliacao['id_avaliacao'] ?>">
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
                            alt="<?= htmlspecialchars($avaliacao['titulo_item'] ?? 'Item') ?>" class="avaliacao-item-image">
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

                        <!-- Fotos da Avaliação -->
                        <?php
                        $fotos = [];
                        if (!empty($avaliacao['fotos_urls'])) {
                            $fotos = explode(',', $avaliacao['fotos_urls']);
                        } elseif (!empty($avaliacao['foto_principal'])) {
                            $fotos[] = $avaliacao['foto_principal'];
                        }
                        ?>

                        <?php if (!empty($fotos)): ?>
                            <div class="avaliacao-photos" style="margin-top: 15px; display: flex; gap: 10px; flex-wrap: wrap;">
                                <?php foreach ($fotos as $foto): ?>
                                    <div class="avaliacao-user-photo">
                                        <img src="<?= htmlspecialchars($foto) ?>" alt="Foto da avaliação"
                                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; cursor: pointer;"
                                            onclick="window.open(this.src, '_blank')">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Botões de Ação -->
                        <div class="avaliacao-actions">
                            <button class="btn-acao-avaliacao btn-acao-editar" onclick="abrirModalEdicao(
                                        <?= $avaliacao['id_avaliacao'] ?>, 
                                        <?= $avaliacao['nota_avaliacao'] ?>, 
                                        '<?= addslashes($avaliacao['comentario_avaliacao'] ?? '') ?>',
                                        '<?= addslashes($avaliacao['titulo_item'] ?? '') ?>'
                                    )">
                                <i class="fa fa-edit"></i> Editar Avaliação
                            </button>
                            <button class="btn-acao-avaliacao btn-acao-excluir"
                                onclick="abrirModalExclusao(<?= $avaliacao['id_avaliacao'] ?>)">
                                <i class="fa fa-trash"></i> Excluir Avaliação
                            </button>
                        </div>
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

<!-- MODAL DE EDIÇÃO -->
<div class="modal-overlay" id="modalEdicao">
    <div class="modal-content">
        <button class="modal-close" onclick="fecharModalEdicao()">&times;</button>

        <h3 style="margin-top:0; font-size:20px; font-weight:700;">Editar Avaliação</h3>
        <p style="color:#888; font-size:14px; margin-bottom:20px;" id="modalEdicaoTituloItem">Item</p>

        <div class="rating-label">Sua nota</div>
        <div class="star-rating" id="starRatingEdicao">
            <i class="fa fa-star star" data-rating="1"></i>
            <i class="fa fa-star star" data-rating="2"></i>
            <i class="fa fa-star star" data-rating="3"></i>
            <i class="fa fa-star star" data-rating="4"></i>
            <i class="fa fa-star star" data-rating="5"></i>
        </div>
        <div class="rating-text" id="ratingTextEdicao"></div>

        <div class="rating-label" style="margin-top:15px;">Seu comentário</div>
        <textarea class="modal-textarea" id="comentarioEdicao" maxlength="500"></textarea>
        <div class="char-counter"><span id="charCountEdicao">0</span>/500</div>

        <!-- Seção de fotos existentes (populada via JS ao abrir o modal) -->
        <div class="rating-label" style="margin-top: 15px;">Fotos atuais</div>
        <div id="fotosExistentesContainer" class="fotos-existentes-container">
            <!-- Thumbnails das fotos existentes com botões de excluir/substituir -->
        </div>

        <div class="rating-label" style="margin-top: 15px;">Adicionar novas fotos (opcional) - Máx 5</div>
        <div class="file-upload-container">
            <input type="file" id="fotoEdicao" accept="image/*" multiple onchange="handleFileSelectEdicao(this)">
            <!-- Input oculto para substituição individual de foto -->
            <input type="file" id="fotoSubstituir" accept="image/*" style="display:none" onchange="handleSubstituirFoto(this)">
            <div id="previewContainerEdicao" style="margin-top: 10px; display: none; gap: 10px; flex-wrap: wrap;">
                <!-- Thumbnails -->
            </div>
        </div>

        <div class="modal-buttons">
            <button class="btn-modal secondary" onclick="fecharModalEdicao()">Cancelar</button>
            <button class="btn-modal primary" id="btnSalvarEdicao" onclick="salvarEdicao()">Salvar Alterações</button>
        </div>
    </div>
</div>

<!-- MODAL DE EXCLUSÃO -->
<div class="modal-overlay" id="modalExclusao">
    <div class="modal-content">
        <button class="modal-close" onclick="fecharModalExclusao()">&times;</button>

        <div style="text-align:center;">
            <i class="fa fa-exclamation-circle" style="font-size:40px; color:#D32F2F; margin-bottom:15px;"></i>
            <h3 style="margin:0 0 10px; font-size:20px;">Excluir Avaliação?</h3>
            <p style="color:#666; font-size:14px; margin-bottom:25px;">
                Tem certeza que deseja excluir esta avaliação? Essa ação não pode ser desfeita.
            </p>

            <div class="modal-buttons" style="justify-content:center;">
                <button class="btn-modal secondary" onclick="fecharModalExclusao()">Cancelar</button>
                <button class="btn-modal danger" id="btnConfirmarExclusao" onclick="confirmarExclusao()">Sim,
                    Excluir</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Estado Global
    let currentEdicaoId = null;
    let currentEdicaoRating = 0;
    let currentExclusaoId = null;
    // ID da foto que está sendo substituída (para o fluxo de substituição)
    let substituindoFotoId = null;

    const ratingTexts = {
        1: 'Péssimo',
        2: 'Ruim',
        3: 'Regular',
        4: 'Bom',
        5: 'Excelente!'
    };

    let selectedFilesEdicao = [];


    function handleFileSelectEdicao(input) {
        const files = Array.from(input.files);
        const MAX_SIZE_MB = 5; // 5MB por imagem
        const MAX_SIZE_BYTES = MAX_SIZE_MB * 1024 * 1024;

        // Calcula total considerando fotos existentes + novas já selecionadas
        const fotosExistentes = fotosExistentesMap[currentEdicaoId] || [];
        const totalAtual = fotosExistentes.length + selectedFilesEdicao.length;
        if (totalAtual + files.length > 5) {
            alert(`Você pode ter no máximo 5 imagens. Atualmente há ${totalAtual} foto(s).`);
            return;
        }

        // Valida cada arquivo
        for (let file of files) {
            // Verifica tamanho
            if (file.size > MAX_SIZE_BYTES) {
                const tamanhoMB = (file.size / 1024 / 1024).toFixed(1);
                alert(`A imagem "${file.name}" tem ${tamanhoMB}MB e excede o limite de ${MAX_SIZE_MB}MB. Por favor, envie uma imagem menor.`);
                return;
            }

            // Verifica tipo
            if (file.type.match('image.*')) {
                selectedFilesEdicao.push(file);
            } else {
                alert(`O arquivo "${file.name}" não é uma imagem válida.`);
                return;
            }
        }

        renderPreviewEdicao();
        input.value = '';
    }

    function renderPreviewEdicao() {
        const container = document.getElementById('previewContainerEdicao');
        container.innerHTML = '';

        if (selectedFilesEdicao.length === 0) {
            container.style.display = 'none';
            return;
        }

        container.style.display = 'flex';

        selectedFilesEdicao.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const div = document.createElement('div');
                div.style.position = 'relative';
                div.style.width = '100px';
                div.style.height = '100px';

                div.innerHTML = `
                <img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                <button onclick="removerImagemEdicao(${index})" style="position: absolute; top: -5px; right: -5px; background: white; border-radius: 50%; border: 1px solid red; color: red; cursor: pointer; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                    <i class="fa fa-times"></i>
                </button>
            `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }

    function removerImagemEdicao(index) {
        selectedFilesEdicao.splice(index, 1);
        renderPreviewEdicao();
    }

    // =======================
    // FOTOS EXISTENTES
    // =======================

    /**
     * Renderiza as fotos existentes da avaliação no modal de edição.
     * Cada foto mostra botões de "Excluir" e "Substituir" ao passar o mouse.
     */
    function renderFotosExistentes(idAvaliacao) {
        const container = document.getElementById('fotosExistentesContainer');
        const fotos = fotosExistentesMap[idAvaliacao] || [];

        container.innerHTML = '';

        if (fotos.length === 0) {
            container.innerHTML = '<span class="fotos-existentes-vazio"><i class="fa fa-image"></i> Nenhuma foto anexada</span>';
            return;
        }

        fotos.forEach(foto => {
            const wrapper = document.createElement('div');
            wrapper.className = 'foto-existente-wrapper';
            wrapper.id = 'foto-wrapper-' + foto.id_foto;

            wrapper.innerHTML = `
                <img src="${foto.caminho_foto}" alt="Foto da avaliação" title="Clique para ampliar" onclick="window.open('${foto.caminho_foto}', '_blank')">
                <div class="foto-existente-actions">
                    <button class="btn-foto-acao btn-foto-excluir" title="Excluir foto" onclick="excluirFotoExistente(${foto.id_foto}, ${idAvaliacao})">
                        <i class="fa fa-trash"></i>
                    </button>
                    <button class="btn-foto-acao btn-foto-substituir" title="Substituir foto" onclick="iniciarSubstituirFoto(${foto.id_foto}, ${idAvaliacao})">
                        <i class="fa fa-refresh"></i>
                    </button>
                </div>
            `;
            container.appendChild(wrapper);
        });
    }

    /**
     * Exclui uma foto existente da avaliação via AJAX.
     * Pede confirmação antes de excluir.
     */
    async function excluirFotoExistente(idFoto, idAvaliacao) {
        if (!confirm('Tem certeza que deseja excluir esta foto? A ação não pode ser desfeita.')) {
            return;
        }

        const wrapper = document.getElementById('foto-wrapper-' + idFoto);
        if (wrapper) {
            wrapper.style.opacity = '0.5';
            wrapper.style.pointerEvents = 'none';
        }

        try {
            const formData = new FormData();
            formData.append('id_foto', idFoto);
            formData.append('id_avaliacao', idAvaliacao);

            const resp = await fetch('/backend/api/cliente/avaliacao/foto/excluir', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            const data = await resp.json();

            if (data.success) {
                // Remove a foto do mapa local
                if (fotosExistentesMap[idAvaliacao]) {
                    fotosExistentesMap[idAvaliacao] = fotosExistentesMap[idAvaliacao].filter(f => f.id_foto !== idFoto);
                }
                // Re-renderiza as fotos existentes no modal
                renderFotosExistentes(idAvaliacao);
                // Atualiza fotos no card da avaliação
                atualizarFotosCard(idAvaliacao);
                console.log('[Excluir Foto] Sucesso:', data.message);
            } else {
                alert(data.message || 'Erro ao excluir foto.');
                if (wrapper) {
                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';
                }
            }
        } catch (e) {
            console.error('[Excluir Foto] Erro:', e);
            alert('Erro de conexão ao excluir foto.');
            if (wrapper) {
                wrapper.style.opacity = '1';
                wrapper.style.pointerEvents = 'auto';
            }
        }
    }

    /**
     * Inicia o fluxo de substituição de foto:
     * 1) Abre o seletor de arquivo
     * 2) Ao selecionar, exclui a foto antiga via AJAX
     * 3) A nova foto será enviada junto com salvarEdicao()
     */
    function iniciarSubstituirFoto(idFoto, idAvaliacao) {
        substituindoFotoId = idFoto;
        const fileInput = document.getElementById('fotoSubstituir');
        fileInput.value = '';
        fileInput.click();
    }

    /**
     * Callback do input de substituição de foto.
     * Exclui a foto antiga e adiciona a nova ao array de seleção.
     */
    async function handleSubstituirFoto(input) {
        if (!input.files || input.files.length === 0 || !substituindoFotoId) return;

        const file = input.files[0];
        const MAX_SIZE_BYTES = 5 * 1024 * 1024;

        if (file.size > MAX_SIZE_BYTES) {
            alert(`A imagem excede o limite de 5MB.`);
            return;
        }

        if (!file.type.match('image.*')) {
            alert('Selecione um arquivo de imagem válido.');
            return;
        }

        const idFoto = substituindoFotoId;
        const idAvaliacao = currentEdicaoId;
        substituindoFotoId = null;

        // Exclui a foto antiga via AJAX
        const wrapper = document.getElementById('foto-wrapper-' + idFoto);
        if (wrapper) {
            wrapper.style.opacity = '0.5';
            wrapper.style.pointerEvents = 'none';
        }

        try {
            const formData = new FormData();
            formData.append('id_foto', idFoto);
            formData.append('id_avaliacao', idAvaliacao);

            const resp = await fetch('/backend/api/cliente/avaliacao/foto/excluir', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            const data = await resp.json();

            if (data.success) {
                // Remove do mapa local
                if (fotosExistentesMap[idAvaliacao]) {
                    fotosExistentesMap[idAvaliacao] = fotosExistentesMap[idAvaliacao].filter(f => f.id_foto !== idFoto);
                }
                renderFotosExistentes(idAvaliacao);

                // Adiciona a nova foto ao array de novas fotos
                selectedFilesEdicao.push(file);
                renderPreviewEdicao();

                console.log('[Substituir Foto] Foto antiga excluída, nova adicionada à fila de upload.');
            } else {
                alert(data.message || 'Erro ao substituir foto.');
                if (wrapper) {
                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';
                }
            }
        } catch (e) {
            console.error('[Substituir Foto] Erro:', e);
            alert('Erro de conexão ao substituir foto.');
            if (wrapper) {
                wrapper.style.opacity = '1';
                wrapper.style.pointerEvents = 'auto';
            }
        }
    }

    /**
     * Atualiza a seção de fotos no card da avaliação após exclusão.
     */
    function atualizarFotosCard(idAvaliacao) {
        const card = document.getElementById('card-avaliacao-' + idAvaliacao);
        if (!card) return;

        const fotosContainer = card.querySelector('.avaliacao-photos');
        const fotos = fotosExistentesMap[idAvaliacao] || [];

        if (fotos.length === 0) {
            // Remove o container de fotos se não há mais fotos
            if (fotosContainer) fotosContainer.remove();
            return;
        }

        // Atualiza as fotos no card
        if (fotosContainer) {
            fotosContainer.innerHTML = '';
            fotos.forEach(foto => {
                const div = document.createElement('div');
                div.className = 'avaliacao-user-photo';
                div.innerHTML = `<img src="${foto.caminho_foto}" alt="Foto da avaliação" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; cursor: pointer;" onclick="window.open(this.src, '_blank')">`;
                fotosContainer.appendChild(div);
            });
        }
    }

    // =======================
    // LÓGICA DE EDIÇÃO
    // =======================

    function abrirModalEdicao(id, nota, comentario, tituloItem) {
        currentEdicaoId = id;
        currentEdicaoRating = nota;

        document.getElementById('modalEdicaoTituloItem').textContent = tituloItem;
        document.getElementById('comentarioEdicao').value = comentario;
        document.getElementById('charCountEdicao').textContent = comentario.length;

        // Reset inputs de nova foto
        selectedFilesEdicao = [];
        document.getElementById('fotoEdicao').value = '';
        renderPreviewEdicao();

        // Renderiza fotos existentes da avaliação no modal
        renderFotosExistentes(id);

        updateStars(nota);
        document.getElementById('modalEdicao').classList.add('active');
    }

    function fecharModalEdicao() {
        document.getElementById('modalEdicao').classList.remove('active');
        currentEdicaoId = null;
        substituindoFotoId = null;
    }

    function updateStars(rating) {
        currentEdicaoRating = rating;
        const stars = document.querySelectorAll('#starRatingEdicao .star');
        stars.forEach((s, i) => {
            s.classList.toggle('active', i < rating);
        });
        document.getElementById('ratingTextEdicao').textContent = ratingTexts[rating] || '';
    }

    // Event Listeners para Estrelas
    document.querySelectorAll('#starRatingEdicao .star').forEach(star => {
        star.addEventListener('click', function () {
            updateStars(parseInt(this.dataset.rating));
        });

        star.addEventListener('mouseenter', function () {
            const rating = parseInt(this.dataset.rating);
            document.querySelectorAll('#starRatingEdicao .star').forEach((s, i) => {
                s.classList.toggle('hover', i < rating);
            });
        });

        star.addEventListener('mouseleave', function () {
            document.querySelectorAll('#starRatingEdicao .star').forEach(s => s.classList.remove('hover'));
        });
    });

    // Contador Caracteres
    document.getElementById('comentarioEdicao').addEventListener('input', function () {
        document.getElementById('charCountEdicao').textContent = this.value.length;
    });

    async function salvarEdicao() {
        if (!currentEdicaoId || currentEdicaoRating < 1) return;

        const btn = document.getElementById('btnSalvarEdicao');
        const comentario = document.getElementById('comentarioEdicao').value;

        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Salvando...';

        try {
            const formData = new FormData();
            formData.append('id_avaliacao', currentEdicaoId);
            formData.append('nota', currentEdicaoRating);
            formData.append('comentario', comentario);

            selectedFilesEdicao.forEach((file, index) => {
                formData.append('fotos_avaliacao[]', file);
            });

            console.log('[Editar] Enviando:', { id: currentEdicaoId, nota: currentEdicaoRating, comentario });

            const resp = await fetch('/backend/api/cliente/avaliacao/atualizar', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            console.log('[Editar] Status HTTP:', resp.status);
            const data = await resp.json();
            console.log('[Editar] Resposta:', data);

            if (data.success) {
                // Atualiza o card no DOM em tempo real
                const card = document.getElementById('card-avaliacao-' + currentEdicaoId);
                if (card) {
                    // Atualiza estrelas
                    const stars = card.querySelectorAll('.avaliacao-stars i.fa-star');
                    stars.forEach((s, i) => {
                        s.classList.toggle('filled', i < currentEdicaoRating);
                    });
                    // Atualiza texto da nota
                    const notaText = card.querySelector('.avaliacao-nota-text');
                    if (notaText) notaText.textContent = currentEdicaoRating + '/5';
                    // Atualiza comentário
                    const comentarioDiv = card.querySelector('.avaliacao-comentario');
                    if (comentarioDiv) {
                        if (comentario && comentario.trim()) {
                            comentarioDiv.className = 'avaliacao-comentario';
                            comentarioDiv.innerHTML = comentario.replace(/\n/g, '<br>');
                        } else {
                            comentarioDiv.className = 'avaliacao-comentario empty';
                            comentarioDiv.innerHTML = '<i class="fa fa-quote-left"></i> Nenhum comentário adicionado';
                        }
                    }
                }
                fecharModalEdicao();
                // Recarrega a página para refletir fotos novas adicionadas/removidas
                if (selectedFilesEdicao.length > 0) {
                    alert('Avaliação atualizada com sucesso!');
                    location.reload();
                } else {
                    alert('Avaliação atualizada com sucesso!');
                }
            } else {
                alert(data.message || 'Erro ao atualizar.');
                console.error('[Editar] Falha:', data.message);
            }
        } catch (e) {
            console.error('[Editar] Erro de conexão:', e);
            alert('Erro de conexão. Verifique se o servidor está rodando.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Salvar Alterações';
        }
    }

    // =======================
    // LÓGICA DE EXCLUSÃO
    // =======================

    function abrirModalExclusao(id) {
        currentExclusaoId = id;
        document.getElementById('modalExclusao').classList.add('active');
    }

    function fecharModalExclusao() {
        document.getElementById('modalExclusao').classList.remove('active');
        currentExclusaoId = null;
    }

    async function confirmarExclusao() {
        if (!currentExclusaoId) return;

        const btn = document.getElementById('btnConfirmarExclusao');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Excluindo...';

        try {
            const formData = new FormData();
            formData.append('id_avaliacao', currentExclusaoId);

            console.log('[Excluir] Enviando id:', currentExclusaoId);

            const resp = await fetch('/backend/api/cliente/avaliacao/deletar', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin'
            });

            console.log('[Excluir] Status HTTP:', resp.status);
            const data = await resp.json();
            console.log('[Excluir] Resposta:', data);

            if (data.success) {
                // Remove o card da UI sem recarregar
                const card = document.getElementById('card-avaliacao-' + currentExclusaoId);
                if (card) {
                    card.style.transition = 'opacity 0.3s, transform 0.3s';
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(20px)';
                    setTimeout(() => card.remove(), 300);
                }

                fecharModalExclusao();

                // Atualiza o contador de avaliações
                const countEl = document.querySelector('.avaliacoes-count');
                if (countEl) {
                    const remaining = document.querySelectorAll('.avaliacao-card').length - 1;
                    countEl.innerHTML = '<i class="fa fa-comment"></i> ' + remaining + ' avaliação(ões) realizada(s)';
                }

                // Se não houver mais cards, recarrega para mostrar estado vazio
                setTimeout(() => {
                    const cards = document.querySelectorAll('.avaliacao-card');
                    if (cards.length === 0) location.reload();
                }, 400);

            } else {
                alert(data.message || 'Erro ao excluir.');
                console.error('[Excluir] Falha:', data.message);
            }
        } catch (e) {
            console.error('[Excluir] Erro de conexão:', e);
            alert('Erro de conexão. Verifique se o servidor está rodando.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = 'Sim, Excluir';
        }
    }

    // Fechar modais ao clicar fora
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });
</script>