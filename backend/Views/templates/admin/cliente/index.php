<?php
// O header e footer já são incluídos pelo View::render
// Variáveis esperadas (passadas pelo controller):
// totalCategorias, totalCategoriasInativas, totalItens, totalItensInativos, vendasMes, faturamentoMes, ultimosItens
?>

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
}

.dashboard-header p {
    margin: 5px 0 0 0;
    opacity: 0.9;
    font-size: 14px;
}

/* Botões de Ação Rápida */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 30px;
}

.quick-btn {
    background: white;
    border: 2px solid var(--bege-primary);
    padding: 15px 20px;
    border-radius: 10px;
    text-decoration: none;
    color: var(--marrom);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.quick-btn:hover {
    background: var(--bege-primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.quick-btn i {
    font-size: 20px;
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

/* Seção de Conteúdo */
.content-section {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    margin-bottom: 25px;
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

/* Painel de Informações */
.info-panel {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.info-box {
    background: var(--bege-light);
    padding: 15px 20px;
    border-radius: 10px;
    border-left: 4px solid var(--bege-dark);
}

.info-box strong {
    color: var(--marrom);
    font-size: 16px;
}

/* Seletor de Período */
.period-selector {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    margin-bottom: 25px;
}

.period-selector label {
    font-weight: 600;
    color: var(--marrom);
    margin-right: 10px;
}

.period-selector select {
    padding: 8px 15px;
    border: 2px solid var(--bege-primary);
    border-radius: 6px;
    font-size: 14px;
    color: var(--marrom);
    background: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.period-selector select:hover,
.period-selector select:focus {
    border-color: var(--bege-dark);
    outline: none;
}

/* Grid de Gráficos */
.charts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 25px;
    margin-top: 25px;
}

.chart-container {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(0,0,0,0.08);
}

.chart-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--marrom);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.chart-title i {
    color: var(--bege-dark);
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

/* Responsividade */
@media (max-width: 768px) {
    .metrics-grid,
    .charts-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
    
    .dashboard-header h1 {
        font-size: 22px;
    }
    
    .metric-value {
        font-size: 26px;
    }
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

.metric-card,
.content-section,
.chart-container {
    animation: fadeInUp 0.5s ease-out;
}
</style>

<div class="dashboard-container">
    <!-- Header do Dashboard -->
    