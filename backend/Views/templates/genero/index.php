<div class="w3-container" style="padding: 20px;">
    <h3 style="color: #6B5235;">
        <i class="fa fa-theater-masks"></i> Gerenciar Gêneros
    </h3>

    <a href="/backend/genero/criar" 
       class="w3-button w3-round-large" 
       style="background: #B38B5E; color: white; margin: 15px 0; padding: 10px 20px;">
       <i class="fa fa-plus"></i> Adicionar Novo Gênero
    </a>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-top: 20px;">
        <?php foreach ($genero as $cat): ?>
            <div class="w3-card w3-white w3-round-large" style="padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                <h4 style="margin-top: 0; color: #4A4A4A; font-weight: 600;">
                    <?= htmlspecialchars($cat['nome_genero']); ?>
                </h4>
                
                <?php if (!empty($cat['nome_genero_musica'])): ?>
                    <p style="color: #888; font-size: 14px; margin: 10px 0;">
                        <?= htmlspecialchars($cat['nome_genero_musica']); ?>
                    </p>
                <?php else: ?>
                    <p style="color: #888; font-size: 14px; font-style: italic; margin: 10px 0;">
                        Sem informações adicionais
                    </p>
                <?php endif; ?>

                <div style="margin-top: 15px;">
                    <a href="/backend/genero/editar/<?= $cat['id_genero']; ?>" 
                       class="w3-button w3-small" 
                       style="background: #B38B5E; color: white; border-radius: 4px; margin-right: 5px;">
                       <i class="fa fa-edit"></i> Editar
                    </a>

                    <form action="/backend/genero/deletar/<?= $cat['id_genero']; ?>" 
                          method="POST" 
                          style="display: inline;">
                        <input type="hidden" name="id_genero" value="<?= $cat['id_genero']; ?>">
                        <button type="submit" 
                                class="w3-button w3-small w3-red" 
                                style="border-radius: 4px;"
                                onclick="return confirm('Tem certeza que deseja excluir este gênero?')">
                            <i class="fa fa-trash"></i> Excluir
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>