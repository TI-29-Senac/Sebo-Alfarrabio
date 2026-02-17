/**
 * THEME TOGGLE - Sebo & Livraria O Alfarrábio
 * Alterna entre modo claro e escuro.
 * - Modo Claro: logo2.webp (fundo claro)
 * - Modo Escuro: logo.webp (fundo escuro)
 * Persiste a preferência via localStorage.
 */
(function () {
    'use strict';

    const STORAGE_KEY = 'sebo-alfarrabio-theme';
    const LIGHT_LOGO = 'img/logo2.webp';
    const DARK_LOGO = 'img/logo.webp';

    /**
     * Detecta a preferência do sistema operacional
     */
    function getSystemPreference() {
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        return 'light';
    }

    /**
     * Retorna o tema salvo ou a preferência do sistema
     */
    function getSavedTheme() {
        const saved = localStorage.getItem(STORAGE_KEY);
        return saved || getSystemPreference();
    }

    /**
     * Troca todas as logos do site
     */
    function swapLogos(theme) {
        const logoSrc = theme === 'dark' ? DARK_LOGO : LIGHT_LOGO;
        const selectors = [
            'header .logo',
            '.sidebar-logo',
            '.logo-footer'
        ];

        selectors.forEach(function (selector) {
            const imgs = document.querySelectorAll(selector);
            imgs.forEach(function (img) {
                if (img && img.tagName === 'IMG') {
                    img.src = logoSrc;
                }
            });
        });
    }

    /**
     * Aplica o tema no documento
     */
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        swapLogos(theme);
        updateToggleButton(theme);
    }

    /**
     * Atualiza o ícone e tooltip do botão
     */
    function updateToggleButton(theme) {
        var btn = document.querySelector('.theme-toggle-btn');
        if (!btn) return;

        var icon = btn.querySelector('.toggle-icon');
        if (icon) {
            icon.textContent = theme === 'dark' ? '☀️' : '🌙';
        }

        btn.setAttribute('data-tooltip',
            theme === 'dark' ? 'Modo Claro' : 'Modo Escuro'
        );
        btn.setAttribute('aria-label',
            theme === 'dark' ? 'Ativar modo claro' : 'Ativar modo escuro'
        );
    }

    /**
     * Cria e insere o botão toggle no DOM
     */
    function createToggleButton() {
        var btn = document.createElement('button');
        btn.className = 'theme-toggle-btn';
        btn.id = 'theme-toggle';
        btn.setAttribute('aria-label', 'Alternar tema');

        var icon = document.createElement('span');
        icon.className = 'toggle-icon';
        btn.appendChild(icon);

        btn.addEventListener('click', function () {
            var currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            var newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            // Animação de rotação
            btn.classList.add('animating');

            setTimeout(function () {
                applyTheme(newTheme);
                localStorage.setItem(STORAGE_KEY, newTheme);

                btn.classList.remove('animating');
            }, 250);
        });

        document.body.appendChild(btn);

        // Pulso de atenção na primeira visita
        if (!localStorage.getItem(STORAGE_KEY)) {
            btn.classList.add('pulse');
            setTimeout(function () {
                btn.classList.remove('pulse');
            }, 6000);
        }

        return btn;
    }

    /**
     * Inicialização
     */
    // Aplicar tema imediatamente (antes do DOM) para evitar flash
    var savedTheme = getSavedTheme();
    document.documentElement.setAttribute('data-theme', savedTheme);

    // Quando o DOM estiver pronto, criar o botão e trocar logos
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            createToggleButton();
            applyTheme(savedTheme);
        });
    } else {
        createToggleButton();
        applyTheme(savedTheme);
    }

    // Ouvir mudanças de preferência do sistema
    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function (e) {
            // Só aplica se o usuário não tiver salvo uma preferência manual
            if (!localStorage.getItem(STORAGE_KEY)) {
                var theme = e.matches ? 'dark' : 'light';
                applyTheme(theme);
            }
        });
    }
})();
