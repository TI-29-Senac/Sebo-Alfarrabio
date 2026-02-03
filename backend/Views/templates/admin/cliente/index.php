<?php
// O header e footer já são incluídos pelo View::render
// Variáveis esperadas: $usuario, $usuarioNome, $usuarioEmail, $total_pedidos, $total_avaliacoes, $total_favoritos, $pedidos
?>

<style>
    :root {
        --color-bg-primary: #F8F5F1;
        --color-card-bg: #FFFFFF;
        --color-stats-bg: #FDFBF7;
        --color-text-primary: #3D3D3D;
        --color-text-secondary: #8C8C8C;
        --color-accent: #C8B896;
        /* Dourado suave para bordas/detalhes */
        --color-vintage-brown: #8B7355;
        /* Marrom Alfarrábio */
        --color-vintage-red: #D46A6A;
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

    /* LAYOUT PRINCIPAL */
    .profile-main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px 40px;
    }

    /* CARD DE PERFIL HERO */
    .profile-hero-card {
        background: white;
        border-radius: var(--radius-main);
        padding: 40px;
        display: flex;
        align-items: center;
        gap: 40px;
        box-shadow: var(--shadow-soft);
        position: relative;
        overflow: hidden;
        margin-top: 20px;
    }

    .tree-overlay {
        position: absolute;
        right: -30px;
        bottom: -20px;
        width: 420px;
        opacity: 0.8;
        pointer-events: none;
        z-index: 0;
    }

    .hero-avatar-wrapper {
        position: relative;
        z-index: 1;
    }

    .hero-avatar {
        width: 170px;
        height: 170px;
        border-radius: 50%;
        border: 6px solid white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        object-fit: cover;
    }

    .hero-edit-badge {
        position: absolute;
        bottom: 8px;
        right: 12px;
        width: 42px;
        height: 42px;
        background: var(--color-vintage-brown);
        color: white;
        border: 3px solid white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 16px;
    }

    .hero-info {
        flex: 1;
        z-index: 1;
    }

    .hero-name {
        font-size: 34px;
        font-weight: 800;
        margin: 0 0 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .hero-bio {
        color: var(--color-text-secondary);
        font-size: 16px;
        margin: 0 0 25px;
    }

    .hero-stats-card {
        background: var(--color-stats-bg);
        border-radius: 20px;
        padding: 20px 45px;
        display: inline-flex;
        gap: 60px;
        border: 1px solid #F5EFE6;
    }

    .hero-stat-item {
        text-align: center;
    }

    .hero-stat-val {
        display: block;
        font-size: 24px;
        font-weight: 800;
        color: var(--color-text-primary);
    }

    .hero-stat-label {
        font-size: 13px;
        color: var(--color-text-secondary);
        font-weight: 600;
    }

    /* ========================================
       SEÇÃO DE PEDIDOS
       ======================================== */
    .orders-container {
        background: white;
        border-radius: var(--radius-main);
        padding: 40px;
        box-shadow: var(--shadow-soft);
        margin-top: 30px;
    }

    .orders-title-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .orders-title-row h2 {
        font-size: 26px;
        margin: 0;
        font-weight: 800;
    }

    .orders-search-bar {
        display: flex;
        gap: 12px;
    }

    .orders-search-bar input {
        width: 350px;
        padding: 12px 20px;
        border-radius: 50px;
        border: 1px solid #E6E0D5;
        font-size: 14px;
        background: #FDFBF7;
    }

    .btn-search-orders {
        padding: 12px 25px;
        background: #3D3D3D;
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
    }

    /* Abas de Pedidos */
    .tabs-navigation {
        display: flex;
        gap: 30px;
        border-bottom: 2px solid #F5EFE6;
        margin-bottom: 25px;
    }

    .tab-btn {
        padding: 12px 0;
        color: var(--color-text-secondary);
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        position: relative;
    }

    .tab-btn.active {
        color: var(--color-vintage-brown);
    }

    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--color-vintage-brown);
        border-radius: 5px;
    }

    .orders-meta-info {
        font-size: 14px;
        color: var(--color-text-secondary);
        margin-bottom: 30px;
    }

    .orders-meta-info strong {
        color: var(--color-text-primary);
    }

    .year-filter {
        padding: 8px 15px;
        border-radius: 5px;
        background: #F5EFE6;
        border: none;
        margin-left: 10px;
        font-weight: 700;
        color: var(--color-vintage-brown);
    }

    /* CARD DE PEDIDO INDIVIDUAL */
    .order-card {
        border: 1px solid #F0ECE4;
        border-radius: 18px;
        margin-bottom: 25px;
        overflow: hidden;
        transition: 0.2s;
    }

    .order-card:hover {
        border-color: var(--color-accent);
    }

    .order-header {
        background: #F9F7F4;
        padding: 18px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #F0ECE4;
    }

    .header-group-row {
        display: flex;
        gap: 40px;
    }

    .header-cell label {
        display: block;
        font-size: 10px;
        font-weight: 800;
        color: var(--color-text-secondary);
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .header-cell span {
        font-size: 13px;
        font-weight: 700;
        color: var(--color-text-primary);
    }

    .order-number-link {
        font-size: 12px;
        color: var(--color-text-secondary);
        text-align: right;
    }

    .order-links-row {
        margin-top: 4px;
        display: flex;
        gap: 15px;
        font-weight: 600;
        text-decoration: underline;
        color: #666;
        font-size: 12px;
    }

    /* Corpo do Pedido */
    .order-body {
        padding: 25px;
        display: flex;
        gap: 25px;
    }

    .order-item-image {
        width: 90px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .order-item-details {
        flex: 1;
    }

    .status-text {
        font-size: 18px;
        font-weight: 800;
        margin: 0 0 10px;
        color: var(--color-text-primary);
    }

    .item-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--color-vintage-brown);
        margin: 0 0 5px;
        text-decoration: none;
    }

    .item-vendor {
        font-size: 13px;
        color: var(--color-text-secondary);
        margin-bottom: 15px;
    }

    .order-action-buttons {
        display: flex;
        gap: 12px;
    }

    .btn-action {
        padding: 10px 22px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        border: 1px solid #E0E0E0;
        background: white;
    }

    .btn-action.gold {
        background: #F2E3C0;
        border-color: #D4B673;
        color: #7A5C1F;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .order-side-actions {
        width: 220px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-side {
        width: 100%;
        padding: 10px;
        border-radius: 50px;
        border: 1px solid #E0E0E0;
        background: white;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    @media (max-width: 1100px) {
        .hero-stats-card {
            gap: 30px;
            width: 100%;
            justify-content: space-around;
        }

        .order-body {
            flex-direction: column;
        }

        .order-side-actions {
            width: 100%;
        }
    }
</style>

<div class="profile-main-container">

    <!-- HEADER DO PERFIL -->
    <div class="profile-hero-card">
        <div class="hero-avatar-wrapper">
            <img src="<?= !empty($usuario['foto_perfil_usuario']) ? htmlspecialchars($usuario['foto_perfil_usuario']) : '/img/avatar_placeholder.png' ?>"
                class="hero-avatar" alt="Perfil">
            <div class="hero-edit-badge" onclick="document.getElementById('input-foto').click()">
                <i class="fas fa-camera"></i>
            </div>
            <form id="form-foto" action="/backend/admin/cliente/foto" method="POST" enctype="multipart/form-data"
                style="display:none;">
                <input type="file" name="foto_usuario" id="input-foto" accept="image/*"
                    onchange="document.getElementById('form-foto').submit()">
            </form>
        </div>

        <div class="hero-info">
            <h1 class="hero-name">
                <?= htmlspecialchars($usuarioNome) ?>
                <i class="fas fa-check-circle" style="color:var(--color-verify); font-size:22px;"></i>
            </h1>
            <p class="hero-bio">Amante de livros clássicos e histórias atemporais</p>

            <div class="hero-stats-card">
                <div class="hero-stat-item">
                    <span class="hero-stat-val">
                        <?= $total_pedidos ?? 0 ?>
                    </span>
                    <span class="hero-stat-label">Pedidos</span>
                </div>
                <div class="hero-stat-item">
                    <span class="hero-stat-val">
                        <?= $total_avaliacoes ?? 0 ?>
                    </span>
                    <span class="hero-stat-label">Avaliações</span>
                </div>
                <div class="hero-stat-item">
                    <span class="hero-stat-val">
                        <?= $total_favoritos ?? 0 ?>
                    </span>
                    <span class="hero-stat-label">Favoritos</span>
                </div>
            </div>
        </div>

        <img src="/img/banner2.png" alt="Árvore" class="tree-overlay">
    </div>

    <!-- SEÇÃO DE PEDIDOS REDESENHADA -->
    <section class="orders-container">
        <div class="orders-title-row">
            <h2>Seus pedidos</h2>
            <div class="orders-search-bar">
                <input type="text" placeholder="Pesquisar todos os pedidos">
                <button class="btn-search-orders">Buscar pedidos</button>
            </div>
        </div>

        <div class="tabs-navigation">
            <div class="tab-btn active">Pedidos</div>
            <div class="tab-btn">Compre Novamente</div>
            <div class="tab-btn">Ainda não enviado</div>
        </div>

        <div class="orders-meta-info">
            <strong>
                <?= count($pedidos ?? []) ?> pedidos
            </strong> feitos em
            <select class="year-filter">
                <option>2025</option>
                <option>2024</option>
            </select>
        </div>

        <!-- Listagem de Pedidos Real -->
        <?php if (!empty($pedidos)): ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div class="header-group-row">
                            <div class="header-cell">
                                <label>PEDIDO REALIZADO</label>
                                <span>
                                    <?= date('d \d\e F \d\e Y', strtotime($pedido['data_pedido'])) ?>
                                </span>
                            </div>
                            <div class="header-cell">
                                <label>TOTAL</label>
                                <span>R$
                                    <?= number_format($pedido['valor_total'], 2, ',', '.') ?>
                                </span>
                            </div>
                            <div class="header-cell">
                                <label>ENVIAR PARA</label>
                                <span>
                                    <?= htmlspecialchars($usuarioNome) ?> <i class="fas fa-caret-down"></i>
                                </span>
                            </div>
                        </div>
                        <div class="order-number-link">
                            <label>PEDIDO Nº
                                <?= $pedido['id_pedidos'] ?? $pedido['id'] ?? '---' ?>
                            </label>
                            <div class="order-links-row">
                                <a href="#">Exibir detalhes do pedido</a>
                                <a href="#">Fatura</a>
                            </div>
                        </div>
                    </div>
                    <div class="order-body">
                        <img src="/img/book_placeholder.jpg" class="order-item-image" alt="Item">
                        <div class="order-item-details">
                            <h3 class="status-text">
                                <?= $pedido['status'] ?? 'Entregue' ?>
                            </h3>
                            <p class="item-title">Item do Pedido #
                                <?= $pedido['id_pedidos'] ?? $pedido['id'] ?? '---' ?>
                            </p>
                            <p class="item-vendor">Vendido por: Sebo Alfarrábio</p>
                            <div class="order-action-buttons">
                                <button class="btn-action gold">Comprar novamente</button>
                                <button class="btn-action">Ver o seu item</button>
                            </div>
                        </div>
                        <div class="order-side-actions">
                            <button class="btn-side">Avaliar o produto</button>
                            <button class="btn-side">Rastrear pacote</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Exemplo ilustrativo se não houver pedidos -->
            <div class="order-card">
                <div class="order-header">
                    <div class="header-group-row">
                        <div class="header-cell"><label>PEDIDO REALIZADO</label><span>15 de Janeiro de 2025</span></div>
                        <div class="header-cell"><label>TOTAL</label><span>R$ 54,90</span></div>
                    </div>
                </div>
                <div class="order-body">
                    <div
                        style="width:90px; height:120px; background:#f0f0f0; border-radius:8px; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-book" style="color:#ccc; font-size:32px;"></i>
                    </div>
                    <div class="order-item-details">
                        <h3 class="status-text">Entregue</h3>
                        <p class="item-title">Memórias Póstumas de Brás Cubas</p>
                        <p class="item-vendor">Vendido por: Sebo Alfarrábio</p>
                        <div class="order-action-buttons">
                            <button class="btn-action gold">Comprar novamente</button>
                            <button class="btn-action">Ver o seu item</button>
                        </div>
                    </div>
                    <div class="order-side-actions">
                        <button class="btn-side">Avaliar o produto</button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>