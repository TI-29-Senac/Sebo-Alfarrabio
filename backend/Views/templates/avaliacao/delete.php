<div class="w3-container">
    <h3 class="w3-text-red">Confirmar Inativação de Avaliação #<?= $avaliacao['id_avaliacao'] ?></h3>
    
    <div class="w3-container w3-card-4 w3-padding">
        <p>Você tem certeza que deseja inativar a avaliação?</p>
        <br>
        
        <h4><strong><?= htmlspecialchars($avaliacao['nota_avaliacao'] ?? '') ?> Estrelas: <?= htmlspecialchars($avaliacao['comentario_avaliacao'] ?? 'Sem comentário') ?></strong></h4>
        
        <p>Esta ação é reversível, mas a avaliação deixará de aparecer no site público.</p>

        <form action="/backend/avaliacao/deletar" method="POST">
            <input type="hidden" name="id_avaliacao" value="<?= $avaliacao['id_avaliacao'] ?>">
            <button type="submit" class="w3-button w3-red w3-padding">Sim, Inativar</button>
            <a href="/backend/avaliacao/listar" class="w3-button w3-grey w3-padding">Cancelar</a>
        </form>
    </div>
</div>