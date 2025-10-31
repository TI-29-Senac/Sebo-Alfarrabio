<?php
// Define o título da página
$page_title = 'Dashboard';

// Inclui o header (que já tem tudo: config, conexão, verificação de login, etc)
include 'header.php';

// ============================================
// LÓGICA DO DASHBOARD
// ============================================

// Busca estatísticas para o dashboard
$total_acervo = $conn->query("SELECT COUNT(*) as total FROM tbl_acervo WHERE excluido_em IS NULL")->fetch_assoc()['total'];
$total_reservas = $conn->query("SELECT COUNT(*) as total FROM tbl_reservas WHERE status_reserva = 'ativa' AND excluido_em IS NULL")->fetch_assoc()['total'];
$vendas_mes = $conn->query("SELECT COUNT(*) as total FROM tbl_vendas WHERE MONTH(data_venda) = MONTH(CURRENT_DATE()) AND YEAR(data_venda) = YEAR(CURRENT_DATE())")->fetch_assoc()['total'];
$faturamento_mes = $conn->query("SELECT COALESCE(SUM(valor_total), 0) as total FROM tbl_vendas WHERE MONTH(data_venda) = MONTH(CURRENT_DATE()) AND YEAR(data_venda) = YEAR(CURRENT_DATE())")->fetch_assoc()['total'];

