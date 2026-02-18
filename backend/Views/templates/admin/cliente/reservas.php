<?php
// View de reservas ativas do cliente
// Variáveis esperadas: $usuario, $pedidos, $usuarioNome
?>

<style>
    :root {
        --color-bg-primary: #F8F5F1;
        --color-card-bg: #FFFFFF;
        --color-text-primary: #3D3D3D;
        --color-text-secondary: #8C8C8C;
        --color-accent: #C8B896;
        --color-vintage-brown: #8B7355;
        --shadow-soft: 0 10px 40px rgba(139, 115, 85, 0.08);
        --radius-main: 30px;
    }

    body {
        font-family: 'Outfit', 'Inter', sans-serif;
        background: var(--color-bg-primary);
        color: var(--color-text-primary);
    }

    .main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px;
    }

    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 800;
        color: var(--color-vintage-brown);
        margin: 0 0 10px;
    }

    .page-header p {
        color: var(--color-text-secondary);
        font-size: 15px;
    }

    /* Order Card Styles (Copied from index.php) */
    .order-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 30px;
        overflow: hidden;
        border: 1px solid #F0F0F0;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(139, 115, 85, 0.1);
    }

    .order-header {
        background: #FAFAFA;
        padding: 20px 30px;
        border-bottom: 1px solid #EEE;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-group-row {
        display: flex;
        gap: 40px;
    }

    .header-cell label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: var(--color-text-secondary);
        margin-bottom: 5px;
        letter-spacing: 0.5px;
    }

    .header-cell span {
        font-size: 14px;
        color: var(--color-text-primary);
        font-weight: 600;
    }

    .order-number-link {
        text-align: right;
    }

    .order-number-link label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: var(--color-text-secondary);
        margin-bottom: 5px;
    }

    .order-links-row {
        display: flex;
        gap: 15px;
    }

    .order-links-row a {
        font-size: 13px;
        color: var(--color-vintage-brown);
        text-decoration: none;
        font-weight: 600;
    }

    .order-links-row a:hover {
        text-decoration: underline;
    }

    .order-body {
        padding: 30px;
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }

    .order-item-image {
        width: 90px;
        height: 130px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .order-item-placeholder {
        width: 90px;
        height: 130px;
        background: #F5EFE6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--color-vintage-brown);
        font-size: 24px;
    }

    .order-item-details {
        flex: 1;
    }

    .status-text {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 8px;
        display: inline-block;
    }

    .status-pendente {
        color: #F5A623;
    }

    .status-entregue {
        color: #28A745;
    }

    .status-cancelado {
        color: #DC3545;
    }

    .status-enviado {
        color: #007BFF;
    }

    .item-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--color-vintage-brown);
        margin: 0 0 5px;
    }

    .item-description {
        font-size: 13px;
        color: #666;
        margin: 5px 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .item-price {
        font-weight: 700;
        color: var(--color-vintage-brown);
        margin: 10px 0;
        font-size: 16px;
    }

    .item-quantity {
        font-size: 13px;
        color: var(--color-text-secondary);
        margin: 0 0 10px;
    }

    .item-vendor {
        font-size: 12px;
        color: #999;
        margin-bottom: 20px;
    }

    .order-action-buttons {
        display: flex;
        gap: 15px;
    }

    .btn-action {
        padding: 10px 24px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        border: 1px solid #E0E0E0;
        background: white;
        color: var(--color-text-primary);
        transition: all 0.2s;
    }

    .btn-action:hover {
        background: #F9F9F9;
        border-color: #CCC;
    }

    .btn-action.gold {
        background: var(--color-vintage-brown);
        color: white;
        border: none;
    }

    .btn-action.gold:hover {
        background: #6B5235;
        box-shadow: 0 4px 10px rgba(139, 115, 85, 0.2);
    }

    .empty-state {
        text-align: center;
        padding: 60px;
        color: var(--color-text-secondary);
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 20px;
        color: #E0D8CC;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        backdrop-filter: blur(4px);
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        width: 90%;
        max-width: 600px;
        border-radius: 20px;
        padding: 30px;
        position: relative;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        animation: modalSlide 0.3s ease;
    }

    @keyframes modalSlide {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        border: none;
        font-size: 24px;
        color: #999;
        cursor: pointer;
        transition: color 0.2s;
    }

    .modal-close:hover {
        color: var(--color-vintage-brown);
    }

    .modal-header {
        margin-bottom: 20px;
        border-bottom: 1px solid #EEE;
        padding-bottom: 15px;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 22px;
        color: var(--color-vintage-brown);
    }

    .modal-body p {
        margin-bottom: 12px;
        line-height: 1.6;
        color: #555;
        font-size: 15px;
    }

    .modal-body strong {
        color: var(--color-text-primary);
    }

    .modal-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
        background: #F9F9F9;
        padding: 15px;
        border-radius: 12px;
    }

    /* ========================================
       TEMA ESCURO — RESERVAS
       ======================================== */
    [data-theme="dark"] .main-container {
        color: #f5f1e8;
    }

    [data-theme="dark"] .page-header h1 {
        color: #f5f1e8;
    }

    [data-theme="dark"] .order-card {
        background: #2a1f14;
        border-color: rgba(212, 165, 116, 0.1);
    }

    [data-theme="dark"] .order-header {
        background: #33261a;
        border-bottom-color: rgba(212, 165, 116, 0.1);
    }

    [data-theme="dark"] .header-cell label {
        color: #a89880;
    }

    [data-theme="dark"] .header-cell span {
        color: #d4c5a9;
    }

    [data-theme="dark"] .order-number-link {
        color: #d4a574;
    }

    [data-theme="dark"] .item-title {
        color: #f5f1e8;
    }

    [data-theme="dark"] .order-item-details p {
        color: #a89880;
    }

    [data-theme="dark"] .order-item-placeholder {
        background: #33261a;
        color: #a89880;
    }

    [data-theme="dark"] .btn-action {
        background: #33261a;
        color: #d4c5a9;
        border-color: rgba(212, 165, 116, 0.2);
    }

    [data-theme="dark"] .btn-action:hover {
        background: #d4a574;
        color: #1a1209;
    }

    [data-theme="dark"] .modal-content {
        background: #221a10;
        color: #f5f1e8;
    }

    [data-theme="dark"] .modal-info-grid {
        background: #33261a;
    }

    [data-theme="dark"] .modal-info-grid label {
        color: #a89880;
    }

    [data-theme="dark"] .modal-info-grid span {
        color: #d4c5a9;
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

        .page-header h1 {
            font-size: 22px;
        }

        .order-header {
            flex-direction: column;
            padding: 15px;
            gap: 10px;
        }

        .header-group-row {
            flex-wrap: wrap;
            gap: 20px;
        }

        .order-number-link {
            text-align: left;
        }

        .order-body {
            padding: 20px 15px;
            flex-direction: column;
        }

        .order-item-image {
            width: 100%;
            height: 180px;
        }

        .order-item-placeholder {
            width: 100%;
            height: 180px;
        }

        .order-action-buttons {
            flex-wrap: wrap;
        }

        .btn-action {
            flex: 1;
            min-width: 120px;
            text-align: center;
        }

        .modal-info-grid {
            grid-template-columns: 1fr;
        }

        .modal-content {
            padding: 25px 20px;
            width: 95%;
        }

        .order-card {
            border-radius: 16px;
        }
    }

    @media (max-width: 480px) {
        .page-header h1 {
            font-size: 20px;
        }

        .order-header {
            padding: 12px;
        }

        .header-cell label {
            font-size: 10px;
        }

        .header-cell span {
            font-size: 13px;
        }

        .order-body {
            padding: 15px 12px;
        }

        .item-title {
            font-size: 16px;
        }

        .btn-action {
            padding: 8px 16px;
            font-size: 12px;
        }

        .empty-state {
            padding: 40px 20px;
        }
    }
