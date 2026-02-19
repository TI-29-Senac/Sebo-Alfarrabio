<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pedido - Sebo</title>
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
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #8a7a6a;
        }

        .breadcrumb a {
            color: #d4a574;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb i {
            font-size: 10px;
        }

        /* Header */
        .page-header {
            background: white;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-left: 5px solid #d4a574;
        }

        .page-header h2 {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 24px;
            color: #5a4a3a;
        }

        .page-header i {
            color: #d4a574;
            font-size: 28px;
        }

        /* Form Container */
        .form-container {
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #5a4a3a;
            font-size: 14px;
        }

        .form-group label i {
            margin-right: 6px;
            color: #d4a574;
            width: 16px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e8dcc8;
            border-radius: 8px;
            font-size: 15px;
            color: #5a4a3a;
            background: #fafaf8;
            transition: all 0.3s;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #d4a574;
            background: white;
            box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
        }

        .form-group input:hover,
        .form-group select:hover {
            border-color: #d4a574;
        }

        /* Status Select */
        .form-group select {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23d4a574' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
            appearance: none;
        }

        /* Info Box */
        .info-box {
            background: #fff8e7;
            border-left: 4px solid #f4a261;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: start;
            gap: 12px;
        }

        .info-box i {
            color: #f4a261;
            font-size: 18px;
            margin-top: 2px;
        }

        .info-box-content {
            flex: 1;
        }

        .info-box-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: #5a4a3a;
        }

        .info-box-text {
            font-size: 14px;
            color: #8a7a6a;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 35px;
            padding-top: 25px;
            border-top: 2px solid #f0e8d8;
        }

        .btn {
            padding: 13px 30px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .btn-primary {
            background: #8b9556;
            color: white;
        }

        .btn-primary:hover {
            background: #7a8449;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 149, 86, 0.3);
        }

        .btn-secondary {
            background: white;
            color: #5a4a3a;
            border: 2px solid #d4c4a8;
        }

        .btn-secondary:hover {
            background: #f9f6f0;
            border-color: #c4a574;
            transform: translateY(-2px);
        }

        /* Input Icons */
        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #d4a574;
            pointer-events: none;
        }

        .form-group input[type="date"],
        .form-group input[type="number"] {
            padding-right: 45px;
        }

        /* Required Indicator */
        .required {
            color: #e74c3c;
            margin-left: 3px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .form-container {
                padding: 25px 20px;
            }

            .page-header {
                padding: 20px;
            }

            .page-header h2 {
                font-size: 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Status Badge Preview */
        .status-preview {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 8px;
        }

        .status-pendente {
            background: #fff3cd;
            color: #856404;
        }

        .status-pago {
            background: #c8e6c9;
            color: #2e7d32;
        }

        .status-enviado {
            background: #bbdefb;
            color: #1565c0;
        }

        .status-cancelado {
            background: #ffcdd2;
            color: #c62828;
        }

        .status-reservado {
            background: #ffecb3;
            color: #ffa000;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="/backend/admin/dashboard">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="backend/pedidos/listar">Pedidos</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>Editar Pedido #<?= $pedidos['id_pedidos'] ?></span>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <h2>
                <i class="fa-solid fa-pen-to-square"></i>
                Editar Pedido #<?= $pedidos['id_pedidos'] ?>
            </h2>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <div class="info-box">
                <i class="fa-solid fa-circle-info"></i>
                <div class="info-box-content">
                    <div class="info-box-title">Atualizando Pedido</div>
                    <div class="info-box-text">
                        Preencha os campos abaixo para atualizar as informações do pedido. Todos os campos marcados com
                        <span class="required">*</span> são obrigatórios.
                    </div>
                </div>
            </div>

            <form action="/backend/pedidos/atualizar" method="POST">
                <input type="hidden" name="id_pedido" value="<?= $pedidos['id_pedidos'] ?>">

                <!-- Valor Total -->
                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-brazilian-real-sign"></i>
                        Valor Total <small>(Somente Leitura)</small>
                    </label>
                    <div class="input-wrapper">
                        <input type="number" step="0.01" name="valor_total" value="<?= $pedidos['valor_total'] ?>"
                            placeholder="0,00" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                        <i class="fa-solid fa-money-bill-wave input-icon"></i>
                    </div>
                </div>

                <!-- Data do Pedido -->
                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-calendar-days"></i>
                        Data do Pedido <small>(Somente Leitura)</small>
                    </label>
                    <div class="input-wrapper">
                        <input type="text" name="data_pedido" value="<?= $pedidos['data_pedido'] ?>" readonly
                            style="background-color: #e9ecef; cursor: not-allowed;">
                        <i class="fa-solid fa-calendar-check input-icon"></i>
                    </div>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-tag"></i>
                        Status do Pedido<span class="required">*</span>
                    </label>
                    <select name="status_pedido" required id="statusSelect">
                        <option value="Reservado" <?= $pedidos['status'] == 'Reservado' ? 'selected' : '' ?>>
                            📌 Reservado
                        </option>
                        <option value="Pendente" <?= $pedidos['status'] == 'Pendente' ? 'selected' : '' ?>>
                            📋 Pendente
                        </option>
                        <option value="Cancelado" <?= $pedidos['status'] == 'Cancelado' ? 'selected' : '' ?>>
                            ❌ Cancelado
                        </option>
                    </select>
                    <span class="status-preview status-<?= strtolower($pedidos['status']) ?>" id="statusPreview">
                        Status atual: <?= $pedidos['status'] ?>
                    </span>
                </div>

                <hr style="border: 0; border-top: 1px solid #f0e8d8; margin: 30px 0;">

                <!-- Lista de Itens -->
                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-list"></i>
                        Itens do Pedido
                    </label>
                    
                    <?php if (!empty($pedidos['itens'])): ?>
                    <div style="background: #fafaf8; border: 2px solid #e8dcc8; border-radius: 8px; padding: 15px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e8dcc8;">
                                    <th style="text-align: left; padding-bottom: 10px; color: #5a4a3a;">Item</th>
                                    <th style="padding-bottom: 10px; color: #5a4a3a; text-align: center;">Qtd</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pedidos['itens'] as $item): ?>
                                <tr>
                                    <td style="padding: 10px 0; display: flex; align-items: center; gap: 15px;">
                                        <img src="<?= $item['foto_item'] ?>" 
                                             style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;"
                                             alt="Capa">
                                        <span style="font-weight: 600; color: #5a4a3a;"><?= htmlspecialchars($item['titulo_item']) ?></span>
                                    </td>
                                    <td style="text-align: center; color: #8a7a6a; font-weight: bold;">
                                        <?= $item['quantidade'] ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                        <div style="padding: 15px; background: #fff5f5; border: 1px solid #f5c6cb; border-radius: 8px; color: #721c24;">
                            <i class="fa-solid fa-triangle-exclamation"></i> Nenhum item encontrado neste pedido.
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Atualizar Pedido

                    </button>
                    <a href="/pedidos/listar" class="btn btn-secondary">
                        <i class="fa-solid fa-xmark"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Atualizar preview do status
        const statusSelect = document.getElementById('statusSelect');
        const statusPreview = document.getElementById('statusPreview');

        statusSelect.addEventListener('change', function () {
            const selectedStatus = this.value;
            statusPreview.textContent = 'Status atual: ' + selectedStatus;
            statusPreview.className = 'status-preview status-' + selectedStatus.toLowerCase();
        });
    </script>
</body>

</html>