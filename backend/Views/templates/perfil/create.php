<div class="w3-container w3-padding-32 w3-center">
    <h2>Criar Novo Perfil</h2>
    <form action="/backend/perfil/salvar" method="POST" class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin">
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-phone"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="telefone_usuario" type="text" placeholder="Telefone" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-home"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="endereco_usuario" type="text" placeholder="Endereço" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-image"></i></div>
            <div class="w3-rest">
            <label for="myfile">Escolha uma foto:</label>
            <br>
            <input type="file" name="foto_usuario" type="image" placeholder="Foto" required>
            </div>
        </div>
        <button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding">Criar</button>
    </form>
</div>