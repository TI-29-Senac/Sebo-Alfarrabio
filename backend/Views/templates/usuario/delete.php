<style>
    /* Scoped container instead of body */
    .delete-confirmation-wrapper {
        min-height: calc(100vh - 120px); /* Adjust for header/footer */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        font-family: 'Lato', sans-serif;
    }

    .overlay-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 40px rgba(0,0,0,0.12);
        max-width: 520px;
        width: 100%;
        overflow: hidden;
        animation: slideUp 0.35s ease;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Header strip — matches dashboard's olive/brown header */
    .card-header {
        background: #8b7355;
        padding: 28px 32px 24px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .card-header .icon-wrap {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: rgba(255,255,255,0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .card-header .icon-wrap svg {
        width: 22px;
        height: 22px;
        fill: #fff;
    }

    .card-header h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.35rem;
        color: #fff;
        font-weight: 600;
        line-height: 1.25;
    }

    .card-header p {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.72);
        margin-top: 2px;
    }

    /* Body */
    .card-body {
        padding: 32px;
    }

    /* Warning banner — matches the pinkish alert in the dashboard */
    .warning-banner {
        background: #fde8e8;
        border-left: 4px solid #e07070;
        border-radius: 6px;
        padding: 14px 18px;
        margin-bottom: 24px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .warning-banner svg {
        width: 20px;
        height: 20px;
        fill: #c0392b;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .warning-banner .warn-text strong {
        display: block;
        color: #c0392b;
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 2px;
    }

    .warning-banner .warn-text span {
        font-size: 0.82rem;
        color: #7a3535;
    }

    /* User info box */
    .user-info {
        background: #faf8f4;
        border: 1px solid #e8e0d0;
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #d4c5a9;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .user-avatar svg {
        width: 22px;
        height: 22px;
        fill: #8b7355;
    }

    .user-details .name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #3a2e1e;
    }

    .user-details .id-badge {
        display: inline-block;
        background: #8b7355;
        color: #fff;
        font-size: 0.72rem;
        padding: 1px 7px;
        border-radius: 20px;
        margin-left: 6px;
        vertical-align: middle;
        font-weight: 700;
    }

    .user-details .label {
        font-size: 0.78rem;
        color: #9e8f78;
        margin-top: 2px;
    }

    /* Divider */
    .divider {
        border: none;
        border-top: 1px solid #ede6d8;
        margin: 0 0 24px;
    }

    /* Actions */
    .actions {
        display: flex;
        gap: 12px;
    }

    .btn {
        flex: 1;
        padding: 13px 20px;
        border-radius: 8px;
        font-family: 'Lato', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        border: none;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: filter 0.18s, transform 0.15s;
    }

    .btn:hover { filter: brightness(0.93); transform: translateY(-1px); }
    .btn:active { transform: translateY(0); }

    .btn-danger {
        background: #c0392b;
        color: #fff;
    }

    .btn-cancel {
        background: #ede6d8;
        color: #5a4e3a;
    }

    .btn svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    /* Dark theme support */
    [data-theme="dark"] .delete-confirmation-wrapper {
        color: #f5f1e8;
    }
    
    [data-theme="dark"] .overlay-card {
        background: #221a10;
        box-shadow: 0 8px 40px rgba(0,0,0,0.4);
    }
    
    [data-theme="dark"] .card-header {
        background: #3d2e20;
    }
    
    [data-theme="dark"] .card-header h2 {
        color: #d4a574;
    }
    
    [data-theme="dark"] .user-info {
        background: #2a1f14;
        border-color: #3d2e20;
    }
    
    [data-theme="dark"] .user-details .name {
        color: #f5f1e8;
    }
    
    [data-theme="dark"] .user-details .label {
        color: #d4c5a9;
    }
    
    [data-theme="dark"] .warning-banner {
        background: #3d1a1a;
        border-left-color: #dc3545;
    }
    
    [data-theme="dark"] .warning-banner svg {
        fill: #e8a3a3;
    }
    
    [data-theme="dark"] .warning-banner .warn-text strong {
        color: #e8a3a3;
    }
    
    [data-theme="dark"] .warning-banner .warn-text span {
        color: #d4c5a9;
    }
    
    [data-theme="dark"] .btn-cancel {
        background: #33261a;
        color: #d4a574;
    }
</style>

<div class="delete-confirmation-wrapper">
    <div class="overlay-card">

        <!-- Header -->
        <div class="card-header">
            <div class="icon-wrap">
                <!-- shield/user icon -->
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
            </div>
            <div>
                <h2>Confirmar Desativação</h2>
                <p>Sebo Alfarrábio · Gerenciar Usuários</p>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body">

            <!-- Warning -->
            <div class="warning-banner">
                <svg viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                <div class="warn-text">
                    <strong>Atenção! Esta ação desativará o usuário.</strong>
                    <span>O usuário perderá acesso ao sistema imediatamente após a confirmação.</span>
                </div>
            </div>

            <!-- User Info -->
            <div class="user-info">
                <div class="user-avatar">
                    <?php if (!empty($usuario['foto_perfil_usuario'])): ?>
                        <img src="<?php echo htmlspecialchars($usuario['foto_perfil_usuario']); ?>" alt="Foto" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                    <?php endif; ?>
                </div>
                <div class="user-details">
                    <div class="name">
                        <?php echo htmlspecialchars($usuario['nome_usuario']); ?>
                        <span class="id-badge">#<?php echo $usuario['id_usuario']; ?></span>
                    </div>
                    <div class="label">Usuário do sistema</div>
                </div>
            </div>

            <hr class="divider">

            <!-- Form -->
            <form action="/backend/usuario/excluir" method="POST" onsubmit="return confirm('Sim?');">
                <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                <div class="actions">
                    <a href="/backend/usuario/listar" class="btn btn-cancel">
                        <svg viewBox="0 0 24 24"><path d="M19 11H7.83l4.88-4.88c.39-.39.39-1.03 0-1.42-.39-.39-1.02-.39-1.41 0l-6.59 6.59c-.39.39-.39 1.02 0 1.41l6.59 6.59c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L7.83 13H19c.55 0 1-.45 1-1s-.45-1-1-1z"/></svg>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <svg viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                        Desativar
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>