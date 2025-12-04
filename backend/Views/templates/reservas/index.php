
  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-brown w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
        <h3><?php echo $total_reservas; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total de Reservas</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-sienna w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_inativos; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Reservas Inativas</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-note w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $total_ativos; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Reservas Ativas</h4>
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
   <h2>Lista de Pedidos</h2>
<a href="/pedidos/criar" class="w3-button w3-green w3-margin-bottom">Novo Pedido</a>

<table class="w3-table w3-striped w3-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Valor Total</th>
            <th>Data</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pedidos as $p): ?>
        <tr>
            <td><?= $p['id_pedido'] ?></td>
            <td>R$ <?= number_format($p['valor_total'], 2, ',', '.') ?></td>
            <td><?= date('d/m/Y', strtotime($p['data_pedido'])) ?></td>
            <td><?= $p['status_pedido'] ?></td>
            <td>
                <a href="/pedidos/editar/<?= $p['id_pedido'] ?>">Editar</a> |
                <a href="/pedidos/excluir/<?= $p['id_pedido'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
