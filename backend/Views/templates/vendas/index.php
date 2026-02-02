<style>
    :root {
        --bege-primary: #D4B896;
        --bege-light: #E8DCCF;
        --bege-dark: #B89968;
        --marrom: #8B6F47;
        --verde: #6B8E23;
        --azul: #5B9BD5;
        --laranja: #F4A460;
        --vermelho: #dc3545;
    }

    .vendas-container {
        background: linear-gradient(135deg, #f5f5f0 0%, #faf8f3 100%);
        min-height: 100vh;
        padding: 20px;
    }

    .vendas-header {
        background: linear-gradient(135deg, var(--bege-dark) 0%, var(--marrom) 100%);
        color: white;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .vendas-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 600;
    }

    .vendas-header .btn-nova-venda {
        background: white;
        color: var(--marrom);
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .vendas-header .btn-nova-venda:hover {
        background: var(--verde);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Cards de Estatísticas */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 4px solid;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .stat-card.brown {
        border-left-color: var(--marrom);
    }

    .stat-card.red {
        border-left-color: var(--vermelho);
    }

    .stat-card.green {
        border-left-color: var(--verde);
    }

    .stat-card.blue {
        border-left-color: var(--azul);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        color: white;
    }

    .stat-card.brown .stat-icon {
        background: linear-gradient(135deg, var(--marrom), #6B5235);
    }

    .stat-card.red .stat-icon {
        background: linear-gradient(135deg, #dc3545, #c82333);
    }

    .stat-card.green .stat-icon {
        background: linear-gradient(135deg, var(--verde), #557016);
    }

    .stat-card.blue .stat-icon {
        background: linear-gradient(135deg, var(--azul), #4A7FB8);
    }

    .stat-info {
        flex: 1;
        margin-left: 20px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    .stat-label {
        font-size: 14px;
        color: #666;
        margin: 5px 0 0 0;
    }

    /* Seção de Tabela */
    .table-section {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--bege-light);
    }

    .table-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--marrom);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Tabela Moderna */
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .modern-table thead th {
        background: linear-gradient(135deg, var(--bege-primary), var(--bege-dark));
        color: white;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
    }

    .modern-table thead th:first-child {
        border-top-left-radius: 8px;
    }

    .modern-table thead th:last-child {
        border-top-right-radius: 8px;
    }

    .modern-table tbody tr {
        transition: background 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: var(--bege-light);
    }

    .modern-table tbody td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        color: #333;
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Badges de Status */
    .badge-pagamento {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-dinheiro {
        background: #d4edda;
        color: #155724;
    }

    .badge-cartao {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-pix {
        background: #d4edda;
        color: #155724;
    }

    .badge-transferencia {
        background: #fff3cd;
        color: #856404;
    }

    /* Botões de Ação */
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .btn-action {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
    }

    .btn-edit {
        background: var(--azul);
        color: white;
    }

    .btn-edit:hover {
        background: #4A7FB8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(91, 155, 213, 0.3);
    }

    .btn-delete {
        background: var(--vermelho);
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    /* Paginação Moderna */
    .pagination-container {
        margin-top: 30px;
        text-align: center;
    }

    .pagination {
        display: inline-flex;
        gap: 5px;
        margin-bottom: 15px;
    }

    .pagination .page-btn {
        padding: 10px 16px;
        border: 2px solid var(--bege-primary);
        background: white;
        color: var(--marrom);
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .pagination .page-btn:hover {
        background: var(--bege-light);
        border-color: var(--bege-dark);
    }

    .pagination .page-btn.active {
        background: var(--bege-dark);
        color: white;
        border-color: var(--bege-dark);
    }

    .pagination-info {
        color: #666;
        font-size: 14px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
    }

    .empty-state i {
        font-size: 64px;
        color: var(--bege-dark);
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: var(--marrom);
        font-size: 24px;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 25px;
    }

    .empty-state .btn-primary {
        background: var(--verde);
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .empty-state .btn-primary:hover {
        background: #557016;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 142, 35, 0.3);
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .vendas-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .action-buttons {
            flex-direction: column;
        }

        .modern-table {
            font-size: 12px;
        }

        .modern-table thead th,
        .modern-table tbody td {
            padding: 10px;
        }
    }

    /* Animações */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card,
    .table-section {
        animation: fadeInUp 0.5s ease-out;
    }
</style>

<div class="vendas-container">
    <!-- Header -->
    <div class="vendas-header">
        <h1><i class="fa fa-shopping-cart"></i> Gerenciamento de Vendas</h1>
        <a href="/backend/vendas/criar" class="btn-nova-venda">
            <i class="fa fa-plus-circle"></i>
            Nova Venda
        </a>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="stats-grid">
        <div class="stat-card brown">
            <div class="stat-icon">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h2 class="stat-value"><?php echo $total_vendas ?? 0; ?></h2>
                <p class="stat-label">Total de Vendas</p>
            </div>
        </div>

        <div class="stat-card red">
            <div class="stat-icon">
                <i class="fa fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <h2 class="stat-value"><?php echo $total_inativos ?? 0; ?></h2>
                <p class="stat-label">Vendas Inativas</p>
            </div>
        </div>

        <div class="stat-card green">
            <div class="stat-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h2 class="stat-value"><?php echo $total_ativos ?? 0; ?></h2>
                <p class="stat-label">Vendas Ativas</p>
            </div>
        </div>

        <div class="stat-card blue">
            <div class="stat-icon">
                <i class="fa fa-dollar"></i>
            </div>
            <div class="stat-info">
                <h2 class="stat-value">R$ <?php
                $total_valor = 0;
                if (!empty($vendas)) {
                    foreach ($vendas as $v) {
                        $total_valor += $v['valor_total'];
                    }
                }
                echo number_format($total_valor, 2, ',', '.');
                ?></h2>
                <p class="stat-label">Valor Total</p>
            </div>
        </div>
    </div>

    <!-- Tabela de Vendas -->
    <?php if (isset($vendas) && count($vendas) > 0): ?>
        <div class="table-section">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fa fa-list"></i>
                    Lista de Vendas
                </h3>
            </div>

            <div style="overflow-x: auto;">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><i class="fa fa-calendar"></i> Data</th>
                            <th><i class="fa fa-money"></i> Valor Total</th>
                            <th><i class="fa fa-credit-card"></i> Pagamento</th>
                            <th><i class="fa fa-user"></i> Usuário</th>
                            <th style="text-align: center;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vendas as $venda): ?>
                            <tr>
                                <td><strong>#<?= htmlspecialchars($venda['id_venda']) ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($venda['data_venda'])) ?></td>
                                <td><strong>R$ <?= number_format($venda['valor_total'], 2, ',', '.') ?></strong></td>
                                <td>
                                    <?php
                                    $forma = htmlspecialchars($venda['forma_pagamento']);
                                    $badge_class = [
                                        'Dinheiro' => 'badge-dinheiro',
                                        'Cartão' => 'badge-cartao',
                                        'Pix' => 'badge-pix',
                                        'Transferência' => 'badge-transferencia'
                                    ];
                                    $class = $badge_class[$forma] ?? 'badge-dinheiro';
                                    ?>
                                    <span class="badge-pagamento <?= $class ?>"><?= $forma ?></span>
                                </td>
                                <td>#<?= htmlspecialchars($venda['id_usuario']) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/backend/vendas/editar/<?= $venda['id_venda'] ?>" class="btn-action btn-edit"
                                            title="Editar">
                                            <i class="fa fa-edit"></i> Editar
                                        </a>
                                        <a href="/backend/vendas/excluir/<?= $venda['id_venda'] ?>"
                                            class="btn-action btn-delete" title="Excluir"
                                            onclick="return confirm('Tem certeza que deseja excluir esta venda?');">
                                            <i class="fa fa-trash"></i> Excluir
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <?php if (isset($paginacao) && $paginacao['ultima_pagina'] > 1): ?>
                <div class="pagination-container">
                    <div class="pagination">
                        <?php if ($paginacao['pagina_atual'] > 1): ?>
                            <a href="/backend/vendas/listar/1" class="page-btn" title="Primeira página">
                                <i class="fa fa-angle-double-left"></i>
                            </a>
                            <a href="/backend/vendas/listar/<?= $paginacao['pagina_atual'] - 1 ?>" class="page-btn"
                                title="Página anterior">
                                <i class="fa fa-angle-left"></i>
                            </a>
                        <?php endif; ?>

                        <?php
                        $inicio = max(1, $paginacao['pagina_atual'] - 2);
                        $fim = min($paginacao['ultima_pagina'], $paginacao['pagina_atual'] + 2);

                        for ($i = $inicio; $i <= $fim; $i++): ?>
                            <?php if ($i == $paginacao['pagina_atual']): ?>
                                <span class="page-btn active"><?= $i ?></span>
                            <?php else: ?>
                                <a href="/backend/vendas/listar/<?= $i ?>" class="page-btn"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                            <a href="/backend/vendas/listar/<?= $paginacao['pagina_atual'] + 1 ?>" class="page-btn"
                                title="Próxima página">
                                <i class="fa fa-angle-right"></i>
                            </a>
                            <a href="/backend/vendas/listar/<?= $paginacao['ultima_pagina'] ?>" class="page-btn"
                                title="Última página">
                                <i class="fa fa-angle-double-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <p class="pagination-info">
                        Mostrando <strong><?= $paginacao['de'] ?></strong> a <strong><?= $paginacao['para'] ?></strong> de
                        <strong><?= $paginacao['total'] ?></strong> registros
                    </p>
                </div>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <!-- Empty State -->
        <div class="empty-state">
            <i class="fa fa-shopping-cart"></i>
            <h3>Nenhuma venda encontrada</h3>
            <p>Ainda não há vendas cadastradas no sistema. Comece adicionando a primeira venda!</p>
            <a href="/backend/vendas/criar" class="btn-primary">
                <i class="fa fa-plus-circle"></i>
                Cadastrar Primeira Venda
            </a>
        </div>
    <?php endif; ?>
</div>