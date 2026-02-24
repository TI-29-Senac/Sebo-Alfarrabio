<style>
    .reset-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .reset-box {
        max-width: 450px;
        width: 100%;
    }

    .reset-card {
        background: var(--bg-card, linear-gradient(180deg, #d8c2a7 0%, #bfa07c 100%));
        color: var(--text-primary, #fff);
        border-radius: 16px;
        border: 3px solid var(--border-accent, #8c6e63);
        box-shadow: 0 6px 25px var(--shadow-medium, rgba(90, 74, 58, 0.25));
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .reset-card:hover {
        box-shadow: 0 10px 35px rgba(90, 74, 58, 0.35);
        transform: translateY(-3px);
    }

    .logo-icon {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 30px auto 15px;
        background-color: #fff;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 2px solid var(--border-accent, #8c6e63);
    }

    .logo-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    h2 {
        color: var(--text-primary, #4a3a2b);
        margin: 10px 0;
    }

    p.subtitle {
        color: var(--text-secondary, #6b5a4b);
        font-size: 14px;
        margin-bottom: 20px;
    }

    .btn-reset {
        background: var(--accent, #5a4a3a);
        color: var(--text-on-accent, #FFF2DF);
        transition: all 0.3s;
        border: none;
    }

    .btn-reset:hover {
        background: var(--accent-hover, #4a3a2b);
        transform: translateY(-2px);
    }

    input.w3-input {
        border: 1px solid var(--border-color, #a1876f) !important;
        background-color: var(--bg-input, #fff) !important;
        color: var(--text-primary) !important;
    }

    .w3-text-grey {
        color: var(--text-secondary, #3e2f22) !important;
    }

    .footer-box {
        background-color: var(--bg-secondary, #f9f7f4);
        padding: 15px;
        border-top: 1px solid var(--border-color, #e8dccb);
    }

    .footer-box a {
        color: var(--accent, #8a6f52);
        text-decoration: none;
        font-weight: bold;
    }

    .footer-box a:hover {
        text-decoration: underline;
    }

    .footer-box p {
        color: var(--text-secondary, #6e5a4a);
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin: 10px 16px;
        border-left: 4px solid;
        animation: slideDown 0.4s ease;
        font-size: 14px;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #d4edda;
        border-left-color: #28a745;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        border-left-color: #dc3545;
        color: #721c24;
    }
</style>

<div class="reset-container">
    <div class="reset-box">
        <div class="reset-card w3-animate-zoom">
            <div class="w3-container w3-center w3-padding">
                <div class="logo-icon">
                    <img src="/img/logo2.webp" alt="Logo Sebo Alfarrabio">
                </div>
                <h2>Redefinir Senha</h2>
                <p class="subtitle">Crie uma nova senha para sua conta</p>
            </div>

            <form class="w3-container w3-padding" action="/backend/redefinir-senha" method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">

                <p>
                    <label class="w3-text-grey"><b><i class="fa fa-lock"></i> Nova Senha</b></label>
                    <input class="w3-input w3-round" type="password" name="senha_nova" required placeholder="••••••••"
                        minlength="6">
                </p>

                <p>
                    <label class="w3-text-grey"><b><i class="fa fa-lock"></i> Confirmar Nova Senha</b></label>
                    <input class="w3-input w3-round" type="password" name="senha_confirm" required
                        placeholder="Repita sua nova senha" minlength="6">
                </p>

                <p style="margin-top: 20px;">
                    <button class="w3-button w3-block w3-round btn-reset w3-padding" type="submit">
                        <i class="fa fa-key"></i> <b>Redefinir Senha</b>
                    </button>
                </p>
            </form>

            <div class="w3-container w3-center footer-box">
                <p style="margin: 5px 0;">
                    <a href="/backend/login"><i class="fa fa-arrow-left"></i> Voltar para o Login</a>
                </p>
                <p style="margin: 5px 0; font-size: 12px;">
                    © <?php echo date('Y'); ?> Sebo Alfarrabio - Todos os direitos reservados
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                alert.style.transition = 'opacity 1s ease-out';
                alert.style.opacity = '0';
                setTimeout(function () {
                    alert.remove();
                }, 1000);
            });
        }, 5000);
    });
</script>