<style>
    .author-container {
        padding: 30px;
    }

    .page-title {
        color: #4a3829;
        font-weight: 600;
    }

    .btn-add {
        background: #b38b5e;
        color: white;
        margin: 18px 0;
    }

    .author-col {
        margin-bottom: 25px;
    }

    .author-card {
        background: #fdf8f2;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.10);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .author-name {
        color: #4a3829;
        margin: 0;
        font-weight: 600;
    }

    .author-bio {
        font-size: 13px;
        color: #6b5d4a;
        margin-top: 10px;
        flex-grow: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
    }

    .author-actions {
        margin-top: 15px;
        display: flex;
        gap: 5px;
    }

    .btn-edit {
        background: #b38b5e;
        color: white;
    }

    /* Dark Theme Overrides */
    [data-theme="dark"] .page-title,
    [data-theme="dark"] .author-name {
        color: #d4a574;
    }

    [data-theme="dark"] .author-card {
        background: #221a10;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
    }

    [data-theme="dark"] .author-bio {
        color: #d4c5a9;
    }

    [data-theme="dark"] .btn-add,
    [data-theme="dark"] .btn-edit {
        background: #33261a;
        color: #d4a574;
        border: 1px solid #3d2e20;
    }

    [data-theme="dark"] .btn-add:hover,
    [data-theme="dark"] .btn-edit:hover {
        background: #2a1f14;
    }
</style>

<div class="w3-container author-container">

    <h3 class="page-title">
        <i class="fa fa-users"></i> Gerenciar Autores
    </h3>

    <a href="/backend/autor/criar" class="w3-button w3-round-large btn-add">
        <i class="fa fa-plus"></i> Adicionar Novo Autor
    </a>

    <div class="w3-row-padding">

        <?php foreach ($autores as $autor): ?>
            <div class="w3-col l3 m4 s12 author-col">
                <div class="w3-card author-card">

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

                        <form action="/backend/autor/excluir" method="POST" style="display:inline-block;"
                            onsubmit="return confirm('Tem certeza que deseja excluir este autor?')">

                            <input type="hidden" name="id_autor" value="<?= $autor['id_autor']; ?>">

                            <button class="w3-button w3-red w3-round">
                                <i class="fa fa-trash"></i> Excluir
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>