
<div class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin w3-center" style="max-width:800px;">
    <h1>Editar Avaliação</h1>
     <form action="/backend/avaliacao/atualizar" method="POST" class="w3-panel w3-center">
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-star"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="nota_avaliacao" type="text" id="nota_avaliacao" value="<?php echo $avaliacao['nota_avaliacao']; ?>" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="comentario_avaliacao" type="text" id="comentario_avaliacao" value="<?php echo $avaliacao['comentario_avaliacao']; ?>" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="data_avaliacao" type="text" id="data_avaliacao" value="<?php echo $avaliacao['data_avaliacao']; ?>" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="status_avaliacao" type="text" id="status_avaliacao" value="<?php echo $avaliacao['status_avaliacao']; ?>" required>
            </div>
        </div>
        <button type="submit" class="w3-button w3-blue">Salvar</button>
    </form>
</div>