<div class="w3-container" style="padding: 20px;">
    <h3 style="color: #6B5235;">
        <i class="fa fa-pencil"></i> Gerenciar Autores
    </h3>

    <a href="/backend/autor/criar" 
       class="w3-button w3-round-large" 
       style="background: var(--bege-dark); color: white; margin: 15px 0;">
       <i class="fa fa-plus"></i> Adicionar Novo Autor
    </a>

    <div class="w3-responsive w3-card w3-round-large" style="overflow-x: auto; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
        <table class="w3-table w3-bordered w3-hoverable w3-white" style="border-color: var(--bege-light); border-radius: 8px;">
            <thead style="background: var(--bege-primary); color: white;">
                <tr>
                    <th>Nome</th>
                    <th>Biografia</th>
                    <th style="width: 180px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($autores as $escritor): ?>
                    <tr>
                        <td><b><?= htmlspecialchars($escritor['nome_autor']); ?></b></td>
                        <td><?= htmlspecialchars(substr($escritor['biografia'], 0, 60)); ?>...</td>
                        <td>
                            <a href="/backend/autor/editar/<?= $escritor['id_autor']; ?>" 
                               class="w3-button w3-small" 
                               style="background: var(--bege-primary); color: white; border-radius: 6px;">
                               <i class="fa fa-edit"></i> Editar
                            </a>

                            <form action="/backend/autor/excluir/<?= $escritor['id_autor']; ?>" 
                                  method="POST" 
                                  style="display: inline;">
                                <input type="hidden" name="id_autor" value="<?= $escritor['id_autor']; ?>">
                                <button type="submit" 
                                        class="w3-button w3-small w3-red w3-round" 
                                        onclick="return confirm('Tem certeza que deseja excluir este autor?')">
                                    <i class="fa fa-trash"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
