console.log('🚀 produtos.js carregado!');

const produtosContainer = document.getElementById('produtos-grid');
const cartCountEl = document.getElementById('cart-count');
const cartItemsEl = document.getElementById('cart-items');
const cartTotalEl = document.getElementById('cart-total');
const btnFinalizar = document.getElementById('btn-finalizar');
const pedidoStatusEl = document.getElementById('pedido-status');

let carrinho = [];
const localStorageKey = 'carrinhoSebo';
let paginaAtual = 1;
let por_pagina = 8

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
    
    // Configura o grid para 3 colunas (mais bonito e responsivo)
    produtosContainer.style.cssText = `
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        max-width: 1200px;
    `;
    
    produtosContainer.innerHTML = '';
    
    if (produtos.length === 0) {
        produtosContainer.innerHTML = '<p style="grid-column: 1 / -1; text-align: center;">Nenhum produto disponível.</p>';
        return;
    }
    
    produtos.forEach(item => {
        const preco = parseFloat(item.preco || 0).toFixed(2);
        
        const cardHtml = `
            <div class="card-livro" style="
                background: linear-gradient(145deg, #fff2df, #f9e8d2);
                border-radius: 12px;
                padding: 10px 30px;
                text-align: center;
                box-shadow: 0 4px 12px rgba(139, 111, 71, 0.15);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border: 1px solid #d4b896;
            " onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 6px 20px rgba(139, 111, 71, 0.25)'" 
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(139, 111, 71, 0.15)'">
                <img src="${item.caminho_imagem}" alt="${item.titulo_item}" style="
                    width: 100%;
                    height: auto;
                    max-height: 350px;
                    object-fit: contain;
                    border-radius: 8px;
                    margin-bottom: 10px;
                ">
                <h3 style="color: #8b6f47; margin: 10px 0; font-size: 16px;">${item.titulo_item}</h3>
                <p style="font-size: 18px; font-weight: bold; color: #8b6f47; margin: 5px 0;">R$ ${preco}</p>
              
            </div>
        `;
        produtosContainer.insertAdjacentHTML('beforeend', cardHtml);
    });
}





// Inicializa
const salvo = localStorage.getItem(localStorageKey);
if (salvo) carrinho = JSON.parse(salvo);

carregarProdutos();