<h2>Cadastrar Nova Venda</h2>
<form action="/backend/vendas/salvar" method="post" enctype="multipart/form-data" class="w3-container w3-card-4 w3-light-grey w3-margin">
    <div class="w3-row w3-section">
        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-calendar"></i></div>
        <div class="w3-rest">
            <label for="data_venda">Data da Venda</label>
            <input type="date" name="data_venda" id="data_venda" value="<?php echo date('Y-m-d'); ?>" required class="w3-input w3-border">
        </div>
    </div>
    
    <div class="w3-row w3-section">
        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-money"></i></div>
        <div class="w3-rest">
            <label for="valor_total">Valor Total (R$)</label>
            <input type="number" name="valor_total" id="valor_total" step="0.01" min="0" required placeholder="0.00" class="w3-input w3-border">
        </div>
    </div>
    
    <div class="w3-row w3-section">
        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-credit-card"></i></div>
        <div class="w3-rest">
            <label>Forma de Pagamento</label><br>
            <input type="radio" id="dinheiro" name="forma_pagamento" value="Dinheiro" required> <label for="dinheiro">Dinheiro</label><br>
            <input type="radio" id="cartao" name="forma_pagamento" value="Cartão" required> <label for="cartao">Cartão</label><br>
            <input type="radio" id="transferencia" name="forma_pagamento" value="Transferência" required> <label for="transferencia">Transferência</label><br>
            <input type="radio" id="pix" name="forma_pagamento" value="Pix" required> <label for="pix">Pix</label>
        </div>
    </div>
    
    <div class="w3-rest">
            <input type="hidden" name="id_venda" value="<?php echo $vendas['id_venda']; ?>">
        </div>

    <button type="submit" class="w3-button w3-blue w3-large w3-section"><i class="fa fa-save"></i> Salvar Venda</button>
    <a href="/backend/vendas/listar" class="w3-button w3-grey w3-large w3-section"><i class="fa fa-arrow-left"></i> Voltar</a>
</form>
