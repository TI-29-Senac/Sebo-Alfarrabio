<div class="w3-container">
    <h3>Editando Avaliação</h3>
    
    <form action="/backend/avaliacao/atualizar" method="POST" class="w3-container w3-card-4">
        
        <input type="hidden" name="id_avaliacao" value="<?= htmlspecialchars($avaliacao['id_avaliacao']) ?>">

        <div class="w3-section">
            <label class="w3-text-blue">ID Item (Livro/Produto) *</label>
            <select class="w3-select w3-border" name="id_item" required>
                <option value="">Selecione...</option>
                <?php foreach ($itens ?? [] as $item): ?>
                    <option value="<?= $item['id_item'] ?>" <?= $avaliacao['id_item'] == $item['id_item'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($item['titulo_item']) ?> (ID: <?= $item['id_item'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="w3-section">
            <label class="w3-text-blue">ID Usuário</label>
            <input class="w3-input w3-border" name="id_usuario" type="number" value="<?= htmlspecialchars($avaliacao['id_usuario']) ?>" readonly>
        </div>

        <div class="w3-section">
            <label class="w3-text-blue">Nota (1-5) *</label>
            <select class="w3-select w3-border" name="nota_avaliacao" required>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>" <?= $avaliacao['nota_avaliacao'] == $i ? 'selected' : '' ?>>
                        <?= $i ?> Estrela<?= $i > 1 ? 's' : '' ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="w3-section">
            <label class="w3-text-blue">Comentário</label>
            <textarea class="w3-input w3-border" name="comentario_avaliacao" rows="3"><?= htmlspecialchars($avaliacao['comentario_avaliacao']) ?></textarea>
        </div>

        <div class="w3-section">
            <label class="w3-text-blue">Data</label>
            <input class="w3-input w3-border" name="data_avaliacao" type="date" value="<?= htmlspecialchars($avaliacao['data_avaliacao']) ?>">
        </div>

        <div class="w3-section">
            <label class="w3-text-blue">Status</label>
            <select class="w3-select w3-border" name="status_avaliacao">
                <option value="ativo" <?= $avaliacao['status_avaliacao'] == 'ativo' ? 'selected' : '' ?>>Ativo</option>
                <option value="inativo" <?= $avaliacao['status_avaliacao'] == 'inativo' ? 'selected' : '' ?>>Inativo</option>
            </select>
        </div>

        <div class="w3-section">
            <button type="submit" class="w3-button w3-blue">Salvar</button>
            <a href="/backend/avaliacao/listar" class="w3-button w3-grey">Cancelar</a>
        </div>
    </form>
</div>