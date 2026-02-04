// novidades.js - Carrega os últimos livros cadastrados

document.addEventListener('DOMContentLoaded', function () {
    carregarNovidades();
});

async function carregarNovidades() {
    const container = document.querySelector('.card-livros');

    // Mostra loading
    container.innerHTML = `
        <div style="width: 100%; text-align: center; padding: 40px; color: #a87e4b;">
            <i class="fas fa-spinner fa-spin" style="font-size: 2rem;"></i>
            <p style="margin-top: 10px;">Carregando novidades...</p>
        </div>
    `;

    try {
        const response = await fetch('/backend/index.php/api/item');
        const data = await response.json();

        if (data.status === 'success' && data.data) {
            // Filtra apenas livros e pega os 5 mais recentes
            const livros = data.data
                .filter(item => item.tipo_item === 'Livro')
                .slice(0, 5);

            if (livros.length === 0) {
                container.innerHTML = `
                    <div style="width: 100%; text-align: center; padding: 40px; color: #a87e4b;">
                        <p>Nenhum livro cadastrado ainda.</p>
                    </div>
                `;
                return;
            }

            // Renderiza os cards
            container.innerHTML = livros.map(livro => criarCardLivro(livro)).join('');
        } else {
            mostrarErro(container);
        }
    } catch (error) {
        console.error('Erro ao carregar novidades:', error);
        mostrarErro(container);
    }
}

function criarCardLivro(livro) {
    // Extrai apenas o primeiro nome do autor se houver vários
    const primeiroAutor = livro.autores
        ? livro.autores.split(',')[0].trim()
        : 'Autor Desconhecido';

    // Formata o título (limita a 50 caracteres)
    const tituloFormatado = livro.titulo_item.length > 50
        ? livro.titulo_item.substring(0, 47) + '...'
        : livro.titulo_item;

    // Define imagem padrão se não houver
    const imagemUrl = livro.caminho_imagem || '/img/sem-imagem.png';

    return `
        <div class="card-livro">
            <figure>
                <img src="${imagemUrl}" 
                     alt="${livro.titulo_item}" 
                     onerror="this.src='/img/sem-imagem.png'">
                <figcaption class="figcaption-livro">
                    <h2 class="name">${tituloFormatado}</h2>
                    <small>${primeiroAutor}</small>
                </figcaption>
            </figure>
            <a href="produto-detalhe.html?id=${livro.id_item}">
                <p class="saiba-mais">Saiba Mais</p>
            </a>
        </div>
    `;
}

function mostrarErro(container) {
    container.innerHTML = `
        <div style="width: 100%; text-align: center; padding: 40px; color: #a87e4b;">
            <i class="fas fa-exclamation-circle" style="font-size: 2rem;"></i>
            <p style="margin-top: 10px;">Erro ao carregar os livros. Tente novamente mais tarde.</p>
        </div>
    `;
}