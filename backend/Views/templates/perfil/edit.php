
<div class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin w3-center" style="max-width:800px;">
    <h1>Editar Perfil do Usuário</h1>
     <form action="/backend/perfil/atualizar" method="POST" class="w3-panel w3-center">
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="telefone_usuario" type="text" id="telefone_usuario" value="<?php echo $perfil['telefone_usuario']; ?>" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="endereco_usuario" type="text" id="endereco_usuario" value="<?php echo $perfil['endereco_usuario']; ?>" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="foto_usuario" type="image" id="foto_usuario" value="<?php echo $perfil['foto_usuario']; ?>" required>
            </div>
        </div>
        <button type="submit" class="w3-button w3-blue">Salvar</button>
    </form>
</div>