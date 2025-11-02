<div class="w3-container w3-card-4 w3-light-grey w3-text-red w3-margin w3-center" style="max-width:600px;">
    <h1><i class="fa fa-exclamation-triangle"></i> Confirmar Exclusão</h1>
    <p class="w3-large">Tem certeza que deseja <strong>desativar</strong> a venda #<?php echo $vendas['id_venda']; ?>?<br>
       Data: <?php echo date('d/m/Y', strtotime($vendas['data_venda'])); ?> | Valor: R$ <?php echo number_format($vendas['valor_total'], 2, ',', '.'); ?> | Forma: <?php echo $vendas['forma_pagamento']; ?></p>
    
    <form action="/backend/vendas/deletar" method="POST" onsubmit="return confirm('Desativar permanentemente? (Soft delete - pode reativar depois.)');">
        <input type="hidden" name="id_venda" value="<?php echo $vendas['id_venda']; ?>">
        <div class="w3-row w3-section">
            <button type="submit" class="w3-button w3-red w3-large"><i class="fa fa-trash"></i> Sim, Desativar</button>
            <a href="/backend/vendas/listar" class="w3-button w3-grey w3-large"><i class="fa fa-times"></i> Cancelar</a>
        </div>
    </form>
    
    <?php if (isset($_GET['debug'])): ?>
        <pre style="text-align:left; background:#f4f4f4; padding:10px; margin:10px;">
            Dados: <?php print_r($vendas); ?>
        </pre>
    <?php endif; ?>
</div>