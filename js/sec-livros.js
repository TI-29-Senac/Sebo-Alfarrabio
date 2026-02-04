/* ========================================
   CARROSSEL DE LIVROS MODERNO - JAVASCRIPT
   O Alfarrábio - Seção Livros (Máximo 8 produtos)
   ======================================== */

// ========================================
// CONFIGURAÇÃO DA API
// ========================================
const API_CONFIG = {
  baseUrl: '/backend/index.php/api',
  itemsLimit: 8 // Limite máximo de produtos
};

// Elementos DOM
const carouselTrack = document.getElementById('carouselTrack');
const prevBtn = document.querySelector('.nav-btn.prev');
const nextBtn = document.querySelector('.nav-btn.next');

// ========================================
// CARREGAR PRODUTOS DO BANCO
// ========================================
async function carregarProdutos() {
  try {
    console.log('📦 Carregando produtos...');

    const response = await fetch(`${API_CONFIG.baseUrl}/item?por_pagina=${API_CONFIG.itemsLimit}`);

    if (!response.ok) {
      throw new Error(`Erro HTTP: ${response.status}`);
    }

    const json = await response.json();

    if (json.status === 'success' && json.data && json.data.length > 0) {
      // Garante que mostra apenas 8 produtos
      const produtos = json.data.slice(0, 8);
      console.log('✅ Produtos carregados:', produtos.length);
      renderizarCards(produtos);
      inicializarNavegacao();
    } else {
      mostrarMensagemVazia();
    }

  } catch (error) {
    console.error('❌ Erro ao carregar produtos:', error);
    mostrarErro();
  }
}

// ========================================
// RENDERIZAR CARDS
// ========================================
function renderizarCards(produtos) {
  carouselTrack.innerHTML = '';

  produtos.forEach((produto, index) => {
    const card = criarCard(produto, index);
    carouselTrack.appendChild(card);
  });
}

function criarCard(produto, index) {
  const preco = parseFloat(produto.preco || 0);
  const precoFormatado = preco.toFixed(2).replace('.', ',');

  const card = document.createElement('div');
  card.className = 'book-card-modern';
  card.style.animation = `fadeInUp 0.6s ease ${index * 0.1}s both`;

  // Badge opcional (se houver campo de destaque)
  const badge = produto.destaque ? '<div class="book-badge">Destaque</div>' : '';

  card.innerHTML = `
    ${badge}
    <div class="book-image-wrapper">
      <img src="${produto.caminho_imagem || '/img/sem-imagem.png'}" 
           alt="${produto.titulo}"
           onerror="this.src='/img/sem-imagem.png'">
    </div>
    <div class="book-info">
      <h3 class="book-title">${produto.titulo}</h3>
      ${produto.autores ? `<span class="book-author">${produto.autores}</span>` : ''}
      <div class="book-price-wrapper">
        <span class="book-price">R$ ${precoFormatado}</span>
        <button class="book-btn" onclick="verDetalhes(${produto.id_item})">Ver mais</button>
      </div>
    </div>
  `;

  return card;
}

// ========================================
// NAVEGAÇÃO DO CARROSSEL
// ========================================
function inicializarNavegacao() {
  const scrollAmount = 310; // 280px (card) + 30px (gap)

  if (prevBtn) {
    prevBtn.addEventListener('click', () => {
      carouselTrack.scrollBy({
        left: -scrollAmount,
        behavior: 'smooth'
      });
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', () => {
      carouselTrack.scrollBy({
        left: scrollAmount,
        behavior: 'smooth'
      });
    });
  }

  // Navegação por teclado
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft' && prevBtn) {
      prevBtn.click();
    } else if (e.key === 'ArrowRight' && nextBtn) {
      nextBtn.click();
    }
  });
}

// ========================================
// MENSAGENS DE ESTADO
// ========================================
function mostrarMensagemVazia() {
  carouselTrack.innerHTML = `
    <div class="empty-message">
      <div class="empty-message-icon">📚</div>
      <h3>Nenhum livro disponível</h3>
      <p>Em breve teremos novidades incríveis!</p>
    </div>
  `;
}

function mostrarErro() {
  carouselTrack.innerHTML = `
    <div class="empty-message">
      <div class="empty-message-icon">⚠️</div>
      <h3>Erro ao carregar livros</h3>
      <p>Por favor, tente novamente mais tarde</p>
    </div>
  `;
}

// ========================================
// FUNÇÃO PARA VER DETALHES
// ========================================
function verDetalhes(idItem) {
  window.location.href = `produtos.html?id=${idItem}`;
}

// ========================================
// INICIALIZAÇÃO
// ========================================
document.addEventListener('DOMContentLoaded', () => {
  console.log('🚀 Inicializando seção de livros...');
  carregarProdutos();
});

console.log('✅ Script carregado - Máximo 8 produtos com scroll!');