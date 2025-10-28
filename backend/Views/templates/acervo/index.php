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
 
  <!-- Listagem de Acervos -->
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5><i class="fa fa-list me-2"></i>Listar Acervos</h5>
      <a href="/backend/acervo/criar" class="btn btn-outline-coffee btn-sm">
        <i class="fa fa-plus me-1"></i>Adicionar Novo Acervo
      </a>
    </div>

    <?php if (isset($acervos) && count($acervos) > 0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
          <thead>
            <tr>
              <th>Foto</th>
              <th>Título</th>
              <th>Estado</th>
              <th>Disponibilidade</th>
              <th>Estoque</th>
              <th>Publicação</th>
              <th>Detalhes</th>
              <th>Preço</th>
              <th class="text-center">Ações</th>
            </tr>
          </thead>
          <tbody>
            
            <?php foreach ($acervos as $acervo): ?>

              <tr>
                <td><?= htmlspecialchars($acervo['titulo_acervo']) ?></td>
                <td><?= htmlspecialchars($acervo['estado_conservacao']) ?></td>
                <td><?= htmlspecialchars($acervo['disponibilidade_acervo']) ?></td>
                <td><?= htmlspecialchars($acervo['estoque_acervo']) ?></td>
                <td><?= htmlspecialchars($acervo['data_publicacao']) ?></td>
                <td><?= htmlspecialchars($acervo['detalhes_adicionais']) ?></td>
                <td>R$ <?= htmlspecialchars($acervo['preco_acervo']) ?></td>

                <td><img src="/backend/upload/<?= htmlspecialchars($acervo['foto_acervo']); ?>" style="width:100px;"></td>
                <td class="text-center">
                  <a href="/backend/acervo/editar/<?= htmlspecialchars($acervo['id_acervo']) ?>" class="btn btn-sm btn-outline-coffee me-1">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="/backend/acervo/excluir/<?= htmlspecialchars($acervo['id_acervo']) ?>" 
                     class="btn btn-sm btn-outline-danger"
                     onclick="return confirm('Deseja realmente excluir este item?')">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Paginação -->
      <nav aria-label="Navegação de páginas">
        <ul class="pagination justify-content-center mt-3">
          <?php if ($paginacao['pagina_atual'] > 1): ?>
            <li class="page-item">
              <a class="page-link" href="/backend/acervo/listar/<?= $paginacao['pagina_atual'] - 1 ?>">Anterior</a>
            </li>
          <?php endif; ?>

          <li class="page-item active">
            <span class="page-link">
              Página <?= $paginacao['pagina_atual'] ?> de <?= $paginacao['ultima_pagina'] ?>
            </span>
          </li>

          <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
            <li class="page-item">
              <a class="page-link" href="/backend/acervo/listar/<?= $paginacao['pagina_atual'] + 1 ?>">Próximo</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>

    <?php else: ?>
      <div class="alert alert-warning mt-3">Nenhum acervo encontrado.</div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


