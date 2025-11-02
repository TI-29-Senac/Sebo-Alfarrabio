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
    
    <!-- Produtos Dinâmicos (seu JS já é bom, mas adicione preço por item pra calcular total auto) -->
    <div class="w3-section">
        <label class="w3-text-blue">Produtos (Opcional)</label>
        <div id="produtos-container"></div>
        <button type="button" onclick="addProduto()" class="w3-button w3-teal">Adicionar Produto</button>
    </div>
    
    <button type="submit" class="w3-button w3-blue w3-large w3-section"><i class="fa fa-save"></i> Salvar Venda</button>
    <a href="/backend/vendas/listar" class="w3-button w3-grey w3-large w3-section"><i class="fa fa-arrow-left"></i> Voltar</a>
</form>

<script>
let produtoCount = 0;
function addProduto() {
    produtoCount++;
    const container = document.getElementById('produtos-container');
    const produtoDiv = document.createElement('div');
    produtoDiv.id = `produto-${produtoCount}`;
    produtoDiv.className = 'w3-row w3-section mb-3 w3-border';
    produtoDiv.innerHTML = `
        <div class="w3-col m4"><label>Produto ${produtoCount}</label><input type="text" name="carrinho[${produtoCount}][nome]" placeholder="Nome" class="w3-input w3-border" required></div>
        <div class="w3-col m3"><label>Quantidade</label><input type="number" name="carrinho[${produtoCount}][qtd]" placeholder="1" class="w3-input w3-border" required min="1"></div>
        <div class="w3-col m3"><label>Preço Unit. (R$)</label><input type="number" name="carrinho[${produtoCount}][preco]" step="0.01" placeholder="0.00" class="w3-input w3-border" required></div>
        <div class="w3-col m2 w3-center"><button type="button" onclick="removeProduto(${produtoCount})" class="w3-button w3-red w3-section">Remover</button></div>
    `;
    container.appendChild(produtoDiv);
}
function removeProduto(id) {
    document.getElementById(`produto-${id}`).remove();
}
</script>