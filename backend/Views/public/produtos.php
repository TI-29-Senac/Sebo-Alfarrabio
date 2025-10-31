<!DOCTYPE html>
<html lang="pt-BR">  <!-- pt-BR para melhor SEO e acessibilidade no Brasil -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sebo & Livraria O Alfarrábio - Produtos</title>
    <link rel="stylesheet" href="/css/style.css">  <!-- Caminho absoluto; ajuste se for relativo -->
</head>
<body>
    <header>
        <!-- Seu header original, com links atualizados para rotas PHP -->
        <img src="/img/logo2.png" alt="Logo Sebo Alfarrábio" class="logo">
        <nav>
            <ul>
                <li><a href="/">Home</a></li>  <!-- / para index.php -->
                <li><a href="/produtos">Produtos</a></li>
                <li><a href="/sobre">Sobre</a></li>
                <li><a href="/contato">Contato</a></li>
            </ul>
        </nav>
    </header>

    <!-- Seção de Filtros: Mantenha igual ao seu HTML original -->
    <div id="myBtnContainer">
        <div class="categorias-p">
            <div class="item-p" onclick="filterSelection('todos')"><h2>Todos</h2></div>
            <div class="item-p" onclick="filterSelection('romance')">
                <img src="/img/romance.png" alt="Ícone de Romance">
                <h4>Romance</h4>
            </div>
            <div class="item-p" onclick="filterSelection('fantasia')">
                <img src="/img/fantasia.png" alt="Ícone de Fantasia">
                <h4>Fantasia</h4>
            </div>
            <div class="item-p" onclick="filterSelection('ficcao-cientifica')">
                <img src="/img/ficcao.png" alt="Ícone de Ficção Científica">
                <h4>Ficção Científica</h4>
            </div>
            <div class="item-p" onclick="filterSelection('terror')">
                <img src="/img/terror.png" alt="Ícone de Terror">
                <h4>Terror</h4>
            </div>
        </div>
    </div>

    <!-- Container Principal: Aqui entra a mágica PHP! -->
    <div class="container-p">
        <?php if (empty($itens)): ?>  <!-- Condicional: Se não há itens... -->
            <p class="sem-resultados" style="text-align: center; padding: 20px;">Nenhum produto encontrado no momento. 
                <a href="/produtos">Atualizar página</a> ou volte depois!
            </p>
        <?php else: ?>  <!-- Senão, loop nos itens -->
            <?php foreach ($itens as $item): ?>  <!-- Para cada item no array... -->
                <div class="filterDiv <?= htmlspecialchars($item['filtro_classes']) ?>">
                <div class="card-livro-p">
                    <figure>
                        <img src="<?= $item['imagem'] ?>" alt="<?= $item['titulo'] ?> - Capa do <?= $item['tipo'] ?>" loading="lazy">
                        <div class="preco-overlay">R$ <?= $item['preco'] ?> <span class="badge-tipo"><?= ucfirst($item['tipo']) ?></span></div>
                    </figure>
                    <h3><?= $item['titulo'] ?></h3>
                    <p><?= $item['descricao'] ?></p>
                    <p class="autores-snippet"><?= $item['autores'] ?></p>  <!-- Ex: "Autor1, Autor2" -->
                    <?php if ($item['estoque'] > 0): ?>
                        <span class="estoque-disponivel">Em estoque: <?= $item['estoque'] ?> un.</span>
                    <?php endif; ?>
                    <a href="/produto/<?= $item['id'] ?>" class="saiba-mais">Saiba Mais</a>
                        </div>
                    </div>
                        </figure>
                        <h3><?= htmlspecialchars(substr($item['titulo'], 0, 50)) ?>...</h3>  <!-- Título curto para mobile -->
                        <p><?= htmlspecialchars($item['descricao']) ?></p>  <!-- Descrição snippet -->
                        <a href="/produto/<?= $item['id'] ?>" class="saiba-mais">Saiba Mais</a>  <!-- Link para página de detalhes (crie depois) -->
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Paginação: Só aparece se >1 página -->
    <?php if (isset($paginacao) && $paginacao['ultima_pagina'] > 1): ?>
        <div class="paginacao" style="text-align: center; margin: 20px;">
            <?php if ($paginacao['pagina_atual'] > 1): ?>
                <a href="/produtos/<?= $paginacao['pagina_atual'] - 1 ?>" style="margin: 0 10px;">&laquo; Anterior</a>
            <?php endif; ?>
            <span>Página <?= $paginacao['pagina_atual'] ?> de <?= $paginacao['ultima_pagina'] ?> 
                (<?= number_format($paginacao['total'], 0, ',', '.') ?> itens totais)</span>
            <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                <a href="/produtos/<?= $paginacao['pagina_atual'] + 1 ?>" style="margin: 0 10px;">Próxima &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Seu JS de Filtros: Carregue no final para performance -->
    <script src="/js/produtos.js"></script>

    <!-- Footer: Mantenha igual ao original -->
    <footer class="footer">
        <div class="container-footer">
            <div class="footer-nome">
                <img src="/img/logo2.png" alt="Logo Sebo Alfarrábio" class="logo-footer">
                <h3>O Alfarrábio</h3>
            </div>
            <div>
                <div class="links">
                    <h4>Links</h4>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/produtos">Produtos</a></li>
                        <li><a href="/sobre">Sobre</a></li>
                        <li><a href="/contato">Contato</a></li>
                    </ul>
                </div>
            </div>
            <div>
                <div class="footer-section">
                    <h4>Entre em contato</h4>
                    <p>contato@Oalfarrabio.com.br</p>
                    <p>São Miguel Paulista, São Paulo - SP</p>
                    <p>+55 (11) 93277-2737</p>
                    <p>+55 (11) 97317-8024</p>
                </div>
                <div class="footer-section footer-redes">
                    <h4>Redes Sociais</h4>
                    <a href=""><img src="/img/instagram-with-circle-svgrepo-com.svg" alt="Instagram"></a>
                    <a href=""><img src="/img/amazon-svgrepo-com.svg" alt="Amazon"></a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Sebo & Livraria O Alfarrábio | contato@Oalfarrabio.com.br</p>
            </div>
        </div>
    </footer>
</body>
</html>