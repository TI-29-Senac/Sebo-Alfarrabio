<div class="w3-container">
    <h3>Nova Avaliação</h3>
    <form action="backend/avaliacao/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">
        
        <p>
        <label class="w3-text-blue"><b>Nota da Avaliação</b></label>
        <input class="w3-input w3-border" name="nota_avaliacao" type="text" required>
        </p>
        
        <p>
        <label class="w3-text-blue"><b>Comentário</b></label>
        <input class="w3-input w3-border" name="comentario_avaliacao" type="text">
        </p>

        <p>
        <label class="w3-text-blue"><b>Data</b></label>
        <input class="w3-input w3-border" name="data_avaliacao" type="text">
        </p>

        <p>
        <label class="w3-text-blue"><b>Status</b></label>
        <input class="w3-input w3-border" name="status_avaliacao" type="text">
        </p>

        <p>
        <button class="w3-button w3-blue">Salvar Avaliação</button>
        </p>

    </form>
</div>