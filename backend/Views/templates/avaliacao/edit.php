<style>
    .page-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 30px 20px;
    }
    
    .page-header {
        margin-bottom: 30px;
    }
    
    .page-header h3 {
        font-size: 28px;
        font-weight: 600;
        color: #333;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .page-header h3 i {
        color: #C8A870;
    }
    
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #666;
        margin-top: 8px;
    }
    
    .breadcrumb a {
        color: #C8A870;
        text-decoration: none;
    }
    
    .breadcrumb a:hover {
        text-decoration: underline;
    }
    
    .form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 32px;
    }
    
    .form-section {
        margin-bottom: 24px;
    }
    
    .form-section:last-of-type {
        margin-bottom: 0;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    
    .form-label .required {
        color: #E74C3C;
        margin-left: 4px;
    }
    
    .form-label .help-text {
        font-weight: normal;
        color: #999;
        font-size: 12px;
        margin-left: 8px;
    }
    
    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #E0E0E0;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s;
        background: white;
    }
    
    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #C8A870;
        box-shadow: 0 0 0 3px rgba(200, 168, 112, 0.1);
    }
    
    .form-input:read-only {
        background-color: #F5F5F5;
        color: #666;
        cursor: not-allowed;
    }
    
    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    
    .star-rating {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .star-option {
        flex: 1;
        min-width: 80px;
    }
    
    .star-option input[type="radio"] {
        display: none;
    }
    
    .star-option label {
        display: block;
        padding: 12px;
        border: 2px solid #E0E0E0;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 14px;
        font-weight: 500;
    }
    
    .star-option label:hover {
        border-color: #C8A870;
        background-color: #FFF9F0;
    }
    
    .star-option input[type="radio"]:checked + label {
        border-color: #C8A870;
        background-color: #C8A870;
        color: white;
    }
    
    .star-icon {
        font-size: 18px;
        display: block;
        margin-bottom: 4px;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 2px solid #F0F0F0;
    }
    
    .btn {
        padding: 12px 32px;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .btn-primary {
        background-color: #C8A870;
        color: white;
    }
    
    .btn-secondary {
        background-color: #F5F5F5;
        color: #333;
    }
    
    .btn-secondary:hover {
        background-color: #E0E0E0;
    }
    
    .info-box {
        background-color: #E8F4F8;
        border-left: 4px solid #5B9BD5;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        display: flex;
        align-items: start;
        gap: 12px;
    }
    
    .info-box i {
        color: #5B9BD5;
        font-size: 20px;
        margin-top: 2px;
    }
    
    .info-box-content {
        flex: 1;
    }
    
    .info-box-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }
    
    .info-box-text {
        font-size: 14px;
        color: #666;
        line-height: 1.5;
    }
    
    .status-toggle {
        display: flex;
        gap: 12px;
    }
    
    .status-option {
        flex: 1;
    }
    
    .status-option input[type="radio"] {
        display: none;
    }
    
    .status-option label {
        display: block;
        padding: 12px;
        border: 2px solid #E0E0E0;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
    }
    
    .status-option label:hover {
        border-color: #C8A870;
    }
    
    .status-option input[type="radio"]:checked + label.active {
        border-color: #90C695;
        background-color: #D4EDDA;
        color: #155724;
    }
    
    .status-option input[type="radio"]:checked + label.inactive {
        border-color: #E74C3C;
        background-color: #F8D7DA;
        color: #721C24;
    }
</style>

<div class="page-container">
    <div class="page-header">
        <h3>
            <i class="fa fa-star"></i>
            Editando Avaliação
        </h3>
        <div class="breadcrumb">
            <a href="/backend/dashboard"><i class="fa fa-home"></i> Dashboard</a>
            <span>/</span>
            <a href="/backend/avaliacao/listar">Avaliações</a>
            <span>/</span>
            <span>Editar #<?= htmlspecialchars($avaliacao['id_avaliacao']) ?></span>
        </div>
    </div>
    
    <form action="/backend/avaliacao/atualizar" method="POST">
        <div class="form-card">
            <input type="hidden" name="id_avaliacao" value="<?= htmlspecialchars($avaliacao['id_avaliacao']) ?>">
            
            <div class="info-box">
                <i class="fa fa-info-circle"></i>
                <div class="info-box-content">
                    <div class="info-box-title">Informações da Avaliação</div>
                    <div class="info-box-text">
                        Edite os detalhes da avaliação abaixo. Os campos marcados com <span style="color: #E74C3C;">*</span> são obrigatórios.
                    </div>
                </div>
            </div>

            <div class="form-section">
                <label class="form-label">
                    <i class="fa fa-book"></i> Item Avaliado <span class="required">*</span>
                </label>
                <select class="form-select" name="id_item" required>
                    <option value="">Selecione o item...</option>
                    <?php foreach ($itens ?? [] as $item): ?>
                        <option value="<?= $item['id_item'] ?>" <?= $avaliacao['id_item'] == $item['id_item'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($item['titulo_item']) ?> <span style="color: #999;">(ID: <?= $item['id_item'] ?>)</span>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-row">
                <div class="form-section">
                    <label class="form-label">
                        <i class="fa fa-user"></i> ID Usuário
                        <span class="help-text">(somente leitura)</span>
                    </label>
                    <input class="form-input" name="id_usuario" type="number" value="<?= htmlspecialchars($avaliacao['id_usuario']) ?>" readonly>
                </div>

                <div class="form-section">
                    <label class="form-label">
                        <i class="fa fa-calendar"></i> Data da Avaliação
                    </label>
                    <input class="form-input" name="data_avaliacao" type="date" value="<?= htmlspecialchars($avaliacao['data_avaliacao']) ?>">
                </div>
            </div>

            <div class="form-section">
                <label class="form-label">
                    <i class="fa fa-star"></i> Nota da Avaliação <span class="required">*</span>
                </label>
                <div class="star-rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <div class="star-option">
                            <input type="radio" id="star<?= $i ?>" name="nota_avaliacao" value="<?= $i ?>" <?= $avaliacao['nota_avaliacao'] == $i ? 'checked' : '' ?> required>
                            <label for="star<?= $i ?>">
                                <span class="star-icon"><?= str_repeat('⭐', $i) ?></span>
                                <?= $i ?> <?= $i > 1 ? 'Estrelas' : 'Estrela' ?>
                            </label>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="form-section">
                <label class="form-label">
                    <i class="fa fa-comment"></i> Comentário
                    <span class="help-text">(opcional)</span>
                </label>
                <textarea class="form-textarea" name="comentario_avaliacao" placeholder="Escreva um comentário sobre a avaliação..."><?= htmlspecialchars($avaliacao['comentario_avaliacao']) ?></textarea>
            </div>

            <div class="form-section">
                <label class="form-label">
                    <i class="fa fa-toggle-on"></i> Status da Avaliação
                </label>
                <div class="status-toggle">
                    <div class="status-option">
                        <input type="radio" id="status_ativo" name="status_avaliacao" value="ativo" <?= $avaliacao['status_avaliacao'] == 'ativo' ? 'checked' : '' ?>>
                        <label for="status_ativo" class="active">
                            <i class="fa fa-check-circle"></i> Ativo
                        </label>
                    </div>
                    <div class="status-option">
                        <input type="radio" id="status_inativo" name="status_avaliacao" value="inativo" <?= $avaliacao['status_avaliacao'] == 'inativo' ? 'checked' : '' ?>>
                        <label for="status_inativo" class="inactive">
                            <i class="fa fa-times-circle"></i> Inativo
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Salvar Alterações
                </button>
                <a href="/backend/avaliacao/listar" class="btn btn-secondary">
                    <i class="fa fa-times"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
</div>