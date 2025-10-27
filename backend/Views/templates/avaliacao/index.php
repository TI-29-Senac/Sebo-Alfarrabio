<div class="w3-container">
    <h3>Gerenciar Avaliações</h3>
    <a href="/backend/avaliacao/criar" class="w3-button w3-blue">Adicionar Nova Avaliação</a>
    <br><br>
    
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <thead>
            <tr class="w3-blue">
                <th>Nota da Avaliação</th>
                <th>Comentário</th>
                <th>Data</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($avaliacao as $avaliacao): 
                $label = $avaliacao["status_avaliacao"] =='Inativo' ? 'Ativar' : 'Desativar';
                ?>
                <tr>
                    <td><?= htmlspecialchars($avaliacao['nota_avaliacao']); ?></td>
                    <td><?= htmlspecialchars($avaliacao['comentario_avaliacao']); ?></td>
                    <td><?= htmlspecialchars($avaliacao['data_avaliacao']); ?></td>
                    <td><?= htmlspecialchars($avaliacao['status_avaliacao']); ?></td>
                    <td>
                        <a href="/backend/avaliacao/editar/<?= $avaliacao['id_avaliacao']; ?>" class="w3-button w3-tiny w3-khaki">Editar</a>
                        
                        <a href="/backend/avaliacao/deletar/<?= $avaliacao['id_avaliacao']; ?>" class="w3-button w3-tiny w3-red"><?php echo $label; ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    </div>