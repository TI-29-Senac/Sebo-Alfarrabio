<style>
    .login-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-box {
        max-width: 450px;
        width: 100%;
    }

    /* Caixa principal do formulário */
    .login-card {
        background: var(--bg-card, linear-gradient(180deg, #d8c2a7 0%, #bfa07c 100%));
        color: var(--text-primary, #fff);
        border-radius: 16px;
        border: 3px solid var(--border-accent, #8c6e63);
        box-shadow: 0 6px 25px var(--shadow-medium, rgba(90, 74, 58, 0.25));
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .login-card:hover {
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

    h2 {
        color: var(--text-primary, #4a3a2b);
        margin: 10px 0;
    }

    p.subtitle {
        color: var(--text-secondary, #6b5a4b);
        font-size: 14px;
        margin-bottom: 20px;
    }

    .btn-login {
        background: var(--accent, #5a4a3a);
        color: var(--text-on-accent, #FFF2DF);
        transition: all 0.3s;
    }

    .btn-login:hover {
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
</style>

<div class="login-container">
    <div class="login-box">
        <div class="login-card w3-animate-zoom">
            <div class="w3-container w3-center w3-padding">
                <div class="logo-icon">
                    <img src="/img/logo2.webp" alt="Logo Sebo Alfarrabio"
                        style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <h2>Sebo Alfarrabio</h2>
                <p class="subtitle">Onde cada livro tem uma nova chance de ser descoberto</p>
            </div>

            <form class="w3-container w3-padding" action="/backend/login" method="POST">
                <p>
                    <label class="w3-text-grey"><b><i class="fa fa-envelope"></i> Email</b></label>
                    <input class="w3-input w3-round" type="email" name="email_usuario" required
                        placeholder="seu@email.com"
                        value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                </p>

                <p>
                    <label class="w3-text-grey"><b><i class="fa fa-lock"></i> Senha</b></label>
                    <input class="w3-input w3-round" type="password" name="senha_usuario" required
                        placeholder="••••••••">
                </p>

                <p>
                    <label>
                        <input class="w3-check" type="checkbox" name="lembrar">
                        <span class="w3-text-grey"> Lembrar-me</span>
                    </label>
                </p>

                <p>
                    <button class="w3-button w3-block w3-round btn-login w3-padding" type="submit">
                        <i class="fa fa-sign-in"></i> <b>Entrar no Sistema</b>
                    </button>
                </p>
            </form>

            <div class="w3-container w3-center footer-box">
                <p style="margin: 5px 0;">
                    <a href="/backend/forgot-password"><i class="fa fa-question-circle"></i> Esqueci a senha</a>
                </p>
                <p style="margin: 5px 0;">
                    <a href="/index.html" style="color: #6e5a4a;"><i class="fa fa-home"></i> Continuar sem
                        entrar</a>
                </p>
                <p style="margin: 5px 0;">
                    <a href="/backend/register">Não tem conta? Crie aqui.</a>
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
        }, 4000); // Mensagem visível por 4 segundos
    });
</script>