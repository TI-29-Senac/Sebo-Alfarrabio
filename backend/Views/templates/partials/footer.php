</div>
<!-- FIM da div w3-main que foi aberta no header -->

<!-- Footer Responsivo -->
<style>
    .dashboard-footer-main {
        margin-left: 300px;
        background: linear-gradient(135deg, #f5f5f0 0%, #faf8f3 100%);
        border-top: 3px solid #D4B896;
        padding: 30px 20px;
        transition: margin-left 0.3s ease;
    }

    @media (max-width: 993px) {
        .dashboard-footer-main {
            margin-left: 0;
        }
    }

    @media (max-width: 480px) {
        .dashboard-footer-main {
            padding: 20px 12px;
        }
    }

    /* Tema Escuro */
    [data-theme="dark"] .dashboard-footer-main {
        background: linear-gradient(135deg, #221a10 0%, #1a1209 100%);
        border-top-color: rgba(212, 165, 116, 0.2);
    }

    [data-theme="dark"] .dashboard-footer-main h5 {
        color: #d4a574 !important;
    }

    [data-theme="dark"] .dashboard-footer-main p,
    [data-theme="dark"] .dashboard-footer-main li,
    [data-theme="dark"] .dashboard-footer-main a {
        color: #a89880 !important;
    }

    [data-theme="dark"] .dashboard-footer-main a:hover {
        color: #d4a574 !important;
    }

    [data-theme="dark"] .dashboard-footer-main hr {
        border-color: rgba(212, 165, 116, 0.15) !important;
    }

    [data-theme="dark"] .dashboard-footer-main .w3-button {
        background: #33261a !important;
    }

    [data-theme="dark"] .dashboard-footer-main .w3-button:hover {
        background: #d4a574 !important;
    }
</style>
<footer class="dashboard-footer-main">
    <div class="w3-row-padding">
        <!-- Coluna 1 - Sobre -->
        <div class="w3-col l4 m6 s12" style="margin-bottom: 20px;">
            <h5 style="color: #8B6F47; font-weight: 700;">
                <i class="fa fa-book"></i> Sebo Alfarrábio
            </h5>
            <p style="color: #666; font-size: 14px; line-height: 1.6;">
                Sistema de gerenciamento para sebos e livrarias.
                Controle total sobre estoque, vendas, reservas e muito mais.
            </p>
            <div style="margin-top: 15px;">
                <a href="#" class="w3-button"
                    style="background: #D4B896; color: white; margin-right: 5px; border-radius: 50%; width: 35px; height: 35px; padding: 0;">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="#" class="w3-button"
                    style="background: #D4B896; color: white; margin-right: 5px; border-radius: 50%; width: 35px; height: 35px; padding: 0;">
                    <i class="fa fa-instagram"></i>
                </a>
                <a href="#" class="w3-button"
                    style="background: #D4B896; color: white; border-radius: 50%; width: 35px; height: 35px; padding: 0;">
                    <i class="fa fa-twitter"></i>
                </a>
            </div>
        </div>

        <!-- Coluna 2 - Links Rápidos -->
        <div class="w3-col l4 m6 s12" style="margin-bottom: 20px;">
            <h5 style="color: #8B6F47; font-weight: 700;">
                <i class="fa fa-link"></i> Links Rápidos
            </h5>
            <ul style="list-style: none; padding: 0; color: #666; font-size: 14px; line-height: 2;">
                <li><a href="/" style="text-decoration: none; color: #666; transition: color 0.3s;"
                        onmouseover="this.style.color='#B89968'" onmouseout="this.style.color='#666'">
                        <i class="fa fa-angle-right"></i> Dashboard
                    </a></li>
                <li><a href="/item/listar" style="text-decoration: none; color: #666; transition: color 0.3s;"
                        onmouseover="this.style.color='#B89968'" onmouseout="this.style.color='#666'">
                        <i class="fa fa-angle-right"></i> Gerenciar Itens
                    </a></li>
                <li><a href="/reservas/listar" style="text-decoration: none; color: #666; transition: color 0.3s;"
                        onmouseover="this.style.color='#B89968'" onmouseout="this.style.color='#666'">
                        <i class="fa fa-angle-right"></i> Reservas
                    </a></li>
                <li><a href="/vendas/listar" style="text-decoration: none; color: #666; transition: color 0.3s;"
                        onmouseover="this.style.color='#B89968'" onmouseout="this.style.color='#666'">
                        <i class="fa fa-angle-right"></i> Vendas
                    </a></li>
            </ul>
        </div>

        <!-- Coluna 3 - Contato -->
        <div class="w3-col l4 m12 s12">
            <h5 style="color: #8B6F47; font-weight: 700;">
                <i class="fa fa-envelope"></i> Suporte
            </h5>
            <p style="color: #666; font-size: 14px; line-height: 1.8;">
                <i class="fa fa-map-marker" style="color: #B89968; width: 20px;"></i> São Paulo, Brasil<br>
                <i class="fa fa-phone" style="color: #B89968; width: 20px;"></i> +55 (11) 9999-9999<br>
                <i class="fa fa-envelope" style="color: #B89968; width: 20px;"></i> contato@seboalfarrabio.com.br
            </p>
        </div>
    </div>

    <!-- Copyright -->
    <hr style="border-color: #D4B896; margin: 25px 0 15px 0;">
    <div class="w3-center" style="color: #999; font-size: 13px;">
        <p style="margin: 5px 0;">
            © 2026 <strong style="color: #8B6F47;">Sebo Alfarrábio</strong> - Todos os direitos reservados
        </p>
        <p style="margin: 5px 0;">
            Desenvolvido com <i class="fa fa-heart" style="color: #dc3545;"></i> por
            <strong style="color: #8B6F47;">GirlPower Team</strong>
        </p>
    </div>
</footer>

<!-- End page content -->
</div>

<!-- Scripts -->
<script>
    // Get the Sidebar
    var mySidebar = document.getElementById("mySidebar");

    // Get the DIV with overlay effect
    var overlayBg = document.getElementById("myOverlay");

    // Toggle between showing and hiding the sidebar, and add overlay effect
    function w3_open() {
        if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
            overlayBg.style.display = "none";
        } else {
            mySidebar.style.display = 'block';
            overlayBg.style.display = "block";
        }
    }

    // Close the sidebar with the close button
    function w3_close() {
        mySidebar.style.display = "none";
        overlayBg.style.display = "none";
    }

    // Tema Dark/Light
    function myFunction() {
        let x = document.body;
        let tema = localStorage.getItem('theme');
        tema = tema === 'w3-black' ? '' : 'w3-black';

        localStorage.setItem('theme', tema);

        location.reload();
    }

    function tema() {
        let x = document.body;
        let tema = localStorage.getItem('theme');

        if (tema) {
            x.classList.add(tema);
        }
    }

    // Aplicar tema ao carregar
    tema();

    // Highlight do menu ativo baseado na URL atual
    document.addEventListener('DOMContentLoaded', function () {
        const currentPath = window.location.pathname;
        const menuItems = document.querySelectorAll('.menu-item');

        menuItems.forEach(item => {
            // Remove active de todos
            item.classList.remove('active');

            // Adiciona active no item correspondente
            const href = item.getAttribute('href');
            if (href === currentPath || (href !== '/' && currentPath.startsWith(href))) {
                item.classList.add('active');
            }
        });

        // Se estiver na home, marca o dashboard
        if (currentPath === '/' || currentPath === '/admin/dashboard') {
            document.querySelector('a[href="/"]').classList.add('active');
        }
    });

    // Notificações - Auto-fechar alerts após 5 segundos
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.animation = 'fadeOut 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    });

    // Animação de fadeOut
    const style = document.createElement('style');
    style.innerHTML = `
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }
`;
    document.head.appendChild(style);
</script>

</body>

</html>