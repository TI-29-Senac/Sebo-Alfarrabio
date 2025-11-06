<div class="w3-container" style="padding: 20px;">
    <h3 style="color: #6B5235;">
        <i class="fa fa-edit"></i> Editar Categoria: 
        <span style="font-weight:600;"><?= htmlspecialchars($categoria['nome_categoria']); ?></span>
    </h3>

    <form action="/backend/categoria/atualizar" 
          method="POST" 
          enctype="multipart/form-data"
          class="w3-card-4 w3-white w3-round-large w3-padding"
          style="max-width: 700px; margin-top: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

        <input type="hidden" name="id_categoria" value="<?= $categoria['id_categoria']; ?>">

        <div class="w3-row-padding">
            <div class="w3-half">
                <label class="w3-text-brown"><b>Nome da Categoria*</b></label>
                <input class="w3-input w3-border w3-round" 
                       id="nome_categoria" 
                       name="nome_categoria" 
                       type="text" 
                       value="<?= htmlspecialchars($categoria['nome_categoria']); ?>" 
                       required>
            </div>

            <div class="w3-half">
                <label class="w3-text-brown"><b>Tipo*</b></label>
                <select class="w3-select w3-border w3-round" 
                        id="tipo_categoria" 
                        name="tipo_categoria" required>
                    <option value="" disabled>Selecione o tipo</option>
                    <option value="importado" <?= $categoria['tipo_categoria'] == 'importado' ? 'selected' : ''; ?>>Importado</option>
                    <option value="novo" <?= $categoria['tipo_categoria'] == 'novo' ? 'selected' : ''; ?>>Novo</option>
                    <option value="usado" <?= $categoria['tipo_categoria'] == 'usado' ? 'selected' : ''; ?>>Usado</option>
                    <option value="raro" <?= $categoria['tipo_categoria'] == 'raro' ? 'selected' : ''; ?>>Raro</option>
                    <option value="antigo" <?= $categoria['tipo_categoria'] == 'antigo' ? 'selected' : ''; ?>>Antigo</option>
                </select>
            </div>
        </div>

        <div class="w3-row-padding" style="margin-top: 20px;">
            <label class="w3-text-brown"><b>Imagem Atual</b></label><br>
            <?php if (!empty($categoria['imagem'])): ?>
                <img src="/uploads/categorias/<?= htmlspecialchars($categoria['imagem']); ?>" 
                     alt="Imagem da categoria" 
                     style="width: 120px; border-radius: 8px; margin-bottom: 10px;">
            <?php else: ?>
                <div class="w3-small w3-text-grey">Nenhuma imagem cadastrada.</div>
            <?php endif; ?>
            <br><br>
            <label class="w3-text-brown"><b>Nova Imagem (opcional)</b></label>
            <input class="w3-input w3-border w3-round" 
                   id="imagem" 
                   name="imagem" 
                   type="file" 
                   accept="image/*">
        </div>

        <div class="w3-center" style="margin-top: 30px;">
            <button type="submit" 
                    class="w3-button w3-round-large" 
                    style="background-color: #6B5235; color: white; margin-right: 10px;">
                <i class="fa fa-save"></i> Salvar Alterações
            </button>

            <a href="/categoria/listar" 
               class="w3-button w3-light-grey w3-round-large">
                <i class="fa fa-arrow-left"></i> Cancelar
            </a>
        </div>

    </form>
</div>
