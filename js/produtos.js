console.log('🚀 produtos.js carregado!');

const produtosContainer = document.getElementById('produtos-grid');
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
            <div class="card-livro">
                <img src="${item.caminho_imagem}" alt="${item.titulo_item}">
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





// Inicializa
const salvo = localStorage.getItem(localStorageKey);
if (salvo) carrinho = JSON.parse(salvo);

carregarProdutos();