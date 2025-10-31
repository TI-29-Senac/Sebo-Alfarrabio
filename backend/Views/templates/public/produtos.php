<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Sebo & Livraria O Alfarrábio</title>
    
    <!-- 🔧 AJUSTE O CAMINHO DO CSS conforme sua estrutura -->
    <link rel="stylesheet" href="/css/style.css">
    
    <style>
        /* Estilos temporários caso o CSS não carregue */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Georgia', serif; background: #f5f5dc; }
        
        /* Header */
        header { 
            background: #d4a574; 
            padding: 20px 0; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            padding: 20px 50px;
        }
        header .logo { height: 60px; }
        header nav ul { 
            display: flex; 
            list-style: none; 
            gap: 30px; 
        }
        header nav a { 
            color: white; 
            text-decoration: none; 
            font-size: 18px;
            font-weight: bold;
        }
        
        /* Filtros */
        #myBtnContainer {
            background: #f5f5dc;
            padding: 40px 20px;
            text-align: center;
        }
        .categorias-p {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
        }
        .item-p {
            background: white;
            border-radius: 50%;
            width: 150px;
            height: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.3s;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .item-p:hover { transform: scale(1.1); }
        .item-p.active { 
            background: #d4a574; 
            color: white;
        }
        .item-p img { width: 60px; height: 60px; }
        .item-p h2, .item-p h4 { 
            margin: 5px 0; 
            color: #654321;
        }
        .item-p.active h2,
        .item-p.active h4 { color: white; }
        
        /* Container de Produtos */
        .container-p {
            max-width: 1400px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
        }
        
        /* Cards */
        .filterDiv {
            display: block;
            animation: fadeIn 0.5s;
        }
        .filterDiv.hide {
            display: none;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .card-livro-p {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
        }
        .card-livro-p:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .card-livro-p figure {
            position: relative;
            height: 320px;
            overflow: hidden;
            margin: 0;
        }
        .card-livro-p figure img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .preco-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.9));
            color: white;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .badge-tipo {
            background: #d4a574;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            text-transform: uppercase;
        }
        
        .card-livro-p h3 {
            padding: 15px 15px 10px;
            font-size: 18px;
            color: #333;
            min-height: 60px;
            line-height: 1.3;
        }
        
        .card-livro-p .descricao {
            padding: 0 15px;
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            flex-grow: 1;
        }
        
        .autores-snippet {
            padding: 10px 15px;
            font-size: 13px;
            color: #999;
            font-style: italic;
        }
        .autores-snippet strong {
            color: #666;
            font-style: normal;
        }
        
        .estoque-disponivel {
            display: block;
            padding: 8px 15px;
            background: #e8f5e9;
            color: #2e7d32;
            font-size: 13px;
            font-weight: bold;
        }
        
        .estoque-indisponivel {
            display: block;
            padding: 8px 15px;
            background: #ffebee;
            color: #c62828;
            font-size: 13px;
            font-weight: bold;
        }
        
        .saiba-mais {
            display: block;
            text-align: center;
            background: #d4a574;
            color: white;
            padding: 12px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        .saiba-mais:hover {
            background: #b8935f;
        }
        
        /* Mensagem vazia */
        .sem-resultados {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            font-size: 20px;
            color: #666;
        }
        
        /* Paginação */
        .paginacao {
            text-align: center;
            padding: 40px 20px;
            font-size: 16px;
        }
        .paginacao a {
            color: #d4a574;
            text-decoration: none;
            font-weight: bold;
            margin: 0 15px;
            padding: 8px 16px;
            border: 2px solid #d4a574;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .paginacao a:hover {
            background: #d4a574;
            color: white;
        }
        
        /* Footer */
        footer {
            background: #8b7355;
            color: white;
            padding: 40px 20px;
            margin-top: 60px;
        }
        .container-footer {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        .footer-nome {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logo-footer { height: 50px; }
        .footer-section h4 { margin-bottom: 15px; }
        .links ul { list-style: none; }
        .links a { color: white; text-decoration: none; }
        .footer-redes a img { width: 30px; margin-right: 10px; }
        .footer-bottom { 
            grid-column: 1 / -1; 
            text-align: center; 
            margin-top: 20px; 
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <img src="/img/logo2.png" alt="Logo Sebo Alfarrábio" class="logo">
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/produtos">Produtos</a></li>
                <li><a href="/sobre">Sobre</a></li>
                <li><a href="/contato">Contato</a></li>
            </ul>
        </nav>
    </header>

    <!-- Filtros -->
    <div id="myBtnContainer">
        <div class="categorias-p">
            <div class="item-p active" onclick="filterSelection('todos')">
                <h2>Todos</h2>
            </div>
            <div class="item-p" onclick="filterSelection('romance')">
                <img src="/img/romance.png" alt="Romance">
                <h4>Romance</h4>
            </div>
            <div class="item-p" onclick="filterSelection('fantasia')">
                <img src="/img/fantasia.png" alt="Fantasia">
                <h4>Fantasia</h4>
            </div>
            <div class="item-p" onclick="filterSelection('ficcao-cientifica')">
                <img src="/img/ficcao.png" alt="Ficção Científica">
                <h4>Ficção Científica</h4>
            </div>
            <div class="item-p" onclick="filterSelection('terror')">
                <img src="/img/terror.png" alt="Terror">
                <h4>Terror</h4>
            </div>
        </div>
    </div>

    <!-- Container de Produtos -->
    <div class="container-p">
        <?php if (empty($itens)): ?>
            <p class="sem-resultados">
                📚 Nenhum produto encontrado. 
                <br><br>
                <strong>Debug:</strong> Total de itens = <?= $total_itens ?? 0 ?>
                <br>
                <a href="/produtos">Atualizar página</a>
            </p>
        <?php else: ?>
            <?php foreach ($itens as $item): ?>
                <div class="filterDiv <?= $item['filtro_classes'] ?>">
                    <div class="card-livro-p">
                        <figure>
                            <img src="<?= $item['imagem'] ?>" 
                                 alt="<?= $item['titulo'] ?>" 
                                 loading="lazy"
                                 onerror="this.src='/img/default-livro.jpg'">
                            <div class="preco-overlay">
                                R$ <?= $item['preco'] ?>
                                <span class="badge-tipo"><?= $item['tipo'] ?></span>
                            </div>
                        </figure>
                        
                        <h3><?= $item['titulo'] ?></h3>
                        <p class="descricao"><?= $item['descricao'] ?></p>
                        <p class="autores-snippet">
                            <strong>Por:</strong> <?= $item['autores'] ?>
                        </p>
                        
                        <?php if ($item['estoque'] > 0): ?>
                            <span class="estoque-disponivel">
                                ✓ Em estoque: <?= $item['estoque'] ?> un.
                            </span>
                        <?php else: ?>
                            <span class="estoque-indisponivel">✗ Indisponível</span>
                        <?php endif; ?>
                        
                        <a href="/produto/<?= $item['id'] ?>" class="saiba-mais">Saiba Mais</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Paginação -->
    <?php if (isset($paginacao) && $paginacao['ultima_pagina'] > 1): ?>
        <div class="paginacao">
            <?php if ($paginacao['pagina_atual'] > 1): ?>
                <a href="/produtos/<?= $paginacao['pagina_atual'] - 1 ?>">« Anterior</a>
            <?php endif; ?>
            
            <span style="margin: 0 15px;">
                Página <?= $paginacao['pagina_atual'] ?> de <?= $paginacao['ultima_pagina'] ?> 
                (<?= $paginacao['total'] ?> itens)
            </span>
            
            <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                <a href="/produtos/<?= $paginacao['pagina_atual'] + 1 ?>">Próxima »</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Footer -->
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
            <div>
                <div class="footer-section">
                    <h4>Entre em contato</h4>
                    <p>contato@Oalfarrabio.com.br</p>
                    <p>São Miguel Paulista, São Paulo - SP</p>
                    <p>+55 (11) 93277-2737</p>
                    <p>+55 (11) 97317-8024</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Sebo & Livraria O Alfarrábio</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript dos Filtros -->
    <script>
        filterSelection("todos");

        function filterSelection(c) {
            var x = document.getElementsByClassName("filterDiv");
            if (c == "todos") c = "";
            
            for (var i = 0; i < x.length; i++) {
                removeClass(x[i], "show");
                if (x[i].className.indexOf(c) > -1) addClass(x[i], "show");
            }
            
            // Atualiza botão ativo
            var btns = document.getElementsByClassName("item-p");
            for (var i = 0; i < btns.length; i++) {
                btns[i].className = btns[i].className.replace(" active", "");
            }
            event.currentTarget.className += " active";
        }

        function addClass(element, name) {
            element.className = element.className.replace(" hide", "");
        }

        function removeClass(element, name) {
            var arr = element.className.split(" ");
            while (arr.indexOf(name) > -1) {
                arr.splice(arr.indexOf(name), 1);
            }
            element.className = arr.join(" ");
            if (element.className.indexOf("todos") == -1 && element.className.indexOf("show") == -1) {
                element.className += " hide";
            }
        }
    </script>
</body>
</html>