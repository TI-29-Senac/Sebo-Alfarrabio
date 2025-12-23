<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Item - Sebo Alfarrábio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header com botões de ação */
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-btn {
            background: white;
            border: 2px solid #d4af7a;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
            font-size: 16px;
            font-weight: 500;
        }

        .action-btn:hover {
            background: #d4af7a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 122, 0.3);
        }

        .action-btn i {
            font-size: 20px;
        }

        /* Cards de estatísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .stat-card.blue { border-left: 4px solid #2196F3; }
        .stat-card.orange { border-left: 4px solid #FF9800; }
        .stat-card.gray { border-left: 4px solid #9E9E9E; }
        .stat-card.purple { border-left: 4px solid #9C27B0; }

        .stat-info h3 {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-info p {
            font-size: 14px;
            color: #666;
        }

        .stat-icon {
            font-size: 48px;
            opacity: 0.15;
        }

        .stat-card.blue .stat-icon { color: #2196F3; }
        .stat-card.orange .stat-icon { color: #FF9800; }
        .stat-card.gray .stat-icon { color: #9E9E9E; }
        .stat-card.purple .stat-icon { color: #9C27B0; }

        /* Alertas */
        .alerts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .alert-box {
            padding: 15px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 15px;
            font-weight: 500;
        }

        .alert-box.warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            color: #856404;
        }

        .alert-box.info {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            color: #e65100;
        }

        .alert-box i {
            margin-right: 10px;
        }

        /* Formulário de Edição */
        .edit-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .edit-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .edit-header i {
            font-size: 28px;
            color: #d4af7a;
        }

        .edit-header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #8B7355;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #d4af7a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group label .required {
            color: #dc3545;
        }

        .form-control {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            background: #fafafa;
        }

        .form-control:focus {
            outline: none;
            border-color: #d4af7a;
            background: white;
            box-shadow: 0 0 0 3px rgba(212, 175, 122, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        /* Upload de Imagem */
        .image-upload-section {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .image-preview {
            width: 200px;
            height: 280px;
            border: 3px dashed #d4af7a;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #fafafa;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .image-preview:hover {
            border-color: #8B7355;
            background: #f0f0f0;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .image-preview.has-image img {
            display: block;
        }

        .image-preview.has-image .upload-placeholder {
            display: none;
        }

        .upload-placeholder {
            text-align: center;
            color: #999;
        }

        .upload-placeholder i {
            font-size: 48px;
            color: #d4af7a;
            margin-bottom: 15px;
        }

        .upload-placeholder p {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .upload-placeholder small {
            font-size: 12px;
            color: #aaa;
        }

        .remove-image {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .image-preview.has-image .remove-image {
            display: flex;
        }

        .remove-image:hover {
            background: #dc3545;
            transform: scale(1.1);
        }

        #imagem-input {
            display: none;
        }

        /* Busca de Autores */
        .autor-search-wrapper {
            position: relative;
        }

        #autor-search-input {
            padding-left: 40px;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
        }

        #autor-search-results {
            border: 2px solid #e0e0e0;
            border-top: none;
            max-height: 200px;
            overflow-y: auto;
            background: white;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: -8px;
        }

        #autor-search-results div {
            padding: 12px 15px;
            cursor: pointer;
            transition: background 0.2s;
        }

        #autor-search-results div:hover {
            background: #f8f8f8;
        }

        #autores-selecionados-list {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        #autores-selecionados-list span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #8B7355 0%, #6d5a45 100%);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        #autores-selecionados-list span button {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
        }

        #autores-selecionados-list span button:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .campo-especifico {
            display: none;
        }

        /* Botões de ação do formulário */
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .btn {
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20833a 100%);
            color: white;
            flex: 1;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .action-buttons {
                grid-template-columns: 1fr;
            }

            .alerts-grid {
                grid-template-columns: 1fr;
            }

            .image-upload-section {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Botões de Ação -->
        <div class="action-buttons">
            <a href="#" class="action-btn">
                <i class="fas fa-plus-circle"></i>
                Adicionar Produto
            </a>
            <a href="#" class="action-btn">
                <i class="fas fa-calendar-check"></i>
                Ver Reservas
            </a>
            <a href="#" class="action-btn">
                <i class="fas fa-boxes"></i>
                Gerenciar Estoque
            </a>
        </div>

 
        <!-- Alertas -->
        <div class="alerts-grid">
            <div class="alert-box warning">
                <span><i class="fas fa-exclamation-triangle"></i> Categorias Inativas:</span>
                <strong>0</strong>
            </div>
            <div class="alert-box info">
                <span><i class="fas fa-box-open"></i> Itens Inativos:</span>
                <strong>1</strong>
            </div>
        </div>

        <!-- Formulário de Edição -->
        <div class="edit-container">
            <div class="edit-header">
                <i class="fas fa-edit"></i>
                <h1>Editar Item: <?= htmlspecialchars($item['titulo_item']) ?></h1>
            </div>

            <form action="/backend/item/atualizar" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="id_item" value="<?= htmlspecialchars($item['id_item']) ?>">
               <input type="hidden" name="foto_item_atual" value="<?= htmlspecialchars($item['foto_item'] ?? '') ?>">

                <!-- Upload de Imagem -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-image"></i>
                        Imagem do Produto
                    </div>

                    <div class="image-upload-section">
                        <div class="image-preview" id="image-preview" onclick="document.getElementById('imagem-input').click()">
                            <img id="preview-img" src="" alt="Preview">
                            <div class="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Clique para adicionar</p>
                                <small>PNG, JPG até 5MB</small>
                            </div>
                            <button type="button" class="remove-image" onclick="event.stopPropagation(); removerImagem()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <input type="file" id="imagem-input" name="imagem" accept="image/*" onchange="previewImagem(event)">

                        <!-- Informações Básicas ao lado da imagem -->
                        <div>
                            <div class="form-group">
                                <label for="titulo_item">
                                    Título
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" id="titulo_item" name="titulo_item" value="<?= htmlspecialchars($item['titulo_item']) ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tipo, Gênero e Categoria -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-layer-group"></i>
                        Classificação
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tipo_item">
                                Tipo de Item
                                <span class="required">*</span>
                            </label>
                            <select id="tipo_item" name="tipo_item" class="form-control" required>
                                <option value="livro" <?= $item['tipo_item'] == 'livro' ? 'selected' : '' ?>>Livro</option>
                                <option value="cd" <?= $item['tipo_item'] == 'cd' ? 'selected' : '' ?>>CD</option>
                                <option value="dvd" <?= $item['tipo_item'] == 'dvd' ? 'selected' : '' ?>>DVD</option>
                                <option value="revista" <?= $item['tipo_item'] == 'revista' ? 'selected' : '' ?>>Revista</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="id_genero">
                                Gênero
                                <span class="required">*</span>
                            </label>
                            <select id="id_genero" name="id_genero" class="form-control" required>
                                <?php foreach ($generos as $genero): ?>
                                    <option value="<?= $genero['id_genero'] ?>" <?= $item['id_genero'] == $genero['id_genero'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($genero['nome_genero']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="id_categoria">
                                Categoria
                                <span class="required">*</span>
                            </label>
                            <select id="id_categoria" name="id_categoria" class="form-control" required>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= $categoria['id_categoria'] ?>" <?= $item['id_categoria'] == $categoria['id_categoria'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($categoria['nome_categoria']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Autores/Artistas -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-user-edit"></i>
                        Autores/Artistas
                    </div>

                    <div class="form-group">
                        <label for="autor-search-input">Buscar Autores/Artistas</label>
                        <div class="autor-search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="autor-search-input" class="form-control" placeholder="Digite o nome do autor ou artista...">
                        </div>
                        <div id="autor-search-results"></div>
                        <div id="autores-selecionados-list">
                            <?php foreach ($autores_selecionados as $autor): ?>
                                <span id="autor-badge-<?= $autor['id_autor'] ?>">
                                    <?= htmlspecialchars($autor['nome_autor']) ?>
                                    <button type="button" onclick="removerAutor(<?= $autor['id_autor'] ?>)">&times;</button>
                                </span>
                                <input type="hidden" name="autores_ids[]" value="<?= $autor['id_autor'] ?>" id="autor-input-<?= $autor['id_autor'] ?>">
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-align-left"></i>
                        Descrição
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição do Item</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="4"><?= htmlspecialchars($item['descricao']) ?></textarea>
                    </div>
                </div>

                <!-- Detalhes Adicionais -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Detalhes Adicionais
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="editora_gravadora">Editora / Gravadora</label>
                            <input type="text" class="form-control" id="editora_gravadora" name="editora_gravadora" value="<?= htmlspecialchars($item['editora_gravadora']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="ano_publicacao">Ano de Publicação</label>
                            <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao" min="1000" max="2099" value="<?= (int)$item['ano_publicacao'] ?>">
                        </div>

                        <div class="form-group">
                            <label for="estoque">Quantidade em Estoque</label>
                            <input type="number" class="form-control" id="estoque" name="estoque" min="0" value="<?= (int)$item['estoque'] ?>">
                        </div>
                    </div>
                </div>

                <!-- Campos Específicos -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-cog"></i>
                        Campos Específicos
                    </div>

                    <div class="form-row">
                        <div class="form-group campo-especifico" id="campo-isbn">
                            <label for="isbn">ISBN (Livro)</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" value="<?= htmlspecialchars($item['isbn']) ?>">
                        </div>

                        <div class="form-group campo-especifico" id="campo-duracao">
                            <label for="duracao_minutos">Duração em Minutos (CD/DVD)</label>
                            <input type="number" class="form-control" id="duracao_minutos" name="duracao_minutos" value="<?= (int)$item['duracao_minutos'] ?>">
                        </div>

                        <div class="form-group campo-especifico" id="campo-edicao">
                            <label for="numero_edicao">Número da Edição (Revista)</label>
                            <input type="number" class="form-control" id="numero_edicao" name="numero_edicao" value="<?= (int)$item['numero_edicao'] ?>">
                        </div>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Salvar Alterações
                    </button>
                    <a href="/item/listar" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview de Imagem
        function previewImagem(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    const img = document.getElementById('preview-img');
                    img.src = e.target.result;
                    preview.classList.add('has-image');
                }
                reader.readAsDataURL(file);
            }
        }

        function removerImagem() {
            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');
            const input = document.getElementById('imagem-input');
            
            img.src = '';
            input.value = '';
            preview.classList.remove('has-image');
        }

        // Campos Condicionais
        const tipoSelect = document.getElementById('tipo_item');
        const campoIsbn = document.getElementById('campo-isbn');
        const campoDuracao = document.getElementById('campo-duracao');
        const campoEdicao = document.getElementById('campo-edicao');

        function toggleCamposEspeciais() {
            const tipo = tipoSelect.value;
            campoIsbn.style.display = 'none';
            campoDuracao.style.display = 'none';
            campoEdicao.style.display = 'none';

            if (tipo === 'livro') {
                campoIsbn.style.display = 'block';
            } else if (tipo === 'cd' || tipo === 'dvd') {
                campoDuracao.style.display = 'block';
            } else if (tipo === 'revista') {
                campoEdicao.style.display = 'block';
            }
        }

        tipoSelect.addEventListener('change', toggleCamposEspeciais);
        toggleCamposEspeciais();

        // Busca de Autores
        const searchInput = document.getElementById('autor-search-input');
        const searchResults = document.getElementById('autor-search-results');
        const selectedList = document.getElementById('autores-selecionados-list');
        let debounceTimer;

        searchInput.addEventListener('keyup', () => {
            clearTimeout(debounceTimer);
            const termo = searchInput.value.trim();
            
            if (termo.length < 2) {
                searchResults.innerHTML = '';
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`/backend/ajax/buscar/autores?term=${encodeURIComponent(termo)}`)
                    .then(response => response.json())
                    .then(autores => {
                        searchResults.innerHTML = '';
                        autores.forEach(autor => {
                            const div = document.createElement('div');
                            div.textContent = autor.nome_autor;
                            div.dataset.id = autor.id_autor;
                            div.addEventListener('click', () => adicionarAutor(autor.id_autor, autor.nome_autor));
                            searchResults.appendChild(div);
                        });
                    });
            }, 300);
        });

        function adicionarAutor(id, nome) {
            if (document.querySelector(`#autores-selecionados-list input[value="${id}"]`)) {
                searchInput.value = '';
                searchResults.innerHTML = '';
                return;
            }

            const span = document.createElement('span');
            span.id = `autor-badge-${id}`;
            span.innerHTML = `${nome} <button type="button" onclick="removerAutor(${id})">&times;</button>`;
            selectedList.appendChild(span);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'autores_ids[]';
            input.value = id;
            input.id = `autor-input-${id}`;
            selectedList.appendChild(input);

            searchInput.value = '';
            searchResults.innerHTML = '';
        }

        function removerAutor(id) {
            document.getElementById(`autor-badge-${id}`).remove();
            document.getElementById(`autor-input-${id}`).remove();
        }
    </script>
</body>
</html>