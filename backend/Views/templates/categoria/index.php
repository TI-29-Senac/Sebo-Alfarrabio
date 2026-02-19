<style>
    .category-container {
        padding: 20px;
    }

    .page-title {
        color: #6B5235;
        font-weight: 600;
    }

    .btn-add {
        background: var(--bege-dark);
        color: white;
        margin: 15px 0;
    }

    .table-responsive {
        overflow-x: auto;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .category-table {
        border-color: var(--bege-light);
        border-radius: 8px;
    }

    .table-header {
        background: var(--bege-primary);
        color: white;
    }

    .btn-edit {
        background: var(--bege-primary);
        color: white;
        border-radius: 6px;
    }

    /* Dark Theme Overrides */
    [data-theme="dark"] .page-title {
        color: #d4a574;
    }

    [data-theme="dark"] .btn-add {
        background: #33261a;
        color: #d4a574;
        border: 1px solid #3d2e20;
    }

    [data-theme="dark"] .btn-add:hover {
        background: #2a1f14;
    }

    [data-theme="dark"] .table-responsive {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    [data-theme="dark"] .category-table {
        background-color: #221a10 !important;
        /* Override w3-white */
        color: #f5f1e8;
        border-color: #3d2e20;
    }

    [data-theme="dark"] .table-header {
        background: #2a1f14;
        color: #d4a574;
    }

    [data-theme="dark"] .category-table td {
        border-color: rgba(212, 165, 116, 0.1);
    }

    [data-theme="dark"] .btn-edit {
        background: #33261a;
        color: #d4a574;
        border: 1px solid #3d2e20;
    }

    [data-theme="dark"] .btn-edit:hover {
        background: #2a1f14;
    }
</style>

<div class="w3-container category-container">
    <h3 class="page-title">
        <i class="fa fa-tags"></i> Gerenciar Categorias
    </h3>

    <a href="/backend/categoria/criar" class="w3-button w3-round-large btn-add">
        <i class="fa fa-plus"></i> Adicionar Nova Categoria
    </a>

    <div class="w3-responsive w3-card w3-round-large table-responsive">
        <table class="w3-table w3-bordered w3-hoverable w3-white category-table">
            <thead class="table-header">
                <tr>
                    <th>Nome da Categoria</th>
                    <th style="width: 180px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $cat): ?>
                    <tr>
                        <td><b><?= htmlspecialchars($cat['nome_categoria']); ?></b></td>

                        <td>
                            <a href="/backend/categoria/editar/<?= $cat['id_categoria']; ?>"
                                class="w3-button w3-small btn-edit">
                                <i class="fa fa-edit"></i> Editar
                            </a>

                            <form action="/backend/categoria/excluir" method="POST" style="display: inline;">
                                <input type="hidden" name="id_categoria" value="<?= $cat['id_categoria']; ?>">
                                <button type="submit" class="w3-button w3-small w3-red w3-round"
                                    onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">
                                    <i class="fa fa-trash"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>