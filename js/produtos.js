console.log('🚀 produtos.js carregado!');

const produtosContainer = document.getElementById('produtos-grid');
const cartCountEl = document.getElementById('cart-count');
const cartItemsEl = document.getElementById('cart-items');
const cartTotalEl = document.getElementById('cart-total');

// Modal de produto
const modalProduto = document.getElementById('modal-produto');
const modalClose = document.querySelectorAll('.modal-close');

// Elementos de filtro
const searchInput = document.getElementById('search-input');
const precoSlider = document.getElementById('preco-slider');
const precoMaxSpan = document.getElementById('preco-max');
const btnAplicarFiltros = document.getElementById('btn-aplicar-filtros');
const btnLimparFiltros = document.getElementById('btn-limpar-filtros');
const totalProdutosEl = document.getElementById('total-produtos');

let carrinho = [];
let todosOsProdutos = []; // Todos os produtos do banco
let produtosFiltrados = []; // Produtos após aplicar filtros
const localStorageKey = 'carrinhoSebo';
let paginaAtual = 1;
let por_pagina = 12;

// ========================================
// CARREGAR PRODUTOS DO BANCO
// ========================================

function carregarProdutos() {
    console.log('📦 Buscando produtos do banco...');
    
    mostrarLoading();
    
    fetch('/backend/api/item')
        .then(response => {
            console.log('Status:', response.status);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            return response.json();
        })
        .then(json => {
            console.log('✅ Dados recebidos:', json);
            
            if (json.status === 'success' && json.data) {
                todosOsProdutos = json.data;
                produtosFiltrados = [...todosOsProdutos]; // Copia inicial
                renderizarProdutos(produtosFiltrados);
                atualizarContador();
            } else {
                throw new Error(json.message || 'Erro desconhecido');
            }
        })
        .catch(err => {
            console.error('❌ Erro:', err);
            mostrarErro(err.message);
        });
}

// ========================================
// SISTEMA DE FILTROS
// ========================================

function aplicarFiltros() {
    console.log('🔍 Aplicando filtros...');
    
    const termoBusca = searchInput ? searchInput.value.trim().toLowerCase() : '';
    const precoMaximo = precoSlider ? parseFloat(precoSlider.value) : 999999;
    
    // Pega tipos selecionados (checkboxes)
    const tiposSelecionados = [];
    document.querySelectorAll('.filtro-grupo input[type="checkbox"]:checked').forEach(checkbox => {
        tiposSelecionados.push(checkbox.value.toLowerCase());
    });
    
    console.log('Filtros aplicados:', { termoBusca, precoMaximo, tiposSelecionados });
    
    // Filtra os produtos
    produtosFiltrados = todosOsProdutos.filter(produto => {
        // Filtro de busca (título ou autor)
        if (termoBusca) {
            const tituloMatch = produto.titulo_item?.toLowerCase().includes(termoBusca);
            const autorMatch = produto.autores?.toLowerCase().includes(termoBusca);
            
            if (!tituloMatch && !autorMatch) {
                return false;
            }
        }
        
        // Filtro de preço
        const preco = parseFloat(produto.preco_item || produto.preco || 0);
        if (preco > precoMaximo) {
            return false;
        }
        
        // Filtro de tipo
        if (tiposSelecionados.length > 0) {
            const tipoProduto = (produto.tipo_item || '').toLowerCase();
            if (!tiposSelecionados.includes(tipoProduto)) {
                return false;
            }
        }
        
        return true;
    });
    
    console.log(`✅ Filtrados: ${produtosFiltrados.length} de ${todosOsProdutos.length} produtos`);
    
    renderizarProdutos(produtosFiltrados);
    atualizarContador();
}

