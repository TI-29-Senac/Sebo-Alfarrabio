<style>
    .dashboard-header {
        padding: 22px 0;
        margin-bottom: 30px;
    }

    .dashboard-header h5 {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .stats-container {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        flex: 1;
        background: white;
        border: 2px solid;
        border-radius: 12px;
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-card.blue {
        border-color: #5B9BD5;
    }

    .stat-card.orange {
        border-color: #F4A460;
    }

    .stat-card.green {
        border-color: #90C695;
    }

    .stat-card.money {
        border-color: #D4AF37;
    }

    .stat-icon {
        font-size: 48px;
        opacity: 0.2;
    }

    .stat-card.blue .stat-icon {
        color: #5B9BD5;
    }

    .stat-card.orange .stat-icon {
        color: #F4A460;
    }

    .stat-card.green .stat-icon {
        color: #90C695;
    }

    .stat-card.money .stat-icon {
        color: #D4AF37;
    }

    .stat-content {
        text-align: left;
    }

    .stat-number {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        margin: 0;
        line-height: 1;
    }

    .stat-label {
        font-size: 14px;
        color: #666;
        margin-top: 8px;
    }

    .alert-section {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .alert-box {
        flex: 1;
        padding: 16px 24px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .alert-box.warning {
        background-color: #FFF4E6;
    }

    .alert-box.info {
        background-color: #FFE8D6;
    }

    .alert-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-icon {
        font-size: 20px;
    }

    .alert-text {
        font-size: 15px;
        font-weight: 500;
        color: #333;
    }

    .alert-badge {
        background: white;
        padding: 4px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 18px;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .view-all {
        color: #C8A870;
        text-decoration: none;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .view-all:hover {
        text-decoration: underline;
    }

    .data-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .data-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: #C8A870;
    }

    .data-table thead th {
        padding: 16px;
        text-align: left;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }

    .data-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
    }

    .data-table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .data-table tbody td {
        padding: 16px;
        font-size: 14px;
        color: #333;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-badge.active {
        background-color: #D4EDDA;
        color: #155724;
    }

    .status-badge.inactive {
        background-color: #F8D7DA;
        color: #721C24;
    }

    .btn {
        padding: 6px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
        display: inline-block;
        margin-right: 5px;
        transition: opacity 0.2s;
    }

    .btn:hover {
        opacity: 0.8;
    }

    .btn-edit {
        background-color: #5B9BD5;
        color: white;
    }

    .btn-delete {
        background-color: #E74C3C;
        color: white;
    }

    .btn-create {
        background-color: #C8A870;
        color: white;
        padding: 12px 24px;
        font-size: 15px;
        border-radius: 8px;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }

    .pagination .btn {
        background-color: white;
        border: 1px solid #ddd;
        color: #333;
    }

    .pagination .btn.active {
        background-color: #C8A870;
        color: white;
        border-color: #C8A870;
    }

    .pagination-info {
        text-align: center;
        color: #666;
        font-size: 14px;
        margin-top: 10px;
    }

    .empty-state {
        background: #FFF4E6;
        padding: 24px;
        border-radius: 8px;
        text-align: center;
    }
</style>

<div class="dashboard-header">
    <h5><i class="fa fa-users"></i> Dashboard Usuários</h5>
</div>

<div class="stats-container">
    <div class="stat-card blue">
        <div class="stat-content">
            <h2 class="stat-number"><?php echo $total_ativos; ?></h2>
            <div class="stat-label">Usuários Ativos</div>
        </div>
        <div class="stat-icon">
            <i class="fa fa-user-check"></i>
        </div>
    </div>

    <div class="stat-card orange">
        <div class="stat-content">
            <h2 class="stat-number"><?php echo $total_inativos ?? 0; ?></h2>
            <div class="stat-label">Usuários Inativos</div>
        </div>
        <div class="stat-icon">
            <i class="fa fa-user-times"></i>
        </div>
    </div>

    <div class="stat-card green">
        <div class="stat-content">
            <h2 class="stat-number"><?php echo $total_usuarios; ?></h2>
            <div class="stat-label">Total de Usuários</div>
        </div>
        <div class="stat-icon">
            <i class="fa fa-users"></i>
        </div>
    </div>

    <div class="stat-card money">
        <div class="stat-content">
            <a href="/backend/usuario/criar" class="btn btn-create" style="display: block;">
                <i class="fa fa-plus"></i> Criar Usuário
            </a>
        </div>
    </div>
</div>

<div class="alert-section">
    <div class="alert-box warning">
        <div class="alert-content">
            <span class="alert-icon">⚠️</span>
            <span class="alert-text">Usuários Pendentes de Ativação:</span>
        </div>
        <div class="alert-badge">0</div>
    </div>

    <div class="alert-box info">
        <div class="alert-content">
            <span class="alert-icon">📦</span>
            <span class="alert-text">Novos Cadastros Este Mês:</span>
        </div>
        <div class="alert-badge">0</div>
    </div>
</div>

<div class="section-header">
    <h3 class="section-title">
        <i class="fa fa-list"></i> Lista de Usuários
    </h3>
    <a href="/backend/usuario/listar" class="view-all">
        Ver todos <i class="fa fa-arrow-right"></i>
    </a>
</div>

<?php if (!empty($usuarios)): ?>
    <div class="data-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td>#<?php echo $u['id_usuario']; ?></td>
                        <td><?php echo htmlspecialchars($u['nome_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($u['email_usuario']); ?></td>
                        <td><?php echo ucfirst($u['tipo_usuario']); ?></td>
                        <td>
                            <span class="status-badge <?php echo ($u['excluido_em'] ? 'inactive' : 'active'); ?>">
                                <?php echo ($u['excluido_em'] ? 'Inativo' : 'Ativo'); ?>
                            </span>
                        </td>
                        <td>
                            <a href="/backend/usuario/editar/<?php echo $u['id_usuario']; ?>" class="btn btn-edit">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <a href="/backend/usuario/excluir/<?php echo $u['id_usuario']; ?>" class="btn btn-delete"
                                onclick="return confirm('Tem certeza que deseja desativar este usuário?');">
                                <i class="fa fa-trash"></i> Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($paginacao['ultima_pagina'] > 1): ?>
        <div class="pagination">
            <?php if ($paginacao['pagina_atual'] > 1): ?>
                <a href="/backend/usuario/listar/<?= $paginacao['pagina_atual'] - 1 ?>" class="btn">
                    <i class="fa fa-chevron-left"></i> Anterior
                </a>
            <?php endif; ?>

            <span class="btn active">
                Página <?= $paginacao['pagina_atual'] ?> de <?= $paginacao['ultima_pagina'] ?>
            </span>

            <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                <a href="/backend/usuario/listar/<?= $paginacao['pagina_atual'] + 1 ?>" class="btn">
                    Próximo <i class="fa fa-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
        <p class="pagination-info">
            Mostrando <?= $paginacao['de'] ?> a <?= $paginacao['para'] ?> de <?= $paginacao['total'] ?> usuários
        </p>
    <?php endif; ?>
<?php else: ?>
    <div class="empty-state">
        <i class="fa fa-users" style="font-size: 48px; color: #C8A870; margin-bottom: 16px;"></i>
        <h3>Nenhum usuário cadastrado</h3>
        <p>Comece criando o primeiro usuário do sistema.</p>
        <a href="/backend/usuario/criar" class="btn btn-create" style="margin-top: 16px;">
            <i class="fa fa-plus"></i> Criar Primeiro Usuário
        </a>
    </div>
<?php endif; ?>