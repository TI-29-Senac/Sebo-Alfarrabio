<style>
    .page-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 30px 20px;
    }
    
    .page-header {
        margin-bottom: 30px;
        text-align: center;
    }
    
    .warning-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #E74C3C 0%, #C0392B 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 4px 20px rgba(231, 76, 60, 0.3);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 4px 20px rgba(231, 76, 60, 0.3);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 6px 25px rgba(231, 76, 60, 0.4);
        }
    }
    
    .warning-icon i {
        font-size: 40px;
        color: white;
    }
    
    .page-header h3 {
        font-size: 28px;
        font-weight: 700;
        color: #E74C3C;
        margin: 0 0 10px 0;
    }
    
    .page-header .subtitle {
        font-size: 16px;
        color: #666;
    }
    
    .confirm-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .alert-banner {
        background: linear-gradient(135deg, #FFF4E6 0%, #FFE8D6 100%);
        border-left: 5px solid #F4A460;
        padding: 20px;
        display: flex;
        align-items: start;
        gap: 15px;
    }
    
    .alert-banner i {
        font-size: 24px;
        color: #F4A460;
        margin-top: 2px;
    }
    
    .alert-content {
        flex: 1;
    }
    
    .alert-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    
    .alert-text {
        font-size: 14px;
        color: #666;
        line-height: 1.6;
    }
    
    .card-body {
        padding: 32px;
    }
    
    .review-preview {
        background: #F9F9F9;
        border: 2px solid #E0E0E0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }
    
    .review-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    .rating-display {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .stars {
        font-size: 24px;
        color: #FFB800;
        letter-spacing: 2px;
    }
    
    .rating-number {
        font-size: 20px;
        font-weight: 700;
        color: #333;
    }
    
    .review-badge {
        background: #E8F4F8;
        color: #5B9BD5;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    
    .review-comment {
        background: white;
        border-left: 3px solid #C8A870;
        padding: 16px;
        border-radius: 8px;
        font-size: 15px;
        line-height: 1.6;
        color: #333;
        font-style: italic;
        margin-bottom: 16px;
    }
    
    .review-comment.empty {
        color: #999;
        font-style: normal;
        border-left-color: #DDD;
    }
    
    .review-meta {
        display: flex;
        gap: 24px;
        font-size: 13px;
        color: #666;
        padding-top: 16px;
        border-top: 1px solid #E0E0E0;
    }
    
    .review-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .review-meta-item i {
        color: #C8A870;
    }
    
    .warning-message {
        background: #FFF3CD;
        border: 2px solid #FFE69C;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
        display: flex;
        align-items: start;
        gap: 12px;
    }
    
    .warning-message i {
        color: #856404;
        font-size: 20px;
        margin-top: 2px;
    }
    
    .warning-message-content {
        flex: 1;
    }
    
    .warning-message strong {
        color: #856404;
        display: block;
        margin-bottom: 4px;
    }
    
    .warning-message p {
        color: #856404;
        margin: 0;
        font-size: 14px;
        line-height: 1.5;
    }
    
    .info-list {
        background: #F5F5F5;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 24px;
    }
    
    .info-list h4 {
        font-size: 15px;
        font-weight: 600;
        color: #333;
        margin: 0 0 12px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .info-list h4 i {
        color: #5B9BD5;
    }
    
    .info-list ul {
        margin: 0;
        padding-left: 20px;
    }
    
    .info-list li {
        color: #666;
        font-size: 14px;
        line-height: 1.8;
        margin-bottom: 6px;
    }
    
    .info-list li:last-child {
        margin-bottom: 0;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        padding-top: 24px;
        border-top: 2px solid #F0F0F0;
    }
    
    .btn {
        flex: 1;
        padding: 14px 32px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-align: center;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #E74C3C 0%, #C0392B 100%);
        color: white;
    }
    
    .btn-danger:hover {
        background: linear-gradient(135deg, #C0392B 0%, #A93226 100%);
    }
    
    .btn-cancel {
        background: #F5F5F5;
        color: #333;
        border: 2px solid #E0E0E0;
    }
    
    .btn-cancel:hover {
        background: #E0E0E0;
        border-color: #CCC;
    }
    
    @media (max-width: 600px) {
        .form-actions {
            flex-direction: column-reverse;
        }
        
        .review-header {
            flex-direction: column;
            align-items: start;
        }
    }
</style>

<div class="page-container">
    <div class="page-header">
        <div class="warning-icon">
            <i class="fa fa-exclamation-triangle"></i>
        </div>
        <h3>Confirmar Inativação de Avaliação</h3>
        <p class="subtitle">Avaliação #<?= $avaliacao['id_avaliacao'] ?></p>
    </div>
    
    <div class="confirm-card">
        <div class="alert-banner">
            <i class="fa fa-info-circle"></i>
            <div class="alert-content">
                <div class="alert-title">Atenção: Ação Reversível</div>
                <div class="alert-text">
                    Esta avaliação será inativada e não aparecerá mais no site público. Você poderá reativá-la posteriormente se necessário.
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="review-preview">
                <div class="review-header">
                    <div class="rating-display">
                        <span class="stars">
                            <?php 
                            $nota = (int)($avaliacao['nota_avaliacao'] ?? 0);
                            echo str_repeat('⭐', $nota);
                            ?>
                        </span>
                        <span class="rating-number"><?= $nota ?>.0</span>
                    </div>
                    <span class="review-badge">
                        <i class="fa fa-eye"></i> Avaliação Pública
                    </span>
                </div>
                
                <div class="review-comment <?= empty(trim($avaliacao['comentario_avaliacao'] ?? '')) ? 'empty' : '' ?>">
                    <?php if (!empty(trim($avaliacao['comentario_avaliacao'] ?? ''))): ?>
                        <i class="fa fa-quote-left" style="color: #C8A870; margin-right: 8px;"></i>
                        <?= htmlspecialchars($avaliacao['comentario_avaliacao']) ?>
                        <i class="fa fa-quote-right" style="color: #C8A870; margin-left: 8px;"></i>
                    <?php else: ?>
                        <i class="fa fa-comment-slash" style="margin-right: 8px;"></i>
                        Sem comentário escrito
                    <?php endif; ?>
                </div>
                
                <div class="review-meta">
                    <div class="review-meta-item">
                        <i class="fa fa-user"></i>
                        <span>Usuário ID: <?= htmlspecialchars($avaliacao['id_usuario'] ?? 'N/A') ?></span>
                    </div>
                    <div class="review-meta-item">
                        <i class="fa fa-book"></i>
                        <span>Item ID: <?= htmlspecialchars($avaliacao['id_item'] ?? 'N/A') ?></span>
                    </div>
                    <div class="review-meta-item">
                        <i class="fa fa-calendar"></i>
                        <span><?= date('d/m/Y', strtotime($avaliacao['data_avaliacao'] ?? 'now')) ?></span>
                    </div>
                </div>
            </div>
            
            <div class="info-list">
                <h4>
                    <i class="fa fa-list-check"></i>
                    O que acontecerá ao inativar:
                </h4>
                <ul>
                    <li>A avaliação não será mais exibida no site público</li>
                    <li>A nota não contará mais na média de avaliações do item</li>
                    <li>O comentário ficará oculto para outros usuários</li>
                    <li>O histórico da avaliação será mantido no sistema</li>
                    <li>Você poderá reativar a avaliação a qualquer momento</li>
                </ul>
            </div>
            
            <div class="warning-message">
                <i class="fa fa-shield-alt"></i>
                <div class="warning-message-content">
                    <strong>Esta ação é segura e reversível</strong>
                    <p>A avaliação não será deletada permanentemente. Ela apenas mudará seu status para "inativo".</p>
                </div>
            </div>

            <form action="/backend/avaliacao/deletar" method="POST">
                <input type="hidden" name="id_avaliacao" value="<?= $avaliacao['id_avaliacao'] ?>">
                
                <div class="form-actions">
                    <a href="/backend/avaliacao/listar" class="btn btn-cancel">
                        <i class="fa fa-arrow-left"></i> Não, Voltar
                    </a>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-ban"></i> Sim, Inativar Avaliação
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Animação de confirmação ao clicar no botão
document.querySelector('.btn-danger').addEventListener('click', function(e) {
    if (!confirm('Tem certeza absoluta que deseja inativar esta avaliação?')) {
        e.preventDefault();
    }
});
</script>