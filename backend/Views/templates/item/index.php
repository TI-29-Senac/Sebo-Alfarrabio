<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Source+Sans+3:wght@300;400;600&display=swap"
    rel="stylesheet">
<style>
    :root {
        --primary: #8B7355;
        --primary-dark: #6d5a45;
        --accent: #d4af7a;
        --accent-light: #e8d4b8;
        --success: #5a9b7d;
        --warning: #d4a574;
        --danger: #c66b6b;
        --bg-main: #f8f6f3;
        --bg-card: #ffffff;
        --text-primary: #2c2420;
        --text-secondary: #6b6460;
        --border: #e6dfd8;
    }

    /* Dark Theme Overrides */
    [data-theme="dark"] {
        --primary: #8B7355;
        /* Keep or adjust */
        --primary-dark: #5a4b3a;
        --accent: #d4af7a;
        --accent-light: #3d2e20;
        /* Darker accent bg */
        --bg-main: #1a1209;
        --bg-card: #221a10;
        --text-primary: #f5f1e8;
        --text-secondary: #d4c5a9;
        --border: rgba(212, 165, 116, 0.2);
    }

    [data-theme="dark"] .search-input {
        background: #33261a;
        color: #f5f1e8;
        border-color: var(--border);
    }

    [data-theme="dark"] .search-input:focus {
        background: #2a1f14;
    }

    [data-theme="dark"] thead {
        background: #2a1f14;
    }

    [data-theme="dark"] tbody tr:hover {
        background: rgba(212, 165, 116, 0.05);
    }

    [data-theme="dark"] .price-display-cell {
        background: #33261a;
        border-color: rgba(212, 165, 116, 0.3);
        color: #f5f1e8;
    }

    [data-theme="dark"] .price-value {
        color: #d4a574;
    }

    [data-theme="dark"] .currency-symbol {
        color: #8a7a6a;
    }

    /* Dark Mode - Action Buttons */
    [data-theme="dark"] .btn-action {
        background: #33261a !important;
        /* Force dark background */
        border: 1px solid #3d2e20;
        box-shadow: none;
    }

    [data-theme="dark"] .btn-edit {
        color: #d4a574;
        /* Gold/Orange */
    }

    [data-theme="dark"] .btn-delete {
        color: #ff6b6b;
        /* Bright Red */
    }

    [data-theme="dark"] .btn-action:hover {
        background: #2a1f14 !important;
        transform: translateY(-2px);
    }

    /* Dark Mode - Stock Badges */
    [data-theme="dark"] .stock-badge {
        background: #221a10;
        border: 1px solid;
    }

    [data-theme="dark"] .stock-badge.high {
        border-color: #2e7d32;
        color: #81c784;
    }

    [data-theme="dark"] .stock-badge.medium {
        border-color: #e65100;
        color: #ffb74d;
    }

    [data-theme="dark"] .stock-badge.low {
        border-color: #c62828;
        color: #e57373;
    }

    /* Dark Mode - Item Types */
    [data-theme="dark"] .item-type {
        background: #221a10;
        border: 1px solid;
    }

    [data-theme="dark"] .item-type.livro {
        border-color: #1565c0;
        color: #64b5f6;
    }

    [data-theme="dark"] .item-type.cd {
        border-color: #ef6c00;
        color: #ffb74d;
    }

    [data-theme="dark"] .item-type.dvd {
        border-color: #6a1b9a;
        color: #ba68c8;
    }

    [data-theme="dark"] .item-type.revista {
        border-color: #2e7d32;
        color: #81c784;
    }

    /* Dark Mode - Stat Icons */
    [data-theme="dark"] .stat-icon-wrapper {
        background: #33261a !important;
    }

    [data-theme="dark"] .stat-icon-wrapper.blue {
        color: #64b5f6;
        border: 1px solid #1565c0;
    }

    [data-theme="dark"] .stat-icon-wrapper.green {
        color: #81c784;
        border: 1px solid #2e7d32;
    }

    [data-theme="dark"] .stat-icon-wrapper.red {
        color: #e57373;
        border: 1px solid #c62828;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body style removed to avoid conflict with main layout */
    .item-manager-wrapper {
        font-family: 'Source Sans 3', sans-serif;
        background: var(--bg-main);
        color: var(--text-primary);
        min-height: 100vh;
    }

    /* Header Superior */
    .top-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 25px 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .header-content {
        max-width: 1600px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .header-icon {
        font-size: 42px;
        color: #ffd700;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    .header-text h1 {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 700;
        color: white;
        margin-bottom: 5px;
        letter-spacing: -0.5px;
    }

    .header-text p {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.85);
        font-weight: 300;
    }

    .btn-add-new {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 14px 28px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s;
    }

    .btn-add-new:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    .container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 35px 40px;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: var(--bg-card);
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--border);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent) 0%, var(--primary) 100%);
        transform: scaleX(0);
        transition: transform 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
        font-size: 28px;
        transition: transform 0.3s;
    }

    .stat-card:hover .stat-icon-wrapper {
        transform: scale(1.1) rotate(5deg);
    }

    .stat-icon-wrapper.blue {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        color: #1976d2;
    }

    .stat-icon-wrapper.green {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        color: var(--success);
    }

    .stat-icon-wrapper.red {
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
        color: var(--danger);
    }

    .stat-value {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 8px;
        line-height: 1;
    }

    .stat-label {
        font-size: 14px;
        color: var(--text-secondary);
        font-weight: 400;
        letter-spacing: 0.3px;
    }

    /* Search Section */
    .search-section {
        background: var(--bg-card);
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 30px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        border: 1px solid var(--border);
    }

    .search-form {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .search-input-wrapper {
        flex: 1;
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-secondary);
        font-size: 18px;
    }

    .search-input {
        width: 100%;
        padding: 14px 18px 14px 52px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-size: 15px;
        font-family: 'Source Sans 3', sans-serif;
        transition: all 0.3s;
        background: #fafafa;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--accent);
        background: white;
        box-shadow: 0 0 0 4px rgba(212, 175, 122, 0.1);
    }

    .btn {
        padding: 14px 26px;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .btn-search {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
    }

    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(139, 115, 85, 0.3);
    }

    .btn-clear {
        background: var(--danger);
        color: white;
    }

    .btn-clear:hover {
        background: #b02a37;
        transform: translateY(-2px);
    }

    .search-result-text {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--border);
        color: var(--text-secondary);
        font-size: 14px;
    }

    .search-result-text strong {
        color: var(--primary);
    }

    /* Table Container */
    .table-container {
        background: var(--bg-card);
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        border: 1px solid var(--border);
    }

    .table-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 20px 30px;
        color: white;
    }

    .table-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #f8f6f3;
    }

    th {
        padding: 18px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--primary);
        border-bottom: 2px solid var(--border);
    }

    th:first-child {
        text-align: center;
    }

    tbody tr {
        transition: all 0.2s;
        border-bottom: 1px solid var(--border);
    }

    tbody tr:hover {
        background: linear-gradient(90deg, rgba(232, 220, 184, 0.15) 0%, transparent 100%);
    }

    tbody tr:last-child {
        border-bottom: none;
    }

    td {
        padding: 20px;
        vertical-align: middle;
        font-size: 14px;
    }

    .item-image {
        width: 80px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .item-image:hover {
        transform: scale(1.5);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    .item-title {
        font-weight: 600;
        color: var(--text-primary);
        max-width: 250px;
    }

    .item-type {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .item-type.livro {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        color: #1976d2;
    }

    .item-type.cd {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        color: #e65100;
    }

    .item-type.dvd {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
        color: #7b1fa2;
    }

    .item-type.revista {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        color: #2e7d32;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
    }

    .stock-badge.high {
        background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
        color: var(--success);
    }

    .stock-badge.medium {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        color: #e65100;
    }

    .stock-badge.low {
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
        color: var(--danger);
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .price-display-cell {
        display: inline-flex;
        align-items: baseline;
        gap: 4px;
        padding: 8px 16px;
        background: linear-gradient(135deg, #f9f7f4 0%, #f3efe9 100%);
        border-radius: 20px;
        border: 2px solid var(--accent-light);
        font-weight: 600;
    }

    .price-currency {
        font-size: 12px;
        color: var(--text-secondary);
        font-weight: 600;
    }

    .price-value {
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        color: var(--primary);
        font-weight: 700;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        font-size: 14px;
        text-decoration: none;
    }

    .btn-edit {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        color: var(--warning);
    }

    .btn-edit:hover {
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 4px 12px rgba(244, 164, 96, 0.3);
    }

    .btn-delete {
        background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
        color: var(--danger);
    }

    .btn-delete:hover {
        transform: translateY(-2px) scale(1.1);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-secondary);
    }

    .empty-state i {
        font-size: 64px;
        color: var(--accent);
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state p {
        font-size: 18px;
        margin-bottom: 10px;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
    }

    .pagination li {
        border-radius: 8px;
        overflow: hidden;
    }

    .pagination a,
    .pagination span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
    }

    .pagination a {
        background: var(--bg-card);
        color: var(--primary);
        border: 2px solid var(--border);
    }

    .pagination a:hover {
        background: var(--accent-light);
        border-color: var(--accent);
        transform: translateY(-2px);
    }

    .pagination li.active span {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        border: 2px solid var(--primary);
    }

    .pagination li.disabled span {
        background: #f5f5f5;
        color: #ccc;
        border: 2px solid #e0e0e0;
        cursor: not-allowed;
    }

    .pagination-info {
        color: var(--text-secondary);
        font-size: 14px;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .top-header {
            padding: 20px;
        }

        .header-content {
            flex-direction: column;
            gap: 20px;
        }

        .header-left {
            flex-direction: column;
            text-align: center;
        }

        .header-text h1 {
            font-size: 28px;
        }

        .container {
            padding: 20px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .search-form {
            flex-direction: column;
        }

        .search-input-wrapper,
        .btn {
            width: 100%;
        }
    }

    /* Body style removed to avoid conflict with main layout */
    .item-manager-wrapper {
        font-family: 'Source Sans 3', sans-serif;
        background: var(--bg-main);
        color: var(--text-primary);
        min-height: 100vh;
    }

    /* Animation */
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

    .stat-card,
    .search-section,
    .table-container {
        animation: fadeIn 0.6s ease-out;
    }

    .stat-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .stat-card:nth-child(3) {
        animation-delay: 0.2s;
    }

    .search-section {
        animation-delay: 0.3s;
    }

    .table-container {
        animation-delay: 0.4s;
    }
</style>

<div class="item-manager-wrapper">
    <!-- Header Superior -->
    <div class="top-header">
        <div class="header-content">
            <div class="header-left">
                <i class="fa fa-cubes header-icon"></i>
                <div class="header-text">
                    <h1>Gerenciamento de Itens</h1>
                    <p>Gerencie todo o catálogo do seu sebo</p>
                </div>
            </div>
            <a href="/backend/item/criar" class="btn-add-new">
                <i class="fa fa-plus-circle"></i>
                Adicionar Novo Item
            </a>
        </div>
    </div>

    <div class="container">
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon-wrapper blue">
                    <i class="fa fa-archive"></i>
                </div>
                <div class="stat-value"><?= $total_itens ?? 0 ?></div>
                <div class="stat-label">Total de Itens</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-wrapper green">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="stat-value"><?= $total_ativos ?? 0 ?></div>
                <div class="stat-label">Itens Ativos</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-wrapper red">
                    <i class="fa fa-trash"></i>
                </div>
                <div class="stat-value"><?= $total_inativos ?? 0 ?></div>
                <div class="stat-label">Itens Inativos (Lixeira)</div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <form method="GET" action="/backend/item/listar" class="search-form">
                <div class="search-input-wrapper">
                    <i class="fa fa-search search-icon"></i>
                    <input type="text" name="search" class="search-input"
                        placeholder="Pesquisar por título, autor, categoria, gênero ou ISBN..."
                        value="<?= htmlspecialchars($termo_pesquisa ?? '') ?>" />
                </div>
                <button type="submit" class="btn btn-search">
                    <i class="fa fa-search"></i>
                    Pesquisar
                </button>
                <?php if (!empty($termo_pesquisa)): ?>
                    <a href="/backend/item/listar" class="btn btn-clear">
                        <i class="fa fa-times"></i>
                        Limpar
                    </a>
                <?php endif; ?>
            </form>

            <?php if (!empty($termo_pesquisa)): ?>
                <div class="search-result-text">
                    Resultados para: <strong><?= htmlspecialchars($termo_pesquisa) ?></strong>
                </div>
            <?php endif; ?>
        </div>

        <!-- Table Container -->
        <div class="table-container">
            <div class="table-header">
                <h2 class="table-title">
                    <i class="fa fa-list"></i>
                    Lista de Itens
                </h2>
            </div>

            <div class="table-wrapper">
                <?php if (empty($itens)): ?>
                    <div class="empty-state">
                        <i class="fa fa-inbox"></i>
                        <p>Nenhum item encontrado</p>
                        <small>Tente ajustar os filtros de pesquisa ou adicione novos itens ao catálogo</small>
                    </div>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align: center;">Foto</th>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th>Gênero</th>
                                <th>Categoria</th>
                                <th>Autores/Artistas</th>
                                <th style="text-align: center;">Preço</th>
                                <th style="text-align: center;">Estoque</th>
                                <th style="text-align: center;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itens as $item): ?>
                                <tr>
                                    <td style="text-align: center;">
                                        <img src="<?= \Sebo\Alfarrabio\Models\Item::corrigirCaminhoImagem($item['foto_item']) ?>"
                                            alt="<?= htmlspecialchars($item['titulo_item']) ?>" class="item-image" />
                                    </td>
                                    <td>
                                        <div class="item-title"><?= htmlspecialchars($item['titulo_item']) ?></div>
                                    </td>
                                    <td>
                                        <span class="item-type <?= strtolower($item['tipo_item']) ?>">
                                            <?= htmlspecialchars(ucfirst($item['tipo_item'])) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($item['nome_genero']) ?></td>
                                    <td><?= htmlspecialchars($item['nome_categoria']) ?></td>
                                    <td><?= htmlspecialchars($item['autores'] ?? 'N/A') ?></td>
                                    <td style="text-align: center;">
                                        <div class="price-display-cell">
                                            <span class="price-currency">R$</span>
                                            <span
                                                class="price-value"><?= number_format((float) ($item['preco_item'] ?? 0), 2, ',', '.') ?></span>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php
                                        $estoque = (int) $item['estoque'];
                                        $stockClass = $estoque > 10 ? 'high' : ($estoque > 5 ? 'medium' : 'low');
                                        $stockIcon = $estoque > 10 ? 'fa-check-circle' : ($estoque > 5 ? 'fa-exclamation-circle' : 'fa-exclamation-triangle');
                                        ?>
                                        <span class="stock-badge <?= $stockClass ?>">
                                            <i class="fa <?= $stockIcon ?>"></i>
                                            <?= $estoque ?>
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="action-buttons">
                                            <a href="/backend/item/editar/<?= $item['id_item'] ?>" class="btn-action btn-edit"
                                                title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="/backend/item/excluir/<?= $item['id_item'] ?>"
                                                class="btn-action btn-delete" title="Excluir"
                                                onclick="return confirm('Tem certeza que deseja excluir este item?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <?php if (!empty($itens)): ?>
                <div class="pagination-wrapper">
                    <nav>
                        <ul class="pagination">
                            <?php $pag = $paginacao; ?>

                            <li class="<?= ($pag['pagina_atual'] <= 1) ? 'disabled' : '' ?>">
                                <?php if ($pag['pagina_atual'] > 1): ?>
                                    <a href="/backend/item/listar/<?= $pag['pagina_atual'] - 1 ?>">
                                        <i class="fa fa-chevron-left"></i>
                                        Anterior
                                    </a>
                                <?php else: ?>
                                    <span>
                                        <i class="fa fa-chevron-left"></i>
                                        Anterior
                                    </span>
                                <?php endif; ?>
                            </li>

                            <li class="active">
                                <span>Página <?= $pag['pagina_atual'] ?> de <?= $pag['ultima_pagina'] ?></span>
                            </li>

                            <li class="<?= ($pag['pagina_atual'] >= $pag['ultima_pagina']) ? 'disabled' : '' ?>">
                                <?php if ($pag['pagina_atual'] < $pag['ultima_pagina']): ?>
                                    <a href="/backend/item/listar/<?= $pag['pagina_atual'] + 1 ?>">
                                        Próxima
                                        <i class="fa fa-chevron-right"></i>
                                    </a>
                                <?php else: ?>
                                    <span>
                                        Próxima
                                        <i class="fa fa-chevron-right"></i>
                                    </span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </nav>
                    <div class="pagination-info">
                        <?php
                        $de = (($pag['pagina_atual'] - 1) * $pag['por_pagina']) + 1;
                        $para = min($pag['pagina_atual'] * $pag['por_pagina'], $pag['total']);
                        ?>
                        Mostrando de <?= $de ?> até <?= $para ?> de <?= $pag['total'] ?> registros
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>