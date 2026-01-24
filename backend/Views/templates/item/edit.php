<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Item - Sebo Alfarrábio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8B7355;
            --primary-dark: #6d5a45;
            --accent: #d4af7a;
            --accent-light: #e8d4b8;
            --success: #5a9b7d;
            --warning: #d4a574;
            --danger: #c66b6b;
            --bg-main: #f8f6f3;
            --bg-card: #ffffff;
            --text-primary: #2c2420;
            --text-secondary: #6b6460;
            --border: #e6dfd8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Source Sans 3', sans-serif;
            background: var(--bg-main);
            color: var(--text-primary);
            padding: 0;
            min-height: 100vh;
        }

        /* Header Superior */
        .top-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 25px 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1600px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .star-icon {
            font-size: 42px;
            color: #ffd700;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        .header-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            color: white;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }

        .header-text p {
            font-size: 16px;
            color: rgba(255,255,255,0.85);
            font-weight: 300;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 35px 40px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent) 0%, var(--primary) 100%);
            transform: scaleX(0);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 28px;
            transition: transform 0.3s;
        }

        .stat-card:hover .stat-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-icon-wrapper.blue {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            color: #1976d2;
        }

        .stat-icon-wrapper.green {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            color: var(--success);
        }

        .stat-icon-wrapper.orange {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            color: var(--warning);
        }

        .stat-icon-wrapper.red {
            background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
            color: var(--danger);
        }

        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
            line-height: 1;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-secondary);
            font-weight: 400;
            letter-spacing: 0.3px;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .action-card {
            background: var(--bg-card);
            border: 2px solid var(--border);
            border-radius: 14px;
            padding: 22px 28px;
            display: flex;
            align-items: center;
            gap: 18px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: var(--text-primary);
        }

        .action-card:hover {
            border-color: var(--accent);
            background: linear-gradient(135deg, #ffffff 0%, #faf9f7 100%);
            transform: translateX(4px);
            box-shadow: -4px 0 12px rgba(139, 115, 85, 0.15);
        }

        .action-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent-light) 0%, var(--accent) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: var(--primary-dark);
        }

        .action-text {
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        /* Main Form Container */
        .form-container {
            background: var(--bg-card);
            border-radius: 18px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        /* Form Header */
        .form-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 32px 40px;
            color: white;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 8px;
        }

        .form-subtitle {
            font-size: 15px;
            color: rgba(255,255,255,0.85);
            font-weight: 300;
        }

        /* Form Body */
        .form-body {
            padding: 40px;
        }

        /* Image Upload Section */
        .image-section {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 40px;
            margin-bottom: 45px;
            padding-bottom: 45px;
            border-bottom: 2px solid var(--border);
        }

        .image-upload-zone {
            position: relative;
        }

        .image-preview {
            width: 280px;
            height: 380px;
            border: 3px dashed var(--accent);
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #fafaf9 0%, #f5f3f0 100%);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .image-preview:hover {
            border-color: var(--primary);
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(139, 115, 85, 0.2);
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .image-preview.has-image img {
            display: block;
        }

        .image-preview.has-image .upload-placeholder {
            display: none;
        }

        .upload-placeholder {
            text-align: center;
            color: var(--text-secondary);
            padding: 20px;
        }

        .upload-placeholder i {
            font-size: 56px;
            color: var(--accent);
            margin-bottom: 20px;
            display: block;
        }

        .upload-placeholder p {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        .upload-placeholder small {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .remove-image {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(198, 107, 107, 0.95);
            color: white;
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 16px;
        }

        .image-preview.has-image .remove-image {
            display: flex;
        }

        .remove-image:hover {
            background: #c66b6b;
            transform: scale(1.15);
        }

        #imagem-input {
            display: none;
        }

        /* Basic Info */
        .basic-info {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 45px;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border);
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent-light) 0%, var(--accent) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--primary-dark);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary);
        }

        /* Form Groups */
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 10px;
            letter-spacing: 0.3px;
        }

        .form-group label .required {
            color: var(--danger);
            margin-left: 3px;
        }

        .form-control {
            padding: 14px 18px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 15px;
            font-family: 'Source Sans 3', sans-serif;
            transition: all 0.3s;
            background: #fafafa;
            color: var(--text-primary);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            background: white;
            box-shadow: 0 0 0 4px rgba(212, 175, 122, 0.1);
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238B7355' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 45px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            font-family: 'Source Sans 3', sans-serif;
        }

        /* Price Input with Icon */
        .input-group {
            display: flex;
            align-items: stretch;
        }

        .input-group-text {
            background: linear-gradient(135deg, var(--accent) 0%, var(--primary) 100%);
            color: white;
            padding: 14px 20px;
            border: 2px solid var(--accent);
            border-right: none;
            border-radius: 10px 0 0 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            font-size: 16px;
            letter-spacing: 0.5px;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
            border-left: none;
            flex: 1;
            font-weight: 600;
            font-size: 16px;
        }

        .input-group .form-control:focus {
            border-left: 2px solid var(--accent);
        }

        /* Author Search */
        .autor-search-wrapper {
            position: relative;
        }

        #autor-search-input {
            padding-left: 48px;
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            pointer-events: none;
            font-size: 16px;
        }

        #autor-search-results {
            border: 2px solid var(--border);
            border-top: none;
            max-height: 240px;
            overflow-y: auto;
            background: white;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.08);
            margin-top: -10px;
        }

        #autor-search-results div {
            padding: 14px 18px;
            cursor: pointer;
            transition: background 0.2s;
            border-bottom: 1px solid var(--border);
        }

        #autor-search-results div:last-child {
            border-bottom: none;
        }

        #autor-search-results div:hover {
            background: linear-gradient(90deg, var(--accent-light) 0%, transparent 100%);
        }

        #autores-selecionados-list {
            margin-top: 18px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        #autores-selecionados-list span {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 10px 16px;
            border-radius: 24px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(139, 115, 85, 0.25);
            transition: all 0.3s;
        }

        #autores-selecionados-list span:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(139, 115, 85, 0.35);
        }

        #autores-selecionados-list span button {
            background: rgba(255, 255, 255, 0.25);
            border: none;
            color: white;
            font-weight: bold;
            font-size: 18px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #autores-selecionados-list span button:hover {
            background: rgba(255, 255, 255, 0.45);
            transform: scale(1.1);
        }

        .campo-especifico {
            display: none;
        }

        /* Price Visualization Section */
        .price-section {
            background: linear-gradient(135deg, #f9f7f4 0%, #f3efe9 100%);
            border: 2px solid var(--accent-light);
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 45px;
        }

        .price-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .price-display {
            background: white;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: all 0.3s;
        }

        .price-display:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }

        .price-label {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-secondary);
            font-weight: 600;
            margin-bottom: 12px;
        }

        .price-value {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .price-currency {
            font-size: 20px;
            color: var(--text-secondary);
        }

        .price-note {
            margin-top: 12px;
            font-size: 12px;
            color: var(--text-secondary);
            font-style: italic;
        }

        /* Profit Calculator */
        .profit-calculator {
            background: white;
            border-radius: 14px;
            padding: 28px;
            margin-top: 25px;
            border: 2px dashed var(--accent);
        }

        .calculator-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .calculator-inputs {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .calculator-result {
            background: linear-gradient(135deg, var(--success) 0%, #4a8569 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }

        .calculator-result-label {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            opacity: 0.9;
        }

        .calculator-result-value {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
        }

        /* Action Buttons */
        .form-actions {
            display: flex;
            gap: 18px;
            padding-top: 35px;
            border-top: 2px solid var(--border);
        }

        .btn {
            padding: 16px 36px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            font-family: 'Source Sans 3', sans-serif;
            letter-spacing: 0.3px;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success) 0%, #4a8569 100%);
            color: white;
            flex: 1;
            box-shadow: 0 4px 12px rgba(90, 155, 125, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(90, 155, 125, 0.4);
        }

        .btn-secondary {
            background: var(--text-secondary);
            color: white;
            box-shadow: 0 4px 12px rgba(107, 100, 96, 0.25);
        }

        .btn-secondary:hover {
            background: var(--text-primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(107, 100, 96, 0.35);
        }

        /* Responsive Design */
        @media (max-width: 1400px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .container {
                padding: 25px 20px;
            }

            .image-section {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .image-preview {
                margin: 0 auto;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .price-grid {
                grid-template-columns: 1fr;
            }

            .calculator-inputs {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .top-header {
                padding: 20px 20px;
            }

            .header-text h1 {
                font-size: 28px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .form-body {
                padding: 25px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Header Superior -->
    <div class="top-header">
        <div class="header-content">
            <i class="fas fa-star star-icon"></i>
            <div class="header-text">
                <h1>Gerenciar Item</h1>
                <p>Edite informações e acompanhe o desempenho do produto</p>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon-wrapper blue">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-value">247</div>
                <div class="stat-label">Visualizações</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-wrapper green">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-value">12</div>
                <div class="stat-label">Vendas Totais</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-wrapper orange">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-value" id="stat-estoque">5</div>
                <div class="stat-label">Em Estoque</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon-wrapper red">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-value">4.5</div>
                <div class="stat-label">Avaliação Média</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="#" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <span class="action-text">Adicionar Novo Produto</span>
            </a>
            <a href="#" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <span class="action-text">Ver Reservas</span>
            </a>
            <a href="#" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <span class="action-text">Gerenciar Estoque</span>
            </a>
        </div>

        <!-- Main Form Container -->
        <div class="form-container">
            <div class="form-header">
                <h2 class="form-title">
                    <i class="fas fa-edit"></i>
                    Editar Item: <?= htmlspecialchars($item['titulo_item']) ?>
                </h2>
                <p class="form-subtitle">Atualize as informações do produto e mantenha seu catálogo sempre atualizado</p>
            </div>

            <div class="form-body">
                <form action="/backend/item/atualizar" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_item" value="<?= htmlspecialchars($item['id_item']) ?>">
                    <input type="hidden" name="foto_item_atual" value="<?= htmlspecialchars($item['foto_item'] ?? '') ?>">

                    <!-- Image and Basic Info Section -->
                    <div class="image-section">
                        <div class="image-upload-zone">
                            <div class="image-preview <?= !empty($item['foto_item']) ? 'has-image' : '' ?>" id="image-preview" onclick="document.getElementById('imagem-input').click()">
                                <img id="preview-img" src="<?= htmlspecialchars($item['foto_item'] ?? '') ?>" alt="Preview">
                                <div class="upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Clique para adicionar</p>
                                    <small>PNG, JPG até 5MB</small>
                                </div>
                                <button type="button" class="remove-image" onclick="event.stopPropagation(); removerImagem()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <input type="file" id="imagem-input" name="foto_item" accept="image/*" onchange="previewImagem(event)">
                        </div>

                        <div class="basic-info">
                            <div class="form-group">
                                <label for="titulo_item">
                                    Título do Produto
                                    <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control" id="titulo_item" name="titulo_item" value="<?= htmlspecialchars($item['titulo_item']) ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="4"><?= htmlspecialchars($item['descricao']) ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Price Visualization Section -->
                    <div class="price-section">
                        <div class="section-header" style="border: none; padding-bottom: 0; margin-bottom: 25px;">
                            <div class="section-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <h3 class="section-title">Visualização de Preços</h3>
                        </div>

                        <div class="price-grid">
                            <div class="price-display">
                                <div class="price-label">Preço de Venda</div>
                                <div class="price-value">
                                    <span class="price-currency">R$</span>
                                    <span id="display-preco-venda"><?= number_format((float)($item['preco_item'] ?? 0), 2, ',', '.') ?></span>
                                </div>
                                <p class="price-note">Preço exibido ao cliente</p>
                            </div>

                            <div class="price-display">
                                <div class="price-label">Preço com Desconto (10%)</div>
                                <div class="price-value">
                                    <span class="price-currency">R$</span>
                                    <span id="display-preco-desconto"><?= number_format((float)($item['preco_item'] ?? 0) * 0.9, 2, ',', '.') ?></span>
                                </div>
                                <p class="price-note">Promoção ou cliente fiel</p>
                            </div>

                            <div class="price-display">
                                <div class="price-label">Valor Total em Estoque</div>
                                <div class="price-value">
                                    <span class="price-currency">R$</span>
                                    <span id="display-valor-total"><?= number_format((float)($item['preco_item'] ?? 0) * (int)($item['estoque'] ?? 0), 2, ',', '.') ?></span>
                                </div>
                                <p class="price-note">Valor total do estoque atual</p>
                            </div>
                        </div>

                        <!-- Profit Calculator -->
                        <div class="profit-calculator">
                            <h4 class="calculator-title">
                                <i class="fas fa-calculator"></i>
                                Calculadora de Lucro
                            </h4>
                            <div class="calculator-inputs">
                                <div class="form-group">
                                    <label for="custo-aquisicao">Custo de Aquisição (R$)</label>
                                    <input type="number" class="form-control" id="custo-aquisicao" step="0.01" min="0" value="0.00">
                                </div>
                                <div class="form-group">
                                    <label for="quantidade-venda">Quantidade a Vender</label>
                                    <input type="number" class="form-control" id="quantidade-venda" min="1" value="1">
                                </div>
                            </div>
                            <div class="calculator-result">
                                <div class="calculator-result-label">Lucro Estimado</div>
                                <div class="calculator-result-value" id="lucro-estimado">R$ 0,00</div>
                            </div>
                        </div>
                    </div>

                    <!-- Classification Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <h3 class="section-title">Classificação</h3>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="tipo_item">
                                    Tipo de Item
                                    <span class="required">*</span>
                                </label>
                                <select id="tipo_item" name="tipo_item" class="form-control" required>
                                    <option value="livro" <?= $item['tipo_item'] == 'livro' ? 'selected' : '' ?>>Livro</option>
                                    <option value="cd" <?= $item['tipo_item'] == 'cd' ? 'selected' : '' ?>>CD</option>
                                    <option value="dvd" <?= $item['tipo_item'] == 'dvd' ? 'selected' : '' ?>>DVD</option>
                                    <option value="revista" <?= $item['tipo_item'] == 'revista' ? 'selected' : '' ?>>Revista</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_genero">
                                    Gênero
                                    <span class="required">*</span>
                                </label>
                                <select id="id_genero" name="id_genero" class="form-control" required>
                                    <?php foreach ($generos as $genero): ?>
                                        <option value="<?= $genero['id_genero'] ?>" <?= $item['id_genero'] == $genero['id_genero'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($genero['nome_genero']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_categoria">
                                    Categoria
                                    <span class="required">*</span>
                                </label>
                                <select id="id_categoria" name="id_categoria" class="form-control" required>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id_categoria'] ?>" <?= $item['id_categoria'] == $categoria['id_categoria'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($categoria['nome_categoria']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Authors/Artists Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <h3 class="section-title">Autores/Artistas</h3>
                        </div>

                        <div class="form-group">
                            <label for="autor-search-input">Buscar Autores/Artistas</label>
                            <div class="autor-search-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="autor-search-input" class="form-control" placeholder="Digite o nome do autor ou artista...">
                            </div>
                            <div id="autor-search-results"></div>
                            <div id="autores-selecionados-list">
                                <?php foreach ($autores_selecionados as $autor): ?>
                                    <span id="autor-badge-<?= $autor['id_autor'] ?>">
                                        <?= htmlspecialchars($autor['nome_autor']) ?>
                                        <button type="button" onclick="removerAutor(<?= $autor['id_autor'] ?>)">&times;</button>
                                    </span>
                                    <input type="hidden" name="autores_ids[]" value="<?= $autor['id_autor'] ?>" id="autor-input-<?= $autor['id_autor'] ?>">
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Details Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <div class="section-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h3 class="section-title">Detalhes Adicionais</h3>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="preco_item">
                                    Preço (R$)
                                    <span class="required">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" class="form-control" id="preco_item" name="preco_item" 
                                           step="0.01" min="0" value="<?= number_format((float)($item['preco_item'] ?? 0), 2, '.', '') ?>" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="editora_gravadora">Editora / Gravadora</label>
                                <input type="text" class="form-control" id="editora_gravadora" name="editora_gravadora" value="<?= htmlspecialchars($item['editora_gravadora']) ?>">
                            </div>

                            <div class="form-group">
                                <label for="ano_publicacao">Ano de Publicação</label>
                                <input type="number" class="form-control" id="ano_publicacao" name="ano_publicacao" min="1000" max="2099" value="<?= (int)$item['ano_publicacao'] ?>">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="estoque">
                                    Quantidade em Estoque
                                    <span class="required">*</span>
                                </label>
                                <input type="number" class="form-control" id="estoque" name="estoque" min="0" value="<?= (int)$item['estoque'] ?>" required>
                            </div>

                            <div class="form-group campo-especifico" id="campo-isbn">
                                <label for="isbn">ISBN (Livro)</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" value="<?= htmlspecialchars($item['isbn']) ?>">
                            </div>

                            <div class="form-group campo-especifico" id="campo-duracao">
                                <label for="duracao_minutos">Duração em Minutos (CD/DVD)</label>
                                <input type="number" class="form-control" id="duracao_minutos" name="duracao_minutos" value="<?= (int)$item['duracao_minutos'] ?>">
                            </div>

                            <div class="form-group campo-especifico" id="campo-edicao">
                                <label for="numero_edicao">Número da Edição (Revista)</label>
                                <input type="number" class="form-control" id="numero_edicao" name="numero_edicao" value="<?= (int)$item['numero_edicao'] ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Salvar Alterações
                        </button>
                        <a href="/backend/item/listar" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Preview de Imagem
        function previewImagem(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    const img = document.getElementById('preview-img');
                    img.src = e.target.result;
                    preview.classList.add('has-image');
                }
                reader.readAsDataURL(file);
            }
        }

        function removerImagem() {
            const preview = document.getElementById('image-preview');
            const img = document.getElementById('preview-img');
            const input = document.getElementById('imagem-input');
            
            img.src = '';
            input.value = '';
            preview.classList.remove('has-image');
        }

        // Price Display Update
        function atualizarVisualizacaoPreco() {
            const preco = parseFloat(document.getElementById('preco_item').value) || 0;
            const estoque = parseInt(document.getElementById('estoque').value) || 0;

            // Update price displays
            document.getElementById('display-preco-venda').textContent = preco.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('display-preco-desconto').textContent = (preco * 0.9).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            document.getElementById('display-valor-total').textContent = (preco * estoque).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});

            // Update stock stat
            document.getElementById('stat-estoque').textContent = estoque;

            // Update profit calculator
            calcularLucro();
        }

        // Profit Calculator
        function calcularLucro() {
            const precoVenda = parseFloat(document.getElementById('preco_item').value) || 0;
            const custoAquisicao = parseFloat(document.getElementById('custo-aquisicao').value) || 0;
            const quantidade = parseInt(document.getElementById('quantidade-venda').value) || 1;

            const lucro = (precoVenda - custoAquisicao) * quantidade;
            document.getElementById('lucro-estimado').textContent = 'R$ ' + lucro.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        // Event listeners for price updates
        document.getElementById('preco_item').addEventListener('input', atualizarVisualizacaoPreco);
        document.getElementById('estoque').addEventListener('input', atualizarVisualizacaoPreco);
        document.getElementById('custo-aquisicao').addEventListener('input', calcularLucro);
        document.getElementById('quantidade-venda').addEventListener('input', calcularLucro);

        // Formatação automática do preço
        const precoInput = document.getElementById('preco_item');
        precoInput.addEventListener('blur', function() {
            const valor = parseFloat(this.value);
            if (!isNaN(valor)) {
                this.value = valor.toFixed(2);
                atualizarVisualizacaoPreco();
            }
        });

        // Campos Condicionais
        const tipoSelect = document.getElementById('tipo_item');
        const campoIsbn = document.getElementById('campo-isbn');
        const campoDuracao = document.getElementById('campo-duracao');
        const campoEdicao = document.getElementById('campo-edicao');

        function toggleCamposEspeciais() {
            const tipo = tipoSelect.value;
            campoIsbn.style.display = 'none';
            campoDuracao.style.display = 'none';
            campoEdicao.style.display = 'none';

            if (tipo === 'livro') {
                campoIsbn.style.display = 'block';
            } else if (tipo === 'cd' || tipo === 'dvd') {
                campoDuracao.style.display = 'block';
            } else if (tipo === 'revista') {
                campoEdicao.style.display = 'block';
            }
        }

        tipoSelect.addEventListener('change', toggleCamposEspeciais);
        toggleCamposEspeciais();

        // Busca de Autores
        const searchInput = document.getElementById('autor-search-input');
        const searchResults = document.getElementById('autor-search-results');
        const selectedList = document.getElementById('autores-selecionados-list');
        let debounceTimer;

        searchInput.addEventListener('keyup', () => {
            clearTimeout(debounceTimer);
            const termo = searchInput.value.trim();
            
            if (termo.length < 2) {
                searchResults.innerHTML = '';
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`/backend/ajax/buscar/autores?term=${encodeURIComponent(termo)}`)
                    .then(response => response.json())
                    .then(autores => {
                        searchResults.innerHTML = '';
                        autores.forEach(autor => {
                            const div = document.createElement('div');
                            div.textContent = autor.nome_autor;
                            div.dataset.id = autor.id_autor;
                            div.addEventListener('click', () => adicionarAutor(autor.id_autor, autor.nome_autor));
                            searchResults.appendChild(div);
                        });
                    });
            }, 300);
        });

        function adicionarAutor(id, nome) {
            if (document.querySelector(`#autores-selecionados-list input[value="${id}"]`)) {
                searchInput.value = '';
                searchResults.innerHTML = '';
                return;
            }

            const span = document.createElement('span');
            span.id = `autor-badge-${id}`;
            span.innerHTML = `${nome} <button type="button" onclick="removerAutor(${id})">&times;</button>`;
            selectedList.appendChild(span);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'autores_ids[]';
            input.value = id;
            input.id = `autor-input-${id}`;
            selectedList.appendChild(input);

            searchInput.value = '';
            searchResults.innerHTML = '';
        }

        function removerAutor(id) {
            document.getElementById(`autor-badge-${id}`).remove();
            document.getElementById(`autor-input-${id}`).remove();
        }

        // Initialize price displays on load
        document.addEventListener('DOMContentLoaded', () => {
            atualizarVisualizacaoPreco();
        });
    </script>
</body>
</html>