/* ========================================
   CARROSSEL DE LIVROS - JAVASCRIPT
   Carrega produtos do banco de dados via API
   ======================================== */

const carousel = document.querySelector(".carousel");
const btnLeft = document.querySelector(".carousel-btn.left");
const btnRight = document.querySelector(".carousel-btn.right");

// Configuração da API
const API_CONFIG = {
    baseUrl: '/backend/api',
    itemsLimit: 8 // Quantos produtos mostrar no carrossel
};

/* ========================================
   CARREGAR PRODUTOS DO BANCO
   ======================================== */

async function carregarProdutos() {
    try {
        console.log('📦 Carregando produtos do banco...');
        
        // Faz requisição à API
        const response = await fetch(`${API_CONFIG.baseUrl}/item?por_pagina=${API_CONFIG.itemsLimit}`);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }
        
        const json = await response.json();
        
        if (json.status === 'success' && json.data && json.data.length > 0) {
            console.log('✅ Produtos carregados:', json.data.length);
            renderizarCards(json.data);
        } else {
            console.warn('⚠️ Nenhum produto encontrado');
            mostrarMensagemVazia();
        }
        
    } catch (error) {
        console.error('❌ Erro ao carregar produtos:', error);
        mostrarErro(error.message);
    }
}

/* ========================================
   RENDERIZAR CARDS
   ======================================== */

function renderizarCards(produtos) {
    if (!carousel) return;
    
    // Limpa o carrossel
    carousel.innerHTML = '';
    
    // Cria um card para cada produto
    produtos.forEach((produto, index) => {
        const card = criarCard(produto, index);
        carousel.appendChild(card);
    });
    
    // Inicializa funcionalidades após renderizar
    inicializarCarrossel();
    inicializarAnimacoes();
}

function criarCard(produto, index) {
    const preco = parseFloat(produto.preco_item || produto.preco || 0);
    const precoFormatado = preco.toFixed(2).replace('.', ',');
    
    const card = document.createElement('div');
    card.className = 'book-card';
    card.style.animationDelay = `${index * 0.1}s`;
    
    card.innerHTML = `
        <img src="${produto.caminho_imagem || '/img/sem-imagem.png'}" 
             alt="${produto.titulo_item}"
             onerror="this.src='/img/sem-imagem.png'">
        <h3>${produto.titulo_item}</h3>
        ${produto.autores ? `<p class="autor">${produto.autores}</p>` : ''}
        <p class="preco">R$ ${precoFormatado}</p>
    `;
    
    // Ao clicar, redireciona para a página de produtos ou abre modal
    card.addEventListener('click', () => {
        window.location.href = `produtos.html?id=${produto.id_item}`;
    });
    
    return card;
}

/* ========================================
   MENSAGENS DE ESTADO
   ======================================== */

function mostrarMensagemVazia() {
    if (!carousel) return;
    
    carousel.innerHTML = `
        <div style="
            width: 100%;
            text-align: center;
            padding: 60px 20px;
            color: white;
        ">
            <div style="font-size: 48px; margin-bottom: 20px; opacity: 0.5;">📚</div>
            <h3 style="font-size: 24px; margin-bottom: 10px;">Nenhum produto disponível</h3>
            <p style="opacity: 0.8;">Em breve teremos novidades!</p>
        </div>
    `;
}

function mostrarErro(mensagem) {
    if (!carousel) return;
    
    carousel.innerHTML = `
        <div style="
            width: 100%;
            text-align: center;
            padding: 60px 20px;
            color: white;
        ">
            <div style="font-size: 48px; margin-bottom: 20px;">⚠️</div>
            <h3 style="font-size: 24px; margin-bottom: 10px; color: #ff6b6b;">Erro ao carregar produtos</h3>
            <p style="opacity: 0.8; margin-bottom: 20px;">${mensagem}</p>
            <button onclick="carregarProdutos()" style="
                background: linear-gradient(135deg, #b30000, #8b0000);
                color: white;
                border: none;
                padding: 12px 30px;
                border-radius: 25px;
                cursor: pointer;
                font-weight: bold;
                font-size: 16px;
            ">Tentar Novamente</button>
        </div>
    `;
}

/* ========================================
   INICIALIZAR CARROSSEL
   ======================================== */

