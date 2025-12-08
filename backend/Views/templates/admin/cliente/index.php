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

/* Navegação por Abas */
.tabs-navigation {
    background: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
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

        <!-- Navegação por Abas -->
        <div class="tabs-navigation">
            <div class="tabs-container">
                <button class="tab-btn active" onclick="showSection('perfil')">
                    <i class="fas fa-user"></i> Seu Perfil
                </button>
                <button class="tab-btn" onclick="showSection('pedidos')">
                    <i class="fas fa-box"></i> Seus Pedidos
                </button>
                <button class="tab-btn" onclick="showSection('favoritos')">
                    <i class="fas fa-heart"></i> Favoritos
                </button>
                <button class="tab-btn" onclick="showSection('estante')">
                    <i class="fas fa-book"></i> Minha Estante
                </button>
                <button class="tab-btn" onclick="showSection('enderecos')">
                    <i class="fas fa-map-marker-alt"></i> Endereços
                </button>
                <button class="tab-btn" onclick="showSection('pagamento')">
                    <i class="fas fa-credit-card"></i> Pagamento
                </button>
                <button class="tab-btn" onclick="showSection('mensagens')">
                    <i class="fas fa-comments"></i> Mensagens
                </button>
                <button class="tab-btn" onclick="showSection('notificacoes')">
                    <i class="fas fa-bell"></i> Notificações
                </button>
                <button class="tab-btn" onclick="showSection('historico')">
                    <i class="fas fa-history"></i> Histórico
                </button>
                <button class="tab-btn" onclick="showSection('pontos')">
                    <i class="fas fa-gift"></i> Pontos e Cupons
                </button>
                <button class="tab-btn" onclick="showSection('config')">
                    <i class="fas fa-cog"></i> Configurações
                </button>
            </div>
        </div>

        <!-- Seção: Seu Perfil -->
        <div id="perfil" class="content-section active">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-user"></i> Seu Perfil</h2>
            </div>

            <div class="metrics-grid" style="margin-bottom: 30px;">
                <div class="metric-card blue">
                    <div class="metric-icon"><i class="fas fa-shopping-bag"></i></div>
                    <h3 class="metric-value">24</h3>
                    <p class="metric-label">Livros Comprados</p>
                </div>
                <div class="metric-card green">
                    <div class="metric-icon"><i class="fas fa-dollar-sign"></i></div>
                    <h3 class="metric-value">R$ 1.847</h3>
                    <p class="metric-label">Total Gasto</p>
                </div>
                <div class="metric-card purple">
                    <div class="metric-icon"><i class="fas fa-star"></i></div>
                    <h3 class="metric-value">850</h3>
                    <p class="metric-label">Pontos Acumulados</p>
                </div>
            </div>

            <form class="profile-form">
                <div class="form-group">
                    <label>Nome Completo</label>
                    <input type="text" value="João da Silva" />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="joao.silva@email.com" />
                </div>
                <div class="form-group">
                    <label>Telefone</label>
                    <input type="tel" value="(11) 98765-4321" />
                </div>
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" value="123.456.789-00" disabled />
                </div>
                <div class="form-group">
                    <label>Bio / Sobre Você</label>
                    <textarea>Apaixonado por livros clássicos e história. Sempre em busca de edições raras!</textarea>
                </div>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Salvar Alterações
                </button>
            </form>
        </div>

        <!-- Seção: Seus Pedidos -->
        <div id="pedidos" class="content-section">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-box"></i> Seus Pedidos</h2>
            </div>

            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Data</th>
                        <th>Itens</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#1234</td>
                        <td>05/12/2025</td>
                        <td>3 livros</td>
                        <td>R$ 127,50</td>
                        <td><span class="badge badge-success">Entregue</span></td>
                        <td><button class="btn-icon"><i class="fas fa-eye"></i></button></td>
                    </tr>
                    <tr>
                        <td>#1233</td>
                        <td>28/11/2025</td>
                        <td>2 livros</td>
                        <td>R$ 89,00</td>
                        <td><span class="badge badge-info">Em trânsito</span></td>
                        <td><button class="btn-icon"><i class="fas fa-eye"></i></button></td>
                    </tr>
                    <tr>
                        <td>#1232</td>
                        <td>15/11/2025</td>
                        <td>5 livros</td>
                        <td>R$ 245,00</td>
                        <td><span class="badge badge-success">Entregue</span></td>
                        <td><button class="btn-icon"><i class="fas fa-eye"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Seção: Favoritos -->
        <div id="favoritos" class="content-section">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-heart"></i> Seus Favoritos</h2>
            </div>

            <div class="favorites-grid">
                <div class="favorite-item">
                    <div style="background: linear-gradient(135deg, var(--bege-dark), var(--marrom)); height: 200px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; margin-bottom: 10px;">
                        <i class="fas fa-book"></i>
                    </div>
                    <h4>1984</h4>
                    <p>George Orwell</p>
                    <p style="color: var(--verde); font-weight: 600; margin-top: 5px;">R$ 45,00</p>
                </div>
                <div class="favorite-item">
                    <div style="background: linear-gradient(135deg, var(--azul), #4A7FB8); height: 200px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; margin-bottom: 10px;">
                        <i class="fas fa-book"></i>
                    </div>
                    <h4>Dom Casmurro</h4>
                    <p>Machado de Assis</p>
                    <p style="color: var(--verde); font-weight: 600; margin-top: 5px;">R$ 32,00</p>
                </div>
                <div class="favorite-item">
                    <div style="background: linear-gradient(135deg, var(--roxo), #7555B8); height: 200px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; margin-bottom: 10px;">
                        <i class="fas fa-book"></i>
                    </div>
                    <h4>O Senhor dos Anéis</h4>
                    <p>J.R.R. Tolkien</p>
                    <p style="color: var(--verde); font-weight: 600; margin-top: 5px;">R$ 89,90</p>
                </div>
            </div>
        </div>

        <!-- Seção: Minha Estante -->
        <div id="estante" class="content-section">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-book"></i> Minha Estante</h2>
            </div>

            <div class="metrics-grid" style="margin-bottom: 25px;">
                <div class="metric-card blue">
                    <div class="metric-icon"><i class="fas fa-check-circle"></i></div>
                    <h3 class="metric-value">42</h3>
                    <p class="metric-label">Livros Lidos</p>
                </div>
                <div class="metric-card orange">
                    <div class="metric-icon"><i class="fas fa-book-reader"></i></div>
                    <h3 class="metric-value">5</h3>
                    <p class="metric-label">Lendo Agora</p>
                </div>
                <div class="metric-card purple">
                    <div class="metric-icon"><i class="fas fa-bookmark"></i></div>
                    <h3 class="metric-value">18</h3>
                    <p class="metric-label">Quero Ler</p>
                </div>
            </div>

            <p style="color: #666; margin-bottom: 20px;">Organize seus livros por status de leitura e acompanhe seu progresso!</p>
        </div>

        <!-- Seção: Endereços -->
        <div id="enderecos" class="content-section">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-map-marker-alt"></i> Endereços de Entrega</h2>
                <button class="btn-primary"><i class="fas fa-plus"></i> Adicionar Endereço</button>
            </div>

            <div class="card-list">
                <div class="card-item">
                    <div class="card-item-content">
                        <h4>Casa <span class="badge badge-success">Padrão</span></h4>
                        <p>Rua das Flores, 123 - Centro - São Paulo, SP - CEP: 01234-567</p>
                    </div>
                    <div class="card-actions">
                        <button class="btn-icon"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="card-item">
                    <div class="card-item-content">
                        <h4>Trabalho</h4>
                        <p>Av. Paulista, 1000 - Bela Vista - São Paulo, SP - CEP: 01310-100</p>
                    </div>
                    <div class="card-actions">
                        <button class="btn-icon"><i class="fas fa-edit"></i></button>
                        <button class="btn-icon"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção: Pagamento -->
        <div id="pagamento" class="content-section">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-credit-card"></i> Métodos de Pagamento</h2>
                <button class="btn-primary"><i class="fas fa-plus"></i> Adicionar Cartão</button>
            </div>

            <div class="card-list">
                <div class="card-item">
                    <div class="card-item-content">
                        <h4><i class="fas fa-credit-card"></i> Visa •••• 4532</h4>
                        <p>Vencimento: 12/2027</p>
                    </div>
                    <div class="card-actions">
                        <button class="btn-icon"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div class="card-item">
                    <div class="card-item-content">
                        <h4><i class="fas fa-credit-card"></i> Mastercard •••• 8765</h4>
                        <p>Vencimento: 08/2026</p>
                    </div>
                    <div class="card-actions">
                        <button class="btn-icon"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção: Mensagens -->
        <div id="mensagens" class="content-section">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-comments"></i> Mensagens</h2>
            </div>

            <div class="card-list">
                <div class="card-item">
                    <div class="card-item-content">
                        <h4>Conversa com Vendedor - Livro "1984"</h4>
                        <p>Última mensagem há 2 horas</p>
                    </div>
                    <button class="btn-icon"><i class="fas fa-arrow-right"></i></button>
                </div>
                <div class="card-item">
                    <div class="card-item-content">
                        <h4>Suporte - Pedido #1233</h4>
                        <p>Última mensagem há 1 dia</p>
                    </div>
                    <button class="btn-icon"><i class="fas fa-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <!-- Seção: Notificações -->
        <div id="notificacoes" class="content-section">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-bell"></i> Notificações</h2>
            </div>

            <div class="card-list">
                <div class="card-item">
                    <div class="card-item-content">
                        <h4><i class="fas fa-tag" style="color: var(--verde);"></i> Promoção Especial!</h4>
                        <p>Descontos de até 40% em livros de ficção - Válido até amanhã</p>
                    </div>
                </div>
                <div class="card-item">
                    <div class="card-item-content">
                        <h4><i class="fas fa-truck" style="color: var(--azul);"></i> Seu pedido está a caminho</h4>
                        <p>Pedido #1233 saiu para entrega - Previsão: Hoje</p>
                    </div>
                </div>
                <div class="card-item">
                    <div class="card-item-content">
                        <h4><i class="fas fa-heart" style="color: var(--laranja);"></i> Livro favorito em promoção</h4>
                        <p>"1984" agora por R$ 39,90</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seção: Histórico -->
        <div id="historico" class="content-section">
            <div class="section-header">
                <h2 class="section-title"><i class="fas fa-history"></i> Histórico de Navegação</h2>
                <button class="btn-primary"><i class="fas fa-trash"></i> Limpar Histórico</button>
            </div>

            <div class="favorites-grid">
                <div class="favorite-item">
                    <div style="background: linear-gradient(135deg, var(--laranja), #D8854A); height: 150px; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 36px; margin-bottom: 10px;">
                        <i class="fas fa-book"></i>
                    </div>
                    