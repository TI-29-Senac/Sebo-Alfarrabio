/**
 * ========================================
 * ANIMAÇÃO DE BURACO NEGRO - HERO SECTION
 * ========================================
 * 
 * Este script cria o efeito de letras sendo puxadas
 * para o centro (livro) como um buraco negro
 */

(function () {
  'use strict';

  // Configurações
  const CONFIG = {
    letterSpawnInterval: 150,      // Intervalo entre criação de letras (ms)
    maxLetters: 40,                 // Máximo de letras simultâneas
    minDuration: 2000,              // Duração mínima da animação (ms)
    maxDuration: 4000,              // Duração máxima da animação (ms)
  };

  // Caracteres que serão usados (alfabeto + números)
  const CHARACTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'.split('')
  ;

  // Variáveis de controle
  let animationContainer;
  let intervalId;
  let activeLetters = 0;

  /**
   * Inicializa a animação quando o DOM estiver pronto
   */
  function init() {
    animationContainer = document.getElementById('lettersAnimation');

    if (!animationContainer) {
      console.warn('Container de animação não encontrado');
      return;
    }

    // Inicia geração de letras
    startAnimation();

    // Pausa quando a página não está visível (performance)
    document.addEventListener('visibilitychange', handleVisibilityChange);
  }

  /**
   * Inicia a geração contínua de letras
   */
  function startAnimation() {
    intervalId = setInterval(() => {
      if (activeLetters < CONFIG.maxLetters) {
        createFlyingLetter();
      }
    }, CONFIG.letterSpawnInterval);
  }

  /**
   * Para a animação
   */
  function stopAnimation() {
    if (intervalId) {
      clearInterval(intervalId);
      intervalId = null;
    }
  }

  /**
   * Pausa/retoma animação baseado na visibilidade da página
   */
  function handleVisibilityChange() {
    if (document.hidden) {
      stopAnimation();
    } else {
      startAnimation();
    }
  }

  /**
   * Cria uma letra voadora em posição aleatória
   */
  function createFlyingLetter() {
    const letter = document.createElement('div');
    letter.className = 'flying-letter';
    letter.textContent = getRandomCharacter();

    // Posição inicial aleatória nas bordas
    const startPosition = getRandomEdgePosition();
    letter.style.left = startPosition.x + 'px';
    letter.style.top = startPosition.y + 'px';

    // Calcula centro do container
    const containerRect = animationContainer.getBoundingClientRect();
    const centerX = containerRect.width / 2;
    const centerY = containerRect.height / 2;

    // Calcula distância para o centro
    const dx = centerX - startPosition.x;
    const dy = centerY - startPosition.y;

    // Define variáveis CSS personalizadas para animação
    const duration = getRandomDuration();
    const rotation = Math.random() * 720 - 360; // Rotação aleatória

    letter.style.setProperty('--dx', dx + 'px');
    letter.style.setProperty('--dy', dy + 'px');
    letter.style.setProperty('--duration', duration + 'ms');
    letter.style.setProperty('--rotation', rotation + 'deg');

    // Adiciona ao DOM
    animationContainer.appendChild(letter);
    activeLetters++;

    // Remove após animação completar
    setTimeout(() => {
      letter.remove();
      activeLetters--;
    }, duration);
  }

  /**
   * Retorna um caractere aleatório
   */
  function getRandomCharacter() {
    return CHARACTERS[Math.floor(Math.random() * CHARACTERS.length)];
  }

  /**
   * Gera posição aleatória nas bordas do container
   */
  function getRandomEdgePosition() {
    const containerRect = animationContainer.getBoundingClientRect();
    const side = Math.floor(Math.random() * 4); // 0=top, 1=right, 2=bottom, 3=left

    let x, y;

    switch (side) {
      case 0: // Top
        x = Math.random() * containerRect.width;
        y = 0;
        break;
      case 1: // Right
        x = containerRect.width;
        y = Math.random() * containerRect.height;
        break;
      case 2: // Bottom
        x = Math.random() * containerRect.width;
        y = containerRect.height;
        break;
      case 3: // Left
        x = 0;
        y = Math.random() * containerRect.height;
        break;
    }

    return { x, y };
  }

  /**
   * Retorna duração aleatória para a animação
   */
  function getRandomDuration() {
    return CONFIG.minDuration + Math.random() * (CONFIG.maxDuration - CONFIG.minDuration);
  }

  // Inicializa quando o DOM estiver pronto
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // Cleanup ao sair da página
  window.addEventListener('beforeunload', stopAnimation);
})();
