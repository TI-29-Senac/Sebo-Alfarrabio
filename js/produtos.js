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
const generoSelect = document.getElementById('genero-select');
const categoriaSelect = document.getElementById('categoria-select');
const btnAplicarFiltros = document.getElementById('btn-aplicar-filtros');
const btnLimparFiltros = document.getElementById('btn-limpar-filtros');
const totalProdutosEl = document.getElementById('total-produtos');

let carrinho = [];
let todosOsProdutos = [];
let produtosFiltrados = [];
let generosDisponiveis = [];
let categoriasDisponiveis = [];
const localStorageKey = 'carrinhoSebo';

// ========================================
// CONFIGURAÇÕES DE PAGINAÇÃO
// ========================================
let paginaAtual = 1;
const itensPorPagina = 12; // Quantos produtos mostrar por página

// ========================================
// CARREGAR DADOS DO BANCO
// ========================================

async function carregarProdutos() {
    console.log('📦 Buscando produtos do banco...');
    mostrarLoading();
    
    try {
        const response = await fetch('/backend/api/item');
        console.log('Status:', response.status);
        
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        
        const json = await response.json();
        console.log('✅ Dados recebidos:', json);
        
        if (json.status === 'success' && json.data) {
            todosOsProdutos = json.data;
            produtosFiltrados = [...todosOsProdutos];
            
            extrairGenerosECategorias();
            popularSelects();
            
            paginaAtual = 1; // Resetar para página 1
            renderizarProdutos(produtosFiltrados);
            atualizarContador();
        } else {
            throw new Error(json.message || 'Erro desconhecido');
        }
    } catch (err) {
        console.error('❌ Erro:', err);
        mostrarErro(err.message);
    }
}

function extrairGenerosECategorias() {
    const generosSet = new Set();
    const categoriasSet = new Set();
    
    todosOsProdutos.forEach(produto => {
        if (produto.nome_genero) {
            generosSet.add(produto.nome_genero);
        }
        if (produto.nome_categoria) {
            categoriasSet.add(produto.nome_categoria);
        }
    });
    
    generosDisponiveis = Array.from(generosSet).sort();
    categoriasDisponiveis = Array.from(categoriasSet).sort();
    
    console.log('Gêneros:', generosDisponiveis);
    console.log('Categorias:', categoriasDisponiveis);
}

function popularSelects() {
    if (generoSelect) {
        generoSelect.innerHTML = '<option value="">Todos os Gêneros</option>';
        generosDisponiveis.forEach(genero => {
            const option = document.createElement('option');
            option.value = genero;
            option.textContent = genero;
            generoSelect.appendChild(option);
        });
    }
    
    if (categoriaSelect) {
        categoriaSelect.innerHTML = '<option value="">Todas as Categorias</option>';
        categoriasDisponiveis.forEach(categoria => {
            const option = document.createElement('option');
            option.value = categoria;
            option.textContent = categoria;
            categoriaSelect.appendChild(option);
        });
    }
}

// ========================================
// SISTEMA DE FILTROS
// ========================================

function aplicarFiltros() {
    console.log('🔍 Aplicando filtros...');
    
    const termoBusca = searchInput ? searchInput.value.trim().toLowerCase() : '';
    const generoSelecionado = generoSelect ? generoSelect.value : '';
    const categoriaSelecionada = categoriaSelect ? categoriaSelect.value : '';
    
    console.log('Filtros:', { termoBusca, generoSelecionado, categoriaSelecionada });
    
    produtosFiltrados = todosOsProdutos.filter(produto => {
        if (termoBusca) {
            const tituloMatch = produto.titulo_item?.toLowerCase().includes(termoBusca);
            const autorMatch = produto.autores?.toLowerCase().includes(termoBusca);
            
            if (!tituloMatch && !autorMatch) {
                return false;
            }
        }
        
        if (generoSelecionado && produto.nome_genero !== generoSelecionado) {
            return false;
        }
        
        if (categoriaSelecionada && produto.nome_categoria !== categoriaSelecionada) {
            return false;
        }
        
        return true;
    });
    
    console.log(`✅ Filtrados: ${produtosFiltrados.length} de ${todosOsProdutos.length}`);
    
    paginaAtual = 1; // Resetar para página 1 quando filtrar
    renderizarProdutos(produtosFiltrados);
    atualizarContador();
}

