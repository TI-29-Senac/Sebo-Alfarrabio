/**
 * auth-header.js
 * Gerencia a exibição do header autenticado em todas as páginas
 */

document.addEventListener('DOMContentLoaded', async function() {
    console.log('Verificando autenticação...');
    
    try {
        const response = await fetch('/backend/api/check_session.php');
        const data = await response.json();
        
        if (data.authenticated) {
            setupAuthenticatedUser(data.user);
        } else {
            setupGuestUser();
        }
    } catch (error) {
        console.error('Erro ao verificar sessão:', error);
        setupGuestUser();
    }
});

function setupAuthenticatedUser(user) {
    console.log('Usuário logado:', user.name);
    
    const profileContainer = document.querySelector('.user-profile-header');
    const profileBtn = document.querySelector('.profile-btn-header');
    const profileDropdown = document.querySelector('.profile-dropdown-header');
    const cadastroBtn = document.querySelector('.btn-cadastro');

    if (!profileContainer || !profileBtn) return;

    // 1. Atualizar Avatar
    if (user.avatar && user.avatar !== '/img/avatar_placeholder.png') {
        profileBtn.innerHTML = `<img src="${user.avatar}" alt="${user.name}" class="header-avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #8B7355;">`;
    } else {
        // Avatar padrão mas estilizado indicando logado
        profileBtn.innerHTML = `<i class="fas fa-user-circle" style="color: #8B7355; font-size: 32px;"></i>`;
    }

    // 2. Definir link do Painel baseado na Role
    const painelLink = user.role === 'Cliente' 
        ? '/backend/admin/cliente' 
        : '/backend/admin/dashboard';
    
    // 3. Atualizar Dropdown
    profileDropdown.innerHTML = `
        <div style="padding: 10px 15px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 5px;">
            <strong style="display:block; color:#fff;">${user.name}</strong>
            <small style="color:#ccc;">${user.role}</small>
        </div>
        <a href="${painelLink}"><i class="fas fa-tachometer-alt"></i> Meu Painel</a>
        ${user.role === 'Cliente' ? `<a href="/backend/admin/cliente/pedidos"><i class="fas fa-shopping-bag"></i> Meus Pedidos</a>` : ''}
        ${user.role === 'Cliente' ? `<a href="/backend/admin/cliente/avaliacoes"><i class="fas fa-star"></i> Minhas Avaliações</a>` : ''}
        <a href="/backend/admin/cliente/configuracoes"><i class="fas fa-cog"></i> Configurações</a>
        <hr>
        <a href="/backend/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a>
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
    profileBtn.onclick = function() {
        window.location.href = '/backend/login';
    };

    // Remove dropdown antigo para evitar confusão
    if (profileDropdown) {
        profileDropdown.remove();
    }
}

function setupDropdownBehavior(btn, dropdown) {
    btn.onclick = function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('active');
    };

    // Fechar ao clicar fora
    document.addEventListener('click', function(e) {
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });
}
