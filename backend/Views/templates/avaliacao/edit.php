<div class="w3-container">
    <h3>Editando Avaliação: <?= htmlspecialchars($avaliacao['nota_avaliacao']); ?></h3>
    
    <form action="/backend/avaliacao/atualizar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">
        
        <input type="hidden" name="id_avaliacao" value="<?= $avaliacao['id_avaliacao']; ?>">

        <p>
        <label class="w3-text-blue"><b>Nota da Avaliação</b></label>
        <input class="w3-input w3-border" name="nota_avaliacao" type="text" value="<?= htmlspecialchars($avaliacao['nota_avaliacao']); ?>" required>
        </p>
        
        <p>
        <label class="w3-text-blue"><b>Comentário</b></label>
        <input class="w3-input w3-border" name="comentario_avaliacao" type="text" value="<?= htmlspecialchars($avaliacao['comentario_avaliacao']); ?>">
        </p>

        <p>
        <label class="w3-text-blue"><b>Data</b></label>
        <input class="w3-input w3-border" name="data_avaliacao" type="text" value="<?= htmlspecialchars($avaliacao['data_avaliacao']); ?>">
        </p>

        <p>
        <label class="w3-text-blue"><b>Status</b></label>
        <input class="w3-input w3-border" name="status_avaliacao" type="text" value="<?= htmlspecialchars($avaliacao['status_avaliacao']); ?>">
        </p>
       

        <p>
        <button type="submit" class="w3-button w3-blue">Salvar Alterações</button>
        <a href="/backend/avaliacao/listar" class="w3-button w3-grey">Cancelar</a>
        </p>

    </form>
</div>