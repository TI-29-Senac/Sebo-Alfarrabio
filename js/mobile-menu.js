/**
 * ========================================
 * MOBILE MENU - SEBO O ALFARRÁBIO
 * Controla o toggle do menu hambúrguer e sidebar
 * ========================================
 */

document.addEventListener('DOMContentLoaded', function () {

    // Elementos
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.mobile-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const closeSidebar = document.querySelector('.close-sidebar');

    // Verificar se os elementos existem
    if (!menuToggle || !sidebar || !overlay || !closeSidebar) {
        console.warn('Mobile menu: Um ou mais elementos não foram encontrados');
        return;
    }

    /**
     * Abre a sidebar mobile
     */
    function openSidebar() {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Previne scroll do body
    }

    /**
     * Fecha a sidebar mobile
     */
    function closeSidebarMenu() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = ''; // Restaura scroll do body
    }

    // Event Listeners

    // Abrir sidebar ao clicar no botão hambúrguer
    menuToggle.addEventListener('click', function (e) {
        e.stopPropagation();
        openSidebar();
    });

    // Fechar sidebar ao clicar no botão X
    closeSidebar.addEventListener('click', function () {
        closeSidebarMenu();
    });

    // Fechar sidebar ao clicar no overlay
    overlay.addEventListener('click', function () {
        closeSidebarMenu();
    });

    // Fechar sidebar ao pressionar ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar.classList.contains('active')) {
            closeSidebarMenu();
        }
    });

    // Fechar sidebar ao clicar em um link de navegação
    const sidebarLinks = sidebar.querySelectorAll('.sidebar-nav a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function () {
            // Pequeno delay para permitir a navegação antes de fechar
            setTimeout(closeSidebarMenu, 200);
        });
    });

    // Prevenir scroll do body quando sidebar está aberta
    sidebar.addEventListener('touchmove', function (e) {
        if (sidebar.classList.contains('active')) {
            e.stopPropagation();
        }
    }, { passive: true });

});
