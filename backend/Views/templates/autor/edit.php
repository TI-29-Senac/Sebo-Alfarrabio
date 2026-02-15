<div class="w3-container" style="padding:40px; max-width:700px; margin:auto;">

    <div class="w3-card"
        style="
            background:#fdf8f2;
            padding:30px;
            border-radius:18px;
            box-shadow:0 3px 10px rgba(0,0,0,0.10);
        ">

        <h3 style="color:#4a3829; margin-top:0;">Editar Autor</h3>

        <form action="/backend/autor/atualizar" method="POST">

            <input type="hidden" name="id_autor" value="<?= $autor['id_autor']; ?>">

            <label class="w3-text-brown"><b>Nome do Autor</b></label>
            <input class="w3-input w3-border w3-round"
                   style="background:white;"
                   name="nome_autor"
                   value="<?= htmlspecialchars($autor['nome_autor']); ?>" required>

            <label class="w3-text-brown" style="margin-top:15px;"><b>Biografia</b></label>
            <textarea class="w3-input w3-border w3-round" 
                      style="background:white;"
                      rows="5"
                      name="biografia"><?= htmlspecialchars($autor['biografia']); ?></textarea>

            <button class="w3-button w3-round-large"
                    style="background:#b38b5e; color:white; margin-top:20px;">
                Atualizar
            </button>

        </form>

    </div>

</div>
