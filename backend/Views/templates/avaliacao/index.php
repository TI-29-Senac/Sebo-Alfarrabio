
  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-brown w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
        <h3><?php echo $total_avaliacao; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total de Avaliações</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-sienna w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_inativos; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Avaliações Inativas</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-note w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_ativos; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Avaliações Ativas</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-taupe w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>99</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Mudanças</h4>
      </div>
    </div>
  </div>

<div>
    <h3>Listar Avaliações</h3>
</div>
<?php if (isset($avaliacao) && count($avaliacao) > 0): ?>
    <table border="1" cellpadding="5" cellspacing="0"  class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <thead>
            <tr>
                <th>ID Avaliação</th>
                <th>ID Acervo</th>
                <th>ID Usuario</th>
                <th>Nota da Avaliação</th>
                <th>Comentário</th>
                <th>Data da Avaliação</th>
                <th>Status da Avaliação</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($avaliacao as $avaliacao): ?>
                <tr>
                    <td><?= htmlspecialchars($avaliacao['id_avaliacao']) ?></td>
                    <td><?= htmlspecialchars($avaliacao['id_acervo']) ?></td>
                    <td><?= htmlspecialchars($avaliacao['id_usuario']) ?></td>
                    <td><?= htmlspecialchars($avaliacao['nota_avaliacao']) ?></td>
                    <td><?= htmlspecialchars($avaliacao['comentario_avaliacao']) ?></td>
                    <td><?= htmlspecialchars($avaliacao['data_avaliacao']) ?></td>
                    <td><?= htmlspecialchars($avaliacao['status_avaliacao']) ?></td>
                    <td><a href="/backend/avaliacao/editar/<?= htmlspecialchars($avaliacao['id_avaliacao']) ?>">Editar</a></td>
                    <td><a href="/backend/avaliacao/excluir/<?= htmlspecialchars($avaliacao['id_avaliacao']) ?>">Excluir</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            
        
<?php else: ?>
    <div>Nenhuma reserva encontrada.</div>
<?php endif ?>
