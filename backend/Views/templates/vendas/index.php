
  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-brown w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>52</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Messages</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-sienna w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_vendas; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Ativos</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-note w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_vendas; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Inativos</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-taupe w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_vendas; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total de Vendas</h4>
      </div>
    </div>
  </div>

<div>
    <h3>Listar Vendas</h3>
</div>
<?php if (isset($vendas) && count($vendas) > 0): ?>
    <table border="1" cellpadding="5" cellspacing="0"  class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <thead>
            <tr>
                <th>Data</th>
                <th>Valor Total</th>
                <th>Forma de Pagamento</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vendas as $vendas): ?>
                <tr>
                    <td><?= htmlspecialchars($vendas['data_venda']) ?></td>
                    <td><?= htmlspecialchars($vendas['valor_total']) ?></td>
                    <td><?= htmlspecialchars($vendas['forma_pagamento']) ?></td>
                    <td><a href="/backend/vendas/editar/<?= htmlspecialchars($vendas['id_venda']) ?>">Editar</a></td>
                    <td><a href="/backend/vendas/excluir/<?= htmlspecialchars($vendas['id_venda']) ?>">Excluir</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            
        
<?php else: ?>
    <div>Nenhuma venda encontrada.</div>
<?php endif ?>
