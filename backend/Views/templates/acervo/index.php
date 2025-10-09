<div class="w3-main" style="margin-left:300px;margin-top:43px;">
 
  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>
 
  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>52</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Messages</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>99</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Views</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>23</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Shares</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>50</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Users</h4>
      </div>
    </div>
  </div>
 
<div>listar acervos</div>
<?php if (isset($acervos) && count($acervos) > 0): ?>
        <ul class="w3-ul w3-card-4" style="width:80%">
    <table border="1" cellpadding="5" cellspacing="0">
        <tbody>
            <?php foreach ($acervos as $acervo): ?>
</ul>
                <tr>
                    <li>
                Nome:   <?= htmlspecialchars($acervo['titulo_acervo']) ?> -
                Email:  <?= htmlspecialchars($acervo['tipo_item_acervo']) ?> - 
                Tipo:   <?= htmlspecialchars($acervo['estado_conservacao']) ?> - 
                Status: <?= htmlspecialchars($acervo['disponibilidade_acervo']) ?> - 
                        <?= htmlspecialchars($acervo['estoque_acervo']) ?> - 
                    <img src="/backend/upload/<?= htmlspecialchars($acervo['foto']) ?>" style="width:200px">
                    <a href="/backend/acervo/editar/<?= htmlspecialchars($acervo['id_acervo']) ?>">Editar</a>
                    <a href="/backend/acervo/excluir/<?= htmlspecialchars($acervo['id_acervo']) ?>">Excluir</a>
                </li>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div>Nenhum usuário encontrado.</div>
<?php endif ?>
</div>