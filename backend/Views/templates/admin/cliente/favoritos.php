<?php
// View de favoritos do cliente
// Variáveis esperadas: $usuario, $usuarioNome, $usuarioEmail, $favoritos, $total_favoritos
?>

<style>
    :root {
        --color-bg-primary: #F8F5F1;
        --color-card-bg: #FFFFFF;
        --color-text-primary: #3D3D3D;
        --color-text-secondary: #8C8C8C;
        --color-accent: #C8B896;
        --color-vintage-brown: #8B7355;
        --color-vintage-red: #D46A6A;
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

    .favoritos-main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px 20px 40px;
    }

    /* Header da página */
    .favoritos-header {
        background: white;
        border-radius: var(--radius-main);
        padding: 35px 40px;
        box-shadow: var(--shadow-soft);
        margin-bottom: 30px;
    }

    .favoritos-header h1 {
        font-size: 28px;
        font-weight: 800;
        margin: 0 0 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .favoritos-header h1 i {
        color: var(--color-vintage-red);
    }

    .favoritos-header .subtitle {
        color: var(--color-text-secondary);
        font-size: 15px;
        margin: 0;
    }

    .favoritos-count {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #FFEEF0;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        color: var(--color-vintage-red);
        margin-top: 15px;
    }

    /* Container de favoritos */
    .favoritos-container {
        background: white;
        border-radius: var(--radius-main);
        padding: 40px;
        box-shadow: var(--shadow-soft);
    }

    /* Grid de favoritos */
    .favoritos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
    }

    /* Card de favorito */
    .favorito-card {
        border: 1px solid #F0ECE4;
        border-radius: 18px;
        padding: 0;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        background: white;
    }

    .favorito-card:hover {
        border-color: var(--color-accent);
        box-shadow: 0 8px 25px rgba(139, 115, 85, 0.15);
        transform: translateY(-5px);
    }

    /* Imagem do item */
    .favorito-image-wrapper {
        position: relative;
        width: 100%;
        height: 320px;
        overflow: hidden;
        background: linear-gradient(135deg, #F5EFE6 0%, #E8DCCF 100%);
    }

    .favorito-item-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .favorito-card:hover .favorito-item-image {
        transform: scale(1.05);
    }

    .favorito-item-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .favorito-item-placeholder i {
        font-size: 64px;
        color: var(--color-vintage-brown);
        opacity: 0.3;
    }

    /* Botão remover */
    .btn-remove-favorito {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.95);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        z-index: 10;
    }

    .btn-remove-favorito i {
        color: var(--color-vintage-red);
        font-size: 18px;
    }

    .btn-remove-favorito:hover {
        background: var(--color-vintage-red);
        transform: scale(1.1) rotate(90deg);
    }

    .btn-remove-favorito:hover i {
        color: white;
    }

    /* Badge de disponibilidade */
    .favorito-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.95);
        color: var(--color-vintage-brown);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .favorito-badge.disponivel {
        background: #D4EDDA;
        color: #155724;
    }

    .favorito-badge.indisponivel {
        background: #F8D7DA;
        color: #721C24;
    }

    /* Conteúdo do card */
    .favorito-content {
        padding: 20px;
    }

    .favorito-item-title {
        font-size: 17px;
        font-weight: 700;
        color: var(--color-vintage-brown);
        margin: 0 0 8px;
        text-decoration: none;
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .favorito-item-title:hover {
        text-decoration: underline;
        color: var(--color-vintage-red);
    }

    .favorito-item-autor {
        font-size: 14px;
        color: var(--color-text-secondary);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .favorito-item-autor i {
        font-size: 12px;
    }

    .favorito-item-preco {
        font-size: 22px;
        font-weight: 800;
        color: var(--color-vintage-brown);
        margin-bottom: 15px;
    }

    .favorito-item-preco small {
        font-size: 14px;
        font-weight: 600;
        color: var(--color-text-secondary);
    }

    .favorito-date {
        font-size: 12px;
        color: var(--color-text-secondary);
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 15px;
    }

    .favorito-date i {
        font-size: 11px;
    }

    /* Botões de ação */
    .favorito-actions {
        display: flex;
        gap: 10px;
    }

    .btn-favorito-action {
        flex: 1;
        padding: 10px 15px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-favorito-action.primary {
        background: var(--color-vintage-brown);
        color: white;
    }

    .btn-favorito-action.primary:hover {
        background: #6B5235;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 115, 85, 0.3);
    }

    .btn-favorito-action.secondary {
        background: white;
        color: var(--color-text-primary);
        border: 1px solid #E0E0E0;
    }

    .btn-favorito-action.secondary:hover {
        background: #F5EFE6;
        border-color: var(--color-accent);
    }

    /* Estado vazio */
    .favoritos-empty {
        text-align: center;
        padding: 80px 20px;
    }

    .favoritos-empty i {
        font-size: 80px;
        color: #E0D8CC;
        margin-bottom: 25px;
        animation: heartbeat 2s ease-in-out infinite;
    }

    @keyframes heartbeat {
        0%, 100% { transform: scale(1); }
        25% { transform: scale(1.05); }
        50% { transform: scale(1); }
    }

    .favoritos-empty h3 {
        font-size: 24px;
        font-weight: 700;
        color: var(--color-text-primary);
        margin: 0 0 15px;
    }

    .favoritos-empty p {
        color: var(--color-text-secondary);
        font-size: 16px;
        max-width: 500px;
        margin: 0 auto 30px;
        line-height: 1.6;
    }

    .btn-explorar {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        background: var(--color-vintage-brown);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-explorar:hover {
        background: #6B5235;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(139, 115, 85, 0.4);
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

    /* Modal de confirmação */
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
        max-width: 420px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease-out;
        text-align: center;
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

    .modal-content i {
        font-size: 50px;
        color: var(--color-vintage-red);
        margin-bottom: 20px;
    }

    .modal-content h3 {
        font-size: 20px;
        font-weight: 700;
        color: var(--color-text-primary);
        margin: 0 0 10px;
    }

    .modal-content p {
        color: var(--color-text-secondary);
        font-size: 14px;
        margin: 0 0 25px;
    }

    .modal-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
    }

    .btn-modal {
        padding: 12px 28px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-modal.danger {
        background: var(--color-vintage-red);
        color: white;
    }

    .btn-modal.danger:hover {
        background: #B54545;
        transform: translateY(-2px);
    }

    .btn-modal.secondary {
        background: white;
        color: var(--color-text-primary);
        border: 1px solid #E0E0E0;
    }

    .btn-modal.secondary:hover {
        background: #F5F5F5;
    }

    @media (max-width: 768px) {
        .favoritos-grid {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .favorito-image-wrapper {
            height: 260px;
        }

        .favoritos-header {
            padding: 25px;
        }

        .favoritos-container {
            padding: 25px;
        }

        .favoritos-empty {
            padding: 60px 20px;
        }
    }
</style>

<div class="favoritos-main-container">

    <!-- Botão Voltar -->
    <a href="/backend/admin/cliente" class="btn-voltar">
        <i class="fa fa-arrow-left"></i> Voltar ao Perfil
    </a>

    <!-- Header -->
    <div class="favoritos-header">
        <h1>
            <i class="fa fa-heart"></i>
            Seus Favoritos
        </h1>
        <p class="subtitle">Gerencie sua lista de itens favoritos do acervo</p>
        <div class="favoritos-count">
            <i class="fa fa-bookmark"></i>
            <?= $total_favoritos ?? 0 ?> item(ns) favorito(s)
        </div>
    </div>

    <!-- Container de Favoritos -->
    <div class="favoritos-container">
        <?php if (!empty($favoritos)): ?>
            <div class="favoritos-grid">
                <?php foreach ($favoritos as $favorito): ?>
                    <div class="favorito-card" data-favorito-id="<?= $favorito['id_favoritos'] ?? $favorito['id'] ?>">
                        <!-- Imagem do Item -->
                        <div class="favorito-image-wrapper">
                            <?php if (!empty($favorito['foto_item'])): ?>
                                <img src="<?= htmlspecialchars($favorito['foto_item']) ?>" 
                                     alt="<?= htmlspecialchars($favorito['titulo_item'] ?? 'Item') ?>" 
                                     class="favorito-item-image">
                            <?php else: ?>
                                <div class="favorito-item-placeholder">
                                    <i class="fa fa-book"></i>
                                </div>
                            <?php endif; ?>

                            <!-- Botão Remover -->
                            <button class="btn-remove-favorito" 
                                    onclick="confirmarRemocao(<?= $favorito['id_favoritos'] ?? $favorito['id'] ?>, '<?= htmlspecialchars($favorito['titulo_item'] ?? 'Este item') ?>')"
                                    title="Remover dos favoritos">
                                <i class="fa fa-heart"></i>
                            </button>

                            <!-- Badge de Disponibilidade -->
                            <?php if (isset($favorito['disponivel_item'])): ?>
                                <span class="favorito-badge <?= $favorito['disponivel_item'] ? 'disponivel' : 'indisponivel' ?>">
                                    <?= $favorito['disponivel_item'] ? 'Disponível' : 'Indisponível' ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Conteúdo -->
                        <div class="favorito-content">
                            <a href="/produtos.html#item-<?= $favorito['id_item'] ?? '' ?>" class="favorito-item-title">
                                <?= htmlspecialchars($favorito['titulo_item'] ?? 'Item #' . ($favorito['id_item'] ?? '')) ?>
                            </a>

                            <?php if (!empty($favorito['autor_item'])): ?>
                                <div class="favorito-item-autor">
                                    <i class="fa fa-user"></i>
                                    <?= htmlspecialchars($favorito['autor_item']) ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($favorito['preco_item'])): ?>
                                <div class="favorito-item-preco">
                                    R$ <?= number_format($favorito['preco_item'], 2, ',', '.') ?>
                                </div>
                            <?php endif; ?>

                            <div class="favorito-date">
                                <i class="fa fa-calendar"></i>
                                Adicionado em <?= date('d/m/Y', strtotime($favorito['data_adicionado'] ?? 'now')) ?>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="favorito-actions">
                                <a href="/produtos.html#item-<?= $favorito['id_item'] ?? '' ?>" 
                                   class="btn-favorito-action primary">
                                    <i class="fa fa-eye"></i>
                                    Ver detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- Estado vazio -->
            <div class="favoritos-empty">
                <i class="fa fa-heart-o"></i>
                <h3>Você ainda não tem favoritos</h3>
                <p>Explore nosso acervo e adicione itens à sua lista de favoritos para acompanhá-los facilmente.</p>
                <a href="/produtos.html" class="btn-explorar">
                    <i class="fa fa-search"></i> Explorar Acervo
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de Confirmação -->
<div class="modal-overlay" id="modalRemover">
    <div class="modal-content">
        <i class="fa fa-heart-o"></i>
        <h3>Remover dos favoritos?</h3>
        <p id="modalItemNome">Tem certeza que deseja remover este item dos seus favoritos?</p>
        <div class="modal-buttons">
            <button class="btn-modal secondary" onclick="fecharModal()">Cancelar</button>
            <button class="btn-modal danger" id="btnConfirmarRemocao">
                <i class="fa fa-trash"></i> Remover
            </button>
        </div>
    </div>
</div>

<script>
    let favoritoIdParaRemover = null;

    function confirmarRemocao(favoritoId, itemNome) {
        favoritoIdParaRemover = favoritoId;
        document.getElementById('modalItemNome').textContent = 
            `Tem certeza que deseja remover "${itemNome}" dos seus favoritos?`;
        document.getElementById('modalRemover').classList.add('active');
    }

    function fecharModal() {
        document.getElementById('modalRemover').classList.remove('active');
        favoritoIdParaRemover = null;
    }

    document.getElementById('btnConfirmarRemocao').addEventListener('click', function() {
        if (favoritoIdParaRemover) {
            removerFavorito(favoritoIdParaRemover);
        }
    });

    function removerFavorito(favoritoId) {
        // Envia requisição para remover via POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/backend/admin/cliente/favoritos/remover';
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'favorito_id';
        input.value = favoritoId;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }

    // Fechar modal ao clicar fora
    document.getElementById('modalRemover').addEventListener('click', function(e) {
        if (e.target === this) {
            fecharModal();
        }
    });

    // Fechar modal com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModal();
        }
    });
</script>
