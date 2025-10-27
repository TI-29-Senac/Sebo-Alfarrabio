<div class="w3-container">
    <h3>Gerenciar Autores</h3>
    <a href="/backend/autor/criar" class="w3-button w3-blue">Adicionar Novo Autor</a>
    <br><br>
    
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <thead>
            <tr class="w3-blue">
                <th>Nome</th>
                <th>Nacionalidade</th>
                <th>Data de Nascimento</th>
                <th>Biografia</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($autor as $autor): ?>
                <tr>
                    <td><?= htmlspecialchars($autor['nome_autor']); ?></td>
                    <td><?= htmlspecialchars($autor['nacionalidade_autor']); ?></td>
                    <td><?= htmlspecialchars($autor['data_nascimento_autor']); ?></td>
                    <td><?= htmlspecialchars(substr($autor['biografia_autor'], 0, 50)); ?>...</td>
                    <td>
                        <a href="/backend/autor/editar/<?= $autor['id_autor']; ?>" class="w3-button w3-tiny w3-khaki">Editar</a>
                        <a href="/backend/autor/deletar/<?= $autor['id_autor']; ?>" class="w3-button w3-tiny w3-red">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
