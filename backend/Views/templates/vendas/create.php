<h2>Cadastrar/Criar um registro de venda:</h2>
<form action="/backend/vendas/salvar" method="post" enctype="multipart/form-data">
<label for="Data">Data</label>
<input type="date" name="data_venda" id="data_venda" required>
<br>
<label for="Valor">Valor</label>
<input type="text" name="valor_total" id="valor_total" required>
<br>
<h4>Forma de pagamento</h4>
<br>
<label for="Dinheiro">Dinheiro</label>
<input type="radio" name="forma_pagamento" id="forma_pagamento" value required>
<br>
<label for="Cartão">Cartão</label>
<input type="radio" name="forma_pagamento" id="forma_pagamento" value required>
<br>
<label for="Transferência">Transferência</label>
<input type="radio" name="forma_pagamento" id="forma_pagamento" value required>
<br>
<label for="Pix">Pix</label>
<input type="radio" name="forma_pagamento" id="forma_pagamento" value required>
<br>
<button type="submit">Salvar</button>
<div class="mb-3">
        <label class="w3-text-blue">Produtos</label>
        <div id="produtos-container"></div>
    <button type="button" onclick="addProduto()" class="w3-button w3-teal">Adicionar Produto</button>
</div>
</form>

<script>
let produtoCount = 0;
function addProduto() {
        produtoCount++;
        const produtoDiv = document.createElement('div');
        produtoDiv.setAttribute('id', `produto-${produtoCount}`);
        produtoDiv.classList.add('mb-3');
        produtoDiv.innerHTML = `
            <p>produto ${produtoCount} <button type="button" onclick="removeproduto(${produtoCount})" class="w3-button w3-red">Remover produto</button></p>
            <div id="carrinho-container-${produtoCount}">
                <div class="mb-3">
                    <label class="w3-text-blue">Produto</label>
                    <input type="text" name="carrinho[${produtoCount}][]" placeholder="Nome do produto ${produtoCount}" class="w3-input w3-border" required>
                </div>
                <div class="mb-3">
                    <label class="w3-text-blue">Quantidade</label>
                    <input type="text" name="quantidade" placeholder="Quantidade do produto ${produtoCount}" class="w3-input w3-border" required>
                </div>
            </div>
        `;
        document.getElementById('produtos-container').appendChild(produtoDiv);
    }
    function removeproduto(semestreId) {
        const semestreDiv = document.getElementById(`produto-${semestreId}`);
        semestreDiv.remove();
    }
</script>