function limparFiltros() {
    console.log('🧹 Limpando filtros...');
    
    // Limpa campo de busca
    if (searchInput) searchInput.value = '';
    
    // Reseta slider de preço
    if (precoSlider) {
        precoSlider.value = precoSlider.max;
        if (precoMaxSpan) {
            precoMaxSpan.textContent = `R$ ${precoSlider.max}`;
        }
    }
    
    // Desmarca checkboxes
    document.querySelectorAll('.filtro-grupo input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Restaura todos os produtos
    produtosFiltrados = [...todosOsProdutos];
    renderizarProdutos(produtosFiltrados);
    atualizarContador();
}

function atualizarContador() {
    const total = produtosFiltrados.length;
    if (totalProdutosEl) {
        totalProdutosEl.textContent = `${total} produto${total !== 1 ? 's' : ''} encontrado${total !== 1 ? 's' : ''}`;
    }
}

// Busca em tempo real (com debounce)
let searchTimeout;
function configurarBuscaTempoReal() {
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                aplicarFiltros();
            }, 500); // Espera 500ms após parar de digitar
        });
    }
}

// Atualiza label do slider de preço
function configurarSliderPreco() {
    if (precoSlider && precoMaxSpan) {
        precoSlider.addEventListener('input', () => {
            precoMaxSpan.textContent = `R$ ${precoSlider.value}`;
        });
    }
}

// ========================================
// RENDERIZAR PRODUTOS
// ========================================

function renderizarProdutos(produtos) {
    console.log('🎨 Renderizando', produtos.length, 'produtos');
    
    if (!produtosContainer) {
        console.error('Container não encontrado!');
        return;
    }
    
    produtosContainer.innerHTML = '';
    
    if (produtos.length === 0) {
        mostrarMensagemVazia();
        return;
    }
    
    produtos.forEach((item, index) => {
        const preco = parseFloat(item.preco_item || item.preco || 0);
        const precoFormatado = preco.toFixed(2).replace('.', ',');
        const estoque = parseInt(item.estoque) || 0;
        
        const card = document.createElement('div');
        card.className = 'card-livro';
        card.style.cssText = `
            background: linear-gradient(145deg, #fff2df, #f9e8d2);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(139, 111, 71, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #d4b896;
            cursor: pointer;
            animation: fadeInUp 0.5s ease forwards;
            animation-delay: ${index * 0.05}s;
            opacity: 0;
        `;
        
        card.innerHTML = `
            <img src="${item.caminho_imagem || '/img/sem-imagem.png'}" 
                 alt="${item.titulo_item}" 
                 style="
                    width: 100%;
                    height: 280px;
                    object-fit: cover;
                    border-radius: 8px;
                    margin-bottom: 15px;
                 "
                 onerror="this.src='/img/sem-imagem.png'">
            
            ${estoque > 0 ? '' : '<div style="position: absolute; top: 15px; right: 15px; background: #e63946; color: white; padding: 5px 10px; border-radius: 15px; font-size: 11px; font-weight: bold;">ESGOTADO</div>'}
            
            <div style="min-height: 100px;">
                <h3 style="color: #8b6f47; margin: 10px 0; font-size: 16px; line-height: 1.4; min-height: 44px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    ${item.titulo_item}
                </h3>
                
                <p style="font-size: 13px; color: #999; margin: 5px 0; font-style: italic;">
                    ${item.autores || 'Autor desconhecido'}
                </p>
                
                <p style="font-size: 12px; color: #8b6f47; margin: 8px 0; font-weight: 600; text-transform: uppercase;">
                    ${item.tipo_item || 'Produto'}
                </p>
            </div>
            
            <div style="margin-top: auto;">
                <p style="font-size: 22px; font-weight: bold; color: #8b6f47; margin: 15px 0;">
                    R$ ${precoFormatado}
                </p>
                
                <div style="display: flex; align-items: center; justify-content: center; gap: 5px; margin-bottom: 12px; font-size: 12px; ${estoque > 0 ? 'color: #6ba54a;' : 'color: #e63946;'}">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: ${estoque > 0 ? '#6ba54a' : '#e63946'};"></span>
                    ${estoque > 0 ? `${estoque} em estoque` : 'Indisponível'}
                </div>
                
                <button class="btn-add-cart" 
                        ${estoque === 0 ? 'disabled' : ''}
                        style="
                            width: 100%;
                            padding: 12px;
                            background: ${estoque > 0 ? 'linear-gradient(135deg, #c8b896, #a89968)' : '#ccc'};
                            color: white;
                            border: none;
                            border-radius: 8px;
                            font-weight: bold;
                            cursor: ${estoque > 0 ? 'pointer' : 'not-allowed'};
                            transition: all 0.3s;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        "
                        onmouseover="${estoque > 0 ? "this.style.background='linear-gradient(135deg, #a89968, #8b7355)'; this.style.transform='translateY(-2px)'" : ''}"
                        onmouseout="${estoque > 0 ? "this.style.background='linear-gradient(135deg, #c8b896, #a89968)'; this.style.transform='translateY(0)'" : ''}">
                    ${estoque > 0 ? '🛒 Adicionar ao Carrinho' : 'Indisponível'}
                </button>
            </div>
        `;
        
        // Efeitos hover no card
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-8px)';
            card.style.boxShadow = '0 8px 24px rgba(139, 111, 71, 0.25)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = '0 4px 12px rgba(139, 111, 71, 0.15)';
        });
        
        // Ao clicar no card (exceto no botão), abre o modal
        card.addEventListener('click', (e) => {
            if (!e.target.classList.contains('btn-add-cart')) {
                abrirModalProduto(item);
            }
        });
        
        // Botão adicionar ao carrinho
        const btnAdd = card.querySelector('.btn-add-cart');
        if (btnAdd && estoque > 0) {
            btnAdd.addEventListener('click', (e) => {
                e.stopPropagation();
                adicionarAoCarrinho(item);
            });
        }
        
        produtosContainer.appendChild(card);
    });
}

