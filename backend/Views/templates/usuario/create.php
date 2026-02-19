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

        /* Banner Palette Compatibility */
        --primary: #8B7355;
        --primary-dark: #6d5a45;
        --accent: #d4af7a;
    }

    .create-wrapper {
        background-color: var(--color-warm-brown);
        min-height: 100vh;
        padding-bottom: 40px;
    }

    /* Top Header Banner Style */
    .top-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 30px 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-bottom: 3px solid var(--color-gold);
        margin-bottom: 30px;
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
    }

    .form-container {
        max-width: 700px;
        margin: 0 auto;
        background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
        border-radius: 20px;
        padding: 50px 60px;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(212, 167, 106, 0.15);
        position: relative;
        overflow: hidden;
    }

    .form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--color-gold), var(--color-accent), var(--color-gold));
    }

    .form-container h1 {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 700;
        color: #2c2c2c;
        text-align: center;
        margin-bottom: 16px;
        letter-spacing: 0.5px;
    }

    .form-subtitle {
        text-align: center;
        color: #666;
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        margin-bottom: 40px;
        font-weight: 500;
    }

    .form-section {
        margin-bottom: 28px;
        animation: fadeInUp 0.6s ease-out backwards;
    }

    .form-section:nth-child(1) {
        animation-delay: 0.1s;
    }

    .form-section:nth-child(2) {
        animation-delay: 0.2s;
    }

    .form-section:nth-child(3) {
        animation-delay: 0.3s;
    }

    .form-section:nth-child(4) {
        animation-delay: 0.4s;
    }

    .form-section:nth-child(5) {
        animation-delay: 0.5s;
    }

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

    .form-label {
        display: block;
        font-family: 'Playfair Display', serif;
        font-size: 15px;
        font-weight: 700;
        color: var(--color-accent);
        margin-bottom: 10px;
        letter-spacing: 0.3px;
        text-transform: uppercase;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 14px 18px;
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        color: #2c2c2c;
        background: #ffffff;
        border: 2px solid rgba(212, 167, 106, 0.3);
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--color-gold);
        box-shadow: 0 4px 12px rgba(212, 167, 106, 0.2), 0 0 0 4px rgba(212, 167, 106, 0.1);
        transform: translateY(-2px);
    }

    .form-input::placeholder {
        color: #999;
        font-style: italic;
    }

    .form-help-text {
        display: block;
        margin-top: 8px;
        font-family: 'Playfair Display', serif;
        font-size: 13px;
        color: #666;
        font-style: italic;
        line-height: 1.6;
    }

    .form-help-text i {
        color: var(--color-accent);
        margin-right: 4px;
    }

    .form-select {
        cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23c89b5e' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 45px;
        appearance: none;
    }

    .user-type-info {
        background: linear-gradient(135deg, #FFF9F0 0%, #FFF4E6 100%);
        border-left: 4px solid var(--color-gold);
        padding: 16px 20px;
        margin-top: 12px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .user-type-info p {
        margin: 8px 0;
        font-family: 'Playfair Display', serif;
        font-size: 14px;
        color: #555;
        line-height: 1.6;
    }

    .user-type-info strong {
        color: var(--color-accent);
        font-weight: 700;
    }

    .form-actions {
        display: flex;
        gap: 16px;
        margin-top: 40px;
        padding-top: 30px;
        border-top: 2px solid rgba(212, 167, 106, 0.2);
    }

    .btn {
        flex: 1;
        padding: 16px 32px;
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
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
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .btn:active {
        transform: translateY(-1px);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-accent) 100%);
        color: #ffffff;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        box-shadow: var(--shadow-gold);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--color-accent) 0%, #b88a4e 100%);
        box-shadow: 0 6px 24px rgba(212, 167, 106, 0.35);
    }

    .btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: #ffffff;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #5a6268 0%, #495057 100%);
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-accent);
        font-size: 18px;
        pointer-events: none;
    }

    .input-icon .form-input {
        padding-left: 50px;
    }

    /* Dark Theme */
    [data-theme="dark"] .form-container {
        background: linear-gradient(135deg, var(--color-medium-brown) 0%, var(--color-warm-brown) 100%);
        border-color: rgba(212, 167, 106, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
    }

    [data-theme="dark"] .form-container h1 {
        color: var(--color-bright-gold);
    }

    [data-theme="dark"] .form-subtitle {
        color: var(--color-cream);
        opacity: 0.85;
    }

    [data-theme="dark"] .form-label {
        color: var(--color-light-gold);
    }

    [data-theme="dark"] .form-input,
    [data-theme="dark"] .form-select {
        background: rgba(45, 31, 20, 0.6);
        border-color: rgba(212, 167, 106, 0.3);
        color: var(--color-cream);
    }

    [data-theme="dark"] .form-input::placeholder {
        color: rgba(245, 234, 213, 0.5);
    }

    [data-theme="dark"] .form-input:focus,
    [data-theme="dark"] .form-select:focus {
        background: rgba(45, 31, 20, 0.8);
        border-color: var(--color-bright-gold);
        box-shadow: 0 4px 12px rgba(212, 167, 106, 0.3), 0 0 0 4px rgba(212, 167, 106, 0.15);
    }

    [data-theme="dark"] .form-help-text {
        color: var(--color-cream);
        opacity: 0.75;
    }

    [data-theme="dark"] .user-type-info {
        background: linear-gradient(135deg, rgba(74, 53, 38, 0.6) 0%, rgba(61, 42, 31, 0.6) 100%);
        border-color: var(--color-gold);
    }

    [data-theme="dark"] .user-type-info p {
        color: var(--color-cream);
    }

    [data-theme="dark"] .user-type-info strong {
        color: var(--color-bright-gold);
    }

    [data-theme="dark"] .form-actions {
        border-color: rgba(212, 167, 106, 0.3);
    }

    [data-theme="dark"] .form-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23f0d9a8' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-container {
            padding: 40px 30px;
            margin: 20px;
        }

        .form-container h1 {
            font-size: 28px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="create-wrapper">
    <div class="top-header">
        <div class="header-content">
            <div class="header-left">
                <i class="fa fa-user-plus header-icon"></i>
                <div class="header-text">
                    <h1>Cadastrar Novo Usuário</h1>
                    <p>Preencha os dados abaixo para criar um novo perfil</p>
                </div>
            </div>
            <a href="/backend/usuario/listar" class="btn btn-secondary"
                style="background: rgba(255,255,255,0.1); border: 2px solid rgba(255,255,255,0.3); color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600;">
                <i class="fa fa-arrow-left"></i> Voltar à Lista
            </a>
        </div>
    </div>

    <div class="form-container">
        <h1>Criar Novo Usuário</h1>
        <p class="form-subtitle">Cadastre um novo perfil de acesso no sistema</p>

        <form action="/backend/usuario/salvar" method="POST">

            <div class="form-section">
                <label class="form-label"><i class="fa fa-user"></i> Nome Completo</label>
                <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input class="form-input" type="text" name="nome_usuario" placeholder="Ex: João da Silva" required
                        minlength="3">
                </div>
            </div>

            <div class="form-section">
                <label class="form-label"><i class="fa fa-envelope"></i> Email</label>
                <div class="input-icon">
                    <i class="fa fa-envelope"></i>
                    <input class="form-input" type="email" name="email_usuario" placeholder="usuario@email.com"
                        required>
                </div>
            </div>

            <div class="form-section">
                <label class="form-label"><i class="fa fa-lock"></i> Senha</label>
                <div class="input-icon">
                    <i class="fa fa-lock"></i>
                    <input class="form-input" type="password" name="senha_usuario" placeholder="Mínimo 6 caracteres"
                        required minlength="6">
                </div>
                <small class="form-help-text">
                    <i class="fa fa-shield-alt"></i> A senha será criptografada automaticamente para sua segurança
                </small>
            </div>

            <div class="form-section">
                <label class="form-label"><i class="fa fa-user-tag"></i> Tipo de Usuário</label>
                <select class="form-select" name="tipo_usuario" required>
                    <option value="" disabled selected>Selecione o tipo de usuário...</option>
                    <option value="Cliente">👤 Cliente</option>
                    <option value="Funcionario">💼 Funcionário</option>
                    <option value="Admin">⚡ Administrador</option>
                </select>

                <div class="user-type-info">
                    <p><strong>👤 Cliente:</strong> Acesso limitado para compras e consultas</p>
                    <p><strong>💼 Funcionário:</strong> Gerencia vendas, estoque e atendimento</p>
                    <p><strong>⚡ Administrador:</strong> Controle total sobre o sistema</p>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Criar Usuário
                </button>
                <a href="/backend/usuario/listar" class="btn btn-secondary">
                    <i class="fa fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Validação adicional no frontend
    document.querySelector('form').addEventListener('submit', function (e) {
        const senha = document.querySelector('input[name="senha_usuario"]').value;

        if (senha.length < 6) {
            alert('A senha deve ter no mínimo 6 caracteres!');
            e.preventDefault();
            return false;
        }

        // Custom confirmation dialog
        const confirmar = confirm('✓ Confirma a criação deste usuário?');
        if (!confirmar) {
            e.preventDefault();
            return false;
        }

        return true;
    });

    // Add focus effect to inputs
    const inputs = document.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.addEventListener('focus', function () {
            this.parentElement.style.transform = 'scale(1.01)';
        });

        input.addEventListener('blur', function () {
            this.parentElement.style.transform = 'scale(1)';
        });
    });

    // Real-time password validation
    const senhaInput = document.querySelector('input[name="senha_usuario"]');
    const senhaHelp = senhaInput.nextElementSibling;

    senhaInput.addEventListener('input', function () {
        const length = this.value.length;

        if (length === 0) {
            senhaHelp.style.color = '#666';
            senhaHelp.innerHTML = '<i class="fa fa-shield-alt"></i> A senha será criptografada automaticamente para sua segurança';
        } else if (length < 6) {
            senhaHelp.style.color = '#E74C3C';
            senhaHelp.innerHTML = `<i class="fa fa-exclamation-triangle"></i> Faltam ${6 - length} caracteres`;
        } else {
            senhaHelp.style.color = '#90C695';
            senhaHelp.innerHTML = '<i class="fa fa-check-circle"></i> Senha forte! ✓';
        }
    });

    // Animate form on load
    window.addEventListener('load', function () {
        document.querySelector('.form-container').style.animation = 'fadeInUp 0.8s ease-out';
    });
</script>