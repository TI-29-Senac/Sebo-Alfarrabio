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
        url: '/backend/api_avaliacoes_direct.php', // Endpoint direto para evitar problemas de rota
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

        return card;
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