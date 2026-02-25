<style>
    .author-container {
        padding: 30px;
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 25px;
    }

    .page-title {
        color: #4a3829;
        font-weight: 600;
        margin: 0;
    }

    .search-container {
        position: relative;
        flex-grow: 1;
        max-width: 400px;
    }

    .search-container i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #b38b5e;
    }

    .search-input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border-radius: 50px;
        border: 1px solid #e0d5c5;
        background: #fdf8f2;
        color: #4a3829;
        outline: none;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: #b38b5e;
        box-shadow: 0 0 8px rgba(179, 139, 94, 0.2);
    }

    .btn-add {
        background: #b38b5e;
        color: white;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: #9d7a52;
        color: white;
    }

    /* Grid Layout Replacement for Row-Padding */
    .author-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        padding: 0;
    }

    .author-card {
        background: #fdf8f2;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
    }

    .author-card:hover {
        transform: translateY(-5px);
    }

    .author-name {
        color: #4a3829;
        margin: 0 0 10px 0;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .author-bio {
        font-size: 13.5px;
        color: #6b5d4a;
        margin-bottom: 20px;
        flex-grow: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        line-height: 1.5;
    }

    .author-actions {
        display: flex;
        gap: 8px;
        border-top: 1px solid #eee;
        padding-top: 15px;
    }

    .btn-edit {
        background: #b38b5e;
        color: white;
        flex: 1;
    }

    .btn-delete {
        flex: 1;
    }

    /* Dark Theme Overrides */
    [data-theme="dark"] .page-title,
    [data-theme="dark"] .author-name {
        color: #d4a574;
    }

    [data-theme="dark"] .author-card {
        background: #2a1f14;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
    }

    [data-theme="dark"] .author-bio {
        color: #d4c5a9;
    }

    [data-theme="dark"] .search-input {
        background: #33261a;
        border-color: #3d2e20;
        color: #d4c5a9;
    }

    [data-theme="dark"] .author-actions {
        border-color: #3d2e20;
    }

    [data-theme="dark"] .btn-add,
    [data-theme="dark"] .btn-edit {
        background: #b38b5e;
        color: white;
    }

    [data-theme="dark"] .btn-add:hover,
    [data-theme="dark"] .btn-edit:hover {
        background: #9d7a52;
    }

    @media (max-width: 600px) {
        .header-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .search-container {
            max-width: none;
            order: 2;
        }

        .btn-add {
            order: 1;
        }
    }
</style>

<div class="author-container">

    <div class="header-actions">
        <h3 class="page-title">
            <i class="fa fa-users"></i> Gerenciar Autores
        </h3>

        <div class="search-container">
            <i class="fa fa-search"></i>
            <input type="text" id="authorSearch" class="search-input" placeholder="Pesquisar autor...">
        </div>

        <a href="/backend/autor/criar" class="w3-button w3-round-large btn-add">
            <i class="fa fa-plus"></i> Adicionar Novo Autor
        </a>
    </div>

    <div class="author-grid" id="authorGrid">

        <?php foreach ($autores as $autor): ?>
            <div class="author-col" data-name="<?= strtolower(htmlspecialchars($autor['nome_autor'])); ?>">
                <div class="author-card">

                    <h4 class="author-name">
                        <?= htmlspecialchars($autor['nome_autor']); ?>
                    </h4>

                    <p class="author-bio">
                        <?= $autor['biografia'] ? nl2br(htmlspecialchars($autor['biografia']))
                            : '<i>Sem biografia cadastrada</i>'; ?>
                    </p>

                    <div class="author-actions">
                        <a href="/backend/autor/editar/<?= $autor['id_autor']; ?>" class="w3-button w3-round btn-edit">
                            <i class="fa fa-edit"></i> Editar
                        </a>

                        <form action="/backend/autor/excluir" method="POST" style="display:inline-block; flex:1;"
                            onsubmit="return confirm('Tem certeza que deseja excluir este autor?')">

                            <input type="hidden" name="id_autor" value="<?= $autor['id_autor']; ?>">

                            <button class="w3-button w3-red w3-round btn-delete" style="width:100%">
                                <i class="fa fa-trash"></i> Excluir
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<script>
    document.getElementById('authorSearch').addEventListener('input', function (e) {
        const term = e.target.value.toLowerCase().trim();
        const authors = document.querySelectorAll('.author-col');

        authors.forEach(author => {
            const name = author.getAttribute('data-name');
            if (name.includes(term)) {
                author.style.display = 'block';
            } else {
                author.style.display = 'none';
            }
        });
    });
</script>