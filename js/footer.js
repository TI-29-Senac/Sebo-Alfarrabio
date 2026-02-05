/**
 * ========================================
 * SISTEMA DE AVALIAÇÕES DINÂMICAS
 * Carrega avaliações do banco via Model Avaliacao.php
 * Exibe na seção de depoimentos do index.html
 * ========================================
 */

// Configuração da API
const API_CONFIG = {
    url: '/backend/index.php/api/avaliacoes', // Rota que vai para PublicApiController->getAvaliacoes()
    limite: 10,
    cache: true,
    cacheTempo: 300000 // 5 minutos
};

// Estado do slider
let estadoSlider = {
    avaliacoes: [],
    indiceAtual: 0,
    autoplayInterval: null,
    autoplayTempo: 5000
};

/**
 * Inicializa ao carregar a página
 */
document.addEventListener('DOMContentLoaded', function () {
    console.log('🎯 Inicializando sistema de avaliações...');
    carregarAvaliacoes();
    configurarNavegacao();
});

/**
 * Carrega avaliações do banco de dados
 */
async function carregarAvaliacoes() {
    const track = document.getElementById('depoimentoTrack');

    if (!track) {
        console.warn('⚠️ Container de avaliações não encontrado');
        return;
    }

    try {
        // Verifica cache primeiro
        const cacheData = verificarCache();
        if (cacheData) {
            console.log('✅ Usando avaliações do cache');
            estadoSlider.avaliacoes = cacheData;
            renderizarAvaliacoes();
            return;
        }

        // Busca do servidor
        console.log('🔄 Buscando avaliações do servidor...');

        const response = await fetch(`${API_CONFIG.url}?limite=${API_CONFIG.limite}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error(`Erro HTTP: ${response.status}`);
        }

        const data = await response.json();

        if (!data.success) {
            throw new Error(data.error || 'Erro ao carregar avaliações');
        }

        console.log(`✅ ${data.total} avaliações carregadas`);
        console.log(`📊 Média de notas: ${data.media_notas}`);

        estadoSlider.avaliacoes = data.avaliacoes || [];

        // Salva no cache
        if (API_CONFIG.cache && estadoSlider.avaliacoes.length > 0) {
            salvarCache(estadoSlider.avaliacoes);
        }

        renderizarAvaliacoes();

    } catch (error) {
        console.error('❌ Erro ao carregar avaliações:', error);
        exibirErro(track, error.message);
    }
}

/**
 * Renderiza as avaliações no DOM
 */
function renderizarAvaliacoes() {
    const track = document.getElementById('depoimentoTrack');

    if (!estadoSlider.avaliacoes || estadoSlider.avaliacoes.length === 0) {
        track.innerHTML = `
            <div class="depoimento-vazio">
                <i class="fas fa-comment-slash"></i>
                <p>Nenhuma avaliação disponível no momento</p>
                <small>Seja o primeiro a avaliar nossos produtos!</small>
            </div>
        `;
        return;
    }

    // Limpa o loading
    track.innerHTML = '';

    // Renderiza cada avaliação
    estadoSlider.avaliacoes.forEach((avaliacao, index) => {
        const card = criarCardAvaliacao(avaliacao, index);
        track.appendChild(card);
    });

    // Mostra o primeiro card
    atualizarSlider();

    // Inicia autoplay
    iniciarAutoplay();

    // Cria indicadores
    criarIndicadores();

    console.log('✅ Avaliações renderizadas com sucesso');
}

/**
 * Cria um card de avaliação
 */
function criarCardAvaliacao(avaliacao, index) {
    const card = document.createElement('div');
    card.className = 'depoimento-card';
    card.setAttribute('data-index', index);

    // Gera as estrelas baseado na nota
    const estrelas = gerarEstrelas(avaliacao.nota);

    // Foto do usuário ou iniciais
    const fotoUsuario = avaliacao.usuario.foto && avaliacao.usuario.foto !== ''
        ? `<img src="${avaliacao.usuario.foto}" alt="${escapeHtml(avaliacao.usuario.nome)}" class="depoimento-foto" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
           <div class="depoimento-foto-placeholder" style="display:none;">${avaliacao.usuario.iniciais || 'U'}</div>`
        : `<div class="depoimento-foto-placeholder">${avaliacao.usuario.iniciais || 'U'}</div>`;

    // Monta o HTML do card
    card.innerHTML = `
        <div class="depoimento-header">
            <div class="depoimento-usuario">
                ${fotoUsuario}
                <div class="depoimento-info">
                    <h4 class="depoimento-nome">${escapeHtml(avaliacao.usuario.nome)}</h4>
                    <div class="depoimento-estrelas" title="Nota: ${avaliacao.nota}/5">${estrelas}</div>
                </div>
            </div>
            <div class="depoimento-data" title="${avaliacao.data_completa || avaliacao.data}">
                <i class="far fa-clock"></i> ${avaliacao.tempo_decorrido || avaliacao.data}
            </div>
        </div>
        
        <div class="depoimento-corpo">
            <p class="depoimento-comentario">"${escapeHtml(avaliacao.comentario)}"</p>
        </div>
        
        <div class="depoimento-footer">
            <div class="depoimento-item-info">
                <i class="fas fa-book"></i>
                <span class="item-titulo">${escapeHtml(avaliacao.item.titulo)}</span>
            </div>
            ${avaliacao.item.autor ? `
                <div class="depoimento-item-meta">
                    <i class="fas fa-pen-fancy"></i>
                    <span>${escapeHtml(avaliacao.item.autor)}</span>
                </div>
            ` : ''}
        </div>
    `;

    return card;
}

/**
 * Gera HTML das estrelas baseado na nota (1-5)
 */
function gerarEstrelas(nota) {
    let html = '';
    const notaInt = parseInt(nota);
    const temMeia = (nota - notaInt) >= 0.5;

    for (let i = 1; i <= 5; i++) {
        if (i <= notaInt) {
            html += '<i class="fas fa-star"></i>';
        } else if (i === notaInt + 1 && temMeia) {
            html += '<i class="fas fa-star-half-alt"></i>';
        } else {
            html += '<i class="far fa-star"></i>';
        }
    }
    return html;
}

/**
 * Configura navegação do slider
 */
function configurarNavegacao() {
    const btnPrev = document.querySelector('.depoimento-nav-prev');
    const btnNext = document.querySelector('.depoimento-nav-next');

    if (btnPrev) {
        btnPrev.addEventListener('click', () => {
            navegarSlider('prev');
        });
    }

    if (btnNext) {
        btnNext.addEventListener('click', () => {
            navegarSlider('next');
        });
    }

    // Adiciona suporte para teclado
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') navegarSlider('prev');
        if (e.key === 'ArrowRight') navegarSlider('next');
    });

    // Pausa autoplay ao passar mouse
    const track = document.getElementById('depoimentoTrack');
    if (track) {
        track.addEventListener('mouseenter', pararAutoplay);
        track.addEventListener('mouseleave', iniciarAutoplay);

        // Suporte para touch em mobile
        track.addEventListener('touchstart', pararAutoplay);
        track.addEventListener('touchend', iniciarAutoplay);
    }
}

/**
 * Navega entre os slides
 */
function navegarSlider(direcao) {
    if (estadoSlider.avaliacoes.length === 0) return;

    pararAutoplay();

    const total = estadoSlider.avaliacoes.length;

    if (direcao === 'next') {
        estadoSlider.indiceAtual = (estadoSlider.indiceAtual + 1) % total;
    } else {
        estadoSlider.indiceAtual = (estadoSlider.indiceAtual - 1 + total) % total;
    }

    atualizarSlider();
    iniciarAutoplay();
}

/**
 * Atualiza posição do slider
 */
function atualizarSlider() {
    const track = document.getElementById('depoimentoTrack');
    const cards = track.querySelectorAll('.depoimento-card');

    cards.forEach((card, index) => {
        card.classList.remove('active', 'prev', 'next');

        const total = estadoSlider.avaliacoes.length;
        const prevIndex = (estadoSlider.indiceAtual - 1 + total) % total;
        const nextIndex = (estadoSlider.indiceAtual + 1) % total;

        if (index === estadoSlider.indiceAtual) {
            card.classList.add('active');
        } else if (index === prevIndex) {
            card.classList.add('prev');
        } else if (index === nextIndex) {
            card.classList.add('next');
        }
    });

    atualizarIndicadoresAtivos();
}

/**
 * Cria indicadores de navegação
 */
function criarIndicadores() {
    const container = document.getElementById('depoimentoIndicadores');
    if (!container || estadoSlider.avaliacoes.length <= 1) return;

    container.innerHTML = '';

    estadoSlider.avaliacoes.forEach((_, index) => {
        const indicador = document.createElement('button');
        indicador.className = 'depoimento-indicador';
        indicador.setAttribute('aria-label', `Ir para avaliação ${index + 1}`);
        indicador.setAttribute('data-index', index);

        indicador.addEventListener('click', () => {
            pararAutoplay();
            estadoSlider.indiceAtual = index;
            atualizarSlider();
            iniciarAutoplay();
        });

        container.appendChild(indicador);
    });

    atualizarIndicadoresAtivos();
}

/**
 * Atualiza indicadores ativos
 */
function atualizarIndicadoresAtivos() {
    const indicadores = document.querySelectorAll('.depoimento-indicador');
    indicadores.forEach((ind, index) => {
        ind.classList.toggle('active', index === estadoSlider.indiceAtual);
    });
}

/**
 * Inicia autoplay do slider
 */
function iniciarAutoplay() {
    pararAutoplay();

    if (estadoSlider.avaliacoes.length > 1) {
        estadoSlider.autoplayInterval = setInterval(() => {
            navegarSlider('next');
        }, estadoSlider.autoplayTempo);
    }
}

/**
 * Para autoplay do slider
 */
function pararAutoplay() {
    if (estadoSlider.autoplayInterval) {
        clearInterval(estadoSlider.autoplayInterval);
        estadoSlider.autoplayInterval = null;
    }
}

/**
 * Exibe mensagem de erro
 */
function exibirErro(container, mensagem) {
    container.innerHTML = `
        <div class="depoimento-erro">
            <i class="fas fa-exclamation-triangle"></i>
            <p>Não foi possível carregar as avaliações</p>
            <small>${mensagem || 'Tente novamente mais tarde'}</small>
            <button onclick="carregarAvaliacoes()" class="btn-retry">
                <i class="fas fa-sync"></i> Tentar novamente
            </button>
        </div>
    `;
}

/**
 * Verifica cache
 */
function verificarCache() {
    if (!API_CONFIG.cache) return null;

    try {
        const cache = localStorage.getItem('avaliacoes_cache');
        if (!cache) return null;

        const dados = JSON.parse(cache);
        const agora = Date.now();

        // Verifica se o cache expirou
        if (agora - dados.timestamp > API_CONFIG.cacheTempo) {
            localStorage.removeItem('avaliacoes_cache');
            console.log('🗑️ Cache expirado - removido');
            return null;
        }

        return dados.avaliacoes;
    } catch (error) {
        console.error('Erro ao ler cache:', error);
        localStorage.removeItem('avaliacoes_cache');
        return null;
    }
}

/**
 * Salva no cache
 */
function salvarCache(avaliacoes) {
    try {
        const dados = {
            avaliacoes: avaliacoes,
            timestamp: Date.now()
        };
        localStorage.setItem('avaliacoes_cache', JSON.stringify(dados));
        console.log('💾 Avaliações salvas no cache');
    } catch (error) {
        console.error('Erro ao salvar cache:', error);
    }
}

/**
 * Escapa HTML para prevenir XSS
 */
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Limpa cache manualmente (útil para debug)
 */
function limparCacheAvaliacoes() {
    localStorage.removeItem('avaliacoes_cache');
    console.log('🗑️ Cache de avaliações limpo');
    carregarAvaliacoes();
}

// Expõe funções globais para uso em console/debug
window.carregarAvaliacoes = carregarAvaliacoes;
window.limparCacheAvaliacoes = limparCacheAvaliacoes;

console.log('✅ Sistema de avaliações carregado');