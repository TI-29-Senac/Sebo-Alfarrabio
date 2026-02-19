<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&display=swap');

    :root {
        --color-dark-brown: #2d1f14;
        --color-medium-brown: #3d2a1f;
        --color-warm-brown: #4a3526;
        --color-gold: #d4a76a;
        --color-light-gold: #e8c88f;
        --color-bright-gold: #f0d9a8;
        --color-cream: #f5ead5;
        --color-accent: #c89b5e;
        --color-deep-brown: #1a1209;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.15);
        --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.2);
        --shadow-gold: 0 4px 20px rgba(212, 167, 106, 0.25);

        /* Item Management Palette Compatibility */
        --primary: #8B7355;
        --primary-dark: #6d5a45;
        --accent: #d4af7a;
    }

    .dashboard-wrapper {
        font-family: 'Lato', sans-serif;
        background-color: var(--color-warm-brown);
        padding: 0;
        min-height: 100vh;
    }

    /* Top Header Banner Style */
    .top-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 30px 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-bottom: 3px solid var(--color-gold);
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
        font-size: 48px;
        color: #ffd700;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    .header-text h1 {
        font-family: 'Playfair Display', serif;
        font-size: 38px;
        font-weight: 700;
        color: white;
        margin: 0 0 5px 0;
        letter-spacing: -0.5px;
    }

    .header-text p {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.85);
        font-weight: 400;
        margin: 0;
        font-family: 'Lato', sans-serif;
    }

    .header-container {
        padding: 40px;
        max-width: 1600px;
        margin: 0 auto;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
        border: 2px solid;
        border-radius: 16px;
        padding: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, transparent 0%, rgba(212, 167, 106, 0.05) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .stat-card:hover {
        transform: translateY(-6px) scale(1.02);
        box-shadow: var(--shadow-lg);
    }

    .stat-card:hover::before {
        opacity: 1;
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
        border-color: var(--color-gold);
        background: linear-gradient(135deg, #faf8f3 0%, #f5f0e8 100%);
    }

    .stat-icon {
        font-size: 56px;
        opacity: 0.15;
        transition: all 0.4s ease;
        position: relative;
        z-index: 1;
    }

    .stat-card:hover .stat-icon {
        opacity: 0.25;
        transform: scale(1.1) rotate(-5deg);
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
        color: var(--color-gold);
    }

    .stat-content {
        text-align: left;
        position: relative;
        z-index: 2;
    }

    .stat-number {
        font-family: 'Playfair Display', serif;
        font-size: 42px;
        font-weight: 800;
        color: #2c2c2c;
        margin: 0;
        line-height: 1;
        background: linear-gradient(135deg, #2c2c2c 0%, #555 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-label {
        font-family: 'Playfair Display', serif;
        font-size: 15px;
        color: #666;
        margin-top: 10px;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .alert-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .alert-box {
        padding: 20px 28px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .alert-box:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .alert-box.warning {
        background: linear-gradient(135deg, #FFF9F0 0%, #FFF4E6 100%);
        border-color: rgba(244, 164, 96, 0.2);
    }

    .alert-box.info {
        background: linear-gradient(135deg, #FFF5ED 0%, #FFE8D6 100%);
        border-color: rgba(200, 155, 94, 0.2);
    }

    .alert-content {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .alert-icon {
        font-size: 24px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    .alert-text {
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        font-weight: 600;
        color: #2c2c2c;
        letter-spacing: 0.3px;
    }

    .alert-badge {
        background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%);
        padding: 6px 20px;
        border-radius: 24px;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 20px;
        color: var(--color-accent);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        min-width: 50px;
        text-align: center;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid rgba(212, 167, 106, 0.2);
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        font-weight: 700;
        color: #2c2c2c;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: 0.5px;
    }

    .section-title i {
        color: var(--color-accent);
    }

    .view-all {
        color: var(--color-accent);
        text-decoration: none;
        font-family: 'Playfair Display', serif;
        font-size: 15px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 8px;
    }

    .view-all:hover {
        background: rgba(212, 167, 106, 0.1);
        gap: 10px;
    }

    .user-thumbnail {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--color-gold);
        background-color: var(--color-cream);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: var(--color-gold);
        margin: 0 auto;
    }

    [data-theme="dark"] .user-thumbnail {
        border-color: var(--color-bright-gold);
        background-color: var(--color-warm-brown);
        color: var(--color-bright-gold);
    }

    .data-table {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        margin-bottom: 40px;
        border: 1px solid rgba(212, 167, 106, 0.15);
    }

    .data-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-gold) 100%);
        position: relative;
    }

    .data-table thead::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    }

    .data-table thead th {
        padding: 18px 20px;
        text-align: left;
        color: #ffffff;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .data-table tbody tr {
        border-bottom: 1px solid rgba(212, 167, 106, 0.1);
        transition: all 0.3s ease;
    }

    .data-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(212, 167, 106, 0.05) 0%, transparent 100%);
        transform: translateX(4px);
    }

    .data-table tbody td {
        padding: 18px 20px;
        font-family: 'Playfair Display', serif;
        font-size: 15px;
        color: #2c2c2c;
        font-weight: 500;
    }

    .data-table tbody td:first-child {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        color: var(--color-accent);
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 16px;
        font-family: 'Playfair Display', serif;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .status-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .status-badge.active {
        background: linear-gradient(135deg, #D4EDDA 0%, #C3E6CB 100%);
        color: #155724;
        border: 1px solid rgba(21, 87, 36, 0.2);
    }

    .status-badge.inactive {
        background: linear-gradient(135deg, #F8D7DA 0%, #F5C6CB 100%);
        color: #721C24;
        border: 1px solid rgba(114, 28, 36, 0.2);
    }

    .btn {
        padding: 8px 18px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-family: 'Playfair Display', serif;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-right: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }

    .btn:active {
        transform: translateY(0);
    }

    .btn-edit {
        background: linear-gradient(135deg, #5B9BD5 0%, #4A8AC4 100%);
        color: white;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #4A8AC4 0%, #3979B3 100%);
    }

    .btn-delete {
        background: linear-gradient(135deg, #E74C3C 0%, #D63B2D 100%);
        color: white;
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #D63B2D 0%, #C52A1E 100%);
    }

    .btn-create {
        background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-accent) 100%);
        color: #ffffff;
        padding: 14px 28px;
        font-size: 16px;
        border-radius: 10px;
        box-shadow: var(--shadow-gold);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .btn-create:hover {
        background: linear-gradient(135deg, var(--color-accent) 0%, #b88a4e 100%);
        box-shadow: 0 6px 24px rgba(212, 167, 106, 0.35);
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin-top: 28px;
    }

    .pagination .btn {
        background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%);
        border: 2px solid rgba(212, 167, 106, 0.3);
        color: #2c2c2c;
        min-width: 44px;
        justify-content: center;
    }

    .pagination .btn:hover {
        border-color: var(--color-gold);
        background: linear-gradient(135deg, #faf8f3 0%, #f5f0e8 100%);
    }

    .pagination .btn.active {
        background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-accent) 100%);
        color: #ffffff;
        border-color: var(--color-gold);
        box-shadow: var(--shadow-gold);
    }

    .pagination-info {
        text-align: center;
        color: #666;
        font-family: 'Playfair Display', serif;
        font-size: 14px;
        font-weight: 500;
        margin-top: 12px;
        letter-spacing: 0.3px;
    }

    .empty-state {
        background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
        border-radius: 16px;
        padding: 60px 40px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 2px dashed rgba(212, 167, 106, 0.3);
    }

    .empty-state h3 {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 700;
        color: #2c2c2c;
        margin: 16px 0 8px;
        letter-spacing: 0.5px;
    }

    .empty-state p {
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        color: #666;
        margin-bottom: 24px;
    }

    /* Animations */
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

    .stat-card {
        animation: fadeInUp 0.6s ease-out backwards;
    }

    .stat-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .stat-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .stat-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .stat-card:nth-child(4) {
        animation-delay: 0.4s;
    }

    .data-table tbody tr {
        animation: fadeInUp 0.4s ease-out backwards;
    }

    .data-table tbody tr:nth-child(1) {
        animation-delay: 0.1s;
    }

    .data-table tbody tr:nth-child(2) {
        animation-delay: 0.15s;
    }

    .data-table tbody tr:nth-child(3) {
        animation-delay: 0.2s;
    }

    .data-table tbody tr:nth-child(4) {
        animation-delay: 0.25s;
    }

    .data-table tbody tr:nth-child(5) {
        animation-delay: 0.3s;
    }

    /* Dark Theme Overrides */
    [data-theme="dark"] .dashboard-header h5 {
        color: var(--color-bright-gold);
    }

    [data-theme="dark"] .dashboard-header h5 i {
        color: var(--color-light-gold);
    }

    [data-theme="dark"] .dashboard-header::before {
        background: linear-gradient(90deg, var(--color-gold), transparent);
    }

    [data-theme="dark"] .stat-card {
        background: linear-gradient(135deg, var(--color-medium-brown) 0%, var(--color-warm-brown) 100%);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        border-color: rgba(212, 167, 106, 0.3);
    }

    [data-theme="dark"] .stat-card::before {
        background: linear-gradient(135deg, transparent 0%, rgba(212, 167, 106, 0.1) 100%);
    }

    [data-theme="dark"] .stat-card.money {
        background: linear-gradient(135deg, var(--color-warm-brown) 0%, #3d2e20 100%);
        border-color: var(--color-gold);
    }

    [data-theme="dark"] .stat-card:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
    }

    [data-theme="dark"] .stat-number {
        background: linear-gradient(135deg, var(--color-bright-gold) 0%, var(--color-light-gold) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    [data-theme="dark"] .stat-label {
        color: var(--color-cream);
        opacity: 0.85;
    }

    [data-theme="dark"] .alert-box.warning {
        background: linear-gradient(135deg, var(--color-warm-brown) 0%, var(--color-medium-brown) 100%);
        border-color: rgba(244, 164, 96, 0.3);
    }

    [data-theme="dark"] .alert-box.info {
        background: linear-gradient(135deg, #3d2e20 0%, var(--color-warm-brown) 100%);
        border-color: rgba(200, 155, 94, 0.3);
    }

    [data-theme="dark"] .alert-text {
        color: var(--color-bright-gold);
    }

    [data-theme="dark"] .alert-badge {
        background: linear-gradient(135deg, var(--color-medium-brown) 0%, var(--color-warm-brown) 100%);
        color: var(--color-bright-gold);
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
    }

    [data-theme="dark"] .section-header {
        border-bottom-color: rgba(212, 167, 106, 0.3);
    }

    [data-theme="dark"] .section-title {
        color: var(--color-bright-gold);
    }

    [data-theme="dark"] .section-title i {
        color: var(--color-light-gold);
    }

    [data-theme="dark"] .view-all {
        color: var(--color-light-gold);
    }

    [data-theme="dark"] .view-all:hover {
        background: rgba(212, 167, 106, 0.15);
        color: var(--color-bright-gold);
    }

    [data-theme="dark"] .data-table {
        background: var(--color-medium-brown);
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.5);
        border-color: rgba(212, 167, 106, 0.2);
    }

    [data-theme="dark"] .data-table thead {
        background: linear-gradient(135deg, #33261a 0%, #2a1f14 100%);
    }

    [data-theme="dark"] .data-table tbody td {
        color: var(--color-cream);
        border-bottom-color: rgba(212, 167, 106, 0.15);
    }

    [data-theme="dark"] .data-table tbody td:first-child {
        color: var(--color-bright-gold);
    }

    [data-theme="dark"] .data-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(212, 167, 106, 0.1) 0%, transparent 100%);
    }

    [data-theme="dark"] .status-badge.active {
        background: linear-gradient(135deg, rgba(52, 92, 54, 0.9) 0%, rgba(42, 72, 44, 0.9) 100%);
        color: #90EE90;
        border-color: rgba(144, 238, 144, 0.3);
    }

    [data-theme="dark"] .status-badge.inactive {
        background: linear-gradient(135deg, rgba(92, 42, 42, 0.9) 0%, rgba(72, 32, 32, 0.9) 100%);
        color: #FFB6C1;
        border-color: rgba(255, 182, 193, 0.3);
    }

    [data-theme="dark"] .pagination .btn {
        background: linear-gradient(135deg, var(--color-medium-brown) 0%, var(--color-warm-brown) 100%);
        color: var(--color-cream);
        border-color: rgba(212, 167, 106, 0.3);
    }

    [data-theme="dark"] .pagination .btn:hover {
        background: linear-gradient(135deg, var(--color-warm-brown) 0%, #3d2e20 100%);
        border-color: var(--color-gold);
    }

    [data-theme="dark"] .pagination .btn.active {
        background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-accent) 100%);
        color: var(--color-deep-brown);
        border-color: var(--color-gold);
    }

    [data-theme="dark"] .pagination-info {
        color: var(--color-cream);
        opacity: 0.85;
    }

    [data-theme="dark"] .empty-state {
        background: linear-gradient(135deg, var(--color-medium-brown) 0%, var(--color-warm-brown) 100%);
        border-color: rgba(212, 167, 106, 0.3);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    }

    [data-theme="dark"] .empty-state i {
        color: var(--color-gold) !important;
    }

    [data-theme="dark"] .empty-state h3 {
        color: var(--color-bright-gold);
    }

    [data-theme="dark"] .empty-state p {
        color: var(--color-cream);
        opacity: 0.85;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-container {
            grid-template-columns: 1fr;
        }

        .alert-section {
            grid-template-columns: 1fr;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .data-table {
            overflow-x: auto;
        }

        .dashboard-header h5 {
            font-size: 22px;
        }

        .stat-number {
            font-size: 36px;
        }
    }
</style>

<div class="top-header">
    <div class="header-content">
        <div class="header-left">
            <i class="fa fa-users header-icon"></i>
            <div class="header-text">
                <h1>Gerenciamento de Usuários</h1>
                <p>Controle de acessos e perfis do sistema</p>
            </div>
        </div>
        <a href="/backend/usuario/criar" class="btn btn-create"
            style="background: var(--color-gold); border: none; padding: 12px 24px; border-radius: 8px; color: var(--color-dark-brown); font-weight: 700;">
            <i class="fa fa-plus-circle"></i> Novo Usuário
        </a>
    </div>
</div>

<div class="header-container">

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
                        <th>Foto</th>
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
                            <td>
                                <?php if (!empty($u['foto_perfil_usuario'])): ?>
                                    <img src="<?php echo htmlspecialchars($u['foto_perfil_usuario']); ?>" alt="Foto"
                                        class="user-thumbnail">
                                <?php else: ?>
                                    <div class="user-thumbnail">
                                        <i class="fa fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
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
</div>
