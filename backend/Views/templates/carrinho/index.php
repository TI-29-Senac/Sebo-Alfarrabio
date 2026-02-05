<?php
include __DIR__ . '/../partials/header.php';
?>

<div class="w3-container" style="padding: 20px;">
    <header class="w3-container" style="padding-top:22px">
        <h5><b><i class="fa fa-shopping-cart"></i> Minhas Reservas</b></h5>
    </header>

    <div class="w3-container w3-white w3-padding-16 w3-card" style="border-radius: 8px;">
        <?php if (empty($itens)): ?>
            <div class="w3-center w3-padding-32">
                <i class="fa fa-shopping-basket w3-text-grey" style="font-size: 64px; opacity: 0.3;"></i>
                <h3 class="w3-text-brown">Seu carrinho está vazio</h3>
                <p>Você ainda não selecionou nenhum item para reserva.</p>
                <a href="/produtos.html" class="w3-button w3-brown w3-round-large">
                    <i class="fa fa-arrow-left"></i> Voltar ao Catálogo
                </a>
            </div>
        <?php else: ?>
            <div class="w3-responsive">
                <table class="w3-table w3-striped w3-bordered w3-hoverable">
                    <thead>
                        <tr class="w3-brown">
                            <th>Capa</th>
                            <th>Título</th>
                            <th>Preço Unitário</th>
                            <th>Quantidade</th>
                            <th>Subtotal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($itens as $item): ?>
                            <?php $id = $item['id_item']; ?>
                            <tr>
                                <td>
                                    <img src="<?= $item['imagem'] ?: '/img/sem-imagem.png' ?>"
                                        style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;"
                                        onerror="this.src='/img/sem-imagem.png'">
                                </td>
                                <td>
                                    <?= htmlspecialchars($item['titulo']) ?>
                                </td>
                                <td>R$
                                    <?= number_format($item['preco'], 2, ',', '.') ?>
                                </td>
                                <td>
                                    <form action="/backend/index.php/carrinho/atualizar" method="POST"
                                        style="display: flex; align-items: center; gap: 5px;">
                                        <input type="hidden" name="id_item" value="<?= $id ?>">
                                        <input type="number" name="quantidade" value="<?= $item['quantidade'] ?>" min="1"
                                            style="width: 60px;" class="w3-input w3-border">
                                        <button type="submit" class="w3-button w3-tiny w3-blue w3-round">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>R$
                                    <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?>
                                </td>
                                <td>
                                    <a href="/backend/index.php/carrinho/remover/<?= $id ?>"
                                        class="w3-button w3-text-red w3-hover-none"
                                        onclick="return confirm('Remover este item?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="w3-light-grey">
                            <td colspan="4" class="w3-right-align"><strong>TOTAL:</strong></td>
                            <td colspan="2"><strong>R$
                                    <?= number_format($total, 2, ',', '.') ?>
                                </strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="w3-margin-top w3-row-padding">
                <div class="w3-half">
                    <a href="/produtos.html" class="w3-button w3-block w3-light-grey w3-border w3-round">
                        <i class="fa fa-plus"></i> Reservar mais itens
                    </a>
                </div>
                <div class="w3-half">
                    <form action="/backend/index.php/carrinho/finalizar" method="POST">
                        <button type="submit" class="w3-button w3-block w3-brown w3-round w3-large">
                            <i class="fa fa-check"></i> Finalizar Solicitação de Reserva
                        </button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>