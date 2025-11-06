<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar - Sebo Alfarrábio</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html,body {
            font-family: "Raleway", sans-serif; 
            height: 100%;
            margin: 0;
            background-color: #fff2df; /* Fundo bege claro */
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff2df;
            padding: 20px;
        }

        .register-box {
            max-width: 450px;
            width: 100%;
        }

        .register-card {
            background: linear-gradient(180deg, #d8c2a7 0%, #bfa07c 100%);
            color: #fff;
            border-radius: 16px;
            border: 3px solid #8c6e63;
            box-shadow: 0 6px 25px rgba(90, 74, 58, 0.25);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .register-card:hover {
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
            border: 2px solid #8c6e63;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        h2 {
            color: #4a3a2b;
            margin: 10px 0;
        }

        p.subtitle {
            color: #6b5a4b;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .btn-register {
            background: #5a4a3a;
            color: #FFF2DF;
            transition: all 0.3s;
            border: none;
        }

        .btn-register:hover {
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
    <div class="register-container">
        <div class="register-box">
            <div class="register-card w3-animate-zoom">
                <div class="w3-container w3-center w3-padding">
                    <div class="logo-icon">
                        <img src="/img/logo2.png" alt="Logo Sebo Alfarrabio">
                    </div>
                    <h2>Sebo Alfarrabio</h2>
                    <p class="subtitle">Crie sua conta e descubra novos tesouros literários</p>
                </div>
                
                <form class="w3-container w3-padding" action="/backend/register" method="POST">
                    <p>
                        <label class="w3-text-grey"><b><i class="fa fa-user"></i> Nome Completo</b></label>
                        <input class="w3-input w3-round" type="text" name="nome_usuario" required placeholder="Seu nome completo">
                    </p>

                    <p>
                        <label class="w3-text-grey"><b><i class="fa fa-envelope"></i> Email</b></label>
                        <input class="w3-input w3-round" type="email" name="email_usuario" required placeholder="seu@email.com">
                    </p>

                    <p>
                        <label class="w3-text-grey"><b><i class="fa fa-lock"></i> Senha</b></label>
                        <input class="w3-input w3-round" type="password" name="senha_usuario" required placeholder="••••••••">
                    </p>

                    <p>
                        <label class="w3-text-grey"><b><i class="fa fa-lock"></i> Confirmar Senha</b></label>
                        <input class="w3-input w3-round" type="password" name="senha_confirm" required placeholder="Repita sua senha">
                    </p>

                    <p>
                        <button class="w3-button w3-block w3-round btn-register w3-padding" type="submit">
                            <i class="fa fa-user-plus"></i> <b>Registrar</b>
                        </button>
                    </p>
                </form>

                <div class="w3-container w3-center footer-box">
                    <p style="margin: 5px 0;">
                        <a href="/backend/login">Já tem conta? Faça login aqui.</a>
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
