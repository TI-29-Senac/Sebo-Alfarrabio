/* ========================================
   CARROSSEL DE LIVROS CONTÍNUO (ROLLING)
   O Alfarrábio - Seção Livros
   ======================================== */

const API_CONFIG = {
  baseUrl: '/backend/api',
  itemsLimit: 10 // Limite de 10 itens conforme solicitado
};

/**
 * Inicializa ao carregar a página
 */
document.addEventListener('DOMContentLoaded', () => {
  console.log('🚀 Inicializando carrossel contínuo...');
  carregarProdutos();
});

/**
 * Busca produtos do banco
 */
async function carregarProdutos() {
  try {
    const response = await fetch(`${API_CONFIG.baseUrl}/item?por_pagina=${API_CONFIG.itemsLimit}`);
    if (!response.ok) throw new Error(`Erro HTTP: ${response.status}`);

    const json = await response.json();

    if (json.status === 'success' && json.data && json.data.length > 0) {
      // Força limite de 10 itens no frontend
      const itensLimitados = json.data.slice(0, 10);
      renderizarCarrosselContinuo(itensLimitados);
    } else {
      document.getElementById('carouselTrack').innerHTML = `
        <div class="status-container empty-state" style="padding: 40px;">
          <div class="status-icon" style="font-size: 48px;">📚</div>
          <h3 class="status-title" style="font-size: 20px;">Estante sob manutenção</h3>
          <p class="status-message" style="font-size: 14px;">Estamos reorganizando nossas prateleiras. Volte em breve!</p>
        </div>
      `;
    }
  } catch (error) {
    console.error('❌ Erro ao carregar produtos:', error);
    const track = document.getElementById('carouselTrack');
    if (track) {
      track.innerHTML = `
        <div class="status-container error-state" style="padding: 40px;">
          <div class="error-icon" style="width: 50px; height: 50px; font-size: 24px;">✕</div>
          <h3 class="status-title" style="font-size: 20px;">Não foi possível carregar os livros</h3>
          <button onclick="location.reload()" class="status-btn" style="padding: 10px 20px; font-size: 13px;">Tentar Novamente</button>
        </div>
      `;
    }
  }
}

/**
 * Renderiza os cards e duplica-os para criar o efeito de "esteira" infinita
 */
function renderizarCarrosselContinuo(produtos) {
  const track = document.getElementById('carouselTrack');
  if (!track) return;

  track.innerHTML = '';

  // Criamos o conjunto original de cards
  const fragmentoOriginal = document.createDocumentFragment();
  produtos.forEach(p => fragmentoOriginal.appendChild(criarCard(p)));

  // Para o efeito de rolagem contínua sem saltos (CSS animation translate -50%), 
  // precisamos de EXATAMENTE duas cópias idênticas lado a lado.
  const copia1 = fragmentoOriginal.cloneNode(true);
  const copia2 = fragmentoOriginal.cloneNode(true);

  track.appendChild(copia1);
  track.appendChild(copia2);

  console.log(`✅ Carrossel renderizado com ${produtos.length * 2} cards (duplicado para loop).`);
}

/**
 * Cria o elemento HTML do card (mantendo a padronização de tamanho)
 */
function criarCard(produto) {
  const preco = parseFloat(produto.preco || 0);
  const precoFormatado = preco.toFixed(2).replace('.', ',');

  const card = document.createElement('div');
  card.className = 'book-card-modern';

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

function verDetalhes(idItem) {
  window.location.href = `produtos.html?id=${idItem}`;
}