<h2>Editar Pedido #<?= $pedidos['id_pedido'] ?></h2>

<form action="/pedidos/atualizar" method="POST">
    <input type="hidden" name="id_pedido" value="<?= $pedidos['id_pedido'] ?>">

    <label>Valor Total</label>
    <input type="number" step="0.01" name="valor_total" value="<?= $pedidos['valor_total'] ?>" required>

    <label>Data do Pedido</label>
    <input type="date" name="data_pedido" value="<?= $pedidos['data_pedido'] ?>" required>

    <label>Status</label>
    <select name="status_pedido" required>
        <option value="Pendente" <?= $pedidos['status_pedido'] == 'Pendente' ? 'selected' : '' ?>>Pendente</option>
        <option value="Pago" <?= $pedidos['status_pedido'] == 'Pago' ? 'selected' : '' ?>>Pago</option>
        <option value="Enviado" <?= $pedidos['status_pedido'] == 'Enviado' ? 'selected' : '' ?>>Enviado</option>
        <option value="Cancelado" <?= $pedidos['status_pedido'] == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
    </select>

    <button type="submit">Atualizar</button>
    <a href="/pedidos/listar">Cancelar</a>
</form>