</style>

<div class="main-container">

    <div class="page-header">
        <h1>Suas Reservas</h1>
        <p>Acompanhe seus pedidos em andamento e histórico de reservas.</p>
    </div>

    <?php if (!empty($pedidos)): ?>
        <?php foreach ($pedidos as $pedido): ?>
            <div class="order-card">
                <div class="order-header">
                    <div class="header-group-row">
                        <div class="header-cell">
                            <label>DATA DA RESERVA</label>
                            <span><?= date('d/m/Y', strtotime($pedido['data_pedido'])) ?></span>
                        </div>
                        <div class="header-cell">
                            <label>TOTAL</label>
                            <span>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></span>
                        </div>
                    </div>
                    <div class="order-number-link">
                        <label>RESERVA Nº <?= $pedido['id_pedidos'] ?? $pedido['id'] ?></label>
                        <div class="order-links-row">
                            <?php
                            $primeiroItem = !empty($pedido['itens']) ? $pedido['itens'][0] : null;
                            $descricao = $primeiroItem['descricao'] ?? 'Sem descrição disponível.';
                            $titulo = $primeiroItem['titulo_item'] ?? 'Item do Pedido';
                            ?>
                            <a href="#" class="btn-detalhes" data-id="<?= $pedido['id_pedidos'] ?? $pedido['id'] ?>"
                                data-data="<?= date('d/m/Y', strtotime($pedido['data_pedido'])) ?>"
                                data-total="R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?>"
                                data-status="<?= htmlspecialchars($pedido['status']) ?>"
                                data-titulo="<?= htmlspecialchars($titulo) ?>" data-desc="<?= htmlspecialchars($descricao) ?>">
                                Detalhes
                            </a>
                        </div>
                    </div>
                </div>

                <div class="order-body">
                    <?php
                    $fotoItem = $primeiroItem['foto_item'] ?? null;

                    // Ajuste path
                    if (!empty($fotoItem) && strpos($fotoItem, '/uploads') === 0 && strpos($fotoItem, '/backend') === false) {
                        $fotoItem = '/backend' . $fotoItem;
                    }
                    ?>

                    <?php if (!empty($fotoItem)): ?>
                        <img src="<?= htmlspecialchars($fotoItem) ?>" class="order-item-image" alt="Item">
                    <?php else: ?>
                        <div class="order-item-placeholder"><i class="fa fa-book"></i></div>
                    <?php endif; ?>

                    <div class="order-item-details">
                        <?php
                        $statusRaw = strtolower($pedido['status'] ?? 'pendente');
                        $statusClass = 'status-pendente';
                        if (strpos($statusRaw, 'entreg') !== false)
                            $statusClass = 'status-entregue';
                        elseif (strpos($statusRaw, 'cancel') !== false)
                            $statusClass = 'status-cancelado';
                        elseif (strpos($statusRaw, 'envi') !== false)
                            $statusClass = 'status-enviado';
                        ?>
                        <span class="status-text <?= $statusClass ?>">
                            <?= htmlspecialchars($pedido['status']) ?>
                        </span>

                        <h3 class="item-title"><?= htmlspecialchars($primeiroItem['titulo_item'] ?? 'Item do Pedido') ?></h3>

                        <?php if (!empty($primeiroItem['descricao'])): ?>
                            <p class="item-description"><?= htmlspecialchars($primeiroItem['descricao']) ?></p>
                        <?php endif; ?>

                        <?php if (!empty($primeiroItem['preco_item'])): ?>
                            <p class="item-price">R$ <?= number_format($primeiroItem['preco_item'], 2, ',', '.') ?></p>
                        <?php endif; ?>

                        <?php if (count($pedido['itens']) > 1): ?>
                            <p class="item-quantity">+ <?= count($pedido['itens']) - 1 ?> outro(s) item(ns)</p>
                        <?php endif; ?>

                        <div class="order-action-buttons">
                            <a href="/produtos.html"><button class="btn-action gold">Reservar Novamente</button></a>
                            <button class="btn-action">Cancelar Reserva</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <i class="fa fa-shopping-bag"></i>
            <h3>Você ainda não tem reservas ativas.</h3>
            <p>Explore nosso acervo e encontre sua próxima leitura!</p>
            <a href="/produtos.html"><button class="btn-action gold">Reservar Novamente</button></a>
        </div>
    <?php endif; ?>

