<?php
// O header e footer já são incluídos pelo View::render
// Variáveis esperadas (passadas pelo controller):
// totalCategorias, totalCategoriasInativas, totalItens, totalItensInativos, vendasMes, faturamentoMes, ultimosItens
?>

<style>
    :root {
        --color-bg-primary: #f5f1e8;
        --color-bg-card: #f5f1e8;
        --color-text-primary: #2c2c2c;
        --color-text-secondary: #666666;
        --color-accent: #8b7355;
        --color-border: #e0e0e0;
        --shadow-card: 0 8px 24px rgba(0, 0, 0, 0.12);
        --shadow-hover: 0 12px 32px rgba(0, 0, 0, 0.16);
        --radius-card: 25px;
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #f5f1e8 0%, #e8dcc8 100%);
        color: var(--color-text-primary);
    }

    .page-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .page-header {
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-header h2 {
        font-size: 32px;
        font-weight: 600;
        color: var(--color-text-primary);
        margin: 0;
    }



    /* ============================================
       PROFILE CARD MODERNO (Estilo Referência)
       ============================================ */
    .profile-card {
        background: white;
        border-radius: var(--radius-card);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        transition: all 0.3s ease;
        position: relative;
        margin-bottom: 40px;
    }

    .profile-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-5px);
    }

    /* Cover Header com fundo BRANCO e Animação */
    .profile-header {
        position: relative;
        height: 450px;
        background: linear-gradient(135deg, #ffffff 0%, #fafafa 50%, #f5f5f5 100%);
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle cx="100" cy="100" r="80" fill="rgba(139,115,85,0.02)"/></svg>');
        background-size: 150px;
        opacity: 0.5;
        animation: floatPattern 20s linear infinite;
    }

    /* Esfumado suave em todo o header até embaixo */
    .profile-header::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, 
            rgba(255, 255, 255, 0.8) 0%, 
            rgba(255, 255, 255, 0.6) 20%,
            rgba(255, 255, 255, 0.3) 40%,
            rgba(245, 237, 220, 0) 60%,
            rgba(245, 237, 220, 0.3) 75%, 
            rgba(245, 237, 220, 0.7) 85%, 
            #f5eddc 100%);
        pointer-events: none;
        z-index: 5;
    }

    @keyframes floatPattern {
        from { background-position: 0 0; }
        to { background-position: 200px 200px; }
    }

    /* Cena de Leitura CENTRALIZADA no Header */
    .reading-scene {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 450px;
        height: 380px;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: gentleFloat 6s ease-in-out infinite;
        z-index: 2;
    }

    @keyframes gentleFloat {
        0%, 100% { transform: translate(-50%, -50%); }
        50% { transform: translate(-50%, calc(-50% - 15px)); }
    }

    .tree-container {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.2));
    }

    .tree-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        animation: fadeInScale 1.2s ease-out;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Flying Letters */
    .letters-container {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
        z-index: 1;
    }

    .flying-letter {
        position: absolute;
        font-size: 28px;
        font-weight: 700;
        color: rgba(139, 115, 85, 0.3);
        opacity: 0;
        animation: letterFly 8s ease-in-out infinite;
    }

    .flying-letter:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
    .flying-letter:nth-child(2) { top: 20%; right: 15%; animation-delay: 1s; }
    .flying-letter:nth-child(3) { bottom: 25%; left: 20%; animation-delay: 2s; }
    .flying-letter:nth-child(4) { bottom: 35%; right: 25%; animation-delay: 3s; }
    .flying-letter:nth-child(5) { top: 50%; left: 5%; animation-delay: 4s; }
    .flying-letter:nth-child(6) { top: 60%; right: 10%; animation-delay: 5s; }
    .flying-letter:nth-child(7) { bottom: 45%; left: 15%; animation-delay: 6s; }
    .flying-letter:nth-child(8) { top: 30%; right: 30%; animation-delay: 7s; }

    @keyframes letterFly {
        0%, 100% { opacity: 0; transform: translateY(0) rotate(0deg); }
        10% { opacity: 0.6; }
        50% { opacity: 0.8; transform: translateY(-40px) rotate(15deg); }
        90% { opacity: 0.6; }
    }

    .magic-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 550px;
        height: 450px;
        background: radial-gradient(ellipse at center, rgba(139, 115, 85, 0.08) 0%, rgba(139, 115, 85, 0.04) 30%, transparent 70%);
        animation: pulseGlow 4s infinite;
        pointer-events: none;
        z-index: 1;
    }

    @keyframes pulseGlow {
        0%, 100% { opacity: 0.4; transform: translate(-50%, -50%) scale(1); }
        50% { opacity: 0.8; transform: translate(-50%, -50%) scale(1.15); }
    }

    .sparkle {
        position: absolute;
        width: 5px;
        height: 5px;
        background: rgba(201, 163, 106, 0.7);
        border-radius: 50%;
        animation: sparkleFloat 3s infinite;
        box-shadow: 0 0 12px rgba(201, 163, 106, 0.5);
        z-index: 3;
    }

    .sparkle:nth-child(1) { top: 15%; left: 15%; animation-delay: 0s; }
    .sparkle:nth-child(2) { top: 25%; right: 20%; animation-delay: 0.5s; }
    .sparkle:nth-child(3) { bottom: 30%; left: 25%; animation-delay: 1s; }
    .sparkle:nth-child(4) { bottom: 20%; right: 15%; animation-delay: 1.5s; }
    .sparkle:nth-child(5) { top: 40%; left: 10%; animation-delay: 2s; }
    .sparkle:nth-child(6) { top: 55%; right: 35%; animation-delay: 2.5s; }

    @keyframes sparkleFloat {
        0%, 100% { opacity: 0; transform: translateY(0) scale(0); }
        50% { opacity: 1; transform: translateY(-20px) scale(1); }
    }

    /* Avatar posicionado no topo esquerdo sobre o header */
    .profile-avatar-wrapper {
        position: absolute;
        top: 30px;
        left: 30px;
        z-index: 10;
    }

    .profile-avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 5px solid white;
        overflow: hidden;
        background: #f0ede5;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        position: relative;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.25);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-badge {
        position: absolute;
        bottom: -2px;
        right: -2px;
        background: var(--color-accent);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 4px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        font-size: 16px;
    }

    .avatar-badge:hover {
        transform: scale(1.15);
        background: #6d5438;
        box-shadow: 0 6px 16px rgba(139, 115, 85, 0.5);
    }

    /* Bookmark icon no canto superior direito */
    .bookmark-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: rgba(139, 115, 85, 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-accent);
        font-size: 18px;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .bookmark-icon:hover {
        background: rgba(139, 115, 85, 0.2);
        transform: scale(1.1);
    }

    /* Content Area com fundo BEGE */
    .profile-content {
        padding: 30px;
        background: #f5eddc;
    }

    .profile-name-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 5px;
    }

    .profile-name {
        color: var(--color-text-primary);
        font-size: 24px;
        font-weight: 700;
        margin: 0;
    }

    .verified-badge {
        width: 22px;
        height: 22px;
        background: #4CAF50;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
        flex-shrink: 0;
    }

    .profile-bio {
        color: var(--color-text-secondary);
        font-size: 14px;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    /* Stats Grid Horizontal */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 24px 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        margin: 24px 0;
    }

    .stat-box {
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .stat-box:hover {
        transform: scale(1.05);
    }

    .stat-icon {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: var(--color-text-primary);
        display: block;
    }

    .stat-label {
        font-size: 13px;
        color: var(--color-text-secondary);
        font-weight: 500;
    }

    /* Action Buttons */
    .profile-actions {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }

    .btn-primary {
        flex: 1;
        background: #000;
        color: white;
        border: none;
        padding: 14px 24px;
        border-radius: 50px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: #1a1a1a;
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-secondary {
        background: var(--color-accent);
        color: white;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-secondary:hover {
        background: #6d5438;
        transform: scale(1.05);
    }

    /* Info Items */
    .profile-info {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 12px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.6);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: rgba(255, 255, 255, 0.9);
        transform: translateX(5px);
    }

    .info-item i {
        color: var(--color-accent);
        font-size: 16px;
        margin-top: 2px;
        min-width: 20px;
    }

    .info-item-content {
        flex: 1;
        font-size: 14px;
        line-height: 1.5;
        color: var(--color-text-secondary);
    }

    .info-item-content strong {
        display: block;
        color: var(--color-text-primary);
        font-weight: 600;
        margin-bottom: 2px;
        font-size: 13px;
    }

    /* Orders Section */
    .orders-section {
        background: white;
        border-radius: var(--radius-card);
        padding: 30px;
        box-shadow: var(--shadow-card);
    }

    .section-header {
        font-size: 24px;
        color: var(--color-text-primary);
        font-weight: 600;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-header {
            height: 320px;
        }
        
        .reading-scene {
            width: 280px;
            height: 240px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border: 4px solid white;
        }

        .avatar-badge {
            width: 32px;
            height: 32px;
            font-size: 14px;
            border: 3px solid white;
        }

        .profile-actions {
            flex-direction: column;
        }
        
        .btn-secondary {
            width: 100%;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .flying-letter {
            font-size: 20px;
        }
    }
</style>

<div class="page-container">
    <div class="page-header">
        <h2><i class="fa fa-user-circle"></i> Perfil do Usuário</h2>
    </div>

    <!-- Modern Profile Card -->
    <div class="profile-card">
        <!-- Cover Header -->
        <div class="profile-header">
            <div class="magic-glow"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>
            <div class="sparkle"></div>

            <!-- Cena de Leitura -->
            <div class="reading-scene">
                <div class="tree-container">
                    <img src="/img/banner2.png" alt="Pessoa lendo sob a árvore" class="tree-image" />
                </div>
            </div>

            <!-- Letras Voando -->
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

            <!-- Bookmark Icon -->
            <div class="bookmark-icon">
                <i class="fa fa-bookmark"></i>
            </div>

            <!-- Avatar -->
            <div class="profile-avatar-wrapper">
                <div class="profile-avatar">
                    <?php if (!empty($usuario['foto_perfil_usuario'])): ?>
                        <img src="<?= htmlspecialchars($usuario['foto_perfil_usuario']) ?>" alt="Avatar" id="avatar-img">
                    <?php else: ?>
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#2c2c2c; color:white; font-size:48px; font-weight:600;">
                            <?= strtoupper(substr($usuario['nome_usuario'] ?? 'U', 0, 1)) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Upload functionality -->
                    <form id="form-foto" action="/backend/admin/cliente/foto" method="POST" enctype="multipart/form-data" style="display:none;">
                        <input type="file" name="foto_usuario" id="input-foto" accept="image/*" onchange="document.getElementById('form-foto').submit()">
                    </form>

                    <div class="avatar-badge" onclick="document.getElementById('input-foto').click()" title="Alterar Foto">
                        <i class="fa fa-camera"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="profile-content">
            <div class="profile-name-wrapper">
                <h2 class="profile-name"><?= htmlspecialchars($usuarioNome) ?></h2>
                <div class="verified-badge" title="Verificado">
                    <i class="fa fa-check"></i>
                </div>
            </div>

            <p class="profile-bio">
                Amante de livros clássicos e histórias atemporais
            </p>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-icon">📦</div>
                    <span class="stat-number"><?= $total_pedidos ?? 0 ?></span>
                    <div class="stat-label">Pedidos</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon">⭐</div>
                    <span class="stat-number"><?= $total_avaliacoes ?? 0 ?></span>
                    <div class="stat-label">Avaliações</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon">❤️</div>
                    <span class="stat-number"><?= $total_favoritos ?? 0 ?></span>
                    <div class="stat-label">Favoritos</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="profile-actions">
                <button class="btn-primary">
                    <i class="fa fa-edit"></i>
                    Editar Perfil
                </button>
                <button class="btn-secondary" title="Configurações">
                    <i class="fa fa-cog"></i>
                </button>
            </div>

            <!-- Info -->
            <div class="profile-info">
                <div class="info-item">
                    <i class="fa fa-calendar"></i>
                    <div class="info-item-content">
                        <strong>Membro desde</strong>
                        <?= date('d/m/Y', strtotime($usuario['criado_em'] ?? 'now')) ?>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fa fa-map-marker-alt"></i>
                    <div class="info-item-content">
                        <strong>Localização</strong>
                        <?= htmlspecialchars($usuario['cidade'] ?? 'São Paulo, SP') ?>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fa fa-envelope"></i>
                    <div class="info-item-content">
                        <strong>Email</strong>
                        <?= htmlspecialchars($usuarioEmail) ?>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fa fa-phone"></i>
                    <div class="info-item-content">
                        <strong>Contato</strong>
                        <?= htmlspecialchars($usuario['telefone'] ?? 'Não informado') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Section -->
    <div class="orders-section">
        <div class="section-header">
            <i class="fa fa-shopping-bag"></i> Meus Pedidos
        </div>
        <!-- Resto do código de pedidos... -->
    </div>
</div>