// Busca últimas vendas
$ultimas_vendas = $conn->query("
    SELECT v.*, u.nome_usuario 
    FROM tbl_vendas v
    LEFT JOIN tbl_usuario u ON v.id_usuario = u.id_usuario
    ORDER BY v.data_venda DESC 
    LIMIT 5
");

// Busca reservas ativas
$reservas_ativas = $conn->query("
    SELECT r.*, u.nome_usuario, a.titulo_acervo
    FROM tbl_reservas r
    LEFT JOIN tbl_usuario u ON r.id_usuario = u.id_usuario
    LEFT JOIN tbl_acervo a ON r.id_acervo = a.id_acervo
    WHERE r.status_reserva = 'ativa'
    ORDER BY r.data_reserva DESC
    LIMIT 5
");

// Busca itens mais vendidos
$itens_vendidos = $conn->query("
    SELECT a.titulo_acervo, COUNT(*) as total_vendas
    FROM tbl_itens_vendas iv
    LEFT JOIN tbl_acervo a ON iv.id_acervo = a.id_acervo
    WHERE iv.excluido_em IS NULL
    GROUP BY iv.id_acervo
    ORDER BY total_vendas DESC
    LIMIT 5
");

// Busca categorias populares
$categorias = $conn->query("
    SELECT c.nome_categoria, COUNT(i.id_itens) as total
    FROM tbl_categoria c
    LEFT JOIN tbl_itens i ON c.id_categoria = i.id_categoria
    WHERE c.excluido_em IS NULL
    GROUP BY c.id_categoria
    ORDER BY total DESC
    LIMIT 5
");
?>

<!-- ============================================ -->
<!-- CONTEÚDO DO DASHBOARD -->
<!-- ============================================ -->

<!-- Header da página -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Dashboard - Visão Geral</b></h5>
</header>

<!-- Cards de Estatísticas -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter stat-card">
        <div class="w3-container w3-blue w3-padding-16 w3-round">
            <div class="w3-left stat-icon"><i class="fa fa-book"></i></div>
            <div class="w3-clear"></div>
            <h4><?php echo number_format($total_acervo, 0, ',', '.'); ?></h4>
            <p>Itens no Acervo</p>
        </div>
    </div>
    <div class="w3-quarter stat-card">
        <div class="w3-container w3-orange w3-padding-16 w3-round">
            <div class="w3-left stat-icon"><i class="fa fa-bookmark"></i></div>
            <div class="w3-clear"></div>
            <h4><?php echo number_format($total_reservas, 0, ',', '.'); ?></h4>
            <p>Reservas Ativas</p>
        </div>
    </div>
    <div class="w3-quarter stat-card">
        <div class="w3-container w3-green w3-padding-16 w3-round">
            <div class="w3-left stat-icon"><i class="fa fa-shopping-cart"></i></div>
            <div class="w3-clear"></div>
            <h4><?php echo number_format($vendas_mes, 0, ',', '.'); ?></h4>
            <p>Vendas do Mês</p>
        </div>
    </div>
    <div class="w3-quarter stat-card">
        <div class="w3-container w3-purple w3-padding-16 w3-round">
            <div class="w3-left stat-icon"><i class="fa fa-dollar"></i></div>
            <div class="w3-clear"></div>
            <h4><?php echo formatar_moeda($faturamento_mes); ?></h4>
            <p>Faturamento Mensal</p>
        </div>
    </div>
</div>

<!-- Tabelas -->
<div class="w3-row-padding w3-margin-bottom">
    <!-- Últimas Vendas -->
    <div class="w3-half">
        <div class="w3-container w3-white w3-padding-16 w3-round w3-card">
            <h5><i class="fa fa-shopping-cart"></i> Últimas Vendas</h5>
            <table class="w3-table w3-striped w3-bordered w3-hoverable">
                <thead>
                    <tr class="w3-light-grey">
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Valor</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ultimas_vendas->num_rows > 0): ?>
                        <?php while ($venda = $ultimas_vendas->fetch_assoc()): ?>
                            <tr>
                                <td><span class="w3-tag w3-blue w3-round">#<?php echo $venda['id_venda']; ?></span></td>
                                <td><?php echo htmlspecialchars($venda['nome_usuario']); ?></td>
                                <td><strong><?php echo formatar_moeda($venda['valor_total']); ?></strong></td>
                                <td><?php echo formatar_data($venda['data_venda'], 'd/m/Y'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="w3-center w3-text-grey">
                                <i class="fa fa-info-circle"></i> Nenhuma venda registrada
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Reservas Ativas -->
    <div class="w3-half">
        <div class="w3-container w3-white w3-padding-16 w3-round w3-card">
            <h5><i class="fa fa-bookmark"></i> Reservas Ativas</h5>
            <table class="w3-table w3-striped w3-bordered w3-hoverable">
                <thead>
                    <tr class="w3-light-grey">
                        <th>Cliente</th>
                        <th>Item</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($reservas_ativas->num_rows > 0): ?>
                        <?php while ($reserva = $reservas_ativas->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($reserva['nome_usuario']); ?></td>
                                <td><?php echo htmlspecialchars(substr($reserva['titulo_acervo'], 0, 30)); ?>...</td>
                                <td><?php echo formatar_data($reserva['data_reserva']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="w3-center w3-text-grey">
                                <i class="fa fa-info-circle"></i> Nenhuma reserva ativa
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Mais informações -->
<div class="w3-row-padding w3-margin-bottom">
    <!-- Itens Mais Vendidos -->
    <div class="w3-half">
        <div class="w3-container w3-white w3-padding-16 w3-round w3-card">
            <h5><i class="fa fa-trophy"></i> Itens Mais Vendidos</h5>
            <ul class="w3-ul">
                <?php if ($itens_vendidos->num_rows > 0): ?>
                    <?php while ($item = $itens_vendidos->fetch_assoc()): ?>
                        <li class="w3-bar">
                            <div class="w3-bar-item">
                                <span class="w3-large"><?php echo htmlspecialchars($item['titulo_acervo']); ?></span><br>
                                <span class="w3-small w3-text-grey">
                                    <i class="fa fa-shopping-cart"></i> <?php echo $item['total_vendas']; ?> vendas
                                </span>
                            </div>
                            <span class="w3-bar-item w3-right" style="padding-top: 20px;">
                                <span class="w3-badge w3-blue w3-large"><?php echo $item['total_vendas']; ?></span>
                            </span>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="w3-center w3-text-grey w3-padding">
                        <i class="fa fa-info-circle"></i> Nenhum item vendido ainda
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Categorias Populares -->
    <div class="w3-half">
        <div class="w3-container w3-white w3-padding-16 w3-round w3-card">
            <h5><i class="fa fa-tags"></i> Categorias Populares</h5>
            <ul class="w3-ul">
                <?php if ($categorias->num_rows > 0): ?>
                    <?php while ($categoria = $categorias->fetch_assoc()): ?>
                        <li class="w3-bar">
                            <div class="w3-bar-item" style="width: 60%;">
                                <span class="w3-large"><?php echo htmlspecialchars($categoria['nome_categoria']); ?></span><br>
                                <span class="w3-small w3-text-grey">
                                    <i class="fa fa-book"></i> <?php echo $categoria['total']; ?> itens
                                </span>
                            </div>
                            <div class="w3-bar-item w3-right" style="width: 35%; padding-top: 20px;">
                                <div class="w3-light-grey w3-round">
                                    <div class="w3-container w3-green w3-round w3-center" style="width:<?php echo min(100, $categoria['total'] * 10); ?>%">
                                        <?php echo $categoria['total']; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li class="w3-center w3-text-grey w3-padding">
                        <i class="fa fa-info-circle"></i> Nenhuma categoria cadastrada
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<?php
// Inclui o footer (que fecha tudo e tem os scripts)
include 'footer.php';
?>