<div class="w3-container">
    <h3>Editando Gênero: <?= htmlspecialchars($genero['nome_generos']); ?></h3>

    <form action="/backend/genero/atualizar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">

        <input type="hidden" name="id_genero" value="<?= $genero['id_generos']; ?>">

        <div class="form-group col-md-12">
            <label for="nome_genero">Nome do Gênero*</label>
            <input type="text" class="form-control" id="nome_genero" name="nome_genero"
                value="<?= htmlspecialchars($genero['nome_generos']); ?>" required>
        </div>
</div>

<p>
    <button type="submit" class="w3-button w3-blue">Salvar Alterações</button>
    <a href="/backend/genero/listar" class="w3-button w3-grey">Cancelar</a>
</p>

</form>
</div>