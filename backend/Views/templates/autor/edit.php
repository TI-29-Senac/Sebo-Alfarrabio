<div class="w3-container">
    <h3>Editar Autor</h3>

    <form action="/backend/autor/atualizar/<?= $autor['id_autor']; ?>" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nome_autor">Nome do Autor*</label>
                <input type="text" class="form-control" id="nome_autor" name="nome_autor" value="<?= htmlspecialchars($autor['nome_autor']); ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label for="nacionalidade">Nacionalidade</label>
                <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" value="<?= htmlspecialchars($autor['nacionalidade'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="biografia">Biografia</label>
                <textarea class="form-control" id="biografia" name="biografia" rows="5"><?= htmlspecialchars($autor['biografia']); ?></textarea>
            </div>
        </div>

        <?php if (!empty($autor['foto_autor'])): ?>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Foto Atual:</label><br>
                    <img src="/uploads/autores/<?= htmlspecialchars($autor['foto_autor']); ?>" alt="Foto do autor" width="120" class="w3-round w3-border">
                </div>
            </div>
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="foto_autor">Nova Foto (opcional)</label>
                <input type="file" id="foto_autor" name="foto_autor" class="form-control">
            </div>
        </div>

        <p>
            <button type="submit" class="w3-button w3-blue">Atualizar Autor</button>
        </p>

    </form>
</div>
