// ========================================
// ANIMAÇÃO DE LETRAS FLUTUANTES - SEÇÃO DE LIVROS
// ========================================

class BooksLettersAnimation {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;

        this.ctx = this.canvas.getContext('2d');
        this.letters = [];
        this.maxLetters = 40; // Quantidade de letras

        // Frases literárias para as letras
        this.literaryQuotes = [
            "Descubra Novos Mundos",
            "A leitura é uma porta para o infinito",
            "Cada livro é uma aventura",
            "Histórias que transformam vidas",
            "O conhecimento liberta"
        ];

        this.allChars = this.literaryQuotes.join('').split('').filter(c => c.trim());

        this.init();
        this.animate();

        // Redimensionar canvas quando a janela mudar
        window.addEventListener('resize', () => this.init());
    }

    init() {
        this.canvas.width = this.canvas.offsetWidth;
        this.canvas.height = this.canvas.offsetHeight;

        // Criar letras iniciais
        this.letters = [];
        for (let i = 0; i < this.maxLetters; i++) {
            this.letters.push(this.createLetter());
        }
    }

    createLetter() {
        const char = this.allChars[Math.floor(Math.random() * this.allChars.length)];

        return {
            char: char,
            x: Math.random() * this.canvas.width,
            y: Math.random() * this.canvas.height,
            size: Math.random() * 20 + 15, // 15-35px
            speedX: (Math.random() - 0.5) * 0.5,
            speedY: Math.random() * 0.3 + 0.1,
            opacity: Math.random() * 0.4 + 0.2, // 0.2-0.6
            rotation: Math.random() * Math.PI * 2,
            rotationSpeed: (Math.random() - 0.5) * 0.02,
            color: this.getRandomColor()
        };
    }

    getRandomColor() {
        // Cores do banner hero
        const colors = [
            '#bb840dff', // Bege claro
            '#c77919ff', // Bege médio  
            '#b89968', // Dourado
            '#c59767ff', // Creme
            '#c9a961'  // Ouro velho
        ];
        return colors[Math.floor(Math.random() * colors.length)];
    }

    updateLetter(letter) {
        // Movimento
        letter.x += letter.speedX;
        letter.y += letter.speedY;
        letter.rotation += letter.rotationSpeed;

        // Reposicionar se sair da tela
        if (letter.y > this.canvas.height + 50) {
            letter.y = -50;
            letter.x = Math.random() * this.canvas.width;
        }
        if (letter.x < -50) {
            letter.x = this.canvas.width + 50;
        }
        if (letter.x > this.canvas.width + 50) {
            letter.x = -50;
        }
    }

    drawLetter(letter) {
        this.ctx.save();

        // Translação e rotação
        this.ctx.translate(letter.x, letter.y);
        this.ctx.rotate(letter.rotation);

        // Estilo
        this.ctx.font = `${letter.size}px Merriweather, serif`;
        this.ctx.fillStyle = letter.color;
        this.ctx.globalAlpha = letter.opacity;
        this.ctx.textAlign = 'center';
        this.ctx.textBaseline = 'middle';

        // Sombra suave
        this.ctx.shadowColor = 'rgba(0, 0, 0, 0.3)';
        this.ctx.shadowBlur = 5;
        this.ctx.shadowOffsetX = 2;
        this.ctx.shadowOffsetY = 2;

        // Desenhar letra
        this.ctx.fillText(letter.char, 0, 0);

        this.ctx.restore();
    }

    animate() {
        // Limpar canvas
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Atualizar e desenhar cada letra
        this.letters.forEach(letter => {
            this.updateLetter(letter);
            this.drawLetter(letter);
        });

        // Continuar animação
        requestAnimationFrame(() => this.animate());
    }
}

// ========================================
// ANIMAÇÃO DE ONDA PARA O TÍTULO
// ========================================

function initBooksHeaderWave() {
    const booksHeader = document.querySelector('.books-header h2');
    if (!booksHeader) return;

    // Salvar o texto original
    const originalText = booksHeader.textContent;

    // Dividir em caracteres individuais
    const chars = originalText.split('');
    booksHeader.innerHTML = '';

    // Criar spans para cada caractere
    chars.forEach((char, index) => {
        const span = document.createElement('span');
        span.className = 'book-char';
        span.textContent = char;
        span.style.setProperty('--char-index', index);

        // Delay para animação de entrada
        span.style.animationDelay = `${index * 0.05}s`;

        booksHeader.appendChild(span);
    });

    // Após a animação de entrada, ativar a onda
    setTimeout(() => {
        booksHeader.classList.add('wave-active');
    }, chars.length * 50 + 500); // Aguarda a entrada completar
}

// ========================================
// INICIALIZAÇÃO
// ========================================

document.addEventListener('DOMContentLoaded', function () {
    // Iniciar animação de letras na seção de livros
    const booksAnimation = new BooksLettersAnimation('books-letters-canvas');

    // Iniciar animação de onda no título
    initBooksHeaderWave();
});
