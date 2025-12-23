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
    }
</style>
 
<div class="container">
    <h1>Novo Item</h1>

    <form action="/backend/item/salvar" method="POST" enctype="multipart/form-data">
    
        <!-- UPLOAD DE FOTO -->
        <div class="form-group text-center mb-4">
            <label>Foto do Item</label><br>
            <img id="preview-foto" src="/img/no-image.png" style="max-width:200px; max-height:200px; border:2px dashed #ccc; border-radius:10px; padding:5px;">
            <br><br>
            <input type="file" name="foto_item" id="foto_item" accept="image/*" style="display:none">
            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('foto_item').click()">
                Escolher Foto
            </button>
            <button type="button" class="btn btn-outline-danger" onclick="limparFoto()" style="display:none" id="btn-limpar">Remover</button>
        </div>

        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="titulo_item">Título*</label>
                <input type="text" class="form-control" id="titulo_item" name="titulo_item" required>
            </div>
            <div class="form-group col-md-4">
                <label for="tipo_item">Tipo de Item*</label>
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
                <label for="id_genero">Gênero*</label>
                <select id="id_genero" name="id_genero" class="form-control" required>
                    <?php foreach ($generos as $genero): ?>
                        <option value="<?= $genero['id_genero'] ?>"><?= htmlspecialchars($genero['nome_genero']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="id_categoria">Categoria*</label>
                <select id="id_categoria" name="id_categoria" class="form-control" required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id_categoria'] ?>"><?= htmlspecialchars($categoria['nome_categoria']) ?></option>
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
                <label for="editora_gravadora">Editora / Gravadora</label>
                <input type="text" class="form-control" id="editora_gravadora" name="editora_gravadora">
            </div>
            <div class="form-group col-md-4">
                <label for="ano_publicacao">Ano</label>
                <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao" min="1000" max="2099">
            </div>
            <div class="form-group col-md-4">
                <label for="estoque">Estoque</label>
                <input type="number" class="form-control" id="estoque" name="estoque" value="1" min="0">
            </div>
        </div>

        <div class="form-row">
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
document.addEventListener('DOMContentLoaded', function() {
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

        if (tipo === 'livro') campoIsbn.style.display = 'block';
        else if (tipo === 'cd' || tipo === 'dvd') campoDuracao.style.display = 'block';
        else if (tipo === 'revista') campoEdicao.style.display = 'block';
    }

    tipoSelect.addEventListener('change', toggleCamposEspeciais);
    toggleCamposEspeciais();

    // Preview da foto
    document.getElementById('foto_item').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('preview-foto').src = ev.target.result;
                document.getElementById('btn-limpar').style.display = 'inline-block';
            }
            reader.readAsDataURL(file);
        }
    });

    window.limparFoto = function() {
        document.getElementById('foto_item').value = '';
        document.getElementById('preview-foto').src = '/img/no-image.png';
        document.getElementById('btn-limpar').style.display = 'none';
    };

    // Busca de autores (mantido seu código original)
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

    window.adicionarAutor = function(id, nome) {
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

    window.removerAutor = function(id) {
        document.getElementById(`autor-badge-${id}`).remove();
        document.getElementById(`autor-input-${id}`).remove();
    };
});
</script>