</div>

<!-- Modal Structure -->
<div class="modal-overlay" id="modalDetalhes">
    <div class="modal-content">
        <button class="modal-close">&times;</button>
        <div class="modal-header">
            <h2 id="modalTitle">Detalhes da Reserva</h2>
        </div>
        <div class="modal-body">
            <div class="modal-info-grid">
                <div>
                    <label style="display:block; font-size:11px; color:#888; font-weight:700">DATA</label>
                    <span id="modalData" style="font-weight:600"></span>
                </div>
                <div>
                    <label style="display:block; font-size:11px; color:#888; font-weight:700">STATUS</label>
                    <span id="modalStatus" style="font-weight:600"></span>
                </div>
                <div>
                    <label style="display:block; font-size:11px; color:#888; font-weight:700">TOTAL</label>
                    <span id="modalTotal" style="font-weight:600; color:#8B7355"></span>
                </div>
            </div>

            <h3 style="font-size:16px; margin:0 0 10px 0; color:#333">Item: <span id="modalItemTitle"></span></h3>
            <div
                style="background:#FFF; border:1px solid #EEE; padding:15px; border-radius:10px; max-height:200px; overflow-y:auto;">
                <p id="modalDesc" style="margin:0; font-size:14px; white-space: pre-wrap;"></p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modalDetalhes');
        const closeBtn = document.querySelector('.modal-close');
        const btnsDetalhes = document.querySelectorAll('.btn-detalhes');

        // Abrir Modal
        btnsDetalhes.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();

                // Popula dados
                document.getElementById('modalTitle').textContent = 'Reserva Nº ' + this.dataset.id;
                document.getElementById('modalData').textContent = this.dataset.data;
                document.getElementById('modalStatus').textContent = this.dataset.status;
                document.getElementById('modalTotal').textContent = this.dataset.total;
                document.getElementById('modalItemTitle').textContent = this.dataset.titulo;
                document.getElementById('modalDesc').textContent = this.dataset.desc;

                modal.classList.add('active');
            });
        });

        // Fechar Modal
        function fecharModal() {
            modal.classList.remove('active');
        }

        closeBtn.addEventListener('click', fecharModal);

        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                fecharModal();
            }
        });

        // Fechar com ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                fecharModal();
            }
        });
        // Cancelar Reserva
        const btnsCancelar = document.querySelectorAll('.btn-action:not(.gold):not(.modal-close)');
        btnsCancelar.forEach(btn => {
            btn.addEventListener('click', function () {
                const card = this.closest('.order-card');
                const id = card.querySelector('.btn-detalhes').dataset.id;

                if (confirm('Tem certeza que deseja cancelar esta reserva?')) {
                    const formData = new FormData();
                    formData.append('id_pedido', id);

                    fetch('/backend/admin/cliente/cancelar-reserva', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                window.location.reload();
                            } else {
                                alert('Erro: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Erro:', error);
                            alert('Erro ao processar cancelamento.');
                        });
                }
            });
        });
    });
</script>