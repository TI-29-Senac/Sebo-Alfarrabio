<?php
// View de notificações: Última Reserva + Novos Livros
// Variáveis: $usuario, $ultimaReserva, $novosLivros, $usuarioNome
?>

<style>
    :root {
        --color-bg-primary: #F8F5F1;
        --color-text-primary: #3D3D3D;
        --color-text-secondary: #8C8C8C;
        --color-vintage-brown: #8B7355;
        --color-white: #FFFFFF;
        --shadow-card: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    body {
        font-family: 'Outfit', 'Inter', sans-serif;
        background: var(--color-bg-primary);
        color: var(--color-text-primary);
    }

    .main-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .section-header {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-header h2 {
        font-size: 20px;
        font-weight: 700;
        color: var(--color-vintage-brown);
        margin: 0;
    }

    .badge-updated {
        background: #E8F5E9;
        color: #2E7D32;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* CARD ÚLTIMA RESERVA */
    .hero-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-card);
        display: flex;
        margin-bottom: 50px;
        border: 1px solid rgba(0, 0, 0, 0.03);
        transition: transform 0.2s;
    }

    .hero-card:hover {
        transform: translateY(-3px);
    }

    .hero-image-container {
        width: 180px;
        background: #F5F5F5;
        position: relative;
    }

    .hero-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-content {
        flex: 1;
        padding: 30px;
    }

    .hero-top {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .order-id {
        font-size: 14px;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-status {
        font-weight: 700;
        font-size: 14px;
        color: var(--color-vintage-brown);
    }

    .hero-title {
        font-size: 24px;
        font-weight: 800;
        color: var(--color-text-primary);
        margin: 0 0 10px;
        line-height: 1.2;
    }

    .hero-desc {
        color: #666;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .hero-footer {
        display: flex;
        gap: 30px;
        align-items: center;
        border-top: 1px solid #EEE;
        padding-top: 20px;
    }

    .meta-block label {
        display: block;
        font-size: 11px;
        color: #BBB;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .meta-block span {
        font-weight: 600;
        color: #444;
        font-size: 15px;
    }

    /* LISTA DE NOVOS LIVROS */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
    }

    .book-notif-card {
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        display: flex;
        gap: 15px;
        align-items: center;
        border: 1px solid #F0F0F0;
        transition: all 0.2s;
    }

    .book-notif-card:hover {
        border-color: var(--color-vintage-brown);
        box-shadow: 0 5px 20px rgba(139, 115, 85, 0.1);
    }

    .book-thumb {
        width: 60px;
        height: 90px;
        background: #EEE;
        border-radius: 6px;
        object-fit: cover;
    }

    .book-info {
        flex: 1;
    }

    .book-title {
        font-size: 16px;
        font-weight: 700;
        color: #333;
        margin: 0 0 4px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .book-author {
        font-size: 13px;
        color: #888;
        margin-bottom: 8px;
    }

    .book-date {
        font-size: 11px;
        color: var(--color-text-secondary);
        display: block;
        margin-top: 5px;
    }

    .btn-small {
        font-size: 12px;
        color: var(--color-vintage-brown);
        text-decoration: none;
        font-weight: 700;
        border: 1px solid #E0E0E0;
        padding: 5px 12px;
        border-radius: 20px;
        display: inline-block;
        transition: background 0.2s;
    }

    .btn-small:hover {
        background: var(--color-vintage-brown);
        color: white;
        border-color: var(--color-vintage-brown);
    }

    .empty-state {
        padding: 40px;
        text-align: center;
        background: #FFF;
        border-radius: 12px;
        color: #999;
        font-style: italic;
    }

    /* ========================================
       TEMA ESCURO — NOTIFICAÇÕES
       ======================================== */
    [data-theme="dark"] .main-container {
        color: #f5f1e8;
    }

    [data-theme="dark"] .section-header h2 {
        color: #f5f1e8;
    }

    [data-theme="dark"] .hero-card {
        background: #221a10;
        border-color: rgba(212, 165, 116, 0.1);
    }

    [data-theme="dark"] .hero-content {
        color: #f5f1e8;
    }

    [data-theme="dark"] .hero-title {
        color: #f5f1e8;
    }

    [data-theme="dark"] .hero-desc {
        color: #a89880;
    }

    [data-theme="dark"] .hero-footer {
        border-top-color: rgba(212, 165, 116, 0.1);
    }

    [data-theme="dark"] .meta-block label {
        color: #a89880;
    }

    [data-theme="dark"] .meta-block span {
        color: #d4c5a9;
    }

    [data-theme="dark"] .book-notif-card {
        background: #221a10;
        border-color: rgba(212, 165, 116, 0.1);
    }

    [data-theme="dark"] .book-notif-card:hover {
        border-color: rgba(212, 165, 116, 0.2);
    }

    [data-theme="dark"] .book-title {
        color: #f5f1e8;
    }

    [data-theme="dark"] .book-author {
        color: #a89880;
    }

    [data-theme="dark"] .book-price {
        color: #d4a574;
    }

    [data-theme="dark"] .book-thumb {
        background: #33261a;
    }

    [data-theme="dark"] .empty-state {
        background: #2a1f14;
        color: #a89880;
    }

    /* ========================================
       RESPONSIVO
       ======================================== */
    @media (max-width: 768px) {
        .main-container {
            padding: 20px 12px;
        }

        .section-header h2 {
            font-size: 18px;
        }

        .hero-card {
            flex-direction: column;
        }

        .hero-image-container {
            width: 100%;
            height: 200px;
        }

        .hero-content {
            padding: 20px;
        }

        .hero-title {
            font-size: 20px;
        }

        .hero-desc {
            font-size: 14px;
        }

        .hero-footer {
            flex-wrap: wrap;
            gap: 15px;
        }

        .meta-block span {
            font-size: 14px;
        }

        .books-grid {
            grid-template-columns: 1fr;
        }

        .book-notif-card {
            padding: 15px;
        }

        .book-title {
            font-size: 15px;
        }
    }

    @media (max-width: 480px) {
        .hero-image-container {
            height: 160px;
        }

        .hero-content {
            padding: 15px;
        }

        .hero-title {
            font-size: 18px;
        }

        .hero-top {
            flex-direction: column;
            gap: 8px;
        }

        .hero-footer {
            flex-direction: column;
            gap: 12px;
        }

        .meta-block {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .book-notif-card {
            padding: 12px;
        }

        .book-thumb {
            width: 50px;
            height: 75px;
        }

        .empty-state {
            padding: 30px 15px;
        }
    }
</style>

<div class="main-container">

    <!-- SEÇÃO 1: ÚLTIMA RESERVA -->
    <div class="section-header">
        <h2>Sua Última Reserva</h2>
        <span class="badge-updated">Mais Recente</span>
    </div>

    <?php if ($ultimaReserva): ?>
        <div class="hero-card">
            <div class="hero-image-container">
                <?php if (!empty($ultimaReserva['foto_item'])): ?>
                    <img src="<?= htmlspecialchars($ultimaReserva['foto_item']) ?>" class="hero-image" alt="Capa">
                <?php else: ?>
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#CCC">
                        <i class="fa fa-book" style="font-size:40px"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="hero-content">
                <div class="hero-top">
                    <span class="order-id">Reserva #<?= $ultimaReserva['id_pedidos'] ?? $ultimaReserva['id'] ?></span>
                    <span class="order-status"><?= htmlspecialchars($ultimaReserva['status']) ?></span>
                </div>

                <h3 class="hero-title"><?= htmlspecialchars($ultimaReserva['titulo_item'] ?? 'Item da Reserva') ?></h3>
                <p class="hero-desc">
                    <?= !empty($ultimaReserva['descricao']) ? strip_tags($ultimaReserva['descricao']) : 'Sem descrição disponível.' ?>
                </p>

                <div class="hero-footer">
                    <div class="meta-block">
                        <label>DATA</label>
                        <span><?= date('d/m/Y', strtotime($ultimaReserva['data_pedido'])) ?></span>
                    </div>
                    <div class="meta-block">
                        <label>TOTAL</label>
                        <span style="color:var(--color-vintage-brown)">R$
                            <?= number_format($ultimaReserva['valor_total'], 2, ',', '.') ?></span>
                    </div>
                    <!-- Placeholder para Pagamento se houver no futuro -->
                    <!-- <div class="meta-block">
                        <label>PAGAMENTO</label>
                        <span>Cartão</span>
                    </div> -->
                    <div style="margin-left:auto">
                        <a href="/backend/admin/cliente/reservas" class="btn-small">Ver Detalhes</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fa fa-shopping-basket" style="font-size:24px; margin-bottom:10px"></i><br>
            Você ainda não realizou nenhuma reserva.
        </div>
        <div style="height:30px"></div>
    <?php endif; ?>


    <!-- SEÇÃO 2: NOVOS LIVROS -->
    <div class="section-header">
        <h2>Novidades no Acervo</h2>
    </div>

    <?php if (!empty($novosLivros)): ?>
        <div class="books-grid">
            <?php foreach ($novosLivros as $livro): ?>
                <div class="book-notif-card">
                    <?php if (!empty($livro['foto_item'])): ?>
                        <img src="<?= htmlspecialchars($livro['foto_item']) ?>" class="book-thumb" alt="Capa">
                    <?php else: ?>
                        <div class="book-thumb" style="display:flex;align-items:center;justify-content:center;color:#CCC">
                            <i class="fa fa-book"></i>
                        </div>
                    <?php endif; ?>

                    <div class="book-info">
                        <h4 class="book-title"><?= htmlspecialchars($livro['titulo_item']) ?></h4>
                        <div class="book-author"><?= htmlspecialchars($livro['autor'] ?? 'Autor Desconhecido') ?></div>

                        <div style="display:flex; justify-content:space-between; align-items:flex-end">
                            <span class="book-date">Cadastrado em <?= date('d/m/Y', strtotime($livro['criado_em'])) ?></span>
                            <!-- Link genérico para catalogo ou detalhes se houver rota -->
                            <a href="#" class="btn-small">Ver</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            Nenhum novo livro cadastrado no momento.
        </div>
    <?php endif; ?>

</div>