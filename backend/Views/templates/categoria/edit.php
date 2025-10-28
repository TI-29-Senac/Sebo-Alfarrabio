<div class="w3-container">
    <h3>Editando Categoria: <?= htmlspecialchars($categoria['nome_categoria']); ?></h3>
    
    <form action="/backend/categoria/atualizar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">
        
        <input type="hidden" name="id_categoria" value="<?= $categoria['id_categoria']; ?>">

        <p>
        <label class="w3-text-blue"><b>Nome da Categoria</b></label>
        <input class="w3-input w3-border" name="nome_categoria" type="text" value="<?= htmlspecialchars($categoria['nome_categoria']); ?>" required>
        </p>

        <p>
        <label class="w3-text-blue"><b>Descrição</b></label>
        <textarea class="w3-input w3-border" name="descricao_categoria" rows="3"><?= htmlspecialchars($categoria['descricao_categoria']); ?></textarea>
        </p>

        <p>
        <button type="submit" class="w3-button w3-blue">Salvar Alterações</button>
        <a href="/backend/categoria/listar" class="w3-button w3-grey">Cancelar</a>
        </p>

    </form>
</div>
