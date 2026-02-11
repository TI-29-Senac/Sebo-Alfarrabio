/**
 * auth-header.js
 * Gerencia a exibição do header autenticado em todas as páginas
 */

document.addEventListener('DOMContentLoaded', async function () {
    console.log('Verificando autenticação...');

    // Globais para outros scripts usarem
    window.isAuthenticated = false;
    window.currentUser = null;

    try {
        const response = await fetch('/backend/api/auth/session');
        const data = await response.json();

        if (data.authenticated) {
            window.isAuthenticated = true;
            window.currentUser = data.user;
            setupAuthenticatedUser(data.user);
        } else {
            setupGuestUser();
        }
    } catch (error) {
        console.error('Erro ao verificar sessão:', error);
        setupGuestUser();
    } finally {
        // Notificar outros scripts que o status de auth foi verificado
        document.dispatchEvent(new CustomEvent('authChecked', {
            detail: { authenticated: window.isAuthenticated, user: window.currentUser }
        }));
    }
});

/**
 * Configura a interface para um usuário autenticado.
 * Atualiza avatar, dropdown e links de navegação.
 * @param {Object} user - Objeto com dados do usuário (name, avatar, role).
 */
function setupAuthenticatedUser(user) {
    console.log('Usuário logado:', user.name);

    const profileContainer = document.querySelector('.user-profile-header');
    const profileBtn = document.querySelector('.profile-btn-header');
    const profileDropdown = document.querySelector('.profile-dropdown-header');
    const cadastroBtn = document.querySelector('.btn-cadastro');

    if (!profileContainer || !profileBtn) return;

    // 1. Atualizar apenas o Avatar no botão
    if (user.avatar && user.avatar !== '/img/avatar_placeholder.png') {
        profileBtn.innerHTML = `<img src="${user.avatar}" alt="${user.name}" class="header-avatar">`;
    } else {
        profileBtn.innerHTML = `<i class="fas fa-user-circle"></i>`;
    }

    // Resetar estilos do botão para ser circular
    profileBtn.style.width = '50px';
    profileBtn.style.height = '50px';
    profileBtn.style.padding = '0';
    profileBtn.style.borderRadius = '50%';

    // 2. Definir link do Painel baseado na Role
    const painelLink = user.role === 'Cliente'
        ? '/backend/admin/cliente'
        : '/backend/admin/dashboard';

    // 3. Atualizar Dropdown com o Nome em destaque (onde ficaria o rótulo de tipo/cliente)
    profileDropdown.innerHTML = `
        <div style="padding: 15px 20px; border-bottom: 1px solid rgba(189, 144, 86, 0.1); background: rgba(252, 246, 233, 0.3);">
            <span style="display:block; color:#999; font-size: 0.8rem; margin-bottom: 4px;">Logado como:</span>
            <strong style="display:block; color:#694100; font-size: 1.1rem; font-family: 'Merriweather', serif;">${user.name}</strong>
        </div>
        <a href="${painelLink}"><i class="fas fa-tachometer-alt"></i> Meu Painel</a>
        ${user.role === 'Cliente' ? `<a href="/backend/admin/cliente/reservas"><i class="fas fa-shopping-bag"></i> Minhas Reservas</a>` : ''}
        ${user.role === 'Cliente' ? `<a href="/backend/admin/cliente/avaliacoes"><i class="fas fa-star"></i> Minhas Avaliações</a>` : ''}
        <a href="/backend/admin/cliente/configuracoes"><i class="fas fa-cog"></i> Configurações</a>
        <hr>
        <a href="/backend/logout"><i class="fas fa-sign-out-alt"></i> Sair</a>
    `;

    // 4. Mostrar o dropdownContainer (caso estivesse oculto)
    profileContainer.style.display = 'block';

    // 5. Atualizar botão de cadastro do menu secundário (se existir)
    if (cadastroBtn) {
        cadastroBtn.textContent = 'Minha Conta';
        cadastroBtn.href = painelLink;
    }

    // Event Listeners para abrir/fechar dropdown
    setupDropdownBehavior(profileBtn, profileDropdown);
}

/**
 * Configura a interface para um visitante (não autenticado).
 * Mostra botão de login e remove elementos de usuário logado.
 */
function setupGuestUser() {
    console.log('Visitante (não logado)');
    const profileContainer = document.querySelector('.user-profile-header');
    const profileBtn = document.querySelector('.profile-btn-header');
    const profileDropdown = document.querySelector('.profile-dropdown-header');

    if (!profileContainer) return;

    // Ícone padrão de visitante
    profileBtn.innerHTML = `<i class="far fa-user" style="font-size: 24px;"></i>`;
    profileBtn.style.display = 'flex';
    profileBtn.style.alignItems = 'center';
    profileBtn.style.background = 'none';
    profileBtn.style.border = '1px solid #8B7355';
    profileBtn.style.padding = '8px 15px';
    profileBtn.style.borderRadius = '50px';
    profileBtn.style.cursor = 'pointer';
    profileBtn.style.color = '#8B7355';

    // Ao clicar em Entrar, vai pro login direto (sem dropdown) ou abre dropdown simplificado
    // Solução: Botão leva direto pro login
    profileBtn.onclick = function () {
        window.location.href = '/backend/login';
    };

    // Remove dropdown antigo para evitar confusão
    if (profileDropdown) {
        profileDropdown.remove();
    }
}

/**
 * Configura o comportamento do dropdown de perfil.
 * Gerencia cliques no botão e fechamento ao clicar fora.
 * @param {HTMLElement} btn - Botão que aciona o dropdown.
 * @param {HTMLElement} dropdown - Elemento do dropdown.
 */
function setupDropdownBehavior(btn, dropdown) {
    btn.onclick = function (e) {
        e.stopPropagation();
        dropdown.classList.toggle('active');
    };

    // Fechar ao clicar fora
    document.addEventListener('click', function (e) {
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });
}
