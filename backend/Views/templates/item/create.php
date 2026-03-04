<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #c9a96e 0%, #b8935a 100%);
        padding: 20px;
        min-height: 100vh;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    h1 {
        color: #6d5a3d;
        font-size: 32px;
        margin-bottom: 30px;
        font-weight: 600;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-row .form-group {
        flex: 1;
        margin-bottom: 0;
    }

    .col-md-4 {
        flex: 0 0 calc(33.333% - 14px);
    }

    .col-md-6 {
        flex: 0 0 calc(50% - 10px);
    }

    .col-md-8 {
        flex: 0 0 calc(66.666% - 7px);
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #6d5a3d;
        font-weight: 500;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0d4c0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .form-control:focus {
        outline: none;
        border-color: #c9a96e;
        background: white;
        box-shadow: 0 0 0 3px rgba(201, 169, 110, 0.1);
    }

    select.form-control {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236d5a3d' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-color: #fafafa;
        padding-right: 40px;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .text-center {
        text-align: center;
    }

    .mb-4 {
        margin-bottom: 30px;
    }

    .mt-2 {
        margin-top: 10px;
    }

    #preview-foto {
        max-width: 200px;
        max-height: 200px;
        border: 2px dashed #c9a96e;
        border-radius: 10px;
        padding: 10px;
        background: #fafafa;
    }

    .btn {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-outline-primary {
        background: white;
        color: #5a8cb8;
        border: 2px solid #5a8cb8;
    }

    .btn-outline-primary:hover {
        background: #5a8cb8;
        color: white;
    }

    .btn-outline-danger {
        background: white;
        color: #dc6b6b;
        border: 2px solid #dc6b6b;
        margin-left: 10px;
    }

    .btn-outline-danger:hover {
        background: #dc6b6b;
        color: white;
    }

    .btn-success {
        background: #7a9b5a;
        color: white;
        margin-right: 10px;
    }

    .btn-success:hover {
        background: #6a8a4d;
        box-shadow: 0 5px 15px rgba(122, 155, 90, 0.3);
    }

    .btn-secondary {
        background: #8d7a5e;
        color: white;
    }

    .btn-secondary:hover {
        background: #7a6951;
        box-shadow: 0 5px 15px rgba(141, 122, 94, 0.3);
    }

    /* Campo de preço com ícone R$ */
    .input-group {
        position: relative;
        display: flex;
        align-items: stretch;
    }

    .input-group-text {
        background: linear-gradient(135deg, #c9a96e 0%, #b8935a 100%);
        color: white;
        padding: 12px 15px;
        border: 2px solid #c9a96e;
        border-right: none;
        border-radius: 8px 0 0 8px;
        font-weight: bold;
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .input-group .form-control {
        border-radius: 0 8px 8px 0;
        border-left: none;
    }

    .input-group .form-control:focus {
        border-left: 2px solid #c9a96e;
    }

    /* Estilos para a busca de autores */
    #autor-search-results {
        border: 2px solid #e0d4c0;
        max-height: 150px;
        overflow-y: auto;
        background: #fafafa;
        border-radius: 8px;
        margin-top: 5px;
    }

    #autor-search-results div {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid #f0ebe0;
        transition: background 0.2s ease;
    }

    #autor-search-results div:last-child {
        border-bottom: none;
    }

    #autor-search-results div:hover {
        background: #c9a96e;
        color: white;
    }

    #autores-selecionados-list span {
        display: inline-block;
        background: #c9a96e;
        color: white;
        padding: 8px 15px;
        margin: 5px 5px 0 0;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    #autores-selecionados-list span button {
        background: none;
        border: none;
        color: white;
        font-weight: bold;
        margin-left: 8px;
        cursor: pointer;
        font-size: 16px;
        padding: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        transition: background 0.2s ease;
    }

    #autores-selecionados-list span button:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Esconde campos específicos */
    .campo-especifico {
        display: none;
    }

    /* Destaque para campos obrigatórios */
    .required {
        color: #dc6b6b;
        margin-left: 3px;
    }

    /* ===== Scanner ISBN ===== */
    .isbn-scanner-section {
        background: linear-gradient(135deg, #f8f4ed 0%, #f0ebe0 100%);
        border: 2px solid #c9a96e;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .isbn-scanner-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #c9a96e, #b8935a, #c9a96e);
    }

    .isbn-scanner-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .isbn-scanner-header .scanner-icon {
        font-size: 28px;
        animation: pulse-icon 2s ease-in-out infinite;
    }

    @keyframes pulse-icon {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    .isbn-scanner-header h3 {
        color: #6d5a3d;
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .isbn-scanner-header p {
        color: #8d7a5e;
        font-size: 13px;
        margin: 0;
    }

    .isbn-input-row {
        display: flex;
        gap: 10px;
        align-items: stretch;
    }

    .isbn-input-row .form-control {
        flex: 1;
        font-size: 18px;
        font-family: 'Consolas', 'Courier New', monospace;
        letter-spacing: 2px;
        padding: 14px 18px;
        border: 2px solid #c9a96e;
        background: white;
    }

    .isbn-input-row .form-control:focus {
        border-color: #8d6e3e;
        box-shadow: 0 0 0 4px rgba(201, 169, 110, 0.2);
    }

    .isbn-input-row .form-control.scanner-active {
        border-color: #7a9b5a;
        box-shadow: 0 0 0 4px rgba(122, 155, 90, 0.2);
    }

    .btn-isbn-buscar {
        padding: 14px 28px;
        background: linear-gradient(135deg, #c9a96e 0%, #b8935a 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn-isbn-buscar:hover {
        background: linear-gradient(135deg, #b8935a 0%, #a07d48 100%);
        box-shadow: 0 4px 15px rgba(201, 169, 110, 0.4);
        transform: translateY(-1px);
    }

    .btn-isbn-buscar:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .isbn-status {
        margin-top: 12px;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 14px;
        display: none;
        align-items: center;
        gap: 8px;
    }

    .isbn-status.loading {
        display: flex;
        background: #f0ebe0;
        color: #6d5a3d;
        border: 1px solid #c9a96e;
    }

    .isbn-status.success {
        display: flex;
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #81c784;
    }

    .isbn-status.error {
        display: flex;
        background: #fce4ec;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }

    .isbn-spinner {
        width: 18px;
        height: 18px;
        border: 3px solid #c9a96e;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Campo preenchido pelo scanner */
    .form-control.auto-filled {
        background: #f0f9e8 !important;
        border-color: #7a9b5a !important;
        transition: background 0.5s ease, border-color 0.5s ease;
    }

    @keyframes highlight-fill {
        0% {
            background-color: #d4edda;
        }

        100% {
            background-color: #f0f9e8;
        }
    }

    .form-control.auto-filled {
        animation: highlight-fill 0.6s ease;
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }

        .col-md-4,
        .col-md-6,
        .col-md-8 {
            flex: 1 1 100%;
        }

        .container {
            padding: 20px;
        }

        .isbn-input-row {
            flex-direction: column;
        }
    }
</style>

<div class="container">
    <h1>Novo Item</h1>

    <!-- SCANNER ISBN -->
    <div class="isbn-scanner-section" id="isbn-scanner-section">
        <div class="isbn-scanner-header">
            <div>
                <span class="scanner-icon">📖</span>
            </div>
            <div>
                <h3>Busca Rápida por ISBN</h3>
                <p>Escaneie o código de barras ou digite o ISBN para preencher automaticamente</p>
            </div>
        </div>
        <div class="isbn-input-row">
            <input type="text" class="form-control" id="isbn-scanner-input" placeholder="Ex: 9788535914849"
                autocomplete="off" inputmode="numeric">
            <button type="button" class="btn-isbn-buscar" id="btn-isbn-buscar" onclick="buscarPorIsbn()">
                🔍 Buscar
            </button>
        </div>
        <div class="isbn-status" id="isbn-status"></div>
    </div>

    <form action="/backend/item/salvar" method="POST" enctype="multipart/form-data">

        <!-- UPLOAD DE FOTO -->
        <div class="form-group text-center mb-4">
            <label>Foto do Item</label><br>
            <img id="preview-foto" src="/img/sem-imagem.webp"
                style="max-width:200px; max-height:200px; border:2px dashed #ccc; border-radius:10px; padding:5px;">
            <br><br>
            <input type="file" name="foto_item" id="foto_item" accept="image/*" style="display:none">
            <button type="button" class="btn btn-outline-primary"
                onclick="document.getElementById('foto_item').click()">
                Escolher Foto
            </button>
            <button type="button" class="btn btn-outline-danger" onclick="limparFoto()" style="display:none"
                id="btn-limpar">Remover</button>
        </div>

        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="titulo_item">Título<span class="required">*</span></label>
                <input type="text" class="form-control" id="titulo_item" name="titulo_item" required>
            </div>
            <div class="form-group col-md-4">
                <label for="tipo_item">Tipo de Item<span class="required">*</span></label>
                <select id="tipo_item" name="tipo_item" class="form-control" required>
                    <option value="" selected disabled>Selecione...</option>
                    <option value="livro">Livro</option>
                    <option value="cd">CD</option>
                    <option value="dvd">DVD</option>
                    <option value="revista">Revista</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="id_genero">Gênero<span class="required">*</span></label>
                <select id="id_genero" name="id_genero" class="form-control" required>
                    <?php foreach ($generos as $genero): ?>
                        <option value="<?= $genero['id_generos'] ?>"><?= htmlspecialchars($genero['nome_generos']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="id_categoria">Categoria<span class="required">*</span></label>
                <select id="id_categoria" name="id_categoria" class="form-control" required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id_categoria'] ?>">
                            <?= htmlspecialchars($categoria['nome_categoria']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="autor-search-input">Buscar Autores/Artistas</label>
            <input type="text" id="autor-search-input" class="form-control" placeholder="Digite para buscar...">
            <div id="autor-search-results"></div>
            <div id="autores-selecionados-list" class="mt-2"></div>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="preco_item">Preço (R$)<span class="required">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="number" class="form-control" id="preco_item" name="preco_item" step="0.01" min="0"
                        value="0.00" required>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label for="editora_gravadora">Editora / Gravadora</label>
                <input type="text" class="form-control" id="editora_gravadora" name="editora_gravadora">
            </div>
            <div class="form-group col-md-4">
                <label for="estante">Estante / Localização</label>
                <input type="text" class="form-control" id="estante" name="estante"
                    placeholder="Ex: A1, B3, Corredor 2...">
            </div>
            <div class="form-group col-md-4">
                <label for="ano_publicacao">Ano</label>
                <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao" min="1000"
                    max="2099">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="estoque">Estoque<span class="required">*</span></label>
                <input type="number" class="form-control" id="estoque" name="estoque" value="1" min="0" required>
            </div>
            <div class="form-group col-md-4 campo-especifico" id="campo-isbn">
                <label for="isbn">ISBN (Livro)</label>
                <input type="text" class="form-control" id="isbn" name="isbn">
            </div>
            <div class="form-group col-md-4 campo-especifico" id="campo-duracao">
                <label for="duracao_minutos">Duração (minutos) (CD/DVD)</label>
                <input type="number" class="form-control" id="duracao_minutos" name="duracao_minutos">
            </div>
            <div class="form-group col-md-4 campo-especifico" id="campo-edicao">
                <label for="numero_edicao">Nº Edição (Revista)</label>
                <input type="number" class="form-control" id="numero_edicao" name="numero_edicao">
            </div>
        </div>

        <button type="submit" class="btn btn-success">Salvar Item</button>
        <a href="/backend/item/listar" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ===== ISBN SCANNER =====
        const isbnInput = document.getElementById('isbn-scanner-input');
        const isbnStatus = document.getElementById('isbn-status');
        const btnIsbnBuscar = document.getElementById('btn-isbn-buscar');

        // Detectar entrada de scanner (teclas rápidas seguidas de Enter)
        let scanBuffer = '';
        let scanTimeout = null;

        isbnInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                buscarPorIsbn();
                return;
            }
        });

        // Auto-focus no campo ISBN ao carregar
        isbnInput.focus();

        // Função global de busca por ISBN
        window.buscarPorIsbn = function () {
            const isbn = isbnInput.value.replace(/[\s-]/g, '').trim();

            if (!isbn || !/^(\d{10}|\d{13})$/.test(isbn)) {
                showIsbnStatus('error', '⚠️ ISBN inválido. Informe um ISBN-10 (10 dígitos) ou ISBN-13 (13 dígitos).');
                return;
            }

            // Loading
            showIsbnStatus('loading', '');
            isbnStatus.innerHTML = '<div class="isbn-spinner"></div> Buscando informações do livro...';
            btnIsbnBuscar.disabled = true;

            fetch(`/backend/ajax/buscar/isbn?isbn=${encodeURIComponent(isbn)}`)
                .then(response => response.json())
                .then(result => {
                    btnIsbnBuscar.disabled = false;

                    if (result.success) {
                        const data = result.data;

                        // Preencher título
                        if (data.titulo) {
                            setFieldValue('titulo_item', data.titulo);
                        }

                        // Setar tipo como livro e mostrar campo ISBN
                        const tipoSelect = document.getElementById('tipo_item');
                        tipoSelect.value = 'livro';
                        tipoSelect.dispatchEvent(new Event('change'));

                        // Preencher ISBN
                        setFieldValue('isbn', data.isbn);

                        // Preencher editora
                        if (data.editora) {
                            setFieldValue('editora_gravadora', data.editora);
                        }

                        // Preencher ano
                        if (data.ano_publicacao) {
                            setFieldValue('ano_publicacao', data.ano_publicacao);
                        }

                        // Preencher descrição
                        if (data.descricao) {
                            setFieldValue('descricao', data.descricao);
                        }

                        // Preencher capa
                        if (data.capa_url) {
                            document.getElementById('preview-foto').src = data.capa_url;
                        }

                        // Preencher autores (adicionar como texto no campo de busca)
                        if (data.autores && data.autores.length > 0) {
                            // Buscar cada autor no sistema e adicionar se existir
                            data.autores.forEach(nomeAutor => {
                                buscarEAdicionarAutor(nomeAutor);
                            });
                        }

                        const campos = [data.titulo ? 'Título' : null, data.editora ? 'Editora' : null, data.ano_publicacao ? 'Ano' : null, data.autores?.length ? 'Autores' : null, data.capa_url ? 'Capa' : null].filter(Boolean);
                        showIsbnStatus('success', `✅ Livro encontrado! Campos preenchidos: ${campos.join(', ')}`);
                    } else {
                        showIsbnStatus('error', `❌ ${result.message}`);
                    }
                })
                .catch(err => {
                    btnIsbnBuscar.disabled = false;
                    showIsbnStatus('error', '❌ Erro ao consultar. Verifique a conexão e tente novamente.');
                    console.error('Erro ISBN:', err);
                });
        };

        function setFieldValue(fieldId, value) {
            const field = document.getElementById(fieldId);
            if (field) {
                field.value = value;
                field.classList.add('auto-filled');
                // Remover destaque após 3 segundos
                setTimeout(() => field.classList.remove('auto-filled'), 3000);
            }
        }

        function showIsbnStatus(type, message) {
            isbnStatus.className = 'isbn-status ' + type;
            if (message) isbnStatus.innerHTML = message;
        }

        // Buscar autor no sistema por nome e adicioná-lo automaticamente
        function buscarEAdicionarAutor(nomeAutor) {
            fetch(`/backend/ajax/buscar/autores?term=${encodeURIComponent(nomeAutor)}`)
                .then(r => r.json())
                .then(autores => {
                    if (autores.length > 0) {
                        // Pegar o primeiro resultado que contém o nome
                        adicionarAutor(autores[0].id_autor, autores[0].nome_autor);
                    } else {
                        // Colocar o nome do autor no campo de busca para o usuário cadastrar
                        const searchInput = document.getElementById('autor-search-input');
                        if (searchInput) {
                            searchInput.value = nomeAutor;
                            searchInput.classList.add('auto-filled');
                            setTimeout(() => searchInput.classList.remove('auto-filled'), 3000);
                        }
                    }
                })
                .catch(() => { });
        }

        // ===== CAMPOS CONDICIONAIS =====
        const tipoSelect = document.getElementById('tipo_item');
        const campoIsbn = document.getElementById('campo-isbn');
        const campoDuracao = document.getElementById('campo-duracao');
        const campoEdicao = document.getElementById('campo-edicao');

        function toggleCamposEspeciais() {
            const tipo = tipoSelect.value;
            campoIsbn.style.display = 'none';
            campoDuracao.style.display = 'none';
            campoEdicao.style.display = 'none';

            if (tipo === 'livro') campoIsbn.style.display = 'block';
            else if (tipo === 'cd' || tipo === 'dvd') campoDuracao.style.display = 'block';
            else if (tipo === 'revista') campoEdicao.style.display = 'block';
        }

        tipoSelect.addEventListener('change', toggleCamposEspeciais);
        toggleCamposEspeciais();

        // Preview da foto
        document.getElementById('foto_item').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (ev) {
                    document.getElementById('preview-foto').src = ev.target.result;
                    document.getElementById('btn-limpar').style.display = 'inline-block';
                }
                reader.readAsDataURL(file);
            }
        });

        window.limparFoto = function () {
            document.getElementById('foto_item').value = '';
            document.getElementById('preview-foto').src = '/img/sem-imagem.webp';
            document.getElementById('btn-limpar').style.display = 'none';
        };

        // Formatação automática do preço
        const precoInput = document.getElementById('preco_item');
        precoInput.addEventListener('blur', function () {
            const valor = parseFloat(this.value);
            if (!isNaN(valor)) {
                this.value = valor.toFixed(2);
            }
        });

        // Busca de autores
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

        window.adicionarAutor = function (id, nome) {
            if (document.querySelector(`#autores-selecionados-list input[value="${id}"]`)) {
                searchInput.value = '';
                searchResults.innerHTML = '';
                return;
            }

            const span = document.createElement('span');
            span.id = `autor-badge-${id}`;
            span.innerHTML = `${nome} <button type="button" onclick="removerAutor(${id})">×</button>`;
            selectedList.appendChild(span);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'autores_ids[]';
            input.value = id;
            input.id = `autor-input-${id}`;
            selectedList.appendChild(input);

            searchInput.value = '';
            searchResults.innerHTML = '';
        };

        window.removerAutor = function (id) {
            document.getElementById(`autor-badge-${id}`).remove();
            document.getElementById(`autor-input-${id}`).remove();
        };
    });
</script>