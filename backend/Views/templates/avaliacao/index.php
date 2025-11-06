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

body {
    background: linear-gradient(135deg, #f5f5f0 0%, #faf8f3 100%);
    color: #333;
    font-family: "Segoe UI", sans-serif;
}

/* CONTAINER PRINCIPAL */
.avaliacao-container {
    max-width: 1100px;
    margin: 50px auto;
    background: white;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    animation: fadeIn 0.6s ease-in-out;
}

/* TÍTULO */
.avaliacao-container h3 {
    font-size: 28px;
    color: var(--marrom);
    font-weight: 700;
    text-align: center;
    margin-bottom: 25px;
}

/* BOTÃO ADICIONAR */
.btn-primary {
    background: var(--bege-dark);
    color: #fff;
    font-weight: 600;
    padding: 12px 22px;
    border-radius: 8px;
    border: none;
    text-decoration: none;
    transition: all 0.3s ease;
}
.btn-primary:hover {
    background: var(--marrom);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(139, 111, 71, 0.3);
}

/* TABELA */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
}
.table thead {
    background: var(--marrom);
    color: white;
}
.table th, .table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
    vertical-align: middle;
}
.table tbody tr:hover {
    background-color: #f9f5ef;
}

/* STATUS */
.status-ativo {
    color: var(--verde);
    font-weight: 600;
}
.status-inativo {
    color: var(--vermelho);
    font-weight: 600;
}

/* BOTÕES DE AÇÃO */
.btn-warning {
    background: var(--laranja);
    border: none;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-warning:hover {
    background: #e69540;
    transform: translateY(-2px);
}

.btn-danger {
    background: var(--vermelho);
    border: none;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-danger:hover {
    background: #b02a37;
    transform: translateY(-2px);
}

/* ANIMAÇÃO */
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(30px);}
    to {opacity: 1; transform: translateY(0);}
}
</style>

<div class="avaliacao-container">
    <h3><i class="fa fa-star"></i> Gerenciamento de Avaliações</h3>

    <div style="text-align:right; margin-bottom:20px;">
        <a href="/backend/avaliacao/criar" class="btn-primary"><i class="fa fa-plus"></i> Adicionar Nova Avaliação</a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nota da Avaliação</th>
                    <th>Comentário</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($avaliacao as $avaliacao): 
                    $label = $avaliacao["status_avaliacao"] =='Inativo' ? 'Ativar' : 'Desativar';
                ?>
                    <tr>
                        <td><?= htmlspecialchars($avaliacao['nota_avaliacao']); ?></td>
                        <td><?= htmlspecialchars($avaliacao['comentario_avaliacao']); ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($avaliacao['data_avaliacao']))); ?></td>
                        <td>
                            <?php if ($avaliacao['status_avaliacao'] == 'Ativo'): ?>
                                <span class="status-ativo">Ativo</span>
                            <?php else: ?>
                                <span class="status-inativo">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/backend/avaliacao/editar/<?= $avaliacao['id_avaliacao']; ?>" class="btn-warning"><i class="fa fa-edit"></i> Editar</a>
                            <a href="/backend/avaliacao/deletar/<?= $avaliacao['id_avaliacao']; ?>" class="btn-danger"><i class="fa fa-trash"></i> <?= $label; ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
