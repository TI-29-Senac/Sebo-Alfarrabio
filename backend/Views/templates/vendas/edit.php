<div class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin w3-center" style="max-width:800px;">
    <h1>Editar registro da venda</h1>
    
    <!-- 🔥 IMPORTANTE: Adicionado campo hidden com ID -->
    <form action="/backend/vendas/atualizar" method="POST" class="w3-panel w3-center">
        
        <!-- ✅ CAMPO HIDDEN COM O ID DA VENDA -->
        <input type="hidden" name="id_venda" value="<?php echo $vendas['id_venda']; ?>">
        
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px">
                <i class="w3-xxlarge fa fa-calendar"></i>
            </div>
            <div class="w3-rest">
                <label for="data_venda">Data da Venda</label>
                <input class="w3-input w3-border" 
                       name="data_venda" 
                       type="text" 
                       id="data_venda" 
                       value="<?php echo htmlspecialchars($vendas['data_venda']); ?>" 
                       required>
            </div>
        </div>
        
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px">
                <i class="w3-xxlarge fa fa-money"></i>
            </div>
            <div class="w3-rest">
                <label for="valor_total">Valor Total</label>
                <input class="w3-input w3-border" 
                       name="valor_total" 
                       type="number" 
                       step="0.01" 
                       id="valor_total" 
                       value="<?php echo htmlspecialchars($vendas['valor_total']); ?>" 
                       required>
            </div>
        </div>
        
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px">
                <i class="w3-xxlarge fa fa-credit-card"></i>
            </div>
            <div class="w3-rest">
                <label>Forma de Pagamento</label>
                <select class="w3-select w3-border" name="forma_pagamento" required>
                    <option value="" disabled>Selecione...</option>
                    <option value="Dinheiro" <?php echo ($vendas['forma_pagamento'] == 'Dinheiro') ? 'selected' : ''; ?>>Dinheiro</option>
                    <option value="Cartão" <?php echo ($vendas['forma_pagamento'] == 'Cartão') ? 'selected' : ''; ?>>Cartão</option>
                    <option value="Transferência" <?php echo ($vendas['forma_pagamento'] == 'Transferência') ? 'selected' : ''; ?>>Transferência</option>
                    <option value="Pix" <?php echo ($vendas['forma_pagamento'] == 'Pix') ? 'selected' : ''; ?>>Pix</option>
                </select>
            </div>
        </div>
        
        <div class="w3-row w3-section">
            <button type="submit" class="w3-button w3-blue w3-large">
                <i class="fa fa-save"></i> Salvar Alterações
            </button>
            <a href="/backend/vendas/listar" class="w3-button w3-grey w3-large">
                <i class="fa fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<?php
// Debug (remover em produção)
if (isset($_GET['debug'])) {
    echo '<pre style="text-align:left; background:#f4f4f4; padding:20px; margin:20px;">';
    echo "Dados da Venda:\n";
    print_r($vendas);
    echo '</pre>';
}
?>