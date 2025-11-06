<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Sistema Sebo</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html,body {
            font-family: "Raleway", sans-serif; 
            height: 100%;
            margin: 0;
            background-color: #fff2df; /* Fundo branco */
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff2df; /* Fundo bege claro */
            padding: 20px;
        }

        .login-box {
            max-width: 450px;
            width: 100%;
        }

        /* Caixa principal do formulário */
        .login-card {
            background: linear-gradient(180deg, #d8c2a7 0%, #bfa07c 100%);
            color: #fff;
            border-radius: 16px;
            border: 3px solid #8c6e63; /* 🌟 Borda dourada suave */
            box-shadow: 0 6px 25px rgba(90, 74, 58, 0.25);
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
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 2px solid #8c6e63; /* borda dourada também no logo */
        }

        c
        h2 {
            color: #4a3a2b;
            margin: 10px 0;
        }

        p.subtitle {
            color: #6b5a4b;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .btn-login {
            background: #5a4a3a;
            color: #FFF2DF;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: #4a3a2b;
            transform: translateY(-2px);
        }

        input.w3-input {
            border: 1px solid #a1876f !important;
            background-color: #fff;
        }

        .w3-text-grey {
            color: #3e2f22 !important;
        }

        .footer-box {
            background-color: #f9f7f4;
            padding: 15px;
            border-top: 1px solid #e8dccb;
        }

        .footer-box a {
            color: #8a6f52;
            text-decoration: none;
            font-weight: bold;
        }

        .footer-box a:hover {
            text-decoration: underline;
        }

        .footer-box p {
            color: #6e5a4a;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-card w3-animate-zoom">
                <div class="w3-container w3-center w3-padding">
                    <div class="logo-icon">
                        <img src="/img/logo2.png" alt="Logo Sebo Alfarrabio">
                    </div>
                    <h2>Sebo Alfarrabio</h2>
                    <p class="subtitle">Onde cada livro tem uma nova chance de ser descoberto</p>
                </div>
                
                <form class="w3-container w3-padding" action="/backend/login" method="POST">
                    <p>
                        <label class="w3-text-grey"><b><i class="fa fa-envelope"></i> Email</b></label>
                        <input class="w3-input w3-round" type="email" name="email_usuario" required placeholder="seu@email.com" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                    </p>
                    
                    <p>
                        <label class="w3-text-grey"><b><i class="fa fa-lock"></i> Senha</b></label>
                        <input class="w3-input w3-round" type="password" name="senha_usuario" required placeholder="••••••••">
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
                        <a href="/backend/register">Não tem conta? Crie aqui.</a>
                    </p>
                    <p style="margin: 5px 0; font-size: 12px;">
                        © <?php echo date('Y'); ?> Sebo Alfarrabio - Todos os direitos reservados
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
