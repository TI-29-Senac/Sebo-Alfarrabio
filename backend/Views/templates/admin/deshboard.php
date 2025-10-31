<?php
require_once '../config.php';
requireLogin();  // Agora funciona!

$controller = new \Sebo\Alfarrabio\Controllers\Admin\DashboardController();
$data = $controller->getDashboardData();

$pageTitle = "Dashboard";
$pageDescription = "Visão geral do acervo, vendas e reservas do Sebo Alfarrábio.";
$totalReservasPendentes = $data['total_reservas_pendentes'] ?? 0;
$totalNotificacoes = $data['total_notificacoes'] ?? 0;

// Dados para gráficos (usando dados reais do controller)
$meses = json_encode(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun']);  // Pode ser dinâmico do banco
$valores = json_encode($data['faturamento_por_mes'] ?? [0, 0, 0, 0, 0, 0]);
$categorias = json_encode(array_keys($data['categorias'] ?? []));
$totais = json_encode(array_values($data['categorias'] ?? []));

include '../Views/template/header.php';
?>

<!-- DASHBOARD CONTENT -->
<div class="dashboard-grid">
    <!-- Cards de Estatísticas -->
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-book"></i></div>
        <div class="stat-info">
            <h3><?php echo number_format($data['total_acervo'] ?? 0); ?></h3>
            <p>Itens no Acervo</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
        <div class="stat-info">
            <h3><?php echo number_format($data['total_reservas'] ?? 0); ?></h3>
            <p>Reservas Ativas</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
        <div class="stat-info">
            <h3><?php echo number_format($data['vendas_mes'] ?? 0); ?></h3>
            <p>Vendas no Mês</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        <div class="stat-info">
            <h3><?php echo formatarMoeda($data['faturamento_mes'] ?? 0); ?></h3>
            <p>Faturamento do Mês</p>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="charts-grid">
    <div class="chart-card">
        <h3>Faturamento por Mês</h3>
        <canvas id="faturamentoChart" width="400" height="200"></canvas>
    </div>
    <div class="chart-card">
        <h3>Itens por Categoria</h3>
        <canvas id="categoriasChart" width="400" height="200"></canvas>
    </div>
</div>

<!-- Tabela de Últimas Vendas -->
<div class="recent-activity">
    <h3>Últimas Vendas</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Item</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['ultimas_vendas'])): ?>
                    <tr><td colspan="4">Nenhuma venda recente.</td></tr>
                <?php else: ?>
                    <?php foreach ($data['ultimas_vendas'] as $venda): ?>
                    <tr>
                        <td><?php echo formatarData($venda['data_venda']); ?></td>
                        <td><?php echo htmlspecialchars($venda['nome_usuario'] ?? 'Anônimo'); ?></td>
                        <td><?php echo htmlspecialchars($venda['titulo_acervo'] ?? 'N/A'); ?></td>
                        <td><?php echo formatarMoeda($venda['valor_total']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Scripts para Gráficos -->
<script>
    // Gráfico de Faturamento (Linha)
    new Chart(document.getElementById('faturamentoChart'), {
        type: 'line',
        data: {
            labels: <?php echo $meses; ?>,
            datasets: [{
                label: 'Faturamento',
                data: <?php echo $valores; ?>,
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } } }
    });

    // Gráfico de Categorias (Donut)
    new Chart(document.getElementById('categoriasChart'), {
        type: 'doughnut',
        data: {
            labels: <?php echo $categorias; ?>,
            datasets: [{
                data: <?php echo $totais; ?>,
                backgroundColor: ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#6d28d9']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'right' } } }
    });
</script>

<?php include '../Views/template/footer.php'; ?>