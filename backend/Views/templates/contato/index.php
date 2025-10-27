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
 

<div class="table-responsive">
  <table class="table table-striped table-bordered align-middle">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Mensagem</th>
        <th class="text-center">Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($contato) && count($contato) > 0): ?>
        <?php foreach ($contato as $contatos): ?>
          <tr>
            <td><?= htmlspecialchars($contatos['nome_contato']) ?></td>
            <td><?= htmlspecialchars($contatos['email_contato']) ?></td>
            <td><?= htmlspecialchars($contatos['mensagem_contato']) ?></td>
            <td class="text-center">
              <a href="/backend/contato/editar/<?= htmlspecialchars($contatos['id_contato']) ?>" class="btn btn-sm btn-warning">
                <i class="fa fa-edit"></i> Editar
              </a>
              <a href="/backend/contato/excluir/<?= htmlspecialchars($contatos['id_contato']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">
                <i class="fa fa-trash"></i> Excluir
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" class="text-center">Nenhum contato encontrado.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>