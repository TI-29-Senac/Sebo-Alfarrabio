
 
  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>
 
  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-amber w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>52</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Messages</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-sienna w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>99</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Views</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-brown w3-padding-16">
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
 
<div>listar usuarios</div>
<?php if (isset($usuarios) && count($usuarios) > 0): ?>
        
        <table border="1" cellpadding="5" cellspacing="0"  class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Status</th>
                <th>Foto</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['nome_usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['email_usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['tipo_usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['status_usuario']) ?></td>
                    <td><img src="/backend/upload/<?= htmlspecialchars($usuario['foto']) ?>" style="width:200px"></td>
                    <td><a href="/backend/usuarios/editar/<?= htmlspecialchars($usuario['id_usuario']) ?>">Editar</a></td>
                    <td><a href="/backend/usuarios/excluir/<?= htmlspecialchars($usuario['id_usuario']) ?>">Excluir</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginacao-controls" style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
    <div class="page-selector" style="display:flex; align-items:center;">
        <div class="page-nav">
            <?php if ($paginacao['pagina_atual'] > 1): ?>
                <a href="/backend/usuarios/listar/<?= $paginacao['pagina_atual'] - 1 ?>">Anterior</a>
            <?php endif; ?>
            <span style="margin:0 10px;">Página <?= $paginacao['pagina_atual'] ?> de <?= $paginacao['ultima_pagina'] ?></span>
            <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                <a href="/backend/usuarios/listar/<?= $paginacao['pagina_atual'] + 1 ?>">Próximo</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php else: ?>
    <div>Nenhum usuário encontrado.</div>
<?php endif ?>
