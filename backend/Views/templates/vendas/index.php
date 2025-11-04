<!-- Header -->
<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Dashboard de Vendas</b></h5>
</header>

<!-- Cards de Estatísticas -->
<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
        <div class="w3-container w3-brown w3-padding-16">
            <div class="w3-left"><i class="fa fa-shopping-cart w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><?php echo $total_vendas; ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Total de Vendas</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-red w3-padding-16">
            <div class="w3-left"><i class="fa fa-times-circle w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><?php echo $total_inativos; ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Vendas Inativas</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-green w3-padding-16">
            <div class="w3-left"><i class="fa fa-check-circle w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><?php echo $total_ativos; ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Vendas Ativas</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-blue w3-padding-16">
            <div class="w3-left"><i class="fa fa-dollar w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3>R$ <?php 
                    $total_valor = 0;
                    if (!empty($vendas)) {
                        foreach ($vendas as $v) {
                            $total_valor += $v['valor_total'];
                        }
                    }
                    echo number_format($total_valor, 2, ',', '.');
                ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Valor Total</h4>
        </div>
    </div>
</div>

<!-- Botão Adicionar -->
<div class="w3-container w3-margin-bottom">
    <a href="/backend/vendas/criar" class="w3-button w3-green w3-large">
        <i class="fa fa-plus"></i> Nova Venda
    </a>
</div>

<!-- Título da Seção -->
<div class="w3-container">
    <h3><i class="fa fa-list"></i> Lista de Vendas</h3>
    <hr>
</div>

<!-- Tabela de Vendas -->
<?php if (isset($vendas) && count($vendas) > 0): ?>
    <div class="w3-responsive">
        <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
            <thead class="w3-light-grey">
                <tr>
                    <th>ID</th>
                    <th><i class="fa fa-calendar"></i> Data</th>
                    <th><i class="fa fa-money"></i> Valor Total</th>
                    <th><i class="fa fa-credit-card"></i> Forma de Pagamento</th>
                    <th><i class="fa fa-user"></i> ID Usuário</th>
                    <th class="w3-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendas as $venda): ?>
                    <tr>
                        <td><?= htmlspecialchars($venda['id_venda']) ?></td>
                        <td><?= date('d/m/Y', strtotime($venda['data_venda'])) ?></td>
                        <td>R$ <?= number_format($venda['valor_total'], 2, ',', '.') ?></td>
                        <td>
                            <?php
                            $forma = htmlspecialchars($venda['forma_pagamento']);
                            $badge_color = [
                                'Dinheiro' => 'w3-green',
                                'Cartão' => 'w3-blue',
                                'Pix' => 'w3-teal',
                                'Transferência' => 'w3-orange'
                            ];
                            $color = $badge_color[$forma] ?? 'w3-grey';
                            ?>
                            <span class="w3-tag <?= $color ?>"><?= $forma ?></span>
                        </td>
                        <td><?= htmlspecialchars($venda['id_usuario']) ?></td>
                        <td class="w3-center">
                            <a href="/backend/vendas/editar/<?= $venda['id_venda'] ?>" 
                               class="w3-button w3-small w3-blue" 
                               title="Editar">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <a href="/backend/vendas/excluir/<?= $venda['id_venda'] ?>" 
                               class="w3-button w3-small w3-red" 
                               title="Excluir">
                                <i class="fa fa-trash"></i> Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <?php if (isset($paginacao) && $paginacao['ultima_pagina'] > 1): ?>
        <div class="w3-container w3-margin-top w3-center">
            <div class="w3-bar">
                <?php if ($paginacao['pagina_atual'] > 1): ?>
                    <a href="/backend/vendas/listar/1" class="w3-button w3-border">«« Primeira</a>
                    <a href="/backend/vendas/listar/<?= $paginacao['pagina_atual'] - 1 ?>" class="w3-button w3-border">‹ Anterior</a>
                <?php endif; ?>

                <?php
                $inicio = max(1, $paginacao['pagina_atual'] - 2);
                $fim = min($paginacao['ultima_pagina'], $paginacao['pagina_atual'] + 2);
                
                for ($i = $inicio; $i <= $fim; $i++): ?>
                    <?php if ($i == $paginacao['pagina_atual']): ?>
                        <span class="w3-button w3-blue"><?= $i ?></span>
                    <?php else: ?>
                        <a href="/backend/vendas/listar/<?= $i ?>" class="w3-button w3-border"><?= $i ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                    <a href="/backend/vendas/listar/<?= $paginacao['pagina_atual'] + 1 ?>" class="w3-button w3-border">Próxima ›</a>
                    <a href="/backend/vendas/listar/<?= $paginacao['ultima_pagina'] ?>" class="w3-button w3-border">Última »»</a>
                <?php endif; ?>
            </div>
            <p class="w3-margin-top">
                Mostrando <?= $paginacao['de'] ?> a <?= $paginacao['para'] ?> de <?= $paginacao['total'] ?> registros
            </p>
        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="w3-panel w3-yellow">
        <h3>⚠️ Nenhuma venda encontrada</h3>
        <p>Ainda não há vendas cadastradas no sistema.</p>
        <a href="/backend/vendas/criar" class="w3-button w3-green">
            <i class="fa fa-plus"></i> Cadastrar Primeira Venda
        </a>
    </div>
<?php endif; ?>