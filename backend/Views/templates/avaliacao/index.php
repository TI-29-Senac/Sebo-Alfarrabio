<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Avaliações - Sebo O Alfarrábio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bege-primary: #D4B896;
            --bege-light: #E8DCCF;
            --bege-dark: #B89968;
            --marrom: #8B6F47;
            --verde: #90C695;
            --vermelho: #E74C3C;
            --laranja: #F4A460;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f5f0 0%, #faf8f3 100%);
            color: #333;
            padding: 20px;
        }

        /* CONTAINER PRINCIPAL */
        .container-avaliacoes {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        /* HEADER */
        .header-avaliacoes {
            background: linear-gradient(135deg, var(--marrom) 0%, var(--bege-dark) 100%);
            padding: 30px 40px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-title i {
            font-size: 2.5rem;
            color: #FFD700;
        }

        .header-title h1 {
            font-size: 2rem;
            font-weight: 700;
        }

        .header-title p {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-top: 5px;
        }

        .btn-adicionar {
            background: white;
            color: var(--marrom);
            padding: 12px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .btn-adicionar:hover {
            background: var(--bege-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        /* ESTATÍSTICAS */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 30px 40px;
            background: var(--bege-light);
            border-bottom: 3px solid var(--bege-dark);
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.8rem;
        }

        .stat-icon.total {
            background: linear-gradient(135deg, #5B9BD5, #4A8BC2);
            color: white;
        }

        .stat-icon.ativos {
            background: linear-gradient(135deg, var(--verde), #7AB87F);
            color: white;
        }

        .stat-icon.inativos {
            background: linear-gradient(135deg, var(--vermelho), #C0392B);
            color: white;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--marrom);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
            font-weight: 600;
        }

        /* CONTEÚDO DA TABELA */
        .content-avaliacoes {
            padding: 40px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .table-header h2 {
            font-size: 1.5rem;
            color: var(--marrom);
            font-weight: 600;
        }

        /* TABELA */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .table-avaliacoes {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .table-avaliacoes thead {
            background: linear-gradient(135deg, var(--marrom) 0%, var(--bege-dark) 100%);
            color: white;
        }

        .table-avaliacoes thead th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-avaliacoes thead th:first-child {
            border-radius: 12px 0 0 0;
        }

        .table-avaliacoes thead th:last-child {
            border-radius: 0 12px 0 0;
        }

        .table-avaliacoes tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .table-avaliacoes tbody tr:hover {
            background: #faf8f5;
            transform: scale(1.01);
        }

        .table-avaliacoes tbody td {
            padding: 18px 15px;
            vertical-align: middle;
        }

        /* ESTRELAS */
        .rating-stars {
            display: flex;
            gap: 3px;
            font-size: 1.1rem;
        }

        .rating-stars i {
            color: #FFD700;
        }

        .rating-stars .fa-star-o {
            color: #ddd;
        }

        /* COMENTÁRIO */
        .comentario-cell {
            max-width: 350px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: #555;
            font-size: 0.95rem;
        }

        /* DATA */
        .data-cell {
            color: #666;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .data-cell i {
            color: var(--bege-dark);
        }

        /* STATUS */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-badge.ativo {
            background: #D4EDDA;
            color: #155724;
        }

        .status-badge.inativo {
            background: #F8D7DA;
            color: #721C24;
        }

        /* AÇÕES */
        .actions-cell {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-editar {
            background: var(--laranja);
            color: white;
        }

        .btn-editar:hover {
            background: #E69540;
            transform: translateY(-2px);
        }

        .btn-deletar {
            background: var(--vermelho);
            color: white;
        }

        .btn-deletar:hover {
            background: #C0392B;
            transform: translateY(-2px);
        }

        .btn-ativar {
            background: var(--verde);
            color: white;
        }

        .btn-ativar:hover {
            background: #7AB87F;
            transform: translateY(-2px);
        }

        /* MENSAGEM VAZIA */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #ddd;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: #666;
            margin-bottom: 10px;
        }

        /* RESPONSIVIDADE */
        @media (max-width: 768px) {
            .header-avaliacoes {
                padding: 20px;
            }

            .header-title h1 {
                font-size: 1.5rem;
            }

            .stats-container {
                padding: 20px;
                grid-template-columns: 1fr;
            }

            .content-avaliacoes {
                padding: 20px;
            }

            .actions-cell {
                flex-direction: column;
            }
        }

        /* ANIMAÇÕES */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container-avaliacoes {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>
<body>

<div class="container-avaliacoes">
    <!-- HEADER -->
    <div class="header-avaliacoes">
        <div class="header-title">
            <i class="fas fa-star"></i>
            <div>
                <h1>Gerenciar Avaliações</h1>
                <p>Visualize e gerencie todas as avaliações dos clientes</p>
            </div>
        </div>
        <a href="/backend/avaliacao/criar" class="btn-adicionar">
            <i class="fas fa-plus"></i>
            Nova Avaliação
        </a>
    </div>

    <!-- ESTATÍSTICAS -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-number"><?= $total_avaliacao ?? 0 ?></div>
            <div class="stat-label">Total de Avaliações</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon ativos">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-number"><?= $total_ativos ?? 0 ?></div>
            <div class="stat-label">Avaliações Ativas</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon inativos">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-number"><?= $total_inativos ?? 0 ?></div>
            <div class="stat-label">Avaliações Inativas</div>
        </div>
    </div>

    <!-- CONTEÚDO -->
    <div class="content-avaliacoes">
        <div class="table-header">
            <h2><i class="fas fa-list"></i> Lista de Avaliações</h2>
        </div>

        <?php if (empty($avaliacao)): ?>
            <div class="empty-state">
                <i class="fas fa-comments"></i>
                <h3>Nenhuma avaliação encontrada</h3>
                <p>Comece adicionando a primeira avaliação clicando no botão acima.</p>
            </div>
        <?php else: ?>
            <div class="table-wrapper">
                <table class="table-avaliacoes">
                    <thead>
                        <tr>
                            <th>Nota</th>
                            <th>Comentário</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th style="text-align: center;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($avaliacao as $av): ?>
                            <tr>
                                <!-- NOTA -->
                                <td>
                                    <div class="rating-stars">
                                        <?php 
                                        $nota = (int)$av['nota_avaliacao'];
                                        for ($i = 1; $i <= 5; $i++): 
                                            if ($i <= $nota): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif;
                                        endfor; 
                                        ?>
                                        <span style="color: #666; font-weight: 600; margin-left: 5px;">
                                            (<?= $nota ?>)
                                        </span>
                                    </div>
                                </td>

                                <!-- COMENTÁRIO -->
                                <td>
                                    <div class="comentario-cell" title="<?= htmlspecialchars($av['comentario_avaliacao']) ?>">
                                        <?php if (!empty($av['comentario_avaliacao'])): ?>
                                            <i class="fas fa-quote-left" style="color: var(--bege-dark); font-size: 0.8rem;"></i>
                                            <?= htmlspecialchars($av['comentario_avaliacao']) ?>
                                        <?php else: ?>
                                            <span style="color: #999; font-style: italic;">Sem comentário</span>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- DATA -->
                                <td>
                                    <div class="data-cell">
                                        <i class="far fa-calendar"></i>
                                        <?= date('d/m/Y', strtotime($av['data_avaliacao'])) ?>
                                    </div>
                                </td>

                                <!-- STATUS -->
                                <td>
                                    <?php if ($av['status_avaliacao'] == 'ativo'): ?>
                                        <span class="status-badge ativo">
                                            <i class="fas fa-check-circle"></i>
                                            Ativo
                                        </span>
                                    <?php else: ?>
                                        <span class="status-badge inativo">
                                            <i class="fas fa-times-circle"></i>
                                            Inativo
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- AÇÕES -->
                                <td>
                                    <div class="actions-cell">
                                        <a href="/backend/avaliacao/editar/<?= $av['id_avaliacao'] ?>" class="btn-action btn-editar">
                                            <i class="fas fa-edit"></i>
                                            Editar
                                        </a>
                                        
                                        <?php if ($av['status_avaliacao'] == 'ativo'): ?>
                                            <a href="/backend/avaliacao/deletar/<?= $av['id_avaliacao'] ?>" class="btn-action btn-deletar">
                                                <i class="fas fa-ban"></i>
                                                Inativar
                                            </a>
                                        <?php else: ?>
                                            <form action="/backend/avaliacao/ativar" method="POST" style="display: inline;">
                                                <input type="hidden" name="id_avaliacao" value="<?= $av['id_avaliacao'] ?>">
                                                <button type="submit" class="btn-action btn-ativar">
                                                    <i class="fas fa-check"></i>
                                                    Ativar
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>