function inicializarCarrossel() {
    if (!carousel || !btnLeft || !btnRight) return;
    
    // Largura do scroll (1 card + gap)
    const scrollAmount = 245; // 220px (card) + 25px (gap)
    
    // Botão esquerdo - volta 1 card
    btnLeft.addEventListener("click", () => {
        carousel.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    });
    
    // Botão direito - avança 1 card
    btnRight.addEventListener("click", () => {
        carousel.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    });
    
    // Navegação por teclado
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            btnLeft.click();
        } else if (e.key === 'ArrowRight') {
            btnRight.click();
        }
    });
    
    // Atualiza visibilidade dos botões baseado na posição
    function updateButtons() {
        const maxScroll = carousel.scrollWidth - carousel.clientWidth;
        
        // Desabilita botão esquerdo se no início
        if (carousel.scrollLeft <= 0) {
            btnLeft.style.opacity = '0.5';
            btnLeft.style.cursor = 'not-allowed';
        } else {
            btnLeft.style.opacity = '1';
            btnLeft.style.cursor = 'pointer';
        }
        
        // Desabilita botão direito se no final
        if (carousel.scrollLeft >= maxScroll - 1) {
            btnRight.style.opacity = '0.5';
            btnRight.style.cursor = 'not-allowed';
        } else {
            btnRight.style.opacity = '1';
            btnRight.style.cursor = 'pointer';
        }
    }
    
    // Atualiza ao rolar
    carousel.addEventListener('scroll', updateButtons);
    
    // Atualiza ao carregar
    updateButtons();
    
    // Atualiza ao redimensionar
    window.addEventListener('resize', updateButtons);
    
    // Drag para scroll (opcional - desktop)
    let isDown = false;
    let startX;
    let scrollLeft;
    
    carousel.addEventListener('mousedown', (e) => {
        isDown = true;
        carousel.style.cursor = 'grabbing';
        startX = e.pageX - carousel.offsetLeft;
        scrollLeft = carousel.scrollLeft;
    });
    
    carousel.addEventListener('mouseleave', () => {
        isDown = false;
        carousel.style.cursor = 'grab';
    });
    
    carousel.addEventListener('mouseup', () => {
        isDown = false;
        carousel.style.cursor = 'grab';
    });
    
    carousel.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - carousel.offsetLeft;
        const walk = (x - startX) * 2;
        carousel.scrollLeft = scrollLeft - walk;
    });
}

/* ========================================
   ANIMAÇÃO DE ENTRADA DOS CARDS
   ======================================== */

function inicializarAnimacoes() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observa todos os cards
    document.querySelectorAll('.book-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(40px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        cardObserver.observe(card);
    });
}

/* ========================================
   FILTRAR POR TIPO (OPCIONAL)
   ======================================== */

// Função para carregar apenas livros, por exemplo
async function carregarPorTipo(tipo = 'livro') {
    try {
        const response = await fetch(`${API_CONFIG.baseUrl}/item?tipo=${tipo}&por_pagina=${API_CONFIG.itemsLimit}`);
        const json = await response.json();
        
        if (json.status === 'success' && json.data) {
            renderizarCards(json.data);
        }
    } catch (error) {
        console.error('Erro ao filtrar por tipo:', error);
    }
}

// Função para buscar produtos em destaque (se houver campo no banco)
async function carregarProdutosDestaque() {
    try {
        // Ajuste a query conforme sua API
        const response = await fetch(`${API_CONFIG.baseUrl}/item?destaque=true&por_pagina=${API_CONFIG.itemsLimit}`);
        const json = await response.json();
        
        if (json.status === 'success' && json.data) {
            renderizarCards(json.data);
        }
    } catch (error) {
        console.error('Erro ao carregar destaques:', error);
        // Fallback: carrega produtos normais
        carregarProdutos();
    }
}

/* ========================================
   INICIALIZAÇÃO
   ======================================== */

// Carrega os produtos quando a página carregar
document.addEventListener('DOMContentLoaded', () => {
    console.log('🚀 Inicializando carrossel de livros...');
    
    // Você pode escolher qual função usar:
    carregarProdutos(); // Carrega produtos normais
    // carregarPorTipo('livro'); // Carrega apenas livros
    // carregarProdutosDestaque(); // Carrega produtos em destaque
});

console.log('✅ Script do carrossel carregado!');