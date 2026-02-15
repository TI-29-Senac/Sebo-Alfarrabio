<style>
    :root {
        --bege-primary: #D4B896;
        --bege-light: #E8DCCF;
        --bege-dark: #B89968;
        --marrom: #8B6F47;
        --verde: #6B8E23;
        --azul: #5B9BD5;
        --laranja: #F4A460;
        --vermelho: #dc3545;
    }

    .vendas-container {
        background: linear-gradient(135deg, #f5f5f0 0%, #faf8f3 100%);
        min-height: 100vh;
        padding: 40px 20px;
    }

    /* CARD PRINCIPAL */
    .delete-card {
        background: white;
        max-width: 700px;
        margin: 0 auto;
        padding: 40px 30px;
        border-radius: 16px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        text-align: center;
        animation: fadeInUp 0.6s ease-out;
    }

    /* TÍTULO */
    .delete-card h1 {
        font-size: 28px;
        color: var(--vermelho);
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    /* TEXTO DE CONFIRMAÇÃO */
    .delete-card p {
        font-size: 16px;
        color: #555;
        background: #fff5f5;
        padding: 20px;
        border: 1px solid #f5c6cb;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    /* GRIFAR TEXTO IMPORTANTE */
    .delete-card strong {
        color: var(--vermelho);
    }

    /* BOTÕES */
    .btn-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-danger {
        background: var(--vermelho);
        color: white;
        padding: 12px 28px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-danger:hover {
        background: #b02a37;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }

    .btn-secondary {
        background: var(--bege-dark);
        color: white;
        padding: 12px 28px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: var(--marrom);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 111, 71, 0.3);
    }

    /* ANIMAÇÃO */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="vendas-container">
    <div class="delete-card">
        <h1><i class="fa fa-exclamation-triangle"></i> Confirmar Exclusão do Pedido</h1>

        <p>
            Tem certeza que deseja <strong>excluir</strong> o pedido
            <strong>#<?= htmlspecialchars($pedido['id_pedidos'] ?? '') ?></strong>?<br><br>

            <strong>Data do Pedido:</strong>
            <?= isset($pedido['data_pedido']) ? date('d/m/Y H:i', strtotime($pedido['data_pedido'])) : 'Não informada' ?><br>

            <strong>Valor Total:</strong> R$
            <?= isset($pedido['valor_total']) ? number_format($pedido['valor_total'], 2, ',', '.') : '0,00' ?><br>

            <strong>Status Atual:</strong>
            <span style="text-transform: capitalize;">
                <?= isset($pedido['status']) ? str_replace('_', ' ', htmlspecialchars($pedido['status'])) : 'Não informado' ?>
            </span>
        </p>

        <form action="/backend/pedidos/deletar" method="POST"
            onsubmit="return confirm('Excluir permanentemente este pedido? Esta ação não pode ser desfeita.');">
            <input type="hidden" name="id_pedido" value="<?= htmlspecialchars($pedido['id_pedidos'] ?? '') ?>">

            <div class="btn-container">
                <button type="submit" class="btn-danger">
                    <i class="fa fa-trash"></i> Sim, Excluir Pedido
                </button>
                <a href="/backend/pedidos/listar" class="btn-secondary">
                    <i class="fa fa-times"></i> Cancelar
                </a>
            </div>
        </form>

        <?php if (isset($_GET['debug'])): ?>
            <pre style="text-align:left; background:#f4f4f4; padding:10px; margin-top:25px; border-radius:8px;">
                        <?php print_r($pedido); ?>
                    </pre>
        <?php endif; ?>
    </div>
</div>