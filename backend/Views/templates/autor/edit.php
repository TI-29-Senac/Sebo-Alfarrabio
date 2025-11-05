<div class="w3-container">
    <h3>Editando Autor: <?= htmlspecialchars($autor['nome_autor']); ?></h3>
     
 <form action="/backend/autor/atualizar<?= $autor['id_autor']; ?>" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">
        
        <input type="hidden" name="id_autor" value="<?= $autor['id_autor']; ?>">

        <p>
        <label class="w3-text-blue"><b>Nome do Autor</b></label>
        <input class="w3-input w3-border" name="nome_autor" type="text" value="<?= htmlspecialchars($autor['nome_autor']); ?>" required>
        </p>

        <p>
        <label class="w3-text-blue"><b>Biografia</b></label>
        <textarea class="w3-input w3-border" name="biografia" rows="4"><?= htmlspecialchars($autor['biografia']); ?></textarea>
        </p>

        <p>
        <label class="w3-text-blue"><b>Foto do Autor</b></label>
        <input class="w3-input w3-border" name="foto_autor" type="file" accept="image/*">
        </p>

        <p>
        <button type="submit" class="w3-button w3-blue">Salvar Alterações</button>
        <a href="/autor/listar" class="w3-button w3-grey">Cancelar</a>
        </p>

    </form>
</div>
