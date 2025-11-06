<div class="w3-container">
    <h3>Editando Gênero: <?= htmlspecialchars($genero['nome_genero_livro']); ?></h3>

    <form action="/backend/genero/atualizar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">

        <input type="hidden" name="id_genero_livro" value="<?= $genero['id_genero_livro']; ?>">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nome_genero_livro">Gênero Literário*</label>
                <input type="text" class="form-control" id="nome_genero_livro" name="nome_genero_livro"
                       value="<?= htmlspecialchars($genero['nome_genero_livro']); ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label for="nome_genero_musica">Gênero Musical</label>
                <input type="text" class="form-control" id="nome_genero_musica" name="nome_genero_musica"
                       value="<?= htmlspecialchars($genero['nome_genero_musica'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="descricao_genero">Descrição</label>
                <textarea class="form-control" id="descricao_genero" name="descricao_genero" rows="4"><?= htmlspecialchars($genero['descricao_genero']); ?></textarea>
            </div>
        </div>

        <p>
            <button type="submit" class="w3-button w3-blue">Salvar Alterações</button>
            <a href="/backend/genero/listar" class="w3-button w3-grey">Cancelar</a>
        </p>

    </form>
</div>
