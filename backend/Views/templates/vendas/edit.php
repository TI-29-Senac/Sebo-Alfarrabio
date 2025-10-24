
<div class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin w3-center" style="max-width:800px;">
    <h1>Editar registro da venda</h1>
     <form action="/backend/vendas/atualizar" method="POST" class="w3-panel w3-center">
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-calendar"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="data_venda" type="text" id="data_venda" value="<?php echo $vendas['data_venda']; ?>" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-money"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="valor_total" type="text" id="valor_total" value="<?php echo $vendas['valor_total']; ?>" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-dollar"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="forma_pagamento" type="text" id="forma_pagamento" value="<?php echo $vendas['forma_pagamento']; ?>" required>
            </div>
        </div>
        <button type="submit" class="w3-button w3-blue">Salvar</button>
    </form>
</div>