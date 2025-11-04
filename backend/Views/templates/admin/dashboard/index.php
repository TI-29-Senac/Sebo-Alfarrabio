<<<<<<< HEAD
<?php
// O header e footer já são incluídos pelo View::render
// Variáveis esperadas (passadas pelo controller):
// totalCategorias, totalCategoriasInativas, totalItens, totalItensInativos, vendasMes, faturamentoMes, ultimosItens
?>

<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Dashboard - Visão Geral</b></h5>
</header>

<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
        <div class="w3-container w3-blue w3-padding-16 w3-round">
            <div class="w3-left"><i class="fa fa-tags" style="font-size:24px"></i></div>
            <div class="w3-clear"></div>
            <h4><?= number_format($totalCategorias, 0, ',', '.'); ?></h4>
            <p>Categorias</p>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-orange w3-padding-16 w3-round">
            <div class="w3-left"><i class="fa fa-archive" style="font-size:24px"></i></div>
            <div class="w3-clear"></div>
            <h4><?= number_format($totalItens, 0, ',', '.'); ?></h4>
            <p>Itens</p>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-green w3-padding-16 w3-round">
            <div class="w3-left"><i class="fa fa-shopping-cart" style="font-size:24px"></i></div>
            <div class="w3-clear"></div>
            <h4><?= number_format($vendasMes ?? 0, 0, ',', '.'); ?></h4>
            <p>Vendas do Mês</p>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-purple w3-padding-16 w3-round">
            <div class="w3-left"><i class="fa fa-money" style="font-size:24px"></i></div>
            <div class="w3-clear"></div>
            <h4>R$ <?= number_format($faturamentoMes ?? 0, 2, ',', '.'); ?></h4>
            <p>Faturamento Mensal</p>
        </div>
    </div>
</div>

<!-- Últimos itens cadastrados -->
<div class="w3-container w3-white w3-padding-16 w3-round w3-card">
    <h5><i class="fa fa-list"></i> Últimos itens cadastrados</h5>
    <table class="w3-table w3-striped w3-bordered w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>ID</th>
                <th>Título</th>
                <th>Categoria</th>
                <th>Gênero</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($ultimosItens)): ?>
                <?php foreach ($ultimosItens as $item): ?>
                    <tr>
                        <td>#<?= htmlspecialchars($item['id_item']); ?></td>
                        <td><?= htmlspecialchars($item['titulo_item']); ?></td>
                        <td><?= htmlspecialchars($item['nome_categoria'] ?? '-'); ?></td>
                        <td><?= htmlspecialchars($item['nome_genero'] ?? '-'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="w3-center w3-text-grey">Nenhum item cadastrado</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pequenas métricas adicionais -->
<div class="w3-row-padding w3-margin-top">
    <div class="w3-half">
        <div class="w3-panel w3-leftbar w3-border-blue">
            <p><strong>Categorias inativas:</strong> <?= number_format($totalCategoriasInativas, 0, ',', '.'); ?></p>
        </div>
    </div>
    <div class="w3-half">
        <div class="w3-panel w3-leftbar w3-border-orange">
            <p><strong>Itens inativos:</strong> <?= number_format($totalItensInativos, 0, ',', '.'); ?></p>
        </div>
    </div>
</div>

<!-- Seleção do período para os gráficos -->
<div class="w3-row-padding w3-margin-top">
    <div class="w3-container w3-white w3-padding-8 w3-round w3-card">
        <form method="get" id="periodForm">
            <label for="period">Período dos gráficos:</label>
            <select name="period" id="period" onchange="document.getElementById('periodForm').submit()">
                <option value="3" <?= (isset($_GET['period']) && (int)$_GET['period'] === 3) ? 'selected' : '' ?>>Últimos 3 meses</option>
                <option value="6" <?= (!isset($_GET['period']) || (int)$_GET['period'] === 6) ? 'selected' : '' ?>>Últimos 6 meses</option>
                <option value="12" <?= (isset($_GET['period']) && (int)$_GET['period'] === 12) ? 'selected' : '' ?>>Últimos 12 meses</option>
            </select>
            <noscript><button type="submit" class="w3-button w3-blue">Atualizar</button></noscript>
        </form>
    </div>
</div>

<!-- Gráficos: Vendas e Reservas -->
<div class="w3-row-padding w3-margin-top">
    <div class="w3-half w3-white w3-padding w3-round w3-card">
        <h5><i class="fa fa-line-chart"></i> Vendas (últimos 6 meses)</h5>
        <canvas id="vendasChart" width="400" height="200"></canvas>
    </div>
    <div class="w3-half w3-white w3-padding w3-round w3-card">
        <h5><i class="fa fa-bar-chart"></i> Reservas (últimos 6 meses)</h5>
        <canvas id="reservasChart" width="400" height="200"></canvas>
    </div>
</div>

<!-- Chart.js CDN e renderização -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dados vindos do controller
    const vendasLabels = <?= json_encode($vendas_chart_labels ?? []); ?>;
    const vendasData = <?= json_encode($vendas_chart_data ?? []); ?>;

    const reservasLabels = <?= json_encode($reservas_chart_labels ?? []); ?>;
    const reservasData = <?= json_encode($reservas_chart_data ?? []); ?>;

    // Vendas - linha
    if (document.getElementById('vendasChart')) {
        const ctxV = document.getElementById('vendasChart').getContext('2d');
        new Chart(ctxV, {
            type: 'line',
            data: {
                labels: vendasLabels,
                datasets: [{
                    label: 'Vendas',
                    data: vendasData,
                    backgroundColor: 'rgba(54,162,235,0.2)',
                    borderColor: 'rgba(54,162,235,1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Reservas - barra
    if (document.getElementById('reservasChart')) {
        const ctxR = document.getElementById('reservasChart').getContext('2d');
        new Chart(ctxR, {
            type: 'bar',
            data: {
                labels: reservasLabels,
                datasets: [{
                    label: 'Reservas',
                    data: reservasData,
                    backgroundColor: 'rgba(255,159,64,0.6)',
                    borderColor: 'rgba(255,159,64,1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
</script>
=======
<div class="w3-container w3-padding-32">
    <h3><i class="fa fa-dashboard"></i> Meu Painel</h3>
    <h2>Bem-vindo de volta, <?= htmlspecialchars($nomeUsuario); ?>!</h2>
    <h2>Seu usuario, <?= htmlspecialchars($Tipo); ?>!</h2>
    <p>Esta é a sua área segura.</p>
    <a href="/backend/logout" class="w3-button w3-red">Sair do Sistema</a>
</div>
>>>>>>> 30e42a079eaa155a1ba55a4d90bef79ef1323ddb
