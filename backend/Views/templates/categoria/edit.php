<div class="w3-container" style="padding: 20px;">
    <h3 style="color: #6B5235;">
        <i class="fa fa-edit"></i> Editar Categoria:
        <span style="font-weight:600;"><?= htmlspecialchars($categoria['nome_categoria']); ?></span>
    </h3>

    <form action="/backend/categoria/atualizar" method="POST" enctype="multipart/form-data"
        class="w3-card-4 w3-white w3-round-large w3-padding"
        style="max-width: 700px; margin-top: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

        <input type="hidden" name="id_categoria" value="<?= $categoria['id_categoria']; ?>">

        <div class="w3-row-padding">
            <div class="w3-col l12">
                <label class="w3-text-brown"><b>Nome da Categoria*</b></label>
                <input class="w3-input w3-border w3-round" id="nome_categoria" name="nome_categoria" type="text"
                    value="<?= htmlspecialchars($categoria['nome_categoria']); ?>" required>
            </div>
        </div>

        <div class="w3-center" style="margin-top: 30px;">
            <button type="submit" class="w3-button w3-round-large"
                style="background-color: #6B5235; color: white; margin-right: 10px;">
                <i class="fa fa-save"></i> Salvar Alterações
            </button>

            <a href="/categoria/listar" class="w3-button w3-light-grey w3-round-large">
                <i class="fa fa-arrow-left"></i> Cancelar
            </a>
        </div>

    </form>
</div>