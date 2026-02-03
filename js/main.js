document.addEventListener('DOMContentLoaded', function () {

    const servicosCards = document.querySelectorAll('.servicos .card');

    servicosCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.classList.add('is-flipped');
        });

        card.addEventListener('mouseleave', () => {
            card.classList.remove('is-flipped');
        });
    });


    const itensAnimados = document.querySelectorAll('.processos__item');

    if (itensAnimados.length > 0) {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        itensAnimados.forEach(item => {
            observer.observe(item);
        });
    }

    // ========================================
    // BUSCA HERO SECTION
    // ========================================
    const heroSearchInput = document.querySelector('.hero-search');

    if (heroSearchInput) {
        heroSearchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                const termo = heroSearchInput.value.trim();
                if (termo) {
                    // Redireciona para a página de produtos com o termo de busca
                    window.location.href = `produtos.html?busca=${encodeURIComponent(termo)}`;
                }
            }
        });
    }

});