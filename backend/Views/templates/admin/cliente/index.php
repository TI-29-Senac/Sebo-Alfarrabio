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
        padding: 50px;
        display: flex;
        align-items: center;
        gap: 40px;
        box-shadow: var(--shadow-soft);
        position: relative;
        overflow: hidden;
        margin-top: 70px;
    }

    /* Container da animação no canto direito */
    .tree-animation-container {
        position: absolute;
        right: 20px;
        bottom: 15px;
        width: 260px;
        height: 260px;
        pointer-events: none;
        z-index: 0;
    }

    .reading-scene {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: gentleFloat 6s ease-in-out infinite;
    }

    @keyframes gentleFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .tree-container {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.08));
    }

    .tree-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        opacity: 0.75;
        animation: fadeInScale 1.2s ease-out;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 0.75;
            transform: scale(1);
        }
    }

    .letters-container {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
    }

    .flying-letter {
        position: absolute;
        font-size: 18px;
        font-weight: 700;
        color: rgba(139, 115, 85, 0.2);
        opacity: 0;
        animation: letterFly 8s ease-in-out infinite;
    }

    .flying-letter:nth-child(1) { top: 8%; left: 5%; animation-delay: 0s; }
    .flying-letter:nth-child(2) { top: 18%; right: 8%; animation-delay: 1s; }
    .flying-letter:nth-child(3) { bottom: 22%; left: 12%; animation-delay: 2s; }
    .flying-letter:nth-child(4) { bottom: 32%; right: 15%; animation-delay: 3s; }
    .flying-letter:nth-child(5) { top: 45%; left: 2%; animation-delay: 4s; }
    .flying-letter:nth-child(6) { top: 58%; right: 5%; animation-delay: 5s; }
    .flying-letter:nth-child(7) { bottom: 40%; left: 10%; animation-delay: 6s; }
    .flying-letter:nth-child(8) { top: 28%; right: 20%; animation-delay: 7s; }

    @keyframes letterFly {
        0%, 100% { opacity: 0; transform: translateY(0) rotate(0deg); }
        10% { opacity: 0.4; }
        50% { opacity: 0.6; transform: translateY(-25px) rotate(10deg); }
        90% { opacity: 0.4; }
    }

    .magic-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        height: 280px;
        background: radial-gradient(ellipse at center, rgba(139, 115, 85, 0.04) 0%, rgba(139, 115, 85, 0.02) 30%, transparent 70%);
        animation: pulseGlow 4s infinite;
        pointer-events: none;
    }

    @keyframes pulseGlow {
        0%, 100% { opacity: 0.25; transform: translate(-50%, -50%) scale(1); }
        50% { opacity: 0.5; transform: translate(-50%, -50%) scale(1.08); }
    }

    .sparkle {
        position: absolute;
        width: 3px;
        height: 3px;
        background: rgba(201, 163, 106, 0.5);
        border-radius: 50%;
        animation: sparkleFloat 3s infinite;
        box-shadow: 0 0 6px rgba(201, 163, 106, 0.3);
    }

    .sparkle:nth-child(1) { top: 12%; left: 8%; animation-delay: 0s; }
    .sparkle:nth-child(2) { top: 22%; right: 12%; animation-delay: 0.5s; }
    .sparkle:nth-child(3) { bottom: 28%; left: 15%; animation-delay: 1s; }
    .sparkle:nth-child(4) { bottom: 18%; right: 10%; animation-delay: 1.5s; }
    .sparkle:nth-child(5) { top: 38%; left: 6%; animation-delay: 2s; }
    .sparkle:nth-child(6) { top: 52%; right: 22%; animation-delay: 2.5s; }

    @keyframes sparkleFloat {
        0%, 100% { opacity: 0; transform: translateY(0) scale(0); }
        50% { opacity: 1; transform: translateY(-12px) scale(1); }
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
        width: 120px;
        height: 160px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
        flex-shrink: 0;
    }

    .order-item-placeholder {
        width: 120px;
        height: 160px;
        background: linear-gradient(135deg, #F5EFE6 0%, #E8DCCF 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .order-item-placeholder i {
        font-size: 40px;
        color: var(--color-vintage-brown);
        opacity: 0.4;
    }

    .order-item-details {
        flex: 1;
    }

    .status-text {
        display: inline-block;
        font-size: 13px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 50px;
        margin: 0 0 12px;
    }

    .status-entregue { background: #D4EDDA; color: #155724; }
    .status-pendente { background: #FFF3CD; color: #856404; }
    .status-cancelado { background: #F8D7DA; color: #721C24; }
    .status-enviado { background: #CCE5FF; color: #004085; }
    .status-preparo { background: #E2E3E5; color: #383D41; }

    .item-title {
        font-size: 17px;
        font-weight: 700;
        color: var(--color-vintage-brown);
        margin: 0 0 6px;
        text-decoration: none;
    }

    .item-quantity {
        font-size: 13px;
        color: var(--color-text-secondary);
        margin-bottom: 4px;
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

        .tree-animation-container {
            width: 200px;
            height: 180px;
        }

        .order-body {
            flex-direction: column;
        }

        .order-side-actions {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .tree-animation-container {
            display: none;
        }
    }
</style>

<div class="profile-main-container">

    <!-- HEADER DO PERFIL -->
    <div class="profile-hero-card">
        
        <!-- Animação no canto direito -->
        <div class="tree-animation-container">
            <div class="magic-glow"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>

            <div class="reading-scene">
                <div class="tree-container">
                    <img src="/img/banner2.png" alt="Pessoa lendo sob a árvore" class="tree-image" />
                </div>
            </div>

            <div class="letters-container">
                <div class="flying-letter">A</div>
                <div class="flying-letter">L</div>
                <div class="flying-letter">F</div>
                <div class="flying-letter">A</div>
                <div class="flying-letter">R</div>
                <div class="flying-letter">R</div>
                <div class="flying-letter">Á</div>
                <div class="flying-letter">B</div>
            </div>
        </div>

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
                <i class="fas fa-check-circle" style="color:#4CAF50; font-size:22px;"></i>
            </h1>
            

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
                        <?php 
                        // Pega o primeiro item do pedido para exibir a foto
                        $primeiroItem = !empty($pedido['itens']) ? $pedido['itens'][0] : null;
                        $fotoItem = $primeiroItem['foto_item'] ?? null;
                        $tituloItem = $primeiroItem['titulo_item'] ?? 'Item do Pedido';
                        $qtdItens = count($pedido['itens'] ?? []);
                        
                        // Determina a classe de status
                        $statusRaw = strtolower($pedido['status'] ?? 'pendente');
                        $statusClass = 'status-pendente';
                        if (strpos($statusRaw, 'entreg') !== false) $statusClass = 'status-entregue';
                        elseif (strpos($statusRaw, 'cancel') !== false) $statusClass = 'status-cancelado';
                        elseif (strpos($statusRaw, 'envia') !== false || strpos($statusRaw, 'transit') !== false) $statusClass = 'status-enviado';
                        elseif (strpos($statusRaw, 'prepar') !== false || strpos($statusRaw, 'process') !== false) $statusClass = 'status-preparo';
                        ?>
                        
                        <?php if (!empty($fotoItem)): ?>
                            <img src="<?= htmlspecialchars($fotoItem) ?>" 
                                 class="order-item-image" 
                                 alt="<?= htmlspecialchars($tituloItem) ?>"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="order-item-placeholder" style="display:none;">
                                <i class="fa fa-book"></i>
                            </div>
                        <?php else: ?>
                            <div class="order-item-placeholder">
                                <i class="fa fa-book"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="order-item-details">
                            <span class="status-text <?= $statusClass ?>">
                                <?= htmlspecialchars($pedido['status'] ?? 'Pendente') ?>
                            </span>
                            <p class="item-title"><?= htmlspecialchars($tituloItem) ?></p>
                            <?php if ($qtdItens > 1): ?>
                                <p class="item-quantity">+ <?= $qtdItens - 1 ?> outro(s) item(ns)</p>
                            <?php endif; ?>
                            <p class="item-vendor">Vendido por: Sebo Alfarrábio</p>
                            <div class="order-action-buttons">
                                <button class="btn-action gold">Comprar novamente</button>
                                <button class="btn-action">Ver detalhes</button>
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
            <!-- Estado vazio - nenhum pedido encontrado -->
            <div style="text-align: center; padding: 60px 20px;">
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #F5EFE6 0%, #E8DCCF 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px;">
                    <i class="fa fa-shopping-bag" style="font-size: 40px; color: var(--color-vintage-brown); opacity: 0.5;"></i>
                </div>
                <h3 style="font-size: 22px; font-weight: 700; color: var(--color-text-primary); margin: 0 0 10px;">Você ainda não fez nenhum pedido</h3>
                <p style="color: var(--color-text-secondary); font-size: 15px; max-width: 400px; margin: 0 auto 25px;">Explore nosso acervo e encontre livros incríveis para sua coleção.</p>
                <a href="/produtos.html" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: var(--color-vintage-brown); color: white; border: none; border-radius: 50px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s ease;">
                    <i class="fa fa-search"></i> Explorar Acervo
                </a>
            </div>
        <?php endif; ?>
    </section>
</div>