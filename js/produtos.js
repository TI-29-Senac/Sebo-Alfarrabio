console.log('🚀 produtos.js carregado!');

const produtosContainer = document.getElementById('produtos-lista');
const cartCountEl = document.getElementById('cart-count');
const cartItemsEl = document.getElementById('cart-items');
const cartTotalEl = document.getElementById('cart-total');
const btnFinalizar = document.getElementById('btn-finalizar');
const pedidoStatusEl = document.getElementById('pedido-status');

let carrinho = [];
const localStorageKey = 'carrinhoSebo';

// Carrega produtos
function carregarProdutos() {
    console.log('📦 Buscando produtos...');
    
    fetch('/backend/api/item')
        .then(response => {
            console.log('Status:', response.status);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            return response.json();
        })
        .then(json => {
            console.log('✅ Dados recebidos:', json);
            
            if (json.status === 'success' && json.data) {
                renderizarProdutos(json.data);
            } else {
                throw new Error(json.message || 'Erro desconhecido');
            }
        })
        .catch(err => {
            console.error('❌ Erro:', err);
            produtosContainer.innerHTML = `<p style="color: red;">Erro: ${err.message}</p>`;
        });
}

// Renderiza produtos
function renderizarProdutos(produtos) {
    console.log('🎨 Renderizando', produtos.length, 'produtos');
    
    if (!produtosContainer) {
        console.error('Container não encontrado!');
        return;
    }
    
    produtosContainer.innerHTML = '';
    
    if (produtos.length === 0) {
        produtosContainer.innerHTML = '<p style="grid-column: 1 / -1; text-align: center;">Nenhum produto disponível.</p>';
        return;
    }
    
    produtos.forEach(item => {
        const preco = parseFloat(item.preco || 0).toFixed(2);
        
        const cardHtml = `
            <div class="produto-card">
                <img src="${item.caminho_imagem}" alt="${item.titulo_item}" onerror="this.src='/img/default-livro.jpg'">
                <h3>${item.titulo_item}</h3>
                <p>R$ ${preco}</p>
                <button class="btn-add-cart" 
                        data-id="${item.id_item}" 
                        data-nome="${item.titulo_item}" 
                        data-preco="${item.preco}">
                    Adicionar ao Carrinho
                </button>
            </div>
        `;
        produtosContainer.insertAdjacentHTML('beforeend', cardHtml);
    });
}

// Adiciona ao carrinho
function adicionarAoCarrinho(id, nome, preco) {
    const item = carrinho.find(i => i.id === id);
    
    if (item) {
        item.quantidade++;
    } else {
        carrinho.push({ id, titulo_item: nome, preco: parseFloat(preco), quantidade: 1 });
    }
    
    renderizarCarrinho();
}

// Remove do carrinho
function removerDoCarrinho(id) {
    const index = carrinho.findIndex(i => i.id === id);
    
    if (index > -1) {
        if (carrinho[index].quantidade > 1) {
            carrinho[index].quantidade--;
        } else {
            carrinho.splice(index, 1);
        }
        renderizarCarrinho();
    }
}

// Renderiza carrinho
function renderizarCarrinho() {
    cartItemsEl.innerHTML = '';
    let total = 0;
    let totalItens = 0;
    
    carrinho.forEach(item => {
        const subtotal = (item.preco * item.quantidade).toFixed(2);
        
        const itemHtml = `
            <li class="cart-item">
                <div>
                    <strong>${item.titulo_item}</strong><br>
                    R$ ${item.preco.toFixed(2)} x ${item.quantidade} = R$ ${subtotal}
                </div>
                <button class="btn-remove-cart" data-id="${item.id}">Remover</button>
            </li>
        `;
        
        cartItemsEl.insertAdjacentHTML('beforeend', itemHtml);
        total += item.preco * item.quantidade;
        totalItens += item.quantidade;
    });
    
    cartCountEl.textContent = totalItens;
    cartTotalEl.textContent = total.toFixed(2);
    localStorage.setItem(localStorageKey, JSON.stringify(carrinho));
}

// Finaliza pedido
function finalizarPedido() {
    if (carrinho.length === 0) {
        pedidoStatusEl.innerHTML = '<p style="color: orange;">Carrinho vazio!</p>';
        return;
    }
    
    pedidoStatusEl.textContent = 'Enviando...';
    
    fetch('/backend/api/pedidos', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(carrinho)
    })
    .then(r => r.json())
    .then(json => {
        if (json.status === 'success') {
            pedidoStatusEl.innerHTML = `<p style="color: green;">${json.message} (#${json.id_pedido})</p>`;
            carrinho = [];
            renderizarCarrinho();
        } else {
            throw new Error(json.message);
        }
    })
    .catch(err => {
        pedidoStatusEl.innerHTML = `<p style="color: red;">Erro: ${err.message}</p>`;
    });
}

// Event listeners
produtosContainer.addEventListener('click', (e) => {
    if (e.target.classList.contains('btn-add-cart')) {
        const { id, nome, preco } = e.target.dataset;
        adicionarAoCarrinho(id, nome, preco);
    }
});

cartItemsEl.addEventListener('click', (e) => {
    if (e.target.classList.contains('btn-remove-cart')) {
        removerDoCarrinho(e.target.dataset.id);
    }
});

btnFinalizar.addEventListener('click', finalizarPedido);

// Inicializa
const salvo = localStorage.getItem(localStorageKey);
if (salvo) carrinho = JSON.parse(salvo);
renderizarCarrinho();
carregarProdutos();