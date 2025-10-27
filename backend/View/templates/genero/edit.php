<div class="w3-container">
    <h3>Editando Gênero: <?= htmlspecialchars($genero['nome_genero_livro']); ?></h3>
    
    <form action="/backend/genero/atualizar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">
        
        <input type="hidden" name="id_genero_livro" value="<?= $genero['id_genero_livro']; ?>">

        <p>
        <label class="w3-text-blue"><b>Nome do Gênero</b></label>
        <input class="w3-input w3-border" name="nome_genero_livro" type="text" value="<?= htmlspecialchars($genero['nome_genero_livro']); ?>" required>
        </p>

        <p>
        <label class="w3-text-blue"><b>Descrição</b></label>
        <textarea class="w3-input w3-border" name="descricao_genero" rows="3"><?= htmlspecialchars($genero['descricao_genero']); ?></textarea>
        </p>

        <p>
        <button type="submit" class="w3-button w3-blue">Salvar Alterações</button>
        <a href="/backend/genero/listar" class="w3-button w3-grey">Cancelar</a>
        </p>

    </form>
</div>
