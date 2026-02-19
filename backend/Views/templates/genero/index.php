<div class="w3-container" style="padding: 20px;">
    <h3 style="color: #6B5235;">
        <i class="fa fa-theater-masks"></i> Gerenciar Gêneros
    </h3>

    <a href="/backend/genero/criar" class="w3-button w3-round-large"
        style="background: var(--bege-dark); color: white; margin: 15px 0;">
        <i class="fa fa-plus"></i> Adicionar Novo Gênero
    </a>

    <div class="w3-responsive w3-card w3-round-large" style="overflow-x: auto; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
        <table class="w3-table w3-bordered w3-hoverable w3-white"
            style="border-color: var(--bege-light); border-radius: 8px;">
            <thead style="background: var(--bege-primary); color: white;">
                <tr>
                    <th>Nome do Gênero</th>
                    <th style="width: 180px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($genero as $cat): ?>
                    <tr>
                        <td><b><?= htmlspecialchars($cat['nome_generos']); ?></b></td>

                        <td>
                            <a href="/backend/genero/editar/<?= $cat['id_generos']; ?>" class="w3-button w3-small"
                                style="background: var(--bege-primary); color: white; border-radius: 6px;">
                                <i class="fa fa-edit"></i> Editar
                            </a>

                            <form action="/backend/genero/excluir" method="POST" style="display: inline;">
                                <input type="hidden" name="id_genero" value="<?= $cat['id_generos']; ?>">
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