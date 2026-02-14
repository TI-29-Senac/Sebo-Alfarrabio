/**
 * footer.js
 * Gerencia a exibição de avaliações no rodapé.
 * Encapsulado em IIFE para evitar conflitos de escopo.
 */

(function () {
    // Evita execução duplicada
    if (window.footerJsLoaded) {
        console.warn('⚠️ footer.js já foi carregado. Ignorando execução duplicada.');
        return;
    }
    window.footerJsLoaded = true;

    console.log('🏁 Inicializando sistema de avaliações...');

    // Configuração da API
    const API_CONFIG = {
        url: '/backend/index.php/vitrine/avaliacoes', // Endpoint correto via Controller
        limite: 10,
        cache: true,
        cacheTempo: 300000 // 5 minutos
    };

    // Estado do slider
    let estadoSlider = {
        avaliacoes: [],
        indiceAtual: 0,
        autoplayInterval: null
    };

    // Inicialização
    document.addEventListener('DOMContentLoaded', function () {
        console.log('🚀 DOM carregado, iniciando busca de avaliações...');
        carregarAvaliacoes();
        configurarNavegacao();
        injetarEstilosModal(); // Injeta CSS do modal de avaliação
    });

    /**
     * Carrega as avaliações da API ou Cache
     */
    async function carregarAvaliacoes() {
        const track = document.getElementById('depoimentoTrack');
        if (!track) {
            console.error('❌ Elemento #depoimentoTrack não encontrado!');
            return;
        }

        // Verifica cache
        if (API_CONFIG.cache) {
            const cache = localStorage.getItem('avaliacoes_cache');
            const cacheTime = localStorage.getItem('avaliacoes_time');

            if (cache && cacheTime) {
                const now = new Date().getTime();
                if (now - parseInt(cacheTime) < API_CONFIG.cacheTempo) {
                    console.log('💾 Avaliações carregadas do cache');
                    estadoSlider.avaliacoes = JSON.parse(cache);
                    renderizarAvaliacoes();
                    return;
                }
            }
        }

        // Busca da API
        try {
            console.log('🌐 Buscando avaliações do servidor...');
            const response = await fetch(API_CONFIG.url);

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            const data = await response.json();

            if (data.success && data.avaliacoes) {
                estadoSlider.avaliacoes = data.avaliacoes;
                console.log(`✅ ${data.avaliacoes.length} avaliações carregadas`);
                console.log(`📊 Média de notas: ${data.media_notas}`);

                // Salva no cache
                if (API_CONFIG.cache) {
                    localStorage.setItem('avaliacoes_cache', JSON.stringify(data.avaliacoes));
                    localStorage.setItem('avaliacoes_time', new Date().getTime());
                    console.log('💾 Avaliações salvas no cache');
                }

                renderizarAvaliacoes();
            } else {
                console.warn('⚠️ API retornou sucesso=false ou sem avaliações');
                usarDadosDemo();
            }
        } catch (error) {
            console.error('❌ Erro ao carregar avaliações:', error);
            usarDadosDemo();
        }
    }

    /**
     * Dados de demonstração em caso de falha da API
     */
    function usarDadosDemo() {
        console.log('⚠️ Usando dados de demonstração');
        estadoSlider.avaliacoes = [
            {
                id: 3,
                nota: 5,
                comentario: "Encontrei uma edição rara que procurava há anos! O atendimento foi excelente e a entrega super rápida.",
                data: new Date().toLocaleDateString('pt-BR'),
                tempo_decorrido: "2 semanas atrás",
                usuario: {
                    id: 3,
                    nome: "Ana Oliveira",
                    foto: null,
                    iniciais: "AO"
                },
                item: {
                    id: 3,
                    titulo: "1984",
                    autor: "George Orwell"
                }
            },
            {
                id: 4,
                nota: 5,
                comentario: "Fiz uma compra online e recebi tudo certinho. Os livros estavam bem embalados e chegaram antes do prazo!",
                data: new Date().toLocaleDateString('pt-BR'),
                tempo_decorrido: "3 semanas atrás",
                usuario: {
                    id: 4,
                    nome: "Carlos Mendes",
                    foto: null,
                    iniciais: "CM"
                },
                item: {
                    id: 4,
                    titulo: "Cem Anos de Solidão",
                    autor: "Gabriel García Márquez"
                }
            }
        ];
        renderizarAvaliacoes();
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

        console.log('✅ Avaliações renderizadas com sucesso. Total:', estadoSlider.avaliacoes.length);

        // Log de dimensões para debug
        console.log('📏 Dimensões do Track:', track.getBoundingClientRect());

        // Força atualização visual imediata
        requestAnimationFrame(() => {
            atualizarSlider();
            const cards = document.querySelectorAll('.depoimento-card');
            if (cards.length > 0) {
                cards[0].classList.add('active'); // Força o primeiro a ser ativo
                console.log('Primeiro card ativado manualmente');
            }
        });
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

        function escapeHtml(text) {
            if (!text) return '';
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Foto do usuário ou iniciais
        const fotoUsuario = avaliacao.usuario.foto && avaliacao.usuario.foto !== '' && !avaliacao.usuario.foto.includes('default')
            ? `<img src="${avaliacao.usuario.foto}" alt="${escapeHtml(avaliacao.usuario.nome)}" class="depoimento-foto" onerror="this.onerror=null;this.src='/backend/uploads/perfis/default.png';">`
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
            
            <div class="depoimento-conteudo">
                <i class="fas fa-quote-left quote-icon"></i>
                <p>"${escapeHtml(avaliacao.comentario)}"</p>
                <i class="fas fa-quote-right quote-icon-right"></i>
            </div>
            
            ${avaliacao.item ? `
            <div class="depoimento-produto">
                <div class="produto-info-mini">
                    <i class="fas fa-book"></i> 
                    <span>${escapeHtml(avaliacao.item.titulo)}</span>
                </div>
                ${avaliacao.item.autor ? `
                <div class="produto-autor-mini">
                    <i class="fas fa-pen-nib"></i>
                    <span>${escapeHtml(avaliacao.item.autor)}</span>
                </div>` : ''}
            </div>
            ` : ''}
        `;

        // Evento de clique para abrir modal com detalhes completos
        card.style.cursor = 'pointer';
        card.addEventListener('click', function (e) {
            e.stopPropagation();
            abrirModalAvaliacao(avaliacao);
        });

        return card;
    }

    /**
     * Abre o modal com os detalhes completos de uma avaliação
     */
    function abrirModalAvaliacao(avaliacao) {
        // Para o autoplay enquanto o modal estiver aberto
        pararAutoplay();

        // Remove modal anterior se existir
        const modalExistente = document.getElementById('modalDepoimento');
        if (modalExistente) modalExistente.remove();

        function escapeHtml(text) {
            if (!text) return '';
            return text
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        // Foto do usuário
        const fotoUsuario = avaliacao.usuario.foto && avaliacao.usuario.foto !== '' && !avaliacao.usuario.foto.includes('default')
            ? `<img src="${avaliacao.usuario.foto}" alt="${escapeHtml(avaliacao.usuario.nome)}" class="modal-dep-foto" onerror="this.onerror=null;this.src='/backend/uploads/perfis/default.png';">`
            : `<div class="modal-dep-foto-placeholder">${avaliacao.usuario.iniciais || 'U'}</div>`;

        // Estrelas
        const estrelas = gerarEstrelas(avaliacao.nota);

        // Fotos da avaliação (se houver)
        let fotosHtml = '';
        if (avaliacao.fotos && avaliacao.fotos.length > 0) {
            fotosHtml = `
                <div class="modal-dep-fotos">
                    ${avaliacao.fotos.map(f => `<img src="${f}" alt="Foto da avaliação" class="modal-dep-foto-av">`).join('')}
                </div>
            `;
        }

        // Cria o modal
        const modal = document.createElement('div');
        modal.id = 'modalDepoimento';
        modal.className = 'modal-dep-overlay';
        modal.innerHTML = `
            <div class="modal-dep-content">
                <button class="modal-dep-close" aria-label="Fechar">&times;</button>

                <div class="modal-dep-header">
                    ${fotoUsuario}
                    <div class="modal-dep-info">
                        <h3 class="modal-dep-nome">${escapeHtml(avaliacao.usuario.nome)}</h3>
                        <div class="modal-dep-estrelas">${estrelas}</div>
                        <span class="modal-dep-data">
                            <i class="far fa-clock"></i> ${avaliacao.tempo_decorrido || avaliacao.data}
                        </span>
                    </div>
                </div>

                <div class="modal-dep-body">
                    <i class="fas fa-quote-left modal-dep-quote"></i>
                    <p class="modal-dep-comentario">${escapeHtml(avaliacao.comentario)}</p>
                    <i class="fas fa-quote-right modal-dep-quote right"></i>
                </div>

                ${fotosHtml}

                ${avaliacao.item ? `
                <div class="modal-dep-produto">
                    <i class="fas fa-book"></i>
                    <div>
                        <strong>${escapeHtml(avaliacao.item.titulo)}</strong>
                        ${avaliacao.item.autor ? `<span>${escapeHtml(avaliacao.item.autor)}</span>` : ''}
                    </div>
                </div>
                ` : ''}
            </div>
        `;

        document.body.appendChild(modal);

        // Animação de entrada
        requestAnimationFrame(() => modal.classList.add('active'));

        // Fechar ao clicar no X
        modal.querySelector('.modal-dep-close').addEventListener('click', () => fecharModalDepoimento());

        // Fechar ao clicar fora
        modal.addEventListener('click', (e) => {
            if (e.target === modal) fecharModalDepoimento();
        });

        // Fechar com Esc
        document.addEventListener('keydown', fecharComEsc);
    }

    /**
     * Fecha o modal de depoimento
     */
    function fecharModalDepoimento() {
        const modal = document.getElementById('modalDepoimento');
        if (modal) {
            modal.classList.remove('active');
            setTimeout(() => modal.remove(), 300);
        }
        document.removeEventListener('keydown', fecharComEsc);
        iniciarAutoplay();
    }

    /**
     * Handler para fechar modal com tecla Esc
     */
    function fecharComEsc(e) {
        if (e.key === 'Escape') fecharModalDepoimento();
    }

    /**
     * Injeta os estilos CSS do modal de avaliação
     */
    function injetarEstilosModal() {
        if (document.getElementById('estilos-modal-depoimento')) return;

        const style = document.createElement('style');
        style.id = 'estilos-modal-depoimento';
        style.textContent = `
            /* ========== MODAL DE DEPOIMENTO ========== */
            .modal-dep-overlay {
                position: fixed;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background: rgba(0,0,0,0.5);
                backdrop-filter: blur(4px);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                opacity: 0;
                transition: opacity 0.3s ease;
                padding: 20px;
            }
            .modal-dep-overlay.active {
                opacity: 1;
            }
            .modal-dep-content {
                background: #FFFDF9;
                border-radius: 20px;
                max-width: 520px;
                width: 100%;
                padding: 35px;
                position: relative;
                box-shadow: 0 20px 60px rgba(0,0,0,0.15);
                transform: translateY(20px) scale(0.95);
                transition: transform 0.3s ease;
                max-height: 90vh;
                overflow-y: auto;
            }
            .modal-dep-overlay.active .modal-dep-content {
                transform: translateY(0) scale(1);
            }
            .modal-dep-close {
                position: absolute;
                top: 15px; right: 20px;
                background: none;
                border: none;
                font-size: 28px;
                color: #999;
                cursor: pointer;
                line-height: 1;
                transition: color 0.2s;
            }
            .modal-dep-close:hover {
                color: #333;
            }
            .modal-dep-header {
                display: flex;
                align-items: center;
                gap: 15px;
                margin-bottom: 25px;
            }
            .modal-dep-foto {
                width: 65px; height: 65px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid #8B7355;
            }
            .modal-dep-foto-placeholder {
                width: 65px; height: 65px;
                border-radius: 50%;
                background: linear-gradient(135deg, #8B7355, #A08060);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                font-weight: 700;
                flex-shrink: 0;
            }
            .modal-dep-info {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }
            .modal-dep-nome {
                font-size: 18px;
                font-weight: 700;
                color: #3D3D3D;
                margin: 0;
            }
            .modal-dep-estrelas {
                color: #F5A623;
                font-size: 16px;
            }
            .modal-dep-data {
                font-size: 13px;
                color: #999;
            }
            .modal-dep-body {
                position: relative;
                padding: 20px 10px;
            }
            .modal-dep-quote {
                color: #8B7355;
                opacity: 0.2;
                font-size: 24px;
            }
            .modal-dep-quote.right {
                float: right;
            }
            .modal-dep-comentario {
                font-size: 16px;
                line-height: 1.8;
                color: #444;
                margin: 10px 0;
                font-style: italic;
            }
            .modal-dep-fotos {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid #EEE;
            }
            .modal-dep-foto-av {
                width: 100px; height: 100px;
                object-fit: cover;
                border-radius: 10px;
                border: 1px solid #DDD;
                cursor: pointer;
                transition: transform 0.2s;
            }
            .modal-dep-foto-av:hover {
                transform: scale(1.05);
            }
            .modal-dep-produto {
                display: flex;
                align-items: center;
                gap: 12px;
                background: #F5F0EA;
                padding: 15px 18px;
                border-radius: 12px;
                margin-top: 20px;
            }
            .modal-dep-produto i {
                color: #8B7355;
                font-size: 20px;
            }
            .modal-dep-produto strong {
                display: block;
                font-size: 14px;
                color: #3D3D3D;
            }
            .modal-dep-produto span {
                font-size: 12px;
                color: #888;
            }
            @media (max-width: 600px) {
                .modal-dep-content {
                    padding: 25px 20px;
                    border-radius: 15px;
                }
                .modal-dep-foto, .modal-dep-foto-placeholder {
                    width: 50px; height: 50px;
                    font-size: 18px;
                }
                .modal-dep-comentario {
                    font-size: 14px;
                }
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Gera HTML das estrelas
     */
    function gerarEstrelas(nota) {
        let html = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= nota) {
                html += '<i class="fas fa-star"></i>';
            } else {
                html += '<i class="far fa-star"></i>';
            }
        }
        return html;
    }

    /**
     * Atualiza classes dos cards para o slider
     */
    function atualizarSlider() {
        const cards = document.querySelectorAll('.depoimento-card');

        cards.forEach(card => {
            card.classList.remove('active', 'prev', 'next');
            const index = parseInt(card.getAttribute('data-index'));

            if (index === estadoSlider.indiceAtual) {
                card.classList.add('active');
            } else if (index === (estadoSlider.indiceAtual - 1 + estadoSlider.avaliacoes.length) % estadoSlider.avaliacoes.length) {
                card.classList.add('prev');
            } else if (index === (estadoSlider.indiceAtual + 1) % estadoSlider.avaliacoes.length) {
                card.classList.add('next');
            }
        });

        atualizarIndicadores();
    }

    /**
     * Cria os indicadores (bolinhas)
     */
    function criarIndicadores() {
        const container = document.getElementById('depoimentoIndicadores');
        if (!container) return;

        container.innerHTML = '';

        estadoSlider.avaliacoes.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.className = index === estadoSlider.indiceAtual ? 'depoimento-dot active' : 'depoimento-dot';
            dot.setAttribute('aria-label', `Ir para avaliação ${index + 1}`);
            dot.addEventListener('click', () => {
                irParaAvaliacao(index);
            });
            container.appendChild(dot);
        });
    }

    /**
     * Atualiza estado visual dos indicadores
     */
    function atualizarIndicadores() {
        const dots = document.querySelectorAll('.depoimento-dot');
        dots.forEach((dot, index) => {
            if (index === estadoSlider.indiceAtual) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    /**
     * Configura eventos de navegação
     */
    function configurarNavegacao() {
        const btnPrev = document.querySelector('.depoimento-nav-prev');
        const btnNext = document.querySelector('.depoimento-nav-next');
        const track = document.getElementById('depoimentoTrack');

        if (btnPrev) {
            btnPrev.addEventListener('click', () => {
                pararAutoplay();
                navegar(-1);
                iniciarAutoplay();
            });
        }

        if (btnNext) {
            btnNext.addEventListener('click', () => {
                pararAutoplay();
                navegar(1);
                iniciarAutoplay();
            });
        }

        // Pausa no hover
        if (track) {
            track.addEventListener('mouseenter', pararAutoplay);
            track.addEventListener('mouseleave', iniciarAutoplay);
        }
    }

    /**
     * Navega entre os slides
     */
    function navegar(direcao) {
        const total = estadoSlider.avaliacoes.length;
        if (total === 0) return;

        estadoSlider.indiceAtual = (estadoSlider.indiceAtual + direcao + total) % total;
        atualizarSlider();
    }

    /**
     * Vai para um slide específico
     */
    function irParaAvaliacao(index) {
        pararAutoplay();
        estadoSlider.indiceAtual = index;
        atualizarSlider();
        iniciarAutoplay();
    }

    /**
     * Inicia o autoplay
     */
    function iniciarAutoplay() {
        if (estadoSlider.autoplayInterval) clearInterval(estadoSlider.autoplayInterval);

        estadoSlider.autoplayInterval = setInterval(() => {
            navegar(1);
        }, 5000);
    }

    /**
     * Para o autoplay
     */
    function pararAutoplay() {
        if (estadoSlider.autoplayInterval) {
            clearInterval(estadoSlider.autoplayInterval);
            estadoSlider.autoplayInterval = null;
        }
    }

})(); // Fim da IIFE