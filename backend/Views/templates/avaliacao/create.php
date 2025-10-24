<div class="w3-container w3-padding-32 w3-center">
    <h2>Criar Nova Avaliacao</h2>
    <form action="/backend/avaliacao/salvar" method="POST" class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-phone"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="nota_avaliacao" type="text" placeholder="Nota da Avaliação" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-home"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="comentario_avaliacao" type="text" placeholder="Comentário" required>
            </div>
        </div>
        <div class="w3-row w3-section">
        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-home"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="data_avaliacao" type="text" placeholder="Data" required>
            </div>
        </div>
        <div class="w3-row w3-section">
        <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-home"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="status_avaliacao" type="text" placeholder="Status" required>
            </div>
        </div>
        <button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding">Enviar</button>
    </form>
</div>