function limparFiltros() {
    console.log('🧹 Limpando filtros...');
    
    if (searchInput) searchInput.value = '';
    if (generoSelect) generoSelect.value = '';
    if (categoriaSelect) categoriaSelect.value = '';
    
    produtosFiltrados = [...todosOsProdutos];
    paginaAtual = 1;
    renderizarProdutos(produtosFiltrados);
    atualizarContador();
}

function atualizarContador() {
    const total = produtosFiltrados.length;
    if (totalProdutosEl) {
        totalProdutosEl.innerHTML = `<i class="fas fa-box-open"></i> ${total} produto${total !== 1 ? 's' : ''} encontrado${total !== 1 ? 's' : ''}`;
    }
}

let searchTimeout;
function configurarBuscaTempoReal() {
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(aplicarFiltros, 500);
        });
    }
}

// ========================================
// SISTEMA DE PAGINAÇÃO
// ========================================

function calcularPaginacao(produtos) {
    const totalProdutos = produtos.length;
    const totalPaginas = Math.ceil(totalProdutos / itensPorPagina);
    const inicio = (paginaAtual - 1) * itensPorPagina;
    const fim = inicio + itensPorPagina;
    const produtosPagina = produtos.slice(inicio, fim);
    
    return {
        produtosPagina,
        totalPaginas,
        inicio,
        fim: Math.min(fim, totalProdutos),
        totalProdutos
    };
}

function renderizarPaginacao(info) {
    // Remove paginação antiga se existir
    const paginacaoAntiga = document.querySelector('.paginacao-container');
    if (paginacaoAntiga) {
        paginacaoAntiga.remove();
    }
    
    if (info.totalPaginas <= 1) return; // Não mostrar paginação se só tem 1 página
    
    const paginacaoContainer = document.createElement('div');
    paginacaoContainer.className = 'paginacao-container';
    
    // Informações da paginação
    const paginacaoInfo = document.createElement('div');
    paginacaoInfo.className = 'paginacao-info';
    paginacaoInfo.innerHTML = `
        Mostrando <strong>${info.inicio + 1}</strong> - <strong>${info.fim}</strong> de <strong>${info.totalProdutos}</strong> produtos
    `;
    
    // Botões de navegação
    const paginacaoNav = document.createElement('div');
    paginacaoNav.className = 'paginacao';
    
    // Botão "Primeira"
    const btnPrimeira = criarBotaoPaginacao('primeira', '«', 1, paginaAtual === 1);
    paginacaoNav.appendChild(btnPrimeira);
    
    // Botão "Anterior"
    const btnAnterior = criarBotaoPaginacao('anterior', '‹', paginaAtual - 1, paginaAtual === 1);
    paginacaoNav.appendChild(btnAnterior);
    
    // Números das páginas
    const range = gerarRangePaginas(paginaAtual, info.totalPaginas);
    range.forEach(num => {
        if (num === '...') {
            const span = document.createElement('span');
            span.className = 'paginacao-btn disabled';
            span.textContent = '...';
            paginacaoNav.appendChild(span);
        } else {
            const btn = criarBotaoPaginacao('numero', num, num, false, num === paginaAtual);
            paginacaoNav.appendChild(btn);
        }
    });
    
    // Botão "Próxima"
    const btnProxima = criarBotaoPaginacao('proxima', '›', paginaAtual + 1, paginaAtual === info.totalPaginas);
    paginacaoNav.appendChild(btnProxima);
    
    // Botão "Última"
    const btnUltima = criarBotaoPaginacao('ultima', '»', info.totalPaginas, paginaAtual === info.totalPaginas);
    paginacaoNav.appendChild(btnUltima);
    
    paginacaoContainer.appendChild(paginacaoInfo);
    paginacaoContainer.appendChild(paginacaoNav);
    
    produtosContainer.appendChild(paginacaoContainer);
}

