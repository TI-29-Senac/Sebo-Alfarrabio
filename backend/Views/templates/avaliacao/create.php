<div class="w3-container">
    <h3>Nova Avaliação</h3>
    
    <form action="/backend/avaliacao/salvar" method="POST" class="w3-container w3-card-4">
        
        <div class="w3-section">
            <label class="w3-text-blue">ID Item (Livro/Produto) *</label>
            <select class="w3-select w3-border" name="id_item" required>
                <option value="">Selecione...</option>
                <?php foreach ($itens ?? [] as $item): ?>
                    <option value="<?= $item['id_item'] ?>">
                        <?= htmlspecialchars($item['titulo_item']) ?> (ID: <?= $item['id_item'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="w3-section">
    <label class="w3-text-blue">ID Usuário</label>
    <input class="w3-input w3-border" name="id_usuario" type="number" 
           value="<?= $_SESSION['id_usuario'] ?? '' ?>" readonly placeholder="Faça login para ver seu ID">
</div>

        <div class="w3-section">
            <label class="w3-text-blue">Nota (1-5) *</label>
            <select class="w3-select w3-border" name="nota_avaliacao" required>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?> Estrela<?= $i > 1 ? 's' : '' ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="w3-section">
            <label class="w3-text-blue">Comentário</label>
            <textarea class="w3-input w3-border" name="comentario_avaliacao" rows="3"></textarea>
        </div>

        <div class="w3-section">
            <label class="w3-text-blue">Data</label>
            <input class="w3-input w3-border" name="data_avaliacao" type="date" value="<?= date('Y-m-d') ?>">
        </div>

        <div class="w3-section">
            <label class="w3-text-blue">Status</label>
            <select class="w3-select w3-border" name="status_avaliacao">
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
            </select>
        </div>

        <div class="w3-section">
            <button type="submit" class="w3-button w3-blue">Salvar Avaliação</button>
            <a href="/backend/avaliacao/listar" class="w3-button w3-grey">Cancelar</a>
        </div>
    </form>
</div>