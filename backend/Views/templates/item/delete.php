<!-- Modal Overlay de Confirmação de Exclusão -->
<style>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .delete-modal {
        background: white;
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 550px;
        width: 100%;
        padding: 40px;
        animation: slideUp 0.4s ease-out;
        position: relative;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .delete-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .delete-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #ff6b6b 0%, #dc3545 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
        }
        50% {
            transform: scale(1.05);
            box-shadow: 0 0 0 15px rgba(220, 53, 69, 0);
        }
    }

    .delete-icon svg {
        width: 45px;
        height: 45px;
        fill: white;
    }

    .delete-modal h1 {
        color: #2c3e50;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .item-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
    }

    .item-info .label {
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .item-info .value {
        font-size: 20px;
        color: #2c3e50;
        font-weight: 700;
    }

    .alert-delete {
        background: #fff5f5;
        border-left: 4px solid #dc3545;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-delete p {
        color: #721c24;
        font-size: 16px;
        line-height: 1.6;
        margin: 0;
    }

    .warning-box {
        color: #856404;
        background: #fff3cd;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 14px;
        text-align: center;
        border: 1px solid #ffeaa7;
    }

    .warning-box strong {
        display: block;
        margin-bottom: 5px;
        font-size: 15px;
    }

    .delete-form {
        display: flex;
        gap: 15px;
        margin-top: 25px;
    }

    .btn-delete {
        flex: 1;
        padding: 14px 25px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .btn-danger-delete {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .btn-danger-delete:hover {
        background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
    }

    .btn-danger-delete:active {
        transform: translateY(0);
    }

    .btn-secondary-delete {
        background: #6c757d;
        color: white;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .btn-secondary-delete:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-secondary-delete:active {
        transform: translateY(0);
    }

    @media (max-width: 480px) {
        .delete-modal {
            padding: 30px 20px;
        }

        .delete-modal h1 {
            font-size: 24px;
        }

        .delete-form {
            flex-direction: column;
        }

        .btn-delete {
            width: 100%;
        }
    }
</style>

<div class="modal-overlay">
    <div class="delete-modal">
        <div class="delete-header">
            <div class="delete-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                </svg>
            </div>
            <h1>Confirmar Exclusão</h1>
        </div>

        <div class="item-info">
            <div class="label">Item Selecionado</div>
            <div class="value"><?= htmlspecialchars($titulo_item) ?></div>
        </div>

        <div class="alert-delete">
            <p>
                Tem certeza que deseja mover este item para a lixeira?<br>
                Esta ação pode ser revertida posteriormente.
            </p>
        </div>

        <div class="warning-box">
            <strong>⚠️ Atenção</strong>
            O item será marcado como inativo e movido para a lixeira.
        </div>

        <form action="/backend/item/deletar" method="POST" class="delete-form">
            <input type="hidden" name="id_item" value="<?= $id_item ?>">
            
            <a href="/backend/item/listar" class="btn-delete btn-secondary-delete">✕ Cancelar</a>
            <button type="submit" class="btn-delete btn-danger-delete">🗑️ Sim, Excluir</button>
        </form>
    </div>
</div>