<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta - Sebo Alfarrábio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
:root {
    --bege-primary: #D4B896;
    --bege-light: #E8DCCF;
    --bege-dark: #B89968;
    --marrom: #8B6F47;
    --verde: #6B8E23;
    --azul: #5B9BD5;
    --laranja: #F4A460;
    --roxo: #9370DB;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    background: linear-gradient(135deg, #f5f5f0 0%, #faf8f3 100%);
    min-height: 100vh;
}

.dashboard-container {
    background: linear-gradient(135deg, #f5f5f0 0%, #faf8f3 100%);
    min-height: 100vh;
    padding: 20px;
}

.dashboard-header {
    background: linear-gradient(135deg, var(--bege-dark) 0%, var(--marrom) 100%);
    color: white;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.dashboard-header h1 {
    margin: 0;
    font-size: 28px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 15px;
}

.dashboard-header p {
    margin: 5px 0 0 0;
    opacity: 0.9;
    font-size: 14px;
}

.header {
            text-align: center;
            box-shadow: 0px 5px 10px #a87e4b;
            color: #8B4513;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 2em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .header p {
            margin: 5px 0 0;
            font-style: italic;
        }

/* Botões de Ação Rápida */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 30px;
}

.tabs-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.tab-btn {
    background: white;
    border: 2px solid var(--bege-primary);
    padding: 12px 20px;
    border-radius: 8px;
    color: var(--marrom);
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.tab-btn:hover {
    background: var(--bege-light);
    transform: translateY(-2px);
}

.tab-btn.active {
    background: linear-gradient(135deg, var(--bege-dark), var(--marrom));
    color: white;
    border-color: var(--marrom);
}

.tab-btn i {
    font-size: 16px;
}

/* Conteúdo das Seções */
.content-section {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    display: none;
}

.content-section.active {
    display: block;
    animation: fadeInUp 0.5s ease-out;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid var(--bege-light);
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--marrom);
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: var(--bege-dark);
}

/* Cards de Métricas */
.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.metric-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-left: 4px solid;
}

.metric-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

.metric-card.blue { border-left-color: var(--azul); }
.metric-card.orange { border-left-color: var(--laranja); }
.metric-card.green { border-left-color: var(--verde); }
.metric-card.purple { border-left-color: var(--roxo); }

.metric-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.metric-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
}

.metric-card.blue .metric-icon { background: linear-gradient(135deg, var(--azul), #4A7FB8); }
.metric-card.orange .metric-icon { background: linear-gradient(135deg, var(--laranja), #D8854A); }
.metric-card.green .metric-icon { background: linear-gradient(135deg, var(--verde), #557016); }
.metric-card.purple .metric-icon { background: linear-gradient(135deg, var(--roxo), #7555B8); }

.metric-value {
    font-size: 32px;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.metric-label {
    font-size: 14px;
    color: #666;
    margin: 5px 0 0 0;
}

/* Formulário de Perfil */
.profile-form {
    max-width: 600px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: var(--marrom);
    margin-bottom: 8px;
    font-size: 14px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid var(--bege-primary);
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--bege-dark);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.btn-primary {
    background: linear-gradient(135deg, var(--bege-dark), var(--marrom));
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* Tabela Moderna */
.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.modern-table thead th {
    background: linear-gradient(135deg, var(--bege-primary), var(--bege-dark));
    color: white;
    padding: 12px 15px;
    text-align: left;
    font-weight: 600;
    font-size: 14px;
}

.modern-table thead th:first-child {
    border-top-left-radius: 8px;
}

.modern-table thead th:last-child {
    border-top-right-radius: 8px;
}

.modern-table tbody tr {
    transition: background 0.2s ease;
}

.modern-table tbody tr:hover {
    background: var(--bege-light);
}

.modern-table tbody td {
    padding: 12px 15px;
    border-bottom: 1px solid #f0f0f0;
    color: #333;
}

.modern-table tbody tr:last-child td {
    border-bottom: none;
}

/* Badge de Status */
.badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: #d4edda;
    color: #155724;
}

.badge-warning {
    background: #fff3cd;
    color: #856404;
}

.badge-info {
    background: #d1ecf1;
    color: #0c5460;
}

/* Lista de Cards */
.card-list {
    display: grid;
    gap: 15px;
}

.card-item {
    background: var(--bege-light);
    padding: 20px;
    border-radius: 10px;
    border-left: 4px solid var(--bege-dark);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.card-item:hover {
    transform: translateX(5px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.card-item-content h4 {
    color: var(--marrom);
    margin-bottom: 5px;
}

.card-item-content p {
    color: #666;
    font-size: 14px;
}

.card-actions {
    display: flex;
    gap: 10px;
}

.btn-icon {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: none;
    background: white;
    color: var(--marrom);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-icon:hover {
    background: var(--marrom);
    color: white;
    transform: scale(1.1);
}

/* Grid de Favoritos */
.favorites-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.favorite-item {
    background: white;
    border: 2px solid var(--bege-light);
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    transition: all 0.3s ease;
}

.favorite-item:hover {
    border-color: var(--bege-dark);
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.favorite-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 10px;
}

.favorite-item h4 {
    color: var(--marrom);
    font-size: 14px;
    margin-bottom: 5px;
}

.favorite-item p {
    color: #666;
    font-size: 12px;
}

/* Animações */
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

/* Responsividade */
@media (max-width: 768px) {
    .metrics-grid {
        grid-template-columns: 1fr;
    }
    
    .tabs-container {
        flex-direction: column;
    }
    
    .tab-btn {
        width: 100%;
        justify-content: center;
    }
    
    .dashboard-header h1 {
        font-size: 22px;
    }
    
    .favorites-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
}
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Header do Dashboard -->
        <div class="dashboard-header">
            <h1><i class="fas fa-user-circle"></i> Minha Conta - Sebo Alfarrábio</h1>
            <p>Bem-vindo! Gerencie suas informações, pedidos e preferências</p>
        </div>

<div class="dashboard-container">
<div class="header">
            <h1><i class="fa fa fa-user"></i> Seu Perfil - Sebo Alfarrábio</h1>
            <p>Bem-vindo, <?= htmlspecialchars($usuarioNome) ?>! Gerencie suas informações e pedidos aqui.</p>
        </div>
