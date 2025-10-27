<div class="w3-container">
    <h3>Gerenciar Gêneros</h3>
    <a href="/backend/genero/criar" class="w3-button w3-blue">Adicionar Novo Gênero</a>
    <br><br>
    
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <thead>
            <tr class="w3-blue">
                <th>Nome do Gênero</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($genero as $genero): ?>
                <tr>
                    <td><?= htmlspecialchars($genero['nome_genero_livro']); ?></td>
                    <td><?= htmlspecialchars(substr($genero['descricao_genero'], 0, 60)); ?>...</td>
                    <td>
                        <a href="/backend/genero/editar/<?= $genero['id_genero_livro']; ?>" class="w3-button w3-tiny w3-khaki">Editar</a>
                        <a href="/backend/genero/deletar/<?= $genero['id_genero_livro']; ?>" class="w3-button w3-tiny w3-red">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
