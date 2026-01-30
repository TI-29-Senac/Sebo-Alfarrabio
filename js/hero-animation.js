/**
 * HERO ANIMATION - LETRAS SENDO PUXADAS PARA O LIVRO
 * 
 * Este script cria uma animação onde letras aleatórias são geradas
 * nas bordas da tela e puxadas para o centro (livro) como um buraco negro
 */

(function () {
  'use strict';

  // Configurações da animação
  const CONFIG = {
    letterCount: 80,              // Número de letras simultâneas na tela
    spawnInterval: 150,            // Intervalo entre criação de novas letras (ms)
    minDuration: 5000,             // Duração mínima da animação (ms)
    maxDuration: 10000,            // Duração máxima da animação (ms)
    minSize: 20,                   // Tamanho mínimo da fonte (px)
    maxSize: 45,                   // Tamanho máximo da fonte (px)
    edgeMargin: 50,                // Margem das bordas (px)
  };

  // Caracteres que serão animados (letras, números e símbolos relacionados a livros)
  const CHARACTERS =
    'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' +
    '📚📖📕📗📘📙📔📓📒' + // Emojis de livros
    '✨💫⭐🌟🌠' +           // Emojis de brilho
    '🖊️✒️📝🧠💡🕯️☕' +    // Emojis de leitura/escrita
    '♦♥♠♣';               // Símbolos de texto

  // Cache de elementos
  let lettersContainer = null;
  let bookCenter = null;
  let isAnimating = false;
  let animationInterval = null;

  /**
   * Inicializa a animação quando o DOM estiver pronto
   */
  function init() {
    // Aguarda o DOM carregar
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', init);
      return;
    }

    // Busca elementos necessários
    lettersContainer = document.getElementById('lettersAnimation');
    bookCenter = document.querySelector('.book-center');

    if (!lettersContainer || !bookCenter) {
      console.warn('Hero animation: elementos necessários não encontrados');
      return;
    }

    // Inicia a animação
    startAnimation();

    // Anima o texto do hero
    animateHeroText();

    // Para a animação se a janela perder o foco (otimização de performance)
    document.addEventListener('visibilitychange', handleVisibilityChange);
  }

  /**
   * Anima o texto do hero com efeito de digitação (typewriter)
   */
  function animateHeroText() {
    const heroText = document.querySelector('.hero-text');
    if (!heroText) return;

    // Pega o texto original
    const originalText = heroText.textContent;

    // Limpa o conteúdo e mostra o container
    heroText.textContent = '';
    heroText.style.opacity = '1';

    let currentIndex = 0;
    const typingSpeed = 50; // Velocidade de digitação em ms

    // Função de digitação
    function typeNextLetter() {
      if (currentIndex < originalText.length) {
        heroText.textContent += originalText[currentIndex];
        currentIndex++;
        setTimeout(typeNextLetter, typingSpeed);
      } else {
        // Adiciona classe quando terminar de digitar
        heroText.classList.add('typing-complete');
      }
    }

    // Aguarda um pouco antes de começar a digitar
    setTimeout(typeNextLetter, 500);
  }

  /**
   * Inicia a geração contínua de letras
   */
  function startAnimation() {
    if (isAnimating) return;

    isAnimating = true;

    // Cria letras iniciais
    for (let i = 0; i < 30; i++) {
      setTimeout(() => createFloatingLetter(), i * 100);
    }

    // Continua criando letras em intervalo
    animationInterval = setInterval(createFloatingLetter, CONFIG.spawnInterval);
  }

  /**
   * Para a animação
   */
  function stopAnimation() {
    if (!isAnimating) return;

    isAnimating = false;
    if (animationInterval) {
      clearInterval(animationInterval);
      animationInterval = null;
    }
  }

  /**
   * Cria uma nova letra flutuante
   */
  function createFloatingLetter() {
    if (!lettersContainer || !bookCenter) return;

    // Limita o número de letras na tela
    const currentLetters = lettersContainer.children.length;
    if (currentLetters > CONFIG.letterCount) {
      return;
    }

    // Cria o elemento da letra
    const letter = document.createElement('div');
    letter.className = 'letter';  // Alterado para corresponder ao CSS
    letter.textContent = getRandomCharacter();

    // Define propriedades aleatórias
    const props = generateLetterProperties();

    // Aplica estilos iniciais
    Object.assign(letter.style, {
      left: props.startX + 'px',
      top: props.startY + 'px',
      fontSize: props.size + 'px',
      opacity: props.opacity,
    });

    // Adiciona ao container
    lettersContainer.appendChild(letter);

    // Anima a letra para o centro usando requestAnimationFrame
    animateLetterToCenter(letter, props);
  }

  /**
   * Anima uma letra em direção ao centro com efeito de buraco negro
   */
  function animateLetterToCenter(letter, props) {
    const startTime = Date.now();
    let x = props.startX;
    let y = props.startY;
    let vx = 0;
    let vy = 0;

    function animate() {
      const elapsed = Date.now() - startTime;

      // Remove a letra se passou do tempo máximo
      if (elapsed > props.duration) {
        if (letter.parentNode) {
          letter.remove();
        }
        return;
      }

      // Calcula a posição do centro
      const bookRect = bookCenter.getBoundingClientRect();
      const centerX = bookRect.left + bookRect.width / 2;
      const centerY = bookRect.top + bookRect.height / 2;

      // Calcula vetor de direção para o centro
      const dx = centerX - x;
      const dy = centerY - y;
      const distance = Math.sqrt(dx * dx + dy * dy);

      // Se chegou muito perto do centro, remove a letra
      if (distance < 60) {
        if (letter.parentNode) {
          letter.remove();
        }
        return;
      }

      // Aplica força de atração (aumenta quanto mais próximo)
      const force = 0.0008 * (1 + (300 / (distance + 1)));
      vx += (dx / distance) * force * 100;
      vy += (dy / distance) * force * 100;

      // Atualiza posição
      x += vx;
      y += vy;

      // Atualiza opacidade e escala baseado na distância
      const opacity = Math.min(1, distance / 300);
      const scale = Math.max(0.2, Math.min(1, distance / 200));

      // Aplica transformações
      letter.style.left = x + 'px';
      letter.style.top = y + 'px';
      letter.style.opacity = opacity;
      letter.style.transform = `scale(${scale})`;

      // Continua a animação
      requestAnimationFrame(animate);
    }

    // Inicia a animação
    requestAnimationFrame(animate);
  }

  /**
   * Gera propriedades aleatórias para uma letra
   */
  function generateLetterProperties() {
    const viewportWidth = window.innerWidth;
    const viewportHeight = window.innerHeight;

    // Posição do livro (centro)
    const bookRect = bookCenter.getBoundingClientRect();
    const centerX = bookRect.left + bookRect.width / 2;
    const centerY = bookRect.top + bookRect.height / 2;

    // Decide de qual borda a letra virá
    const edge = Math.floor(Math.random() * 4); // 0=top, 1=right, 2=bottom, 3=left
    let startX, startY;

    switch (edge) {
      case 0: // top
        startX = Math.random() * viewportWidth;
        startY = -CONFIG.edgeMargin;
        break;
      case 1: // right
        startX = viewportWidth + CONFIG.edgeMargin;
        startY = Math.random() * viewportHeight;
        break;
      case 2: // bottom
        startX = Math.random() * viewportWidth;
        startY = viewportHeight + CONFIG.edgeMargin;
        break;
      case 3: // left
        startX = -CONFIG.edgeMargin;
        startY = Math.random() * viewportHeight;
        break;
    }

    // Calcula o vetor para o centro
    const targetX = centerX - startX;
    const targetY = centerY - startY;

    return {
      startX,
      startY,
      targetX,
      targetY,
      size: CONFIG.minSize + Math.random() * (CONFIG.maxSize - CONFIG.minSize),
      duration: CONFIG.minDuration + Math.random() * (CONFIG.maxDuration - CONFIG.minDuration),
      opacity: 0.5 + Math.random() * 0.4,
    };
  }

  /**
   * Retorna um caractere aleatório
   */
  function getRandomCharacter() {
    const charsArray = [...CHARACTERS];
    return charsArray[Math.floor(Math.random() * charsArray.length)];
  }

  /**
   * Lida com mudança de visibilidade da página
   */
  function handleVisibilityChange() {
    if (document.hidden) {
      stopAnimation();
    } else {
      startAnimation();
    }
  }

  // Inicia quando o script carregar
  init();

})();