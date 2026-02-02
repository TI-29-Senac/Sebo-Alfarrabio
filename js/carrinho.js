function renderizarCarrinho() {
    cartItemsEl.innerHTML = '';
    let total = 0;
    let totalItens = 0;
    carrinho.forEach(item => {
        const preco_itemItemTotal = (item.preco_item * item.quantidade).toFixed(2);
        const itemHtml = `
            <li>
                ${item.titulo_item} - R$ ${parseFloat(item.preco_item).toFixed(2)} x ${item.quantidade} = R$ ${preco_itemItemTotal}
                <button class="btn-remove-cart w3-button w3-tiny w3-red w3-padding-small" 
                        data-id="${item.id_item}" 
                        style="margin-left: 10px;">
                    Remover 1
                </button>
            </li>`;
        cartItemsEl.insertAdjacentHTML('beforeend', itemHtml);
        total += item.preco_item * item.quantidade;
        totalItens += item.quantidade;
    });

    cartCountEl.textContent = totalItens;
    cartTotalEl.textContent = total.toFixed(2);
    salvarCarrinhoLocalStorage();
}



function adicionarAoCarrinho(id_item, titulo_item, preco_item) {
    const itemExistente = carrinho.find(item => item.id_item === id_item);
    if (itemExistente) {
        itemExistente.quantidade++;
    } else {
        carrinho.push({ id_item, titulo_item, preco_item: parseFloat(preco_item), quantidade: 1 });
    }
    renderizarCarrinho();
}

function removerDoCarrinho(id) {
    const itemIndex = carrinho.findIndex(item => item.id_item === id);
    if (itemIndex > -1) {
        if (carrinho[itemIndex].quantidade > 1) {
            carrinho[itemIndex].quantidade--;
        } else {
            carrinho.splice(itemIndex, 1);
        }
        renderizarCarrinho();
    }
}

