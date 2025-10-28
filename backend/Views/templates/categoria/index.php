<div class="w3-container">
    <h3>Gerenciar Categorias</h3>
    <a href="/backend/categoria/criar" class="w3-button w3-blue">Adicionar Nova Categoria</a>
    <br><br>
    
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <thead>
            <tr class="w3-blue">
                <th>Nome da Categoria</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categoria as $categoria): ?>
                <tr>
                    <td><?= htmlspecialchars($categoria['nome_categoria']); ?></td>
                    <td><?= htmlspecialchars(substr($categoria['descricao_categoria'], 0, 60)); ?>...</td>
                    <td>
                        <a href="/backend/categoria/editar/<?= $categoria['id_categoria']; ?>" class="w3-button w3-tiny w3-khaki">Editar</a>
                        <a href="/backend/categoria/deletar/<?= $categoria['id_categoria']; ?>" class="w3-button w3-tiny w3-red">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
