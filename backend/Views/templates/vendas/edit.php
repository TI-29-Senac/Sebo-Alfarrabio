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

.edit-card {
    background: white;
    max-width: 700px;
    margin: 0 auto;
    padding: 40px 30px;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    animation: fadeInUp 0.6s ease-out;
}

.edit-card h1 {
    font-size: 28px;
    color: var(--marrom);
    margin-bottom: 25px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.edit-form label {
    display: block;
    font-weight: 600;
    color: var(--marrom);
    margin-bottom: 6px;
    text-align: left;
}

.edit-form input,
.edit-form select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid var(--bege-light);
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
    background-color: #fafafa;
}

.edit-form input:focus,
.edit-form select:focus {
    border-color: var(--bege-dark);
    background-color: #fff;
    outline: none;
    box-shadow: 0 0 6px rgba(184, 153, 104, 0.4);
}

.form-group {
    margin-bottom: 20px;
    text-align: left;
}

.btn-container {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 30px;
}

.btn-primary {
    background: var(--azul);
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

.btn-primary:hover {
    background: #4A7FB8;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(91, 155, 213, 0.3);
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

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="vendas-container">
    <div class="edit-card">
        <h1><i class="fa fa-edit"></i> Editar Registro da Venda</h1>

        <form action="/backend/vendas/atualizar" method="POST" class="edit-form">
            <!-- Hidden ID -->
            <input type="hidden" name="id_venda" value="<?php echo $vendas['id_venda']; ?>">

            <div class="form-group">
                <label for="data_venda"><i class="fa fa-calendar"></i> Data da Venda</label>
                <input type="text" 
                       id="data_venda" 
                       name="data_venda" 
                       value="<?php echo htmlspecialchars($vendas['data_venda']); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="valor_total"><i class="fa fa-money"></i> Valor Total</label>
                <input type="number" 
                       id="valor_total" 
                       name="valor_total" 
                       step="0.01"
                       value="<?php echo htmlspecialchars($vendas['valor_total']); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="forma_pagamento"><i class="fa fa-credit-card"></i> Forma de Pagamento</label>
                <select id="forma_pagamento" name="forma_pagamento" required>
                    <option value="" disabled>Selecione...</option>
                    <option value="Dinheiro" <?php echo ($vendas['forma_pagamento'] == 'Dinheiro') ? 'selected' : ''; ?>>Dinheiro</option>
                    <option value="Cartão" <?php echo ($vendas['forma_pagamento'] == 'Cartão') ? 'selected' : ''; ?>>Cartão</option>
                    <option value="Transferência" <?php echo ($vendas['forma_pagamento'] == 'Transferência') ? 'selected' : ''; ?>>Transferência</option>
                    <option value="Pix" <?php echo ($vendas['forma_pagamento'] == 'Pix') ? 'selected' : ''; ?>>Pix</option>
                </select>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn-primary">
                    <i class="fa fa-save"></i> Salvar Alterações
                </button>
                <a href="/backend/vendas/listar" class="btn-secondary">
                    <i class="fa fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <?php if (isset($_GET['debug'])): ?>
        <pre style="text-align:left; background:#f4f4f4; padding:20px; margin:20px;">
            <?php print_r($vendas); ?>
        </pre>
    <?php endif; ?>
</div>
