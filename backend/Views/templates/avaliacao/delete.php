<div class="w3-container">
    <h3 class="w3-text-red">Confirmar Inativação</h3>
    
    <div class="w3-container w3-card-4 w3-padding">
        <p>Você tem certeza que deseja inativar (excluir) a avaliação?</p>
        <br>
        
        <h4><strong><?= htmlspecialchars($avaliacao['comentario_avaliacao']); ?></strong></h4>
        
        <p>Esta ação não pode ser desfeita facilmente e a avaliação deixará de aparecer no site público.</p>

        <form action="/backend/avaliacao/deletar" method="POST">
            <input type="hidden" name="id_avaliacao" value="<?= $avaliacao['id_avaliacao']; ?>">

            <p>
                <button type="submit" class="w3-button w3-red w3-padding">Sim, Inativar Avaliação</button>
                <a href="/backend/avaliacao/listar" class="w3-button w3-grey w3-padding">Cancelar</a>
            </p>
        </form>
    </div>
</div>