/**
 * cookies.js
 * Gerencia o popup de consentimento de cookies e integração com Google Analytics.
 */

(function () {
    const COOKIE_NAME = 'sebo_cookies_accepted';

    function init() {
        const consent = localStorage.getItem(COOKIE_NAME);

        if (!consent) {
            renderPopup();
        } else if (consent === 'full') {
            loadAnalytics();
        }
    }

    function renderPopup() {
        const popup = document.createElement('div');
        popup.className = 'cookie-consent';
        popup.innerHTML = `
            <div class="cookie-content">
                <div class="cookie-icon"><i class="fas fa-cookie-bite"></i></div>
                <div class="cookie-text">
                    <h3>Valorizamos sua privacidade</h3>
                    <p>
                        Usamos cookies para melhorar sua experiência e analisar o tráfego do site. 
                        Ao clicar em "Aceitar todos", você concorda com o uso de cookies conforme nossa 
                        <a href="politica-de-privacidade.html">Política de Privacidade</a>.
                    </p>
                </div>
            </div>
            <div class="cookie-actions">
                <button class="cookie-btn cookie-btn-minimal" id="cookieReject">Apenas essenciais</button>
                <button class="cookie-btn cookie-btn-accept" id="cookieAccept">Aceitar todos</button>
            </div>
        `;

        document.body.appendChild(popup);

        // Animação de entrada
        setTimeout(() => popup.classList.add('active'), 500);

        // Eventos
        document.getElementById('cookieAccept').addEventListener('click', () => handleConsent('full'));
        document.getElementById('cookieReject').addEventListener('click', () => handleConsent('essential'));
    }

    function handleConsent(type) {
        localStorage.setItem(COOKIE_NAME, type);
        const popup = document.querySelector('.cookie-consent');
        if (popup) {
            popup.classList.remove('active');
            setTimeout(() => popup.remove(), 500);
        }

        if (type === 'full') {
            loadAnalytics();
        }
    }

    function loadAnalytics() {
        console.log('📊 Google Analytics carregado com sucesso!');
        // Aqui o usuário pode inserir o código do GA4 no futuro
        /*
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-XXXXXXXXXX');
        */
    }

    // Inicializa quando o DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
