<?php
// O header e footer já são incluídos pelo View::render
// Variáveis esperadas (passadas pelo controller):
// totalCategorias, totalCategoriasInativas, totalItens, totalItensInativos, vendasMes, faturamentoMes, ultimosItens
?>

<style>
    :root {
        --color-bg-primary: #f5f1e8;
        --color-bg-card: #FFFFFF;
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

    /* Layout Grid Topo */
    .content-wrapper {
        display: grid;
        grid-template-columns: 420px 1fr;
        gap: 40px;
        align-items: start;
        margin-bottom: 50px;
    }

    @media (max-width: 1100px) {
        .content-wrapper {
            grid-template-columns: 1fr;
        }
    }

    /* ============================================
       PROFILE CARD MODERNO (Baseado na Referência)
       ============================================ */
    .profile-card {
        background: white;
        border-radius: var(--radius-card);
        overflow: hidden;
        box-shadow: var(--shadow-card);
        transition: all 0.3s ease;
        position: relative;
    }

    .profile-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-5px);
    }

    /* Cover Header com Gradiente */
    .profile-header {
        position: relative;
        height: 180px;
        background: linear-gradient(135deg, #8b7355 0%, #b89968 50%, #d4c4a8 100%);
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle cx="100" cy="100" r="80" fill="rgba(255,255,255,0.05)"/></svg>');
        background-size: 150px;
        opacity: 0.4;
        animation: floatPattern 20s linear infinite;
    }

    @keyframes floatPattern {
        from { background-position: 0 0; }
        to { background-position: 200px 200px; }
    }

    /* Avatar com Badge de Upload */
    .profile-avatar-wrapper {
        position: absolute;
        bottom: -60px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 10;
    }
    
    .profile-header {
        position: relative;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 20px;
        border: 5px solid white;
        overflow: hidden;
        background: #f0ede5;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        position: relative;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-badge {
        position: absolute;
        bottom: -8px;
        right: -8px;
        background: var(--color-accent);
        width: 38px;
        height: 38px;
        border-radius: 12px;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        font-size: 14px;
    }

    .avatar-badge:hover {
        transform: scale(1.15);
        background: #6d5438;
        box-shadow: 0 4px 12px rgba(139, 115, 85, 0.4);
    }

    /* Content Area */
    .profile-content {
        padding: 75px 30px 30px;
    }

    .profile-name-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .profile-name {
        color: var(--color-text-primary);
        font-size: 22px;
        font-weight: 600;
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
        text-align: center;
        margin-bottom: 24px;
        line-height: 1.6;
    }

    /* Stats Grid Horizontal */
    .stats-grid {
        display: flex;
        justify-content: space-around;
        padding: 20px 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        margin: 24px 0;
    }

    .stat-box {
        text-align: center;
        flex: 1;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: scale(1.1);
    }

    .stat-box:not(:last-child) {
        border-right: 1px solid #f0f0f0;
    }

    .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: var(--color-text-primary);
        display: block;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 12px;
        color: var(--color-text-secondary);
        text-transform: capitalize;
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
        background: var(--color-accent);
        color: white;
        border: none;
        padding: 14px 24px;
        border-radius: 14px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: #6d5438;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(139, 115, 85, 0.3);
    }

    .btn-secondary {
        width: 54px;
        height: 54px;
        background: #f8f8f8;
        color: var(--color-accent);
        border: 2px solid #f0f0f0;
        border-radius: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .btn-secondary:hover {
        background: var(--color-accent);
        color: white;
        border-color: var(--color-accent);
        transform: translateY(-2px);
    }

    /* Profile Info Compact */
    .profile-info {
        background: #f8f8f8;
        border-radius: 16px;
        padding: 16px;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        color: var(--color-text-secondary);
        font-size: 13px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-item i {
        color: var(--color-accent);
        width: 20px;
        text-align: center;
        font-size: 14px;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .info-item-content {
        flex: 1;
        line-height: 1.5;
    }

    .info-item-content strong {
        color: var(--color-text-primary);
        font-weight: 600;
        display: block;
        margin-bottom: 2px;
        font-size: 12px;
    }

    /* Reading Scene Animation */
    .animation-container {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        position: relative;
        overflow: visible;
    }

    .reading-scene {
        position: relative;
        width: 450px;
        height: 450px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tree-container {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: floatTree 6s ease-in-out infinite;
    }

    @keyframes floatTree {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }

    .tree-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        filter: drop-shadow(0 20px 40px rgba(139, 115, 85, 0.3));
    }

    /* Flying letters animation */
    .letters-container {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: visible;
        top: 0;
        left: 0;
    }

    .flying-letter {
        position: absolute;
        font-size: 32px;
        font-weight: bold;
        color: #c9a36a;
        opacity: 0;
        font-family: 'Georgia', serif;
        animation: flyToPerson 5s infinite ease-in-out;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3), 0 0 20px rgba(201, 163, 106, 0.5);
        z-index: 100;
    }

    .flying-letter:nth-child(1) { animation-delay: 0s; top: -80px; left: 10%; }
    .flying-letter:nth-child(2) { animation-delay: 0.4s; top: -80px; right: 10%; }
    .flying-letter:nth-child(3) { animation-delay: 0.8s; left: -80px; top: 20%; }
    .flying-letter:nth-child(4) { animation-delay: 1.2s; right: -80px; top: 30%; }
    .flying-letter:nth-child(5) { animation-delay: 1.6s; left: -80px; top: 50%; }
    .flying-letter:nth-child(6) { animation-delay: 2s; right: -80px; top: 60%; }
    .flying-letter:nth-child(7) { animation-delay: 2.4s; bottom: -80px; left: 20%; }
    .flying-letter:nth-child(8) { animation-delay: 2.8s; bottom: -80px; right: 20%; }

    @keyframes flyToPerson {
        0% { opacity: 0; transform: translate(0, 0) rotate(0deg) scale(1); }
        15% { opacity: 1; }
        40% { opacity: 1; transform: translate(var(--tx), var(--ty)) rotate(360deg) scale(0.9); }
        60% { opacity: 0.8; transform: translate(calc(var(--tx) * 1.5), calc(var(--ty) * 1.5)) rotate(540deg) scale(0.6); }
        100% { opacity: 0; transform: translate(calc(var(--tx) * 2), calc(var(--ty) * 2)) rotate(720deg) scale(0.2); }
    }

    .flying-letter:nth-child(1) { --tx: 150px; --ty: 200px; }
    .flying-letter:nth-child(2) { --tx: -150px; --ty: 200px; }
    .flying-letter:nth-child(3) { --tx: 200px; --ty: 100px; }
    .flying-letter:nth-child(4) { --tx: -200px; --ty: 100px; }
    .flying-letter:nth-child(5) { --tx: 180px; --ty: 50px; }
    .flying-letter:nth-child(6) { --tx: -180px; --ty: 50px; }
    .flying-letter:nth-child(7) { --tx: 100px; --ty: -150px; }
    .flying-letter:nth-child(8) { --tx: -100px; --ty: -150px; }

    .magic-glow {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 500px;
        height: 500px;
        background: radial-gradient(ellipse at center, rgba(212, 196, 168, 0.2) 0%, rgba(201, 163, 106, 0.1) 30%, transparent 70%);
        animation: pulseGlow 4s infinite;
        pointer-events: none;
        z-index: -1;
    }

    @keyframes pulseGlow {
        0%, 100% { opacity: 0.4; transform: translate(-50%, -50%) scale(1); }
        50% { opacity: 0.8; transform: translate(-50%, -50%) scale(1.15); }
    }

    .sparkle {
        position: absolute;
        width: 4px;
        height: 4px;
        background: #d4c4a8;
        border-radius: 50%;
        animation: sparkleFloat 3s infinite;
        box-shadow: 0 0 10px #d4c4a8;
    }

    .sparkle:nth-child(1) { top: 15%; left: 15%; animation-delay: 0s; }
    .sparkle:nth-child(2) { top: 25%; right: 20%; animation-delay: 0.5s; }
    .sparkle:nth-child(3) { bottom: 30%; left: 25%; animation-delay: 1s; }
    .sparkle:nth-child(4) { bottom: 20%; right: 15%; animation-delay: 1.5s; }
    .sparkle:nth-child(5) { top: 40%; left: 10%; animation-delay: 2s; }

    @keyframes sparkleFloat {
        0%, 100% { opacity: 0; transform: translateY(0) scale(0); }
        50% { opacity: 1; transform: translateY(-20px) scale(1); }
    }

    .particles {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
    }

    .particle {
        position: absolute;
        font-size: 20px;
        opacity: 0.3;
        animation: float 20s infinite;
    }

    .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
    .particle:nth-child(2) { left: 30%; animation-delay: 4s; }
    .particle:nth-child(3) { left: 50%; animation-delay: 8s; }
    .particle:nth-child(4) { left: 70%; animation-delay: 12s; }
    .particle:nth-child(5) { left: 90%; animation-delay: 16s; }

    @keyframes float {
        0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
        10% { opacity: 0.3; }
        90% { opacity: 0.3; }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    /* Orders Section */
    .orders-section {
        background: white;
        border-radius: var(--radius-card);
        padding: 30px;
        box-shadow: var(--shadow-card);
        margin-top: 40px;
    }

    .section-header {
        font-size: 24px;
        color: var(--color-text-primary);
        font-weight: 600;
        margin-bottom: 24px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .content-wrapper {
            grid-template-columns: 1fr;
        }
        .reading-scene {
            transform: scale(0.85);
        }
    }

    @media (max-width: 768px) {
        .profile-actions {
            flex-direction: column;
        }
        .btn-secondary {
            width: 100%;
        }
        .reading-scene {
            transform: scale(0.65);
        }
    }
</style>

<div class="page-container">
    <div class="page-header">
        <h2><i class="fa fa-user-circle"></i> Perfil do Usuário</h2>
    </div>

    <div class="content-wrapper">
        <!-- Modern Profile Card -->
        <div class="profile-card">
            <!-- Cover Header -->
            <div class="profile-header"></div>

            <!-- Avatar -->
            <div class="profile-avatar-wrapper">
                <div class="profile-avatar">
                    <?php if (!empty($usuario['foto_perfil_usuario'])): ?>
                        <img src="<?= htmlspecialchars($usuario['foto_perfil_usuario']) ?>" alt="Avatar" id="avatar-img">
                    <?php else: ?>
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#d4c4a8; color:white; font-size:48px; font-weight:600;">
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
                        <span class="stat-number"><?= $total_pedidos ?? 0 ?></span>
                        <div class="stat-label">Pedidos</div>
                    </div>
                    <div class="stat-box">
                        <span class="stat-number"><?= $total_avaliacoes ?? 0 ?></span>
                        <div class="stat-label">Avaliações</div>
                    </div>
                    <div class="stat-box">
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

        <!-- Reading Scene Animation -->
        <div class="animation-container">
            <div class="particles">
                <div class="particle">📖</div>
                <div class="particle">📚</div>
                <div class="particle">📕</div>
                <div class="particle">📗</div>
                <div class="particle">📘</div>
            </div>

            <div class="reading-scene">
                <div class="magic-glow"></div>
                <div class="sparkle"></div>
                <div class="sparkle"></div>
                <div class="sparkle"></div>
                <div class="sparkle"></div>
                <div class="sparkle"></div>

                <div class="tree-container">
                    <img src="/img/banner2.png" alt="Pessoa lendo sob a árvore" class="tree-image" />
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
        </div>
    </div>

    <!-- Orders Section (mantida do original) -->
    <div class="orders-section">
        <div class="section-header">
            <i class="fa fa-shopping-bag"></i> Meus Pedidos
        </div>
        <!-- Resto do código de pedidos... -->
    </div>
</div>