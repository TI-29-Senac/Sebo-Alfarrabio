<!-- views/pedidos/create.php -->
<h2>Cadastrar Novo Pedido</h2>

<?php if (isset($_SESSION['mensagem'])): ?>
    <div class="w3-panel w3-<?= $_SESSION['tipo_mensagem'] ?> w3-display-container">
        <span onclick="this.parentElement.style.display='none'" class="w3-button w3-large w3-display-topright">×</span>
        <p><?= $_SESSION['mensagem'] ?></p>
    </div>
    <?php 
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo_mensagem']);
    ?>
<?php endif; ?>

<form action="/pedidos/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4 w3-light-grey w3-margin">
    
    <p>
        <label>Valor Total</label>
        <input class="w3-input w3-border" type="number" step="0.01" name="valor_total" required>
    </p>

    <p>
        <label>Data do Pedido</label>
        <input class="w3-input w3-border" type="date" name="data_pedido" value="<?= date('Y-m-d') ?>" required>
    </p>

    <p>
        <label>Status do Pedido</label>
        <select class="w3-select w3-border" name="status_pedido" required>
            <option value="">Selecione...</option>
            <option value="Pendente">Pendente</option>
            <option value="Pago">Pago</option>
            <option value="Enviado">Enviado</option>
            <option value="Cancelado">Cancelado</option>
        </select>
    </p>

    <p>
        <label>Comprovante (opcional)</label>
        <input class="w3-input w3-border" type="file" name="imagem" accept="image/*,.pdf">
    </p>

    <p>
        <button type="submit" class="w3-button w3-blue">Salvar Pedido</button>
        <a href="/pedidos/listar" class="w3-button w3-gray">Cancelar</a>
    </p>
</form>