function criarBotaoPaginacao(tipo, texto, pagina, disabled, active = false) {
    const btn = document.createElement('button');
    btn.className = 'paginacao-btn';
    btn.textContent = texto;
    
    if (disabled) {
        btn.classList.add('disabled');
        btn.disabled = true;
    }
    
    if (active) {
        btn.classList.add('active');
    }
    
    if (!disabled && !active) {
        btn.addEventListener('click', () => {
            paginaAtual = pagina;
            renderizarProdutos(produtosFiltrados);
            
            // Scroll suave para o topo dos produtos
            produtosContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }
    
    return btn;
}

function gerarRangePaginas(atual, total) {
    const range = [];
    const delta = 2; // Quantas páginas mostrar antes e depois da atual
    
    for (let i = 1; i <= total; i++) {
        if (i === 1 || i === total || (i >= atual - delta && i <= atual + delta)) {
            range.push(i);
        } else if (range[range.length - 1] !== '...') {
            range.push('...');
        }
    }
    
    return range;
}

// ========================================
// RENDERIZAR PRODUTOS COM PAGINAÇÃO
// ========================================

function renderizarProdutos(produtos) {
    console.log('🎨 Renderizando produtos com paginação...');
    
    if (!produtosContainer) return;
    
    produtosContainer.innerHTML = '';
    
    if (produtos.length === 0) {
        mostrarMensagemVazia();
        return;
    }
    
    const info = calcularPaginacao(produtos);
    
    info.produtosPagina.forEach((item, index) => {
        const card = criarCard(item, index);
        produtosContainer.appendChild(card);
    });
    
    renderizarPaginacao(info);
}

function criarCard(item, index) {
    const preco = parseFloat(item.preco_item || item.preco || 0);
    const precoFormatado = preco.toFixed(2).replace('.', ',');
    const estoque = parseInt(item.estoque) || 0;
    const disponivel = estoque > 0;
    
    const card = document.createElement('div');
    card.className = 'card-livro';
    card.style.animation = `fadeInUp 0.5s ease forwards`;
    card.style.animationDelay = `${index * 0.05}s`;
    card.style.opacity = '0';
    
    card.innerHTML = `
        <div class="card-imagem" style="position: relative;">
            <img src="${item.caminho_imagem || '/img/sem-imagem.png'}" 
                 alt="${item.titulo_item}"
                 onerror="this.src='/img/sem-imagem.png'">
            
            ${!disponivel ? '<div class="badge-status">ESGOTADO</div>' : ''}
        </div>
        
        <div class="card-info">
            <div class="card-tipo">${item.tipo_item || 'PRODUTO'}</div>
            
            <h3 class="card-titulo" title="${item.titulo_item}">
                ${item.titulo_item}
            </h3>
            
            ${item.autores ? `
                <p class="card-autor" title="${item.autores}">
                    ✒️ ${item.autores}
                </p>
            ` : '<p class="card-autor">Autor desconhecido</p>'}
            
            ${item.editora_gravadora ? `
                <p class="card-editora" style="
                    font-size: 11px;
                    color: #999;
                    margin: 4px 0;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                " title="${item.editora_gravadora}">
                    📚 ${item.editora_gravadora}
                </p>
            ` : ''}
            
            <div class="card-metadata" style="
                display: flex;
                gap: 10px;
                justify-content: center;
                margin: 6px 0;
                flex-wrap: wrap;
            ">
                ${item.ano_publicacao ? `
                    <span style="
                        font-size: 11px;
                        color: #8b7355;
                        background: rgba(200, 184, 150, 0.15);
                        padding: 3px 8px;
                        border-radius: 10px;
                        font-weight: 600;
                    ">
                        📅 ${item.ano_publicacao}
                    </span>
                ` : ''}
                
                ${item.nome_genero ? `
                    <span style="
                        font-size: 11px;
                        color: #8b7355;
                        background: rgba(200, 184, 150, 0.15);
                        padding: 3px 8px;
                        border-radius: 10px;
                        font-weight: 600;
                    ">
                        🏷️ ${item.nome_genero}
                    </span>
                ` : ''}
            </div>
            
            ${item.isbn ? `
                <p style="
                    font-size: 9px;
                    color: #aaa;
                    margin: 4px 0;
                    font-family: monospace;
                    letter-spacing: 0.5px;
                ">
                    ISBN: ${item.isbn}
                </p>
            ` : ''}
            
            <div class="card-spacer"></div>
            
            <div class="card-preco">R$ ${precoFormatado}</div>
            
            <div class="card-estoque ${disponivel ? 'disponivel' : 'indisponivel'}">
                ${disponivel ? `${estoque} em estoque` : 'Indisponível'}
            </div>
            
            <button class="card-btn ${disponivel ? 'disponivel' : 'indisponivel'}" 
                    ${!disponivel ? 'disabled' : ''}>
                ${disponivel ? '🛒 Adicionar ao Carrinho' : 'Indisponível'}
            </button>
        </div>
    `;
    
    card.addEventListener('click', (e) => {
        if (!e.target.classList.contains('card-btn')) {
            abrirModalProduto(item);
        }
    });
    
    const btn = card.querySelector('.card-btn');
    if (btn && disponivel) {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            adicionarAoCarrinho(item);
        });
    }
    
    return card;
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
                    background: linear-gradient(135deg, #d4a574, #c89968);
                    color: white;
                    border: none;
                    border-radius: 8px;
                    cursor: pointer;
                    font-weight: bold;
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
                <h3 style="color: #8b7355; margin-bottom: 10px;">Nenhum produto encontrado</h3>
                <p style="color: #999; margin-bottom: 25px;">Tente ajustar os filtros ou fazer uma nova busca</p>
                <button onclick="limparFiltros()" style="
                    padding: 12px 24px;
                    background: white;
                    color: #8b6f47;
                    border: 2px solid #c8b896;
                    border-radius: 8px;
                    cursor: pointer;
                    font-weight: bold;
                ">Limpar Filtros</button>
            </div>
        `;
    }
}

// ========================================
// MODAL, CARRINHO E NOTIFICAÇÕES
// ========================================

function abrirModalProduto(produto) {
    if (!modalProduto) return;
    
    const preco = parseFloat(produto.preco_item || produto.preco || 0);
    const precoFormatado = preco.toFixed(2).replace('.', ',');
    
    document.getElementById('modal-capa').src = produto.caminho_imagem || '/img/sem-imagem.png';
    document.getElementById('modal-titulo').textContent = produto.titulo_item;
    document.getElementById('modal-autor').textContent = produto.autores || 'Autor desconhecido';
    document.getElementById('modal-tipo').textContent = produto.tipo_item || 'Produto';
    document.getElementById('modal-preco').textContent = `R$ ${precoFormatado}`;
    document.getElementById('modal-descricao').textContent = produto.descricao || 'Produto em excelente estado.';
    document.getElementById('modal-editora').textContent = produto.editora_gravadora || '-';
    document.getElementById('modal-ano').textContent = produto.ano_publicacao || '-';
    document.getElementById('modal-isbn').textContent = produto.isbn || '-';
    document.getElementById('modal-estoque').textContent = produto.estoque || '0';
    
    const btnAdd = document.getElementById('btn-add-carrinho');
    if (btnAdd) {
        const newBtn = btnAdd.cloneNode(true);
        btnAdd.parentNode.replaceChild(newBtn, btnAdd);
        newBtn.addEventListener('click', () => {
            adicionarAoCarrinho(produto);
            fecharModal();
        });
    }
    
    const btnComprar = document.getElementById('btn-comprar');
    if (btnComprar) {
        const newBtn = btnComprar.cloneNode(true);
        btnComprar.parentNode.replaceChild(newBtn, btnComprar);
        newBtn.addEventListener('click', () => {
            adicionarAoCarrinho(produto);
            fecharModal();
            abrirModalCarrinho();
        });
    }
    
    modalProduto.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function fecharModal() {
    if (modalProduto) {
        modalProduto.classList.remove('show');
        document.body.style.overflow = '';
    }
}

function adicionarAoCarrinho(produto) {
    const itemExistente = carrinho.find(item => item.id_item === produto.id_item);
    
    if (itemExistente) {
        if (itemExistente.quantidade < (produto.estoque || 10)) {
            itemExistente.quantidade++;
        } else {
            mostrarNotificacao('⚠️ Quantidade máxima atingida!', 'warning');
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
    mostrarNotificacao('✓ Produto adicionado!', 'success');
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
            carrinho = [];
        }
    }
}

function atualizarContadorCarrinho() {
    const total = carrinho.reduce((sum, item) => sum + (item.quantidade || 1), 0);
    if (cartCountEl) cartCountEl.textContent = total;
}

function removerDoCarrinho(id_item) {
    carrinho = carrinho.filter(item => item.id_item !== id_item);
    salvarCarrinho();
    atualizarContadorCarrinho();
    renderizarCarrinho();
    mostrarNotificacao('🗑️ Item removido', 'info');
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
                <small>Qtd: ${item.quantidade} x R$ ${preco.toFixed(2).replace('.', ',')} = R$ ${subtotal.toFixed(2).replace('.', ',')}</small>
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

function mostrarNotificacao(mensagem, tipo = 'success') {
    const cores = {
        success: 'linear-gradient(135deg, #d4a574, #c89968)',
        warning: 'linear-gradient(135deg, #ff6b35, #f7931e)',
        info: 'linear-gradient(135deg, #6ba54a, #5a8f3d)'
    };
    
    const notif = document.createElement('div');
    notif.textContent = mensagem;
    notif.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${cores[tipo]};
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 10000;
        animation: slideIn 0.3s ease;
        font-weight: 600;
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

if (btnAplicarFiltros) btnAplicarFiltros.addEventListener('click', aplicarFiltros);
if (btnLimparFiltros) btnLimparFiltros.addEventListener('click', limparFiltros);

modalClose.forEach(btn => {
    btn.addEventListener('click', (e) => {
        const modal = e.target.closest('.modal-overlay');
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
});

if (modalProduto) {
    modalProduto.addEventListener('click', (e) => {
        if (e.target === modalProduto) fecharModal();
    });
}

const modalCarrinho = document.getElementById('modal-carrinho');
if (modalCarrinho) {
    modalCarrinho.addEventListener('click', (e) => {
        if (e.target === modalCarrinho) fecharModalCarrinho();
    });
}

const btnVerCarrinho = document.getElementById('btn-ver-carrinho');
if (btnVerCarrinho) btnVerCarrinho.addEventListener('click', abrirModalCarrinho);

const btnContinuar = document.getElementById('btn-continuar-comprando');
if (btnContinuar) btnContinuar.addEventListener('click', fecharModalCarrinho);

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
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
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

carregarCarrinho();
carregarProdutos();
configurarBuscaTempoReal();

console.log('✅ Sistema pronto com paginação!');
// ========================================
// 🆕 UPGRADE: FILTRO POR URL
// Adicione este código ao seu produtos.js existente
// ========================================

// ADICIONAR APÓS a linha 31 (após: const itensPorPagina = 12;)

// ========================================
// FUNÇÃO PARA LER PARÂMETROS DA URL
// ========================================
function obterParametroUrl(nome) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(nome);
}

function aplicarFiltrosUrl() {
    const generoUrl = obterParametroUrl('genero');
    const categoriaUrl = obterParametroUrl('categoria');
    const buscaUrl = obterParametroUrl('busca');
    
    if (generoUrl && generoSelect) {
        generoSelect.value = generoUrl;
        console.log(`🔗 Filtro de URL aplicado - Gênero: ${generoUrl}`);
    }
    
    if (categoriaUrl && categoriaSelect) {
        categoriaSelect.value = categoriaUrl;
        console.log(`🔗 Filtro de URL aplicado - Categoria: ${categoriaUrl}`);
    }
    
    if (buscaUrl && searchInput) {
        searchInput.value = buscaUrl;
        console.log(`🔗 Filtro de URL aplicado - Busca: ${buscaUrl}`);
    }
    
    // Se algum filtro foi aplicado pela URL, executa a filtragem
    if (generoUrl || categoriaUrl || buscaUrl) {
        aplicarFiltros();
    }
    // ========================================
// 🆕 CÓDIGO COMPLETO PARA ADICIONAR AO produtos.js
// ========================================

// 1️⃣ ADICIONE ESTAS FUNÇÕES APÓS A LINHA 31 (depois de: const itensPorPagina = 12;)

// ========================================
// FUNÇÃO PARA LER PARÂMETROS DA URL
// ========================================
function obterParametroUrl(nome) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(nome);
}



// 2️⃣ MODIFIQUE A FUNÇÃO carregarProdutos
// ENCONTRE esta parte (por volta da linha 50-60):


async function carregarProdutos() {
    console.log('📦 Buscando produtos do banco...');
    mostrarLoading();
    
    try {
        const response = await fetch('/backend/api/item');
        console.log('Status:', response.status);
        
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        
        const json = await response.json();
        console.log('✅ Dados recebidos:', json);
        
        if (json.status === 'success' && json.data) {
            todosOsProdutos = json.data;
            produtosFiltrados = [...todosOsProdutos];
            
            extrairGenerosECategorias();
            popularSelects();
            
            paginaAtual = 1; // Resetar para página 1
            renderizarProdutos(produtosFiltrados);
            atualizarContador();
        } else {
            throw new Error(json.message || 'Erro desconhecido');
        }
    } catch (err) {
        console.error('❌ Erro:', err);
        mostrarErro(err.message);
    }
}


// SUBSTITUA POR ESTA VERSÃO:

async function carregarProdutos() {
    console.log('📦 Buscando produtos do banco...');
    mostrarLoading();
    
    try {
        const response = await fetch('/backend/api/item');
        console.log('Status:', response.status);
        
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        
        const json = await response.json();
        console.log('✅ Dados recebidos:', json);
        
        if (json.status === 'success' && json.data) {
            todosOsProdutos = json.data;
            produtosFiltrados = [...todosOsProdutos];
            
            // Primeiro, extrai e popula os selects
            extrairGenerosECategorias();
            popularSelects();
            
            // IMPORTANTE: Aplica os filtros da URL ANTES de renderizar
            aplicarFiltrosUrl();
            
            // Renderiza já com o filtro aplicado (se houver)
            // NOTA: aplicarFiltrosUrl() já chama renderizarProdutos() se houver filtro
            // Então só renderizamos aqui se NÃO houver filtro na URL
            const temFiltroUrl = obterParametroUrl('genero') || obterParametroUrl('categoria') || obterParametroUrl('busca');
            if (!temFiltroUrl) {
                paginaAtual = 1;
                renderizarProdutos(produtosFiltrados);
                atualizarContador();
            }
        } else {
            throw new Error(json.message || 'Erro desconhecido');
        }
    } catch (err) {
        console.error('❌ Erro:', err);
        mostrarErro(err.message);
    }
}



function limparFiltros() {
    console.log('🧹 Limpando filtros...');
    
    if (searchInput) searchInput.value = '';
    if (generoSelect) generoSelect.value = '';
    if (categoriaSelect) categoriaSelect.value = '';
    
    // Limpa a URL também
    const url = new URL(window.location);
    url.search = '';
    window.history.pushState({}, '', url);
    
    produtosFiltrados = [...todosOsProdutos];
    paginaAtual = 1;
    renderizarProdutos(produtosFiltrados);
    atualizarContador();
}

}
