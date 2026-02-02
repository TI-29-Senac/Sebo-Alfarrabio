<?php
// O header e footer já são incluídos pelo View::render
// Variáveis esperadas (passadas pelo controller):
// totalCategorias, totalCategoriasInativas, totalItens, totalItensInativos, vendasMes, faturamentoMes, ultimosItens
?>

<style>
    :root {
        --bege-primary: #D4B896;
        --bege-light: #E8DCCF;
        --bege-dark: #B89968;
        --marrom: #8B6F47;
        --verde: #6B8E23;
        --azul: #5B9BD5;
        --laranja: #F4A460;
        --roxo: #9370DB;
    }


    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #F5F5F5;
    }

    .page-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h2 {
        font-size: 32px;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header h2 i {
        color: #C8A870;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }

    @media (max-width: 1024px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }

    .profile-card {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .profile-header {
        display: flex;
        gap: 24px;
        align-items: start;
        margin-bottom: 24px;
    }

    .profile-avatar {
        position: relative;
    }

    .avatar-circle {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: linear-gradient(135deg, #C8A870 0%, #A88D5F 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: white;
        font-weight: 700;
        box-shadow: 0 4px 16px rgba(200, 168, 112, 0.3);
    }

    .avatar-circle img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .edit-avatar-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #C8A870;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        color: white;
    }

    .edit-avatar-btn:hover {
        background: #A88D5F;
        transform: scale(1.1);
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .edit-profile-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #F5F5F5;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        color: #666;
    }

    .edit-profile-btn:hover {
        background: #C8A870;
        color: white;
    }

    .profile-meta {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 20px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #666;
    }

    .meta-item i {
        color: #C8A870;
        width: 20px;
    }

    .meta-item strong {
        color: #333;
        margin-left: 4px;
    }

    .social-links {
        display: flex;
        gap: 10px;
        margin-top: 16px;
    }

    .social-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        color: white;
        text-decoration: none;
        font-size: 16px;
    }

    .social-btn:hover {
        transform: translateY(-3px);
    }

    .social-instagram {
        background: linear-gradient(135deg, #833AB4, #FD1D1D, #FCAF45);
    }

    .social-facebook {
        background: #3B5998;
    }

    .social-twitter {
        background: #1DA1F2;
    }

    .social-linkedin {
        background: #0077B5;
    }

    .social-youtube {
        background: #FF0000;
    }

    .social-github {
        background: #333;
    }

    .payment-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }

    .payment-header {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .payment-header i {
        color: #C8A870;
    }

    .card-number {
        background: linear-gradient(135deg, #C8A870 0%, #A88D5F 100%);
        padding: 20px;
        border-radius: 12px;
        color: white;
        margin-bottom: 20px;
        font-size: 18px;
        font-weight: 600;
        letter-spacing: 2px;
        text-align: center;
    }

    .payment-methods {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .payment-method {
        background: #F9F9F9;
        padding: 12px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .payment-method img {
        max-width: 100%;
        height: 32px;
        object-fit: contain;
    }

    .courses-section {
        background: white;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
    }

    .section-header {
        font-size: 22px;
        font-weight: 600;
        color: #333;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-header i {
        color: #C8A870;
    }

    .courses-timeline {
        position: relative;
        padding-left: 40px;
    }

    .timeline-line {
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, #C8A870, #E0E0E0);
    }

    .course-item {
        position: relative;
        margin-bottom: 24px;
        background: #F9F9F9;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s;
    }

    .course-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .course-item::before {
        content: '';
        position: absolute;
        left: -28px;
        top: 24px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: white;
        border: 3px solid #C8A870;
        z-index: 1;
    }

    .course-item.completed::before {
        background: #90C695;
        border-color: #90C695;
    }

    .course-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 12px;
        gap: 12px;
    }

    .course-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .course-description {
        font-size: 13px;
        color: #666;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .course-lessons {
        font-size: 13px;
        color: #999;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .course-lessons i {
        color: #C8A870;
    }

    .course-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-completed {
        background: #D4EDDA;
        color: #155724;
    }

    .badge-in-progress {
        background: #CCE5FF;
        color: #004085;
    }

    .badge-starts {
        background: #E8E8E8;
        color: #666;
    }

    .course-action {
        margin-top: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .action-btn {
        padding: 8px 16px;
        border-radius: 8px;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-primary {
        background: #C8A870;
        color: white;
    }

    .btn-primary:hover {
        background: #A88D5F;
    }

    .premium-card {
        background: linear-gradient(135deg, #C8A870 0%, #A88D5F 100%);
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(200, 168, 112, 0.3);
        color: white;
        margin-top: 24px;
    }

    .premium-header {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .premium-features {
        list-style: none;
        margin-bottom: 24px;
    }

    .premium-features li {
        padding: 8px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    .premium-features li i {
        color: #FFE69C;
    }

    .premium-btn {
        width: 100%;
        padding: 14px;
        background: white;
        color: #C8A870;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
    }

    .premium-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.3);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 24px;
    }

    .stat-box {
        background: #F9F9F9;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #C8A870;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 13px;
        color: #666;
    }
</style>

<div class="page-container">
    <div class="page-header">
        <h2><i class="fa fa-user-circle"></i> Perfil do Usuário</h2>
    </div>

    <div class="profile-grid">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <div class="avatar-circle">
                        <?php if (!empty($usuario['foto_perfil_usuario'])): ?>
                            <img src="<?= htmlspecialchars($usuario['foto_perfil_usuario']) ?>" alt="Avatar">
                        <?php else: ?>
                            <?= strtoupper(substr($usuario['nome_usuario'] ?? 'U', 0, 1)) ?>
                        <?php endif; ?>
                    </div>

                    <form id="form-foto" action="/backend/admin/cliente/foto" method="POST" enctype="multipart/form-data"
                        style="display:none;">
                        <input type="file" name="foto_usuario" id="input-foto" accept="image/*"
                            onchange="document.getElementById('form-foto').submit()">
                    </form>

                    <button class="edit-avatar-btn" title="Editar foto"
                        onclick="document.getElementById('input-foto').click()">
                        <i class="fa fa-camera"></i>
                    </button>
                </div>

                <div class="profile-info">
                    <div class="profile-name">
                        <?= htmlspecialchars($usuarioNome) ?>
                        <button class="edit-profile-btn" title="Editar perfil">
                            <i class="fa fa-pen"></i>
                        </button>
                    </div>

                    <div class="profile-meta">
                        <div class="meta-item">
                            <i class="fa fa-calendar-check"></i>
                            <span>Data de registro:
                                <strong><?= date('d/m/Y', strtotime($usuario['criado_em'] ?? 'now')) ?></strong></span>
                        </div>
                        <div class="meta-item">
                            <i class="fa fa-map-marker-alt"></i>
                            <span><?= htmlspecialchars($usuario['cidade'] ?? 'São Paulo') ?>,
                                <?= htmlspecialchars($usuario['estado'] ?? 'SP') ?></span>
                        </div>

                        <div class="meta-item">
                            <i class="fa fa-envelope"></i>
                            <span><?= htmlspecialchars($usuarioEmail) ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fa fa-phone"></i>
                            <span><?= htmlspecialchars($usuario['telefone'] ?? 'Telefone não cadastrado') ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fa fa-map-marker-alt"></i>
                            <span><?= htmlspecialchars($usuario['endereco'] ?? 'Endereço não cadastrado') ?></span>
                        </div>
                    </div>


                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-number"><?= $total_pedidos ?? 0 ?></div>
                    <div class="stat-label">Pedidos</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number"><?= $total_avaliacoes ?? 0 ?></div>
                    <div class="stat-label">Avaliações</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number"><?= $total_favoritos ?? 0 ?></div>
                    <div class="stat-label">Favoritos</div>
                </div>
            </div>
        </div>

        <div>



        </div>
    </div>

    <div class="orders-section">
        <div class="section-header">
            <i class="fa fa-shopping-bag"></i> Meus Pedidos
        </div>

        <!-- Tab links -->
        <div class="tab">
            <button class="tablinks active" onclick="openOrderTab(event, 'MeusPedidos')">
                <i class="fa fa-clock"></i> Meus Pedidos
            </button>
            <button class="tablinks" onclick="openOrderTab(event, 'Concluidos')">
                <i class="fa fa-check-circle"></i> Pedidos Concluídos
            </button>
            <button class="tablinks" onclick="openOrderTab(event, 'Reservados')">
                <i class="fa fa-bookmark"></i> Reservados
            </button>
        </div>

        <!-- Tab content -->
        <div id="MeusPedidos" class="tabcontent" style="display: block;">
            <h3><i class="fa fa-clock"></i> Meus Pedidos</h3>

            <?php
            $temPedidos = false;
            foreach ($pedidos as $p):
                if ($p['status'] == 'Concluído' || $p['status'] == 'Entregue')
                    continue;
                $temPedidos = true;
                ?>
                <div class="order-card">
                    <div class="order-status-badge badge-in-progress"><?= htmlspecialchars($p['status']) ?></div>
                    <div class="order-title">Pedido #<?= $p['id_pedidos'] ?? $p['id'] ?></div>

                    <?php if (!empty($p['itens'])): ?>
                        <?php foreach ($p['itens'] as $item): ?>
                            <div class="order-product">
                                <?= htmlspecialchars($item['titulo_item']) ?>
                                <small style="font-size: 0.6em; color: #666;">(x<?= $item['quantidade'] ?>)</small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="order-product">Detalhes indisponíveis</div>
                    <?php endif; ?>

                    <div class="order-info">
                        <div class="order-date">
                            <i class="fa fa-calendar"></i> <?= date('d/m/Y', strtotime($p['data_pedido'])) ?>
                        </div>
                        <div class="order-shipping">
                            <i class="fa fa-dollar-sign"></i> R$ <?= number_format($p['valor_total'], 2, ',', '.') ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (!$temPedidos): ?>
                <p style="color: #666; font-style: italic;">Nenhum pedido em andamento.</p>
            <?php endif; ?>
        </div>

        <div id="Concluidos" class="tabcontent">
            <h3><i class="fa fa-check-circle"></i> Pedidos Concluídos</h3>

            <?php
            $temConcluidos = false;
            foreach ($pedidos as $p):
                if ($p['status'] != 'Concluído' && $p['status'] != 'Entregue')
                    continue;
                $temConcluidos = true;
                ?>
                <div class="order-card">
                    <div class="order-status-badge badge-completed"><?= htmlspecialchars($p['status']) ?></div>
                    <div class="order-title">Pedido #<?= $p['id_pedidos'] ?? $p['id'] ?></div>

                    <?php if (!empty($p['itens'])): ?>
                        <?php foreach ($p['itens'] as $item): ?>
                            <div class="order-product">
                                <?= htmlspecialchars($item['titulo_item']) ?>
                                <small style="font-size: 0.6em; color: #666;">(x<?= $item['quantidade'] ?>)</small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="order-info">
                        <div class="order-date">
                            <i class="fa fa-calendar"></i> <?= date('d/m/Y', strtotime($p['data_pedido'])) ?>
                        </div>
                        <div class="order-shipping">
                            <i class="fa fa-check"></i> Finalizado
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if (!$temConcluidos): ?>
                <p style="color: #666; font-style: italic;">Nenhum pedido concluído.</p>
            <?php endif; ?>
        </div>

        <div id="Reservados" class="tabcontent">
            <h3><i class="fa fa-bookmark"></i> Reservados</h3>

            <div class="empty-state">
                <i class="fa fa-bookmark"></i>
                <p>Nenhum item reservado</p>
                <small>Reserve produtos para comprar depois</small>
            </div>
        </div>

        <style>
            /* Estilo das abas */
            .tab {
                overflow: hidden;
                border: 1px solid #ccc;
                background-color: #f1f1f1;
                border-radius: 8px 8px 0 0;
            }

            .tab button {
                background-color: inherit;
                float: left;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 20px;
                transition: 0.3s;
                font-size: 14px;
                font-weight: 500;
                color: #666;
            }

            .tab button i {
                margin-right: 6px;
            }

            .tab button:hover {
                background-color: #ddd;
            }

            .tab button.active {
                background-color: #d4af7a;
                color: white;
            }

            /* Conteúdo das abas */
            .tabcontent {
                display: none;
                padding: 20px;
                border: 1px solid #ccc;
                border-top: none;
                background: white;
                border-radius: 0 0 8px 8px;
                min-height: 400px;
            }

            .tabcontent h3 {
                font-size: 20px;
                font-weight: bold;
                color: #8B7355;
                margin: 0 0 20px 0;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            /* Cards dos pedidos */
            .order-card {
                background: #f8f8f8;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 16px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                position: relative;
            }

            .order-status-badge {
                position: absolute;
                top: 16px;
                right: 16px;
                padding: 6px 14px;
                border-radius: 12px;
                font-size: 12px;
                font-weight: 600;
            }

            .badge-completed {
                background: #d4edda;
                color: #155724;
            }

            .badge-in-progress {
                background: #d1ecf1;
                color: #0c5460;
            }

            .order-title {
                font-size: 14px;
                font-weight: bold;
                color: #333;
                margin-bottom: 6px;
            }

            .order-product {
                font-size: 18px;
                font-weight: 600;
                color: #8B7355;
                margin-bottom: 10px;
            }

            .order-description {
                font-size: 14px;
                color: #666;
                margin-bottom: 16px;
                line-height: 1.5;
            }

            .order-info {
                display: flex;
                gap: 20px;
                margin-bottom: 16px;
                font-size: 13px;
                color: #888;
            }

            .order-info i {
                margin-right: 6px;
            }

            .action-btn {
                width: 100%;
                padding: 12px;
                border: none;
                border-radius: 6px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s;
            }

            .btn-primary {
                background: #d4af7a;
                color: white;
            }

            .btn-primary:hover {
                background: #c09960;
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            }

            .action-btn i {
                margin-right: 8px;
            }

            /* Estado vazio */
            .empty-state {
                text-align: center;
                padding: 60px 20px;
                color: #999;
            }

            .empty-state i {
                font-size: 64px;
                margin-bottom: 20px;
                opacity: 0.3;
            }

            .empty-state p {
                font-size: 16px;
                font-weight: 600;
                margin-bottom: 8px;
                color: #666;
            }

            .empty-state small {
                font-size: 13px;
                color: #aaa;
            }

            /* Responsivo */
            @media (max-width: 768px) {
                .tab button {
                    font-size: 12px;
                    padding: 12px 14px;
                }

                .order-product {
                    font-size: 16px;
                }
            }
        </style>

        <script>
            function openOrderTab(evt, tabName) {
                var i, tabcontent, tablinks;

                // Esconde todo o conteúdo das abas
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }

                // Remove a classe "active" de todos os botões
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }

                // Mostra a aba atual e adiciona a classe "active" ao botão clicado
                document.getElementById(tabName).style.display = "block";
                evt.currentTarget.className += " active";
            }
        </script>