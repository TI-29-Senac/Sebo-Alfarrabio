<?php
use Sebo\Alfarrabio\Core\Flash;
use Sebo\Alfarrabio\Core\Session;
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sebo Alfarrábio - Dashboard Administrativo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        html,
        body,
        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: "Raleway", sans-serif
        }

        :root {
            --bege-primary: #D4B896;
            --bege-light: #E8DCCF;
            --bege-dark: #B89968;
            --marrom: #8B6F47;
            --marrom-escuro: #6B5235;
        }

        /* Top Bar Personalizada */
        .top-bar-sebo {
            background: linear-gradient(135deg, var(--bege-dark) 0%, var(--marrom) 100%) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .top-bar-sebo .logo-text {
            font-weight: 700;
            font-size: 18px;
            letter-spacing: 1px;
        }

        /* Sidebar Personalizada */
        .sidebar-sebo {
            background: linear-gradient(180deg, #ffffff 0%, #faf8f3 100%) !important;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.05);
        }

        .sidebar-sebo .user-profile {
            background: linear-gradient(135deg, var(--bege-light), var(--bege-primary));
            padding: 20px;
            border-radius: 10px;
            margin: 15px;
        }

        .sidebar-sebo .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar-sebo .user-name {
            font-weight: 600;
            color: var(--marrom-escuro);
            font-size: 16px;
        }

        .sidebar-sebo .user-role {
            font-size: 12px;
            color: var(--marrom);
            opacity: 0.8;
        }

        /* Menu Items */
        .menu-section-title {
            padding: 15px 16px 10px 16px;
            font-size: 11px;
            font-weight: 700;
            color: var(--marrom);
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.6;
        }

        .sidebar-sebo .menu-item {
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
            color: #333 !important;
        }

        .sidebar-sebo .menu-item:hover {
            background: var(--bege-light) !important;
            border-left-color: var(--bege-dark);
            padding-left: 19px;
        }

        .sidebar-sebo .menu-item.active {
            background: var(--bege-primary) !important;
            border-left-color: var(--marrom);
            color: white !important;
            font-weight: 600;
        }

        .sidebar-sebo .menu-item i {
            width: 25px;
            color: var(--marrom);
        }

        .sidebar-sebo .menu-item.active i {
            color: white;
        }

        /* Botões de Ação do Usuário */
        .user-action-btn {
            background: white;
            border-radius: 6px;
            margin: 2px;
            transition: all 0.3s ease;
        }

        .user-action-btn:hover {
            background: var(--bege-dark) !important;
            color: white !important;
        }

        /* Mensagens Flash */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px;
            border-left: 4px solid;
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
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

        /* Badge contador */
        .badge-count {
            background: #dc3545;
            color: white;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 700;
            margin-left: 5px;
        }

        /* Logout Button */
        .logout-btn {
            background: #dc3545 !important;
            color: white !important;
            border-radius: 8px;
            margin: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #c82333 !important;
            transform: translateX(5px);
        }
    </style>
</head>

<body class="w3-light-grey">
    <?php
    $session = new Session();
    $usuarioNome = $session->get('usuario_nome') ?? 'Usuário';
    $usuarioTipo = $session->get('usuario_tipo') ?? 'Admin';
    $usuarioEmail = $session->get('usuario_email') ?? 'Email';
    ?>

    <!-- Top Bar -->
    <div class="w3-bar w3-top top-bar-sebo w3-large" style="z-index:4">
        <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();">
            <i class="fa fa-bars"></i> Menu
        </button>
        <span class="w3-bar-item w3-right logo-text">
            <i class="fa fa-book"></i> SEBO ALFARRÁBIO
        </span>
    </div>

    <?php
    $currentPath = $_SERVER['REQUEST_URI'] ?? '';
    $isLoginOrRegister = strpos($currentPath, '/login') !== false || strpos($currentPath, '/register') !== false;
    if (!$isLoginOrRegister):
        ?>

        <!-- Sidebar/Menu -->
        <nav class="w3-sidebar w3-collapse sidebar-sebo w3-animate-left" style="z-index:3;width:300px;" id="mySidebar">

            <!-- Perfil do Usuário -->
            <div class="user-profile">
                <div class="w3-row">
                    <div class="w3-col s3">
                        <img src="<?= !empty($usuario['foto_perfil_usuario']) ? htmlspecialchars($usuario['foto_perfil_usuario']) : '/img/avatar_placeholder.png' ?>"
                            class="user-avatar" alt="Logo">
                    </div>
                    <div class="w3-col s9" style="padding-left: 12px; padding-top: 10px;">
                        <div class="user-name"><?= htmlspecialchars($usuarioNome); ?></div>
                        <div class="user-role"><?= htmlspecialchars($usuarioTipo); ?></div>
                        <div class="user-email"><?= htmlspecialchars($usuarioEmail); ?></div>

                    </div>
                </div>
            </div>

            <hr style="margin: 0;">

            <!-- Menu de Navegação -->
            <div class="w3-bar-block">
                <!-- Botão Close Mobile -->
                <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black"
                    onclick="w3_close()" title="Fechar Menu">
                    <i class="fa fa-remove fa-fw"></i> Fechar Menu
                </a>

                <!-- Dashboard -->
                <div class="menu-section-title">
                    <i class="fa fa-user"></i> Principal
                </div>
                <a href="/backend/admin/cliente" class="menu-item w3-bar-item w3-button w3-padding active">
                    <i class="fa fa-user"></i> Seu Perfil
                </a>
                <a href="/backend/admin/cliente" class="menu-item w3-bar-item w3-button w3-padding active">
                    <i class="fa fa-check"></i> Suas Reservas
                </a>
                <a href="/backend/admin/favoritos" class="menu-item w3-bar-item w3-button w3-padding active">
                    <i class="fa fa-heart"></i> Favoritos
                </a>

                <!-- Gestão de Produtos -->
                <div class="menu-section-title">
                    <i class="fa fa-comment"></i> Interações
                </div>
                <a href="/backend/admin/cliente/avaliacoes" class="menu-item w3-bar-item w3-button w3-padding">
                    <i class="fa fa-comment"></i> Avaliações
                </a>
                <a href="/backend/admin/cliente" class="menu-item w3-bar-item w3-button w3-padding">
                    <i class="fa fa-bell"></i> Notificações
                </a>

                <!-- Vendas e Reservas -->
                <div class="menu-section-title">
                    <i class="fa fa-cog"></i> Configurações do Sistema
                </div>
                <a href="/backend/admin/cliente" class="menu-item w3-bar-item w3-button w3-padding">
                    <i class="fa fa-cog"></i> Configurações
                </a>

                <!-- Ações Finais -->
                <a href="/index.html" class="menu-item w3-bar-item w3-button w3-padding"
                    style="background-color: #28a745 !important; color: white !important; border-radius: 8px; margin: 10px 15px;">
                    <i class="fa fa-arrow-left fa-fw"></i> Continuar Navegando
                </a>

                <a href="/backend/logout" class="logout-btn w3-bar-item w3-button w3-padding">
                    <i class="fa fa-sign-out fa-fw"></i> Sair da Conta
                </a>
            </div>
        </nav>

        <!-- Overlay para mobile -->
        <div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer"
            title="Fechar menu" id="myOverlay"></div>

    <?php endif; ?>

    <!-- Conteúdo Principal -->
    <div class="w3-main" style="margin-left:<?= $isLoginOrRegister ? '0' : '300px' ?>;margin-top:43px;">

        <?php
        // Exibição de mensagens Flash
        $mensagem = Flash::get();
        if (isset($mensagem)) {
            foreach ($mensagem as $key => $value) {
                if ($key == "type") {
                    $tipo = $value == "success" ? "alert-success" : "alert-danger";
                    $icone = $value == "success" ? "fa-check-circle" : "fa-exclamation-triangle";
                    echo "<div class='alert $tipo' role='alert'>";
                    echo "<i class='fa $icone'></i> ";
                } else {
                    echo $value;
                    echo "</div>";
                }
            }
        }
        ?>