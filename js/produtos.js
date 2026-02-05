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
let activeTipoFilter = ''; // Novo filtro de tipo (URL)
const localStorageKey = 'carrinhoSebo';

// ========================================
// CONFIGURAÇÕES DE PAGINAÇÃO
// ========================================
let paginaAtual = 1;
const itensPorPagina = 12; // Quantos produtos mostrar por página

// ========================================
// CARREGAR DADOS DO BANCO
// ========================================

/**
 * Carrega a lista de produtos do backend (API).
 * Gerencia o estado de loading e erros.
 * Inicializa contadores e renderização.
 */
async function carregarProdutos() {
    console.log('📦 Buscando produtos do banco...');
    mostrarLoading();

    try {
        const response = await fetch('/backend/index.php/api/item');
        console.log('Status:', response.status);

        if (!response.ok) throw new Error(`HTTP ${response.status}`);

        const json = await response.json();
        console.log('✅ Dados recebidos:', json);

        if (json.status === 'success' && json.data) {
            todosOsProdutos = json.data;
            produtosFiltrados = [...todosOsProdutos];

            // Busca filtros reais do banco em vez de extrair dos produtos
            await carregarFiltrosDoBanco();

            // Verifica se há filtros na URL
            aplicarFiltrosUrl();

            // Se NÃO houve filtro via URL (que já chama renderizarProdutos), renderiza normalmente
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

/**
 * Carrega as opções de filtro (Categorias e Gêneros) do banco de dados.
 * Popula os selects de filtro na interface.
 */
async function carregarFiltrosDoBanco() {
    console.log('📂 Buscando categorias e gêneros do banco...');
    try {
        // Buscar Categorias
        const respCat = await fetch('/backend/index.php/api/categorias');
        const jsonCat = await respCat.json();
        if (jsonCat.status === 'success') {
            categoriasDisponiveis = jsonCat.data.map(c => c.nome_categoria);
        }

        // Buscar Gêneros
        const respGen = await fetch('/backend/index.php/api/generos');
        const jsonGen = await respGen.json();
        if (jsonGen.status === 'success') {
            generosDisponiveis = jsonGen.data.map(g => g.nome_generos);
        }

        popularSelects();
    } catch (err) {
        console.error('❌ Erro ao carregar filtros:', err);
        // Fallback: extrai do que tem se o banco falhar
        extrairGenerosECategorias();
        popularSelects();
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

/**
 * Aplica os filtros selecionados (busca, gênero, categoria) sobre a lista de produtos.
 * Atualiza `produtosFiltrados` e re-renderiza a lista.
 */
function aplicarFiltros() {
    console.log('🔍 Aplicando filtros...');

    const termoBusca = searchInput ? searchInput.value.trim().toLowerCase() : '';
    const generoSelecionado = generoSelect ? generoSelect.value : '';
    const categoriaSelecionada = categoriaSelect ? categoriaSelect.value : '';

    console.log('Filtros:', { termoBusca, generoSelecionado, categoriaSelecionada });

    produtosFiltrados = todosOsProdutos.filter(produto => {
        if (termoBusca) {
            const tituloMatch = produto.titulo?.toLowerCase().includes(termoBusca);
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

        if (categoriaSelecionada && produto.nome_categoria !== categoriaSelecionada) {
            return false;
        }

        // Filtro por TIPO (vindo da URL/Menu Secundário)
        if (activeTipoFilter) {
            // Tratamento especial para "Disco" que pode não estar exato no banco ou mapear para algo similar
            // Mas vamos assumir comparação direta case-insensitive por enquanto
            if (!produto.tipo || produto.tipo.toLowerCase() !== activeTipoFilter.toLowerCase()) {
                return false;
            }
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
    activeTipoFilter = ''; // Limpa filtro de tipo

    // Limpa a URL
    const url = new URL(window.location);
    url.search = '';
    window.history.pushState({}, '', url);

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

/**
 * Renderiza os cards de produtos na tela usando paginação.
 * @param {Array} produtos - Lista de produtos a serem exibidos.
 */
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
    const preco = parseFloat(item.preco || 0);
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
                 alt="${item.titulo}"
                 onerror="this.src='/img/sem-imagem.png'">
            
            ${!disponivel ? '<div class="badge-status">ESGOTADO</div>' : ''}
        </div>
        
        <div class="card-info">
            <div class="card-tipo">${item.tipo || 'PRODUTO'}</div>
            
            <h3 class="card-titulo" title="${item.titulo}">
                ${item.titulo}
            </h3>
            
            ${item.autores ? `
                <p class="card-autor" title="${item.autores}">
                    ✒️ ${item.autores}
                </p>
            ` : '<p class="card-autor">Autor desconhecido</p>'}
            
            ${item.editora ? `
                <p class="card-editora" style="
                    font-size: 11px;
                    color: #999;
                    margin: 4px 0;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                " title="${item.editora}">
                    📚 ${item.editora}
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
                ${disponivel ? '📌 Adicionar às Reservas' : 'Indisponível'}
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

    const preco = parseFloat(produto.preco || 0);
    const precoFormatado = preco.toFixed(2).replace('.', ',');

    document.getElementById('modal-capa').src = produto.caminho_imagem || '/img/sem-imagem.png';
    document.getElementById('modal-titulo').textContent = produto.titulo;
    document.getElementById('modal-autor').textContent = produto.autores || 'Autor desconhecido';
    document.getElementById('modal-tipo').textContent = produto.tipo || 'Produto';
    document.getElementById('modal-preco').textContent = `R$ ${precoFormatado}`;
    document.getElementById('modal-descricao').textContent = produto.descricao || 'Produto em excelente estado.';
    document.getElementById('modal-editora').textContent = produto.editora || '-';
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

/**
 * Adiciona um produto ao carrinho (reservas).
 * Verifica autenticação do usuário antes de adicionar.
 * @param {Object} produto - Objeto do produto a adicionar.
 */
async function adicionarAoCarrinho(produto) {
    // 1. Verificar se o usuário está logado
    if (!window.isAuthenticated) {
        mostrarNotificacao('⚠️ Ops! Para reservar você precisa estar logado.', 'warning');

        setTimeout(() => {
            const currentPath = window.location.pathname + window.location.search;
            window.location.href = `/backend/login?redirect=${encodeURIComponent(currentPath)}`;
        }, 1500);
        return;
    }

    try {
        const response = await fetch('/backend/index.php/api/carrinho/adicionar', {
            method: 'POST',
            body: JSON.stringify({ id_item: produto.id_item, quantidade: 1 }),
            headers: { 'Content-Type': 'application/json' }
        });
        const data = await response.json();
        if (data.success) {
            mostrarNotificacao('✓ Item adicionado às reservas!', 'success');
            await sincronizarCarrinhoComServidor();
        } else {
            mostrarNotificacao(`❌ ${data.message || 'Erro ao adicionar item.'}`, 'error');
        }
    } catch (err) {
        console.error('Erro ao adicionar item:', err);
        mostrarNotificacao('❌ Erro de conexão com o servidor', 'error');
    }
}

async function sincronizarCarrinhoComServidor() {
    if (!window.isAuthenticated) return;
    try {
        const response = await fetch('/backend/index.php/api/carrinho');
        const data = await response.json();
        if (data.success) {
            // No banco os campos podem ser um pouco diferentes, mapeamos para compatibilidade
            carrinho = data.itens.map(item => ({
                id_item: item.id_item,
                titulo_item: item.titulo,
                preco_item: item.preco,
                caminho_imagem: item.imagem,
                quantidade: item.quantidade
            }));
            atualizarContadorCarrinho();
            if (document.getElementById('modal-carrinho')?.classList.contains('show')) {
                renderizarCarrinho();
            }
        }
    } catch (err) {
        console.error('Erro ao sincronizar carrinho:', err);
    }
}

function salvarCarrinho() {
    localStorage.setItem(localStorageKey, JSON.stringify(carrinho));
}

async function carregarCarrinho() {
    if (window.isAuthenticated) {
        await sincronizarCarrinhoComServidor();
    } else {
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
}

function atualizarContadorCarrinho() {
    const total = carrinho.reduce((sum, item) => sum + (item.quantidade || 1), 0);
    if (cartCountEl) cartCountEl.textContent = total;
}

async function removerDoCarrinho(id_item) {
    if (window.isAuthenticated) {
        try {
            const response = await fetch('/backend/index.php/api/carrinho/remover', {
                method: 'POST',
                body: JSON.stringify({ id_item }),
                headers: { 'Content-Type': 'application/json' }
            });
            const data = await response.json();
            if (data.success) {
                mostrarNotificacao('🗑️ Item removido das reservas', 'info');
                await sincronizarCarrinhoComServidor();
            }
        } catch (err) {
            console.error('Erro ao remover item:', err);
            mostrarNotificacao('❌ Erro ao remover item', 'error');
        }
    } else {
        carrinho = carrinho.filter(item => item.id_item !== id_item);
        salvarCarrinho();
        atualizarContadorCarrinho();
        renderizarCarrinho();
        mostrarNotificacao('🗑️ Item removido das reservas', 'info');
    }
}

function renderizarCarrinho() {
    if (!cartItemsEl) return;

    const carrinhoVazio = document.getElementById('carrinho-vazio');

    if (!carrinho || carrinho.length === 0) {
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
        // Usa preco_item ou preco, garantindo que seja um número válido
        const preco = parseFloat(item.preco_item || item.preco || 0);
        const subtotal = preco * (item.quantidade || 1);
        total += subtotal;

        const li = document.createElement('li');
        li.innerHTML = `
            <div>
                <strong>${item.titulo_item || item.titulo}</strong>
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

async function finalizarReserva() {
    if (!carrinho || carrinho.length === 0) {
        mostrarNotificacao('⚠️ Seu carrinho está vazio!', 'warning');
        return;
    }

    const btn = document.getElementById('btn-finalizar-pedido');
    if (!btn) return;

    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Confirmando...';

    try {
        const response = await fetch('/backend/index.php/api/carrinho/finalizar', {
            method: 'POST',
            body: JSON.stringify({ itens: carrinho }),
            headers: { 'Content-Type': 'application/json' }
        });

        const rawText = await response.text();
        console.log('Raw response:', rawText);

        let data;
        try {
            data = JSON.parse(rawText);
        } catch (e) {
            console.error('Erro ao processar JSON:', e);
            throw new Error('Resposta do servidor inválida (Não é JSON)');
        }

        if (data.success) {
            mostrarNotificacao('🎉 Reserva realizada com sucesso!', 'success');
            carrinho = [];
            atualizarContadorCarrinho();
            renderizarCarrinho();

            setTimeout(() => {
                fecharModalCarrinho();
                window.location.href = '/backend/admin/cliente';
            }, 1500);
        } else {
            mostrarNotificacao(`❌ ${data.message || 'Erro ao processar reserva'}`, 'error');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    } catch (err) {
        console.error('Erro detalhado ao finalizar reserva:', err);
        mostrarNotificacao(`❌ ${err.message || 'Erro de conexão com o servidor'}`, 'error');
        btn.disabled = false;
        btn.innerHTML = originalText;
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

const btnFinalizar = document.getElementById('btn-finalizar-pedido');
if (btnFinalizar) btnFinalizar.addEventListener('click', finalizarReserva);

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

// Escutar evento de autenticação para sincronizar o carrinho
document.addEventListener('authChecked', (e) => {
    if (e.detail.authenticated) {
        carregarCarrinho();
    }
});

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
    const tipoUrl = obterParametroUrl('tipo'); // Novo parametro

    if (tipoUrl) {
        activeTipoFilter = tipoUrl;
        console.log(`🔗 Filtro de URL aplicado - Tipo: ${tipoUrl}`);
    }

    if (generoUrl && generoSelect) {
        // Tenta encontrar a opção correspondente ignorando case
        let match = false;
        for (let i = 0; i < generoSelect.options.length; i++) {
            if (generoSelect.options[i].value.toLowerCase() === generoUrl.toLowerCase()) {
                generoSelect.selectedIndex = i;
                match = true;
                break;
            }
        }

        // Se não achou a opção, cria uma temporária para que o filtro funcione (retornando 0 produtos)
        // em vez de mostrar todos os produtos
        if (!match) {
            const option = document.createElement('option');
            option.value = generoUrl;
            option.textContent = generoUrl;
            generoSelect.appendChild(option);
            generoSelect.value = generoUrl;
        }

        console.log(`🔗 Filtro de URL aplicado - Gênero: ${generoUrl}`);
    }

    if (categoriaUrl && categoriaSelect) {
        // Tenta encontrar a opção correspondente ignorando case
        let match = false;
        for (let i = 0; i < categoriaSelect.options.length; i++) {
            if (categoriaSelect.options[i].value.toLowerCase() === categoriaUrl.toLowerCase()) {
                categoriaSelect.selectedIndex = i;
                match = true;
                break;
            }
        }

        if (!match) {
            const option = document.createElement('option');
            option.value = categoriaUrl;
            option.textContent = categoriaUrl;
            categoriaSelect.appendChild(option);
            categoriaSelect.value = categoriaUrl;
        }

        console.log(`🔗 Filtro de URL aplicado - Categoria: ${categoriaUrl}`);
    }

    if (buscaUrl && searchInput) {
        searchInput.value = buscaUrl;
        console.log(`🔗 Filtro de URL aplicado - Busca: ${buscaUrl}`);
    }

    // Se algum filtro foi aplicado pela URL, executa a filtragem
    if (generoUrl || categoriaUrl || buscaUrl || activeTipoFilter) {
        aplicarFiltros();
    }
}
// ========================================

