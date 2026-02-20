/**
 * Melhoria de UX para filtros de gênero na Home
 * Se já estiver na página de produtos, aplica filtro sem reload
 */
document.addEventListener('DOMContentLoaded', function () {
    const linksFiltro = document.querySelectorAll('.filtro-genero');

    linksFiltro.forEach(link => {
        link.addEventListener('click', function (e) {
            // Se já estiver na página de produtos, previne o reload e filtra
            if (window.location.pathname.includes('produtos.html')) {
                e.preventDefault();
                const genero = this.getAttribute('data-genero');

                // Seleciona o gênero no select e aplica o filtro
                const generoSelect = document.getElementById('genero-select');
                if (generoSelect && typeof aplicarFiltros === 'function') {
                    generoSelect.value = genero;
                    aplicarFiltros();

                    // Scroll suave até os produtos
                    const produtosSection = document.getElementById('produtos-grid');
                    if (produtosSection) {
                        produtosSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            }
            // Se não estiver na página de produtos, deixa o link redirecionar normalmente
        });
    });
});
