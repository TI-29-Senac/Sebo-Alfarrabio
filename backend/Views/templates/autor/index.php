<div class="w3-container">
    <h3>Gerenciar Autores</h3>
    <a href="/backend/autor/criar" class="w3-button w3-blue">Adicionar Novo Autor</a>
    <br><br>
    
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <thead>
            <tr class="w3-blue">
                <th>Nome</th>
                <th>Biografia</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($autores as $escritor): ?>
                <tr>
                    <td><?= htmlspecialchars($escritor['nome_autor']); ?></td>
                    <td><?= htmlspecialchars(substr($escritor['biografia'], 0, 50)); ?>...</td>
                    <td>
                        <a href="/backend/autor/editar/<?= $escritor['id_autor']; ?>" class="w3-button w3-tiny w3-khaki">Editar</a>
<form action="/backend/autor/excluir/<?= $escritor['id_autor']; ?>" method="POST" style="display:inline;">
    <input type="hidden" name="id_autor" value="<?= $escritor['id_autor']; ?>">
    <button type="submit" class="w3-button w3-tiny w3-red" onclick="return confirm('Tem certeza que deseja excluir este autor?')">
        Excluir
    </button>
</form>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
