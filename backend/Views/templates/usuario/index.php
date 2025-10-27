  <!-- Cards -->
  <div class="row g-4 mb-4">
        <div class="col-md-3">
          <div class="card card-dashboard card-yellow text-center p-3">
            <h5>Editar</h5>
            <h2>📝</h2>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card card-dashboard card-blue text-center p-3">
            <h5>Views</h5>
            <h2>99</h2>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card card-dashboard card-green text-center p-3">
            <h5>Shares</h5>
            <h2>23</h2>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card card-dashboard card-orange text-center p-3">
            <h5>Usuários</h5>
            <h2>50</h2>
          </div>
        </div>
      </div>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5><i class="fa fa-list me-2"></i>Listar usuarios</h5>
      <a href="/backend/acervo/criar" class="btn btn-outline-coffee btn-sm">
        <i class="fa fa-plus me-1"></i>Adicionar Novo Usuário
      </a>
    </div>

<?php if (isset($usuarios) && count($usuarios) > 0): ?>
        
  <table class="table table-striped table-bordered align-middle">
  <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo</th>
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
                   
                    <td  class="buttom"><a href="/backend/usuarios/editar/<?= htmlspecialchars($usuario['id_usuario']) ?>" >Editar</a></td>
                    <td><a href="/backend/usuarios/excluir/<?= htmlspecialchars($usuario['id_usuario']) ?>" class="buttom-2" >Excluir</a></td>
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
