<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Avaliação - Sebo O Alfarrábio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bege-primary: #D4B896;
            --bege-light: #E8DCCF;
            --bege-dark: #B89968;
            --marrom: #8B6F47;
            --verde: #90C695;
            --azul: #5B9BD5;
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
        .container-form {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
        }

        /* HEADER */
        .header-form {
            background: linear-gradient(135deg, var(--marrom) 0%, var(--bege-dark) 100%);
            padding: 30px 40px;
            color: white;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .header-title i {
            font-size: 2.5rem;
            color: #FFD700;
        }

        .header-title h1 {
            font-size: 2rem;
            font-weight: 700;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 10px;
        }

        .breadcrumb a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .breadcrumb a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        .breadcrumb i {
            font-size: 0.8rem;
        }

        /* INFO BOX */
        .info-box {
            background: linear-gradient(135deg, #E8F4F8 0%, #D4EDEA 100%);
            border-left: 5px solid var(--azul);
            padding: 20px;
            margin: 30px 40px;
            border-radius: 8px;
            display: flex;
            align-items: start;
            gap: 15px;
        }

        .info-box i {
            color: var(--azul);
            font-size: 1.5rem;
            margin-top: 2px;
        }

        .info-box-content h3 {
            color: #333;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .info-box-content p {
            color: #555;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* FORMULÁRIO */
        .form-content {
            padding: 0 40px 40px 40px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--marrom);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: var(--bege-dark);
            font-size: 1rem;
        }

        .required {
            color: #E74C3C;
            margin-left: 4px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            padding: 12px 16px;
            border: 2px solid #E0E0E0;
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--bege-dark);
            box-shadow: 0 0 0 3px rgba(184, 153, 104, 0.1);
        }

        .form-input:read-only {
            background: #F5F5F5;
            color: #666;
            cursor: not-allowed;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .form-help {
            font-size: 0.85rem;
            color: #666;
            margin-top: 6px;
            font-style: italic;
        }

        /* RATING STARS */
        .star-rating-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
        }

        .star-option {
            position: relative;
        }

        .star-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .star-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px 10px;
            border: 2px solid #E0E0E0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .star-label:hover {
            border-color: var(--bege-dark);
            background: #FFF9F0;
            transform: translateY(-3px);
        }

        .star-option input[type="radio"]:checked + .star-label {
            border-color: #FFD700;
            background: linear-gradient(135deg, #FFF9E6 0%, #FFE8B3 100%);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        }

        .star-icon {
            font-size: 1.8rem;
            color: #FFD700;
            margin-bottom: 8px;
        }

        .star-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: #666;
        }

        .star-option input[type="radio"]:checked + .star-label .star-text {
            color: var(--marrom);
        }

        /* STATUS TOGGLE */
        .status-toggle {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .status-option {
            position: relative;
        }

        .status-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .status-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border: 2px solid #E0E0E0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .status-label:hover {
            border-color: var(--bege-dark);
        }

        .status-option input[type="radio"]:checked + .status-label.ativo {
            border-color: var(--verde);
            background: #D4EDDA;
            color: #155724;
        }

        .status-option input[type="radio"]:checked + .status-label.inativo {
            border-color: #E74C3C;
            background: #F8D7DA;
            color: #721C24;
        }

        /* BOTÕES */
        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #F0F0F0;
        }

        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--bege-dark) 0%, var(--marrom) 100%);
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--marrom) 0%, var(--bege-dark) 100%);
        }

        .btn-secondary {
            background: #F5F5F5;
            color: #333;
            border: 2px solid #E0E0E0;
        }

        .btn-secondary:hover {
            background: #E0E0E0;
        }

        /* RESPONSIVIDADE */
        @media (max-width: 768px) {
            .header-form {
                padding: 20px;
            }

            .header-title h1 {
                font-size: 1.5rem;
            }

            .info-box,
            .form-content {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .star-rating-container {
                grid-template-columns: repeat(3, 1fr);
            }

            .form-actions {
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

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .star-option input[type="radio"]:checked + .star-label .star-icon {
            animation: pulse 0.5s ease;
        }
    </style>
</head>
<body>

<div class="container-form">
    <!-- HEADER -->
    <div class="header-form">
        <div class="header-title">
            <i class="fas fa-star-half-alt"></i>
            <h1>Nova Avaliação</h1>
        </div>
        <div class="breadcrumb">
            <a href="/backend/dashboard"><i class="fas fa-home"></i> Dashboard</a>
            <span>/</span>
            <a href="/backend/avaliacao/listar">Avaliações</a>
            <span>/</span>
            <span>Nova Avaliação</span>
        </div>
    </div>

    <!-- INFO BOX -->
    <div class="info-box">
        <i class="fas fa-info-circle"></i>
        <div class="info-box-content">
            <h3>Cadastro de Nova Avaliação</h3>
            <p>Preencha os campos abaixo para adicionar uma nova avaliação ao sistema. Os campos marcados com <span class="required">*</span> são obrigatórios.</p>
        </div>
    </div>

    <!-- FORMULÁRIO -->
    <form action="/backend/avaliacao/salvar" method="POST">
        <div class="form-content">
            
            <!-- ITEM E USUÁRIO -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-book"></i>
                        Livro / Item
                        <span class="required">*</span>
                    </label>
                    <select class="form-select" name="id_item" required>
                        <option value="">Selecione o livro...</option>
                        <?php foreach ($itens ?? [] as $item): ?>
                            <option value="<?= $item['id_item'] ?>">
                                <?= htmlspecialchars($item['titulo_item']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="form-help">Selecione o item que está sendo avaliado</span>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user"></i>
                        ID do Usuário
                    </label>
                    <input class="form-input" 
                           name="id_usuario" 
                           type="number" 
                           value="<?= $_SESSION['id_usuario'] ?? '' ?>" 
                           readonly
                           placeholder="Faça login para ver seu ID">
                    <span class="form-help">Usuário logado automaticamente</span>
                </div>
            </div>

            <!-- NOTA -->
            <div class="form-row full">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-star"></i>
                        Nota da Avaliação
                        <span class="required">*</span>
                    </label>
                    <div class="star-rating-container">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <div class="star-option">
                                <input type="radio" 
                                       id="star<?= $i ?>" 
                                       name="nota_avaliacao" 
                                       value="<?= $i ?>" 
                                       <?= $i === 5 ? 'checked' : '' ?>
                                       required>
                                <label for="star<?= $i ?>" class="star-label">
                                    <div class="star-icon">
                                        <?= str_repeat('⭐', $i) ?>
                                    </div>
                                    <span class="star-text"><?= $i ?> Estrela<?= $i > 1 ? 's' : '' ?></span>
                                </label>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <span class="form-help">Clique para selecionar a nota (1 a 5 estrelas)</span>
                </div>
            </div>

            <!-- COMENTÁRIO -->
            <div class="form-row full">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-comment-alt"></i>
                        Comentário da Avaliação
                    </label>
                    <textarea class="form-textarea" 
                              name="comentario_avaliacao" 
                              placeholder="Digite seu comentário sobre o produto aqui..."></textarea>
                    <span class="form-help">Opcional - Escreva sua opinião sobre o produto</span>
                </div>
            </div>

            <!-- DATA E STATUS -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="far fa-calendar"></i>
                        Data da Avaliação
                    </label>
                    <input class="form-input" 
                           name="data_avaliacao" 
                           type="date" 
                           value="<?= date('Y-m-d') ?>">
                    <span class="form-help">Data em que a avaliação foi feita</span>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-toggle-on"></i>
                        Status da Avaliação
                    </label>
                    <div class="status-toggle">
                        <div class="status-option">
                            <input type="radio" 
                                   id="status_ativo" 
                                   name="status_avaliacao" 
                                   value="ativo" 
                                   checked>
                            <label for="status_ativo" class="status-label ativo">
                                <i class="fas fa-check-circle"></i>
                                Ativo
                            </label>
                        </div>
                        <div class="status-option">
                            <input type="radio" 
                                   id="status_inativo" 
                                   name="status_avaliacao" 
                                   value="inativo">
                            <label for="status_inativo" class="status-label inativo">
                                <i class="fas fa-times-circle"></i>
                                Inativo
                            </label>
                        </div>
                    </div>
                    <span class="form-help">Avaliações ativas aparecem no site</span>
                </div>
            </div>

            <!-- BOTÕES -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Salvar Avaliação
                </button>
                <a href="/backend/avaliacao/listar" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
            </div>

        </div>
    </form>
</div>

<script>
// Animação visual ao selecionar estrela
document.querySelectorAll('.star-option input[type="radio"]').forEach(input => {
    input.addEventListener('change', function() {
        // Remove animação de todos
        document.querySelectorAll('.star-icon').forEach(icon => {
            icon.style.animation = 'none';
        });
        
        // Adiciona animação no selecionado
        setTimeout(() => {
            if (this.checked) {
                const icon = this.nextElementSibling.querySelector('.star-icon');
                icon.style.animation = 'pulse 0.5s ease';
            }
        }, 10);
    });
});

// Validação antes de enviar
document.querySelector('form').addEventListener('submit', function(e) {
    const idItem = this.querySelector('[name="id_item"]').value;
    const nota = this.querySelector('[name="nota_avaliacao"]:checked');
    
    if (!idItem) {
        e.preventDefault();
        alert('Por favor, selecione um livro/item para avaliar.');
        return false;
    }
    
    if (!nota) {
        e.preventDefault();
        alert('Por favor, selecione uma nota (1 a 5 estrelas).');
        return false;
    }
});
</script>

</body>
</html>