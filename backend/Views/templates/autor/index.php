<div class="w3-container" style="padding: 30px;">

    <h3 style="color:#4a3829; font-weight:600;">
        Gerenciar Autores
    </h3>

    <a href="/backend/autor/criar" class="w3-button w3-round-large"
        style="background:#b38b5e; color:white; margin: 18px 0;">
        <i class="fa fa-plus"></i> Adicionar Novo Autor
    </a>

    <div class="w3-row-padding">

        <?php foreach ($autores as $autor): ?>
            <div class="w3-col l3 m4 s12" style="margin-bottom:25px;">
                <div class="w3-card" style="
                        background:#fdf8f2;
                        border-radius:15px;
                        padding:20px;
                        box-shadow:0 3px 10px rgba(0,0,0,0.10);
                     ">

                    <h4 style="color:#4a3829; margin:0;">
                        <?= htmlspecialchars($autor['nome_autor']); ?>
                    </h4>

                    <p style="font-size:13px; color:#6b5d4a; margin-top:10px;">
                        <?= $autor['biografia'] ? nl2br(htmlspecialchars($autor['biografia']))
                            : '<i>Sem biografia cadastrada</i>'; ?>
                    </p>

                    <div style="margin-top:15px;">
                        <a href="/backend/autor/editar/<?= $autor['id_autor']; ?>" class="w3-button w3-round"
                            style="background:#b38b5e; color:white; margin-right:5px;">
                            <i class="fa fa-edit"></i> Editar
                        </a>

                        <form action="/backend/autor/excluir" method="POST" style="display:inline-block;"
                            onsubmit="return confirm('Tem certeza que deseja excluir este autor?')">

                            <input type="hidden" name="id_autor" value="<?= $autor['id_autor']; ?>">

                            <button class="w3-button w3-red w3-round">
                                <i class="fa fa-trash"></i> Excluir
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>