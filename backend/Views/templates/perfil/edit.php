<div class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin w3-center" style="max-width:800px;">
    <h1>Editar Perfil do Usuário</h1>
    <form action="/backend/perfil/atualizar" method="POST" enctype="multipart/form-data" class="w3-panel w3-center">
        <input type="hidden" name="id_perfil_usuario" value="<?php echo $perfil['id_perfil_usuario']; ?>">
        <input type="hidden" name="foto_atual" value="<?php echo $perfil['foto_perfil_usuario'] ?? ''; ?>">

        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-phone"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="telefone_usuario" type="text" id="telefone_usuario"
                    value="<?php echo htmlspecialchars($perfil['telefone'] ?? $perfil['telefone_usuario'] ?? ''); ?>"
                    required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-home"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="endereco_usuario" type="text" id="endereco_usuario"
                    value="<?php echo htmlspecialchars($perfil['endereco'] ?? $perfil['endereco_usuario'] ?? ''); ?>"
                    required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-image"></i></div>
            <div class="w3-rest">
                <label for="foto_usuario">Alterar foto (JPEG, PNG ou WebP):</label>
                <br>
                <?php if (!empty($perfil['foto_perfil_usuario'])): ?>
                    <div style="margin-bottom:10px;">
                        <p style="margin:5px 0;font-size:0.85em;color:#666;">Foto atual:</p>
                        <img src="<?= asset_path($perfil['foto_perfil_usuario']) ?>" alt="Foto atual"
                            style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid #ccc;">
                    </div>
                <?php endif; ?>
                <input type="file" name="foto_usuario" id="foto_usuario"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" onchange="previewFoto(event)">
                <div id="preview-container" style="margin-top:10px;display:none;">
                    <p style="margin:5px 0;font-size:0.85em;color:#666;">Nova foto:</p>
                    <img id="foto-preview" src="" alt="Preview"
                        style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:2px solid #4CAF50;">
                </div>
            </div>
        </div>
        <button type="submit" class="w3-button w3-blue">Salvar</button>
    </form>
</div>

<script>
    function previewFoto(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('foto-preview').src = e.target.result;
                document.getElementById('preview-container').style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById('preview-container').style.display = 'none';
        }
    }
</script>