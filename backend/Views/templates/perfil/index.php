
  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>
  <a href="/backend/perfil/criar" 
       class="w3-button w3-round-large" 
       style="background: var(--bege-dark); color: white; margin: 15px 0;">
       <i class="fa fa-plus"></i> Adicionar Novo Usuario
    </a>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-brown w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
        <h3><?php echo $total_perfil; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total de Perfis</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-sienna w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_inativos; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Perfis Inativos</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-note w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_ativos; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Perfis Ativos</h4>
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
    <h3>Listar Perfis</h3>
</div>
<?php if (isset($perfil) && count($perfil) > 0): ?>
    <table border="1" cellpadding="5" cellspacing="0"  class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
        <thead>
            <tr>
                <th>ID Perfil Usuário</th>
                <th>ID Usuário</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Foto</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($perfil as $perfil): ?>
                <tr>
                    <td><?= htmlspecialchars($perfil['id_perfil_usuario']) ?></td>
                    <td><?= htmlspecialchars($perfil['id_usuario']) ?></td>
                    <td><?= htmlspecialchars($perfil['telefone_usuario']) ?></td>
                    <td><?= htmlspecialchars($perfil['endereco_usuario']) ?></td>
                    <td><?= htmlspecialchars($perfil['foto_usuario']) ?></td>
                    <td><a href="/backend/perfil/editar/<?= htmlspecialchars($perfil['id_perfil_usuario']) ?>">Editar</a></td>
                    <td><a href="/backend/perfil/excluir/<?= htmlspecialchars($perfil['id_perfil_usuario']) ?>">Excluir</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            
        
<?php else: ?>
    <div>Nenhuma reserva encontrada.</div>
<?php endif ?>
