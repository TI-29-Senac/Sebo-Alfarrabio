<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sebo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f0e8;
            color: #5a4a3a;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Botões de Ação do Topo */
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .action-btn {
            background: white;
            border: 2px solid #d4c4a8;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #5a4a3a;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .action-btn:hover {
            background: #f9f6f0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .action-btn i {
            font-size: 20px;
        }

        /* Cards de Estatísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            border: 3px solid;
            position: relative;
            overflow: hidden;
        }

        .stat-card.blue {
            border-color: #5b9bd5;
        }

        .stat-card.orange {
            border-color: #f4a261;
        }

        .stat-card.green {
            border-color: #8b9556;
        }

        .stat-card.purple {
            border-color: #9b7bb3;
        }

        .stat-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 50px;
            opacity: 0.2;
        }

        .stat-card.blue .stat-icon {
            color: #5b9bd5;
        }

        .stat-card.orange .stat-icon {
            color: #f4a261;
        }

        .stat-card.green .stat-icon {
            color: #8b9556;
        }

        .stat-card.purple .stat-icon {
            color: #9b7bb3;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #5a4a3a;
        }

        .stat-label {
            font-size: 14px;
            color: #8a7a6a;
        }

        /* Alertas */
        .alerts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }

        .alert-box {
            background: #f4e8d0;
            border-left: 4px solid #d4a574;
            border-radius: 8px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .alert-box i {
            color: #d4a574;
            margin-right: 10px;
        }

        .alert-text {
            flex-grow: 1;
            font-weight: 500;
        }

        .alert-number {
            background: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
        }

        /* Seção de Últimos Itens */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 600;
            color: #5a4a3a;
        }

        .section-title i {
            color: #d4a574;
        }

        .view-all-btn {
            color: #d4a574;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .view-all-btn:hover {
            color: #b8936a;
        }

        /* Tabela */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #c4a574;
            color: white;
        }

        thead th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        tbody tr {
            border-bottom: 1px solid #f0e8d8;
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: #faf8f4;
        }

        tbody td {
            padding: 15px;
            font-size: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: #c8e6c9;
            color: #2e7d32;
        }

        .new-order-btn {
            background: #8b9556;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }

        .new-order-btn:hover {
            background: #7a8449;
            transform: translateY(-2px);
        }

        .action-links a {
            color: #d4a574;
            text-decoration: none;
            margin: 0 5px;
            font-size: 13px;
        }

        .action-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {

            .stats-grid,
            .action-buttons,
            .alerts-grid {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 12px;
            }

            thead th,
            tbody td {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Botões de Ação -->
        <div class="action-buttons">
            <a href="/backend/item/criar" class="action-btn">
                <i class="fa-solid fa-circle-plus"></i>
                Adicionar Produto
            </a>
            <a href="/backend/pedidos/listar" class="action-btn">
                <i class="fa-regular fa-calendar-check"></i>
                Ver Reservas
            </a>
            <a href="/backend/item/listar" class="action-btn">
                <i class="fa-solid fa-boxes-stacked"></i>
                Gerenciar Estoque
            </a>
        </div>

        <!-- Cards de Estatísticas -->
        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-number">17</div>
                <div class="stat-label">Categorias Ativas</div>
                <i class="fa-solid fa-tags stat-icon"></i>
            </div>
            <div class="stat-card orange">
                <div class="stat-number">42</div>
                <div class="stat-label">Itens no Estoque</div>
                <i class="fa-solid fa-box stat-icon"></i>
            </div>
            <div class="stat-card green">
                <div class="stat-number">0</div>
                <div class="stat-label">Reservas do Mês</div>
                <i class="fa-solid fa-cart-shopping stat-icon"></i>
            </div>
            <div class="stat-card purple">
                <div class="stat-number">R$ 0,00</div>
                <div class="stat-label">Faturamento Mensal</div>
                <i class="fa-solid fa-brazilian-real-sign stat-icon"></i>
            </div>
        </div>

        <!-- Alertas -->
        <div class="alerts-grid">
            <div class="alert-box">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span class="alert-text">Categorias Inativas:</span>
                <span class="alert-number">0</span>
            </div>
            <div class="alert-box">
                <i class="fa-solid fa-box-open"></i>
                <span class="alert-text">Itens Inativos:</span>
                <span class="alert-number">1</span>
            </div>
        </div>

        <!-- Últimos Itens Cadastrados -->
        <div class="section-header">
            <h2 class="section-title">
                <i class="fa-solid fa-list"></i>
                Últimos Itens Cadastrados
            </h2>
            <a href="/backend/item/listar" class="view-all-btn">
                Ver todos <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Gênero</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#3</td>
                        <td>A Hora da Estrela</td>
                        <td>Livro Raro</td>
                        <td>Romance</td>
                        <td><span class="status-badge">Ativo</span></td>
                    </tr>
                    <tr>
                        <td>#20</td>
                        <td>As Quatro Estações</td>
                        <td>CD Usado</td>
                        <td>MPB</td>
                        <td><span class="status-badge">Ativo</span></td>
                    </tr>
                    <tr>
                        <td>#17</td>
                        <td>Bad</td>
                        <td>CD Usado</td>
                        <td>Pop</td>
                        <td><span class="status-badge">Ativo</span></td>
                    </tr>
                    <tr>
                        <td>#29</td>
                        <td>Cães de Aluguel</td>
                        <td>DVD Usado</td>
                        <td>Ação</td>
                        <td><span class="status-badge">Ativo</span></td>
                    </tr>
                    <tr>
                        <td>#40</td>
                        <td>Casa Vogue</td>
                        <td>Revista Mensal</td>
                        <td>Moda</td>
                        <td><span class="status-badge">Ativo</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <br><br>

        <!-- Lista de Pedidos -->
        <div class="section-header">
            <h2 class="section-title">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                Lista de Pedidos
            </h2>
        </div>

        <a href="/backend/pedidos/criar" class="new-order-btn">
            <i class="fa-solid fa-plus"></i>
            Novo Pedido
        </a>

        <div class="table-container">
            <table>
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
                            <td><span class="status-badge"><?= $p['status_pedido'] ?></span></td>
                            <td class="action-links">
                                <a href="/backend/pedidos/editar/<?= $p['id_pedido'] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a> |
                                <a href="/backend/pedidos/excluir/<?= $p['id_pedido'] ?>"
                                    onclick="return confirm('Tem certeza que deseja excluir?')">
                                    <i class="fa-solid fa-trash"></i> Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>