// ========================================
// ESTADOS DE UI
// ========================================

function mostrarLoading() {
    if (produtosContainer) {
        produtosContainer.innerHTML = `
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                <div style="
                    width: 60px;
                    height: 60px;
                    border: 5px solid #e8dcc4;
                    border-top: 5px solid #c8b896;
                    border-radius: 50%;
                    animation: spin 1s linear infinite;
                    margin: 0 auto 20px;
                "></div>
                <p style="color: #8b7355; font-size: 16px;">Carregando produtos...</p>
            </div>
        `;
    }
}

function mostrarErro(mensagem) {
    if (produtosContainer) {
        produtosContainer.innerHTML = `
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
                <div style="font-size: 48px; margin-bottom: 20px;">❌</div>
                <h3 style="color: #e63946; margin-bottom: 10px;">Erro ao carregar produtos</h3>
                <p style="color: #666; margin-bottom: 20px;">${mensagem}</p>
                <button onclick="carregarProdutos()" style="
                    padding: 12px 24px;
                    background: linear-gradient(135deg, #c8b896, #a89968);
                    color: white;
                    border: none;
                    border-radius: 8px;
                    cursor: pointer;
                    font-weight: bold;
                    font-size: 14px;
                ">Tentar Novamente</button>
            </div>
        `;
    }
}

function mostrarMensagemVazia() {
    if (produtosContainer) {
        produtosContainer.innerHTML = `
            <div style="grid-column: 1 / -1; text-align: center; padding: 80px 20px;">
                <div style="font-size: 64px; margin-bottom: 20px; opacity: 0.3;">📚</div>
                <h3 style="color: #8b7355; margin-bottom: 10px; font-size: 22px;">Nenhum produto encontrado</h3>
                <p style="color: #999; margin-bottom: 25px;">Tente ajustar os filtros ou fazer uma nova busca</p>
                <button onclick="limparFiltros()" style="
                    padding: 12px 24px;
                    background: white;
                    color: #8b6f47;
                    border: 2px solid #c8b896;
                    border-radius: 8px;
                    cursor: pointer;
                    font-weight: bold;
                    font-size: 14px;
                    transition: all 0.3s;
                "
                onmouseover="this.style.background='#c8b896'; this.style.color='white'"
                onmouseout="this.style.background='white'; this.style.color='#8b6f47'">
                    Limpar Filtros
                </button>
            </div>
        `;
    }
}

// ========================================
// MODAL DE DETALHES DO PRODUTO
// ========================================

function abrirModalProduto(produto) {
    console.log('📖 Abrindo modal do produto:', produto.titulo_item);
    
    if (!modalProduto) {
        console.error('Modal não encontrado!');
        return;
    }
    
    const preco = parseFloat(produto.preco_item || produto.preco || 0);
    const precoFormatado = preco.toFixed(2).replace('.', ',');
    
    // Preenche os dados do modal
    document.getElementById('modal-capa').src = produto.caminho_imagem || '/img/sem-imagem.png';
    document.getElementById('modal-capa').alt = produto.titulo_item;
    document.getElementById('modal-titulo').textContent = produto.titulo_item;
    document.getElementById('modal-autor').textContent = produto.autores || 'Autor desconhecido';
    document.getElementById('modal-tipo').textContent = produto.tipo_item || 'Produto';
    document.getElementById('modal-preco').textContent = `R$ ${precoFormatado}`;
    document.getElementById('modal-descricao').textContent = produto.descricao || 'Produto em excelente estado de conservação. Ideal para colecionadores e entusiastas.';
    document.getElementById('modal-editora').textContent = produto.editora_gravadora || '-';
    document.getElementById('modal-ano').textContent = produto.ano_publicacao || '-';
    document.getElementById('modal-isbn').textContent = produto.isbn || '-';
    document.getElementById('modal-estoque').textContent = produto.estoque || '0';
    
    // Configura o botão de adicionar ao carrinho
    const btnAddCarrinho = document.getElementById('btn-add-carrinho');
    if (btnAddCarrinho) {
        const newBtn = btnAddCarrinho.cloneNode(true);
        btnAddCarrinho.parentNode.replaceChild(newBtn, btnAddCarrinho);
        
        newBtn.addEventListener('click', () => {
            adicionarAoCarrinho(produto);
            fecharModal();
        });
    }
    
    // Configura o botão de comprar
    const btnComprar = document.getElementById('btn-comprar');
    if (btnComprar) {
        const newBtnComprar = btnComprar.cloneNode(true);
        btnComprar.parentNode.replaceChild(newBtnComprar, btnComprar);
        
        newBtnComprar.addEventListener('click', () => {
            adicionarAoCarrinho(produto);
            fecharModal();
            abrirModalCarrinho();
        });
    }
    
    // Mostra o modal
    modalProduto.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function fecharModal() {
    if (modalProduto) {
        modalProduto.classList.remove('show');
        document.body.style.overflow = '';
    }
}

// ========================================
// CARRINHO DE COMPRAS
// ========================================

function adicionarAoCarrinho(produto) {
    const itemExistente = carrinho.find(item => item.id_item === produto.id_item);
    
    if (itemExistente) {
        if (itemExistente.quantidade < (produto.estoque || 10)) {
            itemExistente.quantidade++;
        } else {
            mostrarNotificacao('⚠️ Quantidade máxima em estoque atingida!', 'warning');
            return;
        }
    } else {
        carrinho.push({
            id_item: produto.id_item,
            titulo_item: produto.titulo_item,
            preco_item: parseFloat(produto.preco_item || produto.preco || 0),
            caminho_imagem: produto.caminho_imagem,
            quantidade: 1,
            estoque: produto.estoque || 10
        });
    }
    
    salvarCarrinho();
    atualizarContadorCarrinho();
    mostrarNotificacao('✓ Produto adicionado ao carrinho!', 'success');
}

function salvarCarrinho() {
    localStorage.setItem(localStorageKey, JSON.stringify(carrinho));
}

function carregarCarrinho() {
    const salvo = localStorage.getItem(localStorageKey);
    if (salvo) {
        try {
            carrinho = JSON.parse(salvo);
            atualizarContadorCarrinho();
        } catch (e) {
            console.error('Erro ao carregar carrinho:', e);
            carrinho = [];
        }
    }
}

function atualizarContadorCarrinho() {
    const total = carrinho.reduce((sum, item) => sum + (item.quantidade || 1), 0);
    if (cartCountEl) {
        cartCountEl.textContent = total;
    }
}

function removerDoCarrinho(id_item) {
    carrinho = carrinho.filter(item => item.id_item !== id_item);
    salvarCarrinho();
    atualizarContadorCarrinho();
    renderizarCarrinho();
    mostrarNotificacao('🗑️ Item removido do carrinho', 'info');
}

function renderizarCarrinho() {
    if (!cartItemsEl) return;
    
    const carrinhoVazio = document.getElementById('carrinho-vazio');
    
    if (carrinho.length === 0) {
        cartItemsEl.style.display = 'none';
        if (carrinhoVazio) carrinhoVazio.style.display = 'block';
        if (cartTotalEl) cartTotalEl.textContent = 'R$ 0,00';
        return;
    }
    
    if (carrinhoVazio) carrinhoVazio.style.display = 'none';
    cartItemsEl.style.display = 'block';
    cartItemsEl.innerHTML = '';
    
    let total = 0;
    
    carrinho.forEach(item => {
        const preco = parseFloat(item.preco_item || 0);
        const subtotal = preco * (item.quantidade || 1);
        total += subtotal;
        
        const li = document.createElement('li');
        li.innerHTML = `
            <div>
                <strong>${item.titulo_item}</strong>
                <small>Quantidade: ${item.quantidade} x R$ ${preco.toFixed(2).replace('.', ',')} = R$ ${subtotal.toFixed(2).replace('.', ',')}</small>
            </div>
            <button class="btn-remove-cart" onclick="removerDoCarrinho(${item.id_item})">Remover</button>
        `;
        cartItemsEl.appendChild(li);
    });
    
    if (cartTotalEl) {
        cartTotalEl.textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
    }
}

function abrirModalCarrinho() {
    const modalCarrinho = document.getElementById('modal-carrinho');
    if (modalCarrinho) {
        renderizarCarrinho();
        modalCarrinho.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function fecharModalCarrinho() {
    const modalCarrinho = document.getElementById('modal-carrinho');
    if (modalCarrinho) {
        modalCarrinho.classList.remove('show');
        document.body.style.overflow = '';
    }
}

// ========================================
// NOTIFICAÇÕES
// ========================================

function mostrarNotificacao(mensagem, tipo = 'success') {
    const notif = document.createElement('div');
    notif.className = 'notification';
    notif.textContent = mensagem;
    
    const cores = {
        success: 'linear-gradient(135deg, #c8b896, #a89968)',
        warning: 'linear-gradient(135deg, #ff6b35, #f7931e)',
        info: 'linear-gradient(135deg, #6ba54a, #5a8f3d)'
    };
    
    notif.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${cores[tipo] || cores.success};
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 10000;
        animation: slideIn 0.3s ease;
        font-weight: 600;
        letter-spacing: 0.5px;
    `;
    
    document.body.appendChild(notif);
    
    setTimeout(() => {
        notif.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notif.remove(), 300);
    }, 2000);
}

// ========================================
// EVENT LISTENERS
// ========================================

// Botão aplicar filtros
if (btnAplicarFiltros) {
    btnAplicarFiltros.addEventListener('click', aplicarFiltros);
}

// Botão limpar filtros
if (btnLimparFiltros) {
    btnLimparFiltros.addEventListener('click', limparFiltros);
}

// Fechar modais ao clicar no X
modalClose.forEach(btn => {
    btn.addEventListener('click', (e) => {
        const modal = e.target.closest('.modal-overlay');
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
});

// Fechar modal ao clicar fora
if (modalProduto) {
    modalProduto.addEventListener('click', (e) => {
        if (e.target === modalProduto) {
            fecharModal();
        }
    });
}

const modalCarrinho = document.getElementById('modal-carrinho');
if (modalCarrinho) {
    modalCarrinho.addEventListener('click', (e) => {
        if (e.target === modalCarrinho) {
            fecharModalCarrinho();
        }
    });
}

// Botão de ver carrinho
const btnVerCarrinho = document.getElementById('btn-ver-carrinho');
if (btnVerCarrinho) {
    btnVerCarrinho.addEventListener('click', abrirModalCarrinho);
}

// Botão continuar comprando
const btnContinuarComprando = document.getElementById('btn-continuar-comprando');
if (btnContinuarComprando) {
    btnContinuarComprando.addEventListener('click', fecharModalCarrinho);
}

// Fechar modal com ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        fecharModal();
        fecharModalCarrinho();
    }
});

// ========================================
// ANIMAÇÕES
// ========================================

const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);

// ========================================
// INICIALIZAÇÃO
// ========================================

console.log('⚙️ Inicializando sistema...');

carregarCarrinho();
carregarProdutos();
configurarBuscaTempoReal();
configurarSliderPreco();

console.log('✅ Sistema pronto!');