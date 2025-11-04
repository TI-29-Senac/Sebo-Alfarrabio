<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Sebo & Livraria O Alfarrábio</title>
    
    <!-- Seu CSS global -->
    <link rel="stylesheet" href="/css/style.css">
    
    <style>
        
    </style>
</head>
<body>
    <!-- Header (mantido) -->
    <header>
        <img src="/img/logo.png" alt="Logo" class="logo">  <!-- Ajuste o caminho da logo -->
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/produtos">Produtos</a></li>
                <li><a href="/sobre">Sobre</a></li>
                <li><a href="/contato">Contato</a></li>
            </ul>
        </nav>
    </header>

    <!-- NOVO: Layout Principal -->
    <div class="main-layout">
        <!-- Sidebar de Filtros -->
        <aside class="sidebar-filtros">
            <h3>Refine os Resultados</h3>
            <form method="GET" action="/produtos" id="form-filtros">
                <!-- Título -->
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($filtros['titulo'] ?? '') ?>" placeholder="Digite o título">
                
                <!-- Autor -->
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" value="<?= htmlspecialchars($filtros['autor'] ?? '') ?>" placeholder="Digite o nome do autor">
                
                <!-- Gênero (agora só select, sem bolinhas!) -->
                <label for="genero">Gênero:</label>
                <select id="genero" name="genero">
                    <option value="">Todos os Gêneros</option>
                    <?php foreach ($generos as $g): ?>
                        <option value="<?= $g['id_genero'] ?>" <?= ($filtros['genero'] ?? '') == $g['id_genero'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($g['nome_genero']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <!-- Categoria -->
                <label for="categoria">Categoria:</label>
                <select id="categoria" name="categoria">
                    <option value="">Todas as Categorias</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id_categoria'] ?>" <?= ($filtros['categoria'] ?? '') == $cat['id_categoria'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nome_categoria']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <!-- Botões -->
                <button type="submit">Aplicar Filtros</button>
                <a href="/produtos" class="limpar-link">Limpar Filtros</a>
            </form>
            
            <!-- Contador -->
            <div class="contador">
                <?= $paginacao['total'] ?> resultados encontrados.
            </div>
        </aside>

        <!-- Grid de Livros -->
        <main class="container-p">
            <?php if (!empty($itens)): ?>
                <?php foreach ($itens as $item): ?>
                    <article class="card-livro-p filterDiv <?= $item['filtro_classes'] ?>">  <!-- Mantive a classe para futuro, mas sem JS agora -->
                        <figure>
                            <img src="<?= $item['imagem'] ?>" alt="<?= htmlspecialchars($item['titulo']) ?>">
                            <div class="preco-overlay">
                                <strong>R$ <?= $item['preco'] ?></strong>
                            </div>
                        </figure>
                        <div class="info-livro">
                            <h3><?= htmlspecialchars($item['titulo']) ?></h3>
                            <p><?= htmlspecialchars($item['descricao']) ?></p>
                            <p><strong><?= $item['autores'] ?></strong></p>
                            <?php if ($item['estoque'] > 0): ?>
                                <span class="estoque-disponivel">
                                    ✓ Em estoque: <?= $item['estoque'] ?> un.
                                </span>
                            <?php else: ?>
                                <span class="estoque-indisponivel">✗ Indisponível</span>
                            <?php endif; ?>
                            <a href="/produto/<?= $item['id'] ?>" class="saiba-mais">Saiba Mais</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="grid-column: 1 / -1; text-align: center; font-style: italic; color: #666;">
                    Nenhum item encontrado. Tente ajustar os filtros!
                </p>
            <?php endif; ?>

            <!-- Paginação (dentro do grid para centralizar) -->
            <?php if (isset($paginacao) && $paginacao['ultima_pagina'] > 1): ?>
                <nav class="paginacao">
                    <?php if ($paginacao['pagina_atual'] > 1): ?>
                        <a href="/produtos/<?= $paginacao['pagina_atual'] - 1 ?>?<?= http_build_query($filtros) ?>">« Anterior</a>  <!-- Mantém filtros na URL -->
                    <?php endif; ?>
                    
                    <span style="margin: 0 15px;">
                        Página <?= $paginacao['pagina_atual'] ?> de <?= $paginacao['ultima_pagina'] ?> 
                        (<?= $paginacao['total'] ?> itens)
                    </span>
                    
                    <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                        <a href="/produtos/<?= $paginacao['pagina_atual'] + 1 ?>?<?= http_build_query($filtros) ?>">Próxima »</a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>
        </main>
    </div>

    <!-- Footer (mantido) -->
    <footer>
        <div class="container-footer">
            <div class="footer-nome">
                <img src="/img/logo2.png" alt="Logo" class="logo-footer">
                <h3>O Alfarrábio</h3>
            </div>
            <div class="links">
                <h4>Links</h4>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/produtos">Produtos</a></li>
                    <li><a href="/sobre">Sobre</a></li>
                    <li><a href="/contato">Contato</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Entre em contato</h4>
                <p>contato@Oalfarrabio.com.br</p>
                <p>São Miguel Paulista, São Paulo - SP</p>
                <p>+55 (11) 93277-2737</p>
                <p>+55 (11) 97317-8024</p>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Sebo & Livraria O Alfarrábio</p>
            </div>
        </div>
    </footer>

    <!-- JS Opcional: Auto-submit no select (UX: filtra ao mudar gênero sem clicar botão) -->
    <script>
        document.getElementById('genero').addEventListener('change', function() {
            document.getElementById('form-filtros').submit();
        });
        // Se quiser auto-submit em outros campos, adicione debounce para inputs
    </script>
</body>
</html>