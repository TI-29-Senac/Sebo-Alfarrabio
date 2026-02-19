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
       TEMA ESCURO — AVALIAÇÕES
       ======================================== */
    [data-theme="dark"] .avaliacoes-main-container {
        color: #f5f1e8;
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

<<<<<<< HEAD
=======
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

>>>>>>> 88f33ccca9a60de74d6c207e9a47fee21676363c
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
<<<<<<< HEAD
        
=======

        <div class="rating-label" style="margin-top: 15px;">Adicionar novas fotos (opcional) - Máx 5</div>
        <div class="file-upload-container">
            <input type="file" id="fotoEdicao" accept="image/*" multiple onchange="handleFileSelectEdicao(this)">
            <div id="previewContainerEdicao" style="margin-top: 10px; display: none; gap: 10px; flex-wrap: wrap;">
                <!-- Thumbnails -->
            </div>
        </div>

>>>>>>> 88f33ccca9a60de74d6c207e9a47fee21676363c
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

    const ratingTexts = {
        1: 'Péssimo',
        2: 'Ruim',
        3: 'Regular',
        4: 'Bom',
        5: 'Excelente!'
    };

<<<<<<< HEAD
// =======================
// LÓGICA DE EDIÇÃO
// =======================

function abrirModalEdicao(id, nota, comentario, tituloItem) {
    currentEdicaoId = id;
    currentEdicaoRating = nota;
    
    document.getElementById('modalEdicaoTituloItem').textContent = tituloItem;
    document.getElementById('comentarioEdicao').value = comentario;
    document.getElementById('charCountEdicao').textContent = comentario.length;
    
    updateStars(nota);
    document.getElementById('modalEdicao').classList.add('active');
}
=======
    let selectedFilesEdicao = [];


    function handleFileSelectEdicao(input) {
        const files = Array.from(input.files);
        const MAX_SIZE_MB = 5; // 5MB por imagem
        const MAX_SIZE_BYTES = MAX_SIZE_MB * 1024 * 1024;

        if (selectedFilesEdicao.length + files.length > 5) {
            alert("Você pode selecionar no máximo 5 imagens.");
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
    // LÓGICA DE EDIÇÃO
    // =======================

    function abrirModalEdicao(id, nota, comentario, tituloItem) {
        currentEdicaoId = id;
        currentEdicaoRating = nota;

        document.getElementById('modalEdicaoTituloItem').textContent = tituloItem;
        document.getElementById('comentarioEdicao').value = comentario;
        document.getElementById('charCountEdicao').textContent = comentario.length;
>>>>>>> 88f33ccca9a60de74d6c207e9a47fee21676363c

        // Reset inputs de nova foto
        selectedFilesEdicao = [];
        document.getElementById('fotoEdicao').value = '';
        renderPreviewEdicao();

        updateStars(nota);
        document.getElementById('modalEdicao').classList.add('active');
    }

    function fecharModalEdicao() {
        document.getElementById('modalEdicao').classList.remove('active');
        currentEdicaoId = null;
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

<<<<<<< HEAD
async function salvarEdicao() {
    if(!currentEdicaoId || currentEdicaoRating < 1) return;
    
    const btn = document.getElementById('btnSalvarEdicao');
    const comentario = document.getElementById('comentarioEdicao').value;
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Salvando...';
    
    try {
        const formData = new FormData();
        formData.append('id_avaliacao', currentEdicaoId);
        formData.append('nota', currentEdicaoRating);
        formData.append('comentario', comentario);
        
        console.log('[Editar] Enviando:', {id: currentEdicaoId, nota: currentEdicaoRating, comentario});
        
        const resp = await fetch('/backend/api/cliente/avaliacao/atualizar', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        });
        
        console.log('[Editar] Status HTTP:', resp.status);
        const data = await resp.json();
        console.log('[Editar] Resposta:', data);
        
        if(data.success) {
            // Atualiza o card no DOM em tempo real
            const card = document.getElementById('card-avaliacao-' + currentEdicaoId);
            if(card) {
                // Atualiza estrelas
                const stars = card.querySelectorAll('.avaliacao-stars i.fa-star');
                stars.forEach((s, i) => {
                    s.classList.toggle('filled', i < currentEdicaoRating);
                });
                // Atualiza texto da nota
                const notaText = card.querySelector('.avaliacao-nota-text');
                if(notaText) notaText.textContent = currentEdicaoRating + '/5';
                // Atualiza comentário
                const comentarioDiv = card.querySelector('.avaliacao-comentario');
                if(comentarioDiv) {
                    if(comentario && comentario.trim()) {
                        comentarioDiv.className = 'avaliacao-comentario';
                        comentarioDiv.innerHTML = comentario.replace(/\n/g, '<br>');
                    } else {
                        comentarioDiv.className = 'avaliacao-comentario empty';
                        comentarioDiv.innerHTML = '<i class="fa fa-quote-left"></i> Nenhum comentário adicionado';
=======
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
>>>>>>> 88f33ccca9a60de74d6c207e9a47fee21676363c
                    }
                }
                fecharModalEdicao();
                alert('Avaliação atualizada com sucesso!');
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