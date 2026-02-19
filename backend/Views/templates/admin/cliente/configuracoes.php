<?php
// O header e footer já são incluídos pelo View::render
?>
<style>
    .settings-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: 'Raleway', sans-serif;
    }

    .settings-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .settings-header {
        background: linear-gradient(135deg, #B89968 0%, #8B6F47 100%);
        color: white;
        padding: 30px;
    }

    .settings-header h2 {
        margin: 0;
        font-weight: 700;
        font-size: 28px;
    }

    .settings-header p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .tab-bar {
        display: flex;
        background: #f8f5f1;
        border-bottom: 1px solid #e0e0e0;
    }

    .tab-btn {
        padding: 15px 25px;
        cursor: pointer;
        font-weight: 600;
        color: #666;
        transition: 0.3s;
        border-bottom: 3px solid transparent;
    }

    .tab-btn:hover {
        background: #eee;
        color: #333;
    }

    .tab-btn.active {
        color: #8B6F47;
        border-bottom-color: #8B6F47;
        background: white;
    }

    .tab-content {
        padding: 40px;
        display: none;
        animation: fadeIn 0.4s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #555;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 15px;
        transition: 0.3s;
    }

    .form-input:focus,
    .form-select:focus {
        border-color: #8B6F47;
        outline: none;
        box-shadow: 0 0 0 3px rgba(139, 111, 71, 0.1);
    }

    .btn-save {
        background: #28a745;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
    }

    .btn-save:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-cancel {
        background: transparent;
        color: #666;
        border: 1px solid #ddd;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        margin-right: 15px;
        transition: 0.3s;
    }

    .btn-cancel:hover {
        background: #f5f5f5;
        color: #333;
    }

    .photo-preview-container {
        display: flex;
        align-items: center;
        gap: 25px;
        margin-bottom: 30px;
    }

    .photo-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f8f5f1;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .photo-upload-btn {
        position: relative;
        overflow: hidden;
        display: inline-block;
        background: #f8f5f1;
        color: #555;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: 0.2s;
    }

    .photo-upload-btn:hover {
        background: #e0e0e0;
    }

    .photo-upload-btn input {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
        height: 100%;
        width: 100%;
    }

    .section-actions {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
    }

    /* ========================================
       TEMA ESCURO — CONFIGURAÇÕES
       ======================================== */
    [data-theme="dark"] .settings-container {
        color: #f5f1e8;
    }

    [data-theme="dark"] .settings-header {
        background: #221a10;
    }

    [data-theme="dark"] .settings-header h2 {
        color: #f5f1e8;
    }

    [data-theme="dark"] .settings-header p {
        color: #a89880;
    }

    [data-theme="dark"] .settings-card {
        background: #221a10;
    }

    [data-theme="dark"] .tab-bar {
        border-bottom-color: rgba(212, 165, 116, 0.15);
    }

    [data-theme="dark"] .tab-btn {
        color: #a89880;
    }

    [data-theme="dark"] .tab-btn.active {
        color: #d4a574;
        border-bottom-color: #d4a574;
        background: rgba(212, 165, 116, 0.05);
    }

    [data-theme="dark"] .tab-content {
        background: #221a10;
    }

    [data-theme="dark"] .form-label {
        color: #d4c5a9;
    }

    [data-theme="dark"] .form-input,
    [data-theme="dark"] .form-select {
        background: #33261a;
        color: #f5f1e8;
        border-color: rgba(212, 165, 116, 0.15);
    }

    [data-theme="dark"] .form-input:focus,
    [data-theme="dark"] .form-select:focus {
        border-color: #d4a574;
    }

    [data-theme="dark"] .form-input::placeholder {
        color: #a89880;
    }

    [data-theme="dark"] .photo-preview-container {
        color: #d4c5a9;
    }

    [data-theme="dark"] .photo-preview {
        border-color: rgba(212, 165, 116, 0.2);
    }

    [data-theme="dark"] .section-title {
        color: #f5f1e8;
    }

    [data-theme="dark"] .section-actions {
        border-top-color: rgba(212, 165, 116, 0.1);
    }

    [data-theme="dark"] .btn-cancel {
        background: #33261a;
        color: #d4c5a9;
        border-color: rgba(212, 165, 116, 0.2);
    }

    [data-theme="dark"] .btn-save {
        background: #d4a574;
        color: #1a1209;
    }

    [data-theme="dark"] .btn-save:hover {
        background: #c89968;
    }

    /* ========================================
       RESPONSIVO
       ======================================== */
    @media (max-width: 768px) {
        .settings-container {
            padding: 15px 10px;
        }

        .settings-header {
            padding: 20px;
        }

        .settings-header h2 {
            font-size: 22px;
        }

        .settings-header p {
            font-size: 13px;
        }

        .tab-bar {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .tab-bar::-webkit-scrollbar {
            display: none;
        }

        .tab-btn {
            padding: 12px 18px;
            font-size: 13px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .tab-content {
            padding: 25px 20px;
        }

        .photo-preview-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .section-actions {
            margin: 0 20px 25px;
            flex-direction: column;
            gap: 10px;
        }

        .btn-cancel,
        .btn-save {
            width: 100%;
            text-align: center;
            margin-right: 0;
        }
    }

    @media (max-width: 480px) {
        .settings-header {
            padding: 15px;
        }

        .settings-header h2 {
            font-size: 20px;
        }

        .tab-btn {
            padding: 10px 14px;
            font-size: 12px;
        }

        .tab-content {
            padding: 20px 15px;
        }

        .form-input,
        .form-select {
            padding: 10px 12px;
            font-size: 14px;
        }

        .photo-preview {
            width: 80px;
            height: 80px;
        }

        .btn-save {
            font-size: 14px;
            padding: 10px 20px;
        }

        .btn-cancel {
            font-size: 14px;
            padding: 10px 20px;
        }
    }
</style>

<div class="settings-container">
    <div class="settings-card">
        <div class="settings-header">
            <h2><i class="fa fa-cog"></i> Configurações do Perfil</h2>
            <p>Gerencie suas informações pessoais e segurança da conta</p>
        </div>

        <div class="tab-bar">
            <div class="tab-btn active" onclick="openTab(event, 'dados-pessoais')"><i class="fa fa-user"></i> Dados
                Pessoais</div>
            <div class="tab-btn" onclick="openTab(event, 'seguranca')"><i class="fa fa-lock"></i> Segurança</div>
        </div>

        <form action="/backend/admin/cliente/configuracoes/salvar" method="POST" enctype="multipart/form-data">

            <!-- ABAS -->
            <div id="dados-pessoais" class="tab-content" style="display: block;">

                <div class="photo-preview-container">
                    <img src="<?= !empty($usuario['foto_perfil_usuario']) ? $usuario['foto_perfil_usuario'] : '/img/avatar_placeholder.png' ?>"
                        alt="Foto de Perfil" class="photo-preview" id="preview-img">
                    <div>
                        <div class="photo-upload-btn">
                            <i class="fa fa-camera"></i> Alterar Foto
                            <input type="file" name="foto_usuario" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <input type="hidden" name="foto_atual" value="<?= $usuario['foto_perfil_usuario'] ?? '' ?>">
                        <p style="font-size: 12px; color: #888; margin-top: 8px;">Recomendado: JPG ou PNG, máx 2MB</p>
                    </div>
                </div>

                <div class="w3-row-padding" style="margin: 0 -16px;">
                    <div class="w3-half">
                        <div class="form-group">
                            <label class="form-label">Nome Completo</label>
                            <input type="text" class="form-input" name="nome_usuario"
                                value="<?= htmlspecialchars($usuario['nome_usuario']) ?>" required>
                        </div>
                    </div>
                    <div class="w3-half">
                        <div class="form-group">
                            <label class="form-label">Email Cadastrado</label>
                            <input type="email" class="form-input" name="email_usuario"
                                value="<?= htmlspecialchars($usuario['email_usuario']) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="w3-row-padding" style="margin: 0 -16px;">
                    <div class="w3-half">
                        <div class="form-group">
                            <label class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-input" name="data_nascimento_usuario"
                                value="<?= $usuario['data_nascimento_usuario'] ?? '' ?>">
                        </div>
                    </div>
                    <div class="w3-half">
                        <div class="form-group">
                            <label class="form-label">Gênero</label>
                            <select class="form-select" name="genero_usuario">
                                <option value="">Selecione...</option>
                                <option value="Masculino" <?= ($usuario['genero_usuario'] ?? '') == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                                <option value="Feminino" <?= ($usuario['genero_usuario'] ?? '') == 'Feminino' ? 'selected' : '' ?>>Feminino</option>
                                <option value="Outro" <?= ($usuario['genero_usuario'] ?? '') == 'Outro' ? 'selected' : '' ?>>Outro</option>
                                <option value="Prefiro não dizer" <?= ($usuario['genero_usuario'] ?? '') == 'Prefiro não dizer' ? 'selected' : '' ?>>Prefiro não dizer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Telefone / Celular</label>
                    <input type="text" class="form-input" name="telefone_usuario"
                        value="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>" placeholder="(00) 00000-0000">
                </div>

                <div class="form-group">
                    <label class="form-label">Idioma de Preferência</label>
                    <select class="form-select" name="idioma_usuario">
                        <option value="Português" <?= ($usuario['idioma_usuario'] ?? '') == 'Português' ? 'selected' : '' ?>>Português (Brasil)</option>
                        <option value="Inglês" <?= ($usuario['idioma_usuario'] ?? '') == 'Inglês' ? 'selected' : '' ?>>
                            English</option>
                        <option value="Espanhol" <?= ($usuario['idioma_usuario'] ?? '') == 'Espanhol' ? 'selected' : '' ?>>
                            Español</option>
                    </select>
                </div>
            </div>

            <div id="seguranca" class="tab-content">
                <div class="w3-panel w3-pale-blue w3-border w3-border-blue w3-round">
                    <p><i class="fa fa-shield"></i> Preencha os campos abaixo APENAS se desejar alterar sua senha.</p>
                </div>

                <div class="w3-row-padding" style="margin: 0 -16px;">
                    <div class="w3-half">
                        <div class="form-group">
                            <label class="form-label">Nova Senha</label>
                            <input type="password" class="form-input" name="nova_senha" id="nova_senha"
                                placeholder="Deixe em branco para manter a atual" onkeyup="checkPasswordStrength()">
                            <div
                                style="margin-top: 5px; height: 5px; background: #eee; border-radius: 3px; overflow: hidden;">
                                <div id="password-strength-bar" style="height: 100%; width: 0%; transition: 0.3s;">
                                </div>
                            </div>
                            <small id="password-strength-text" style="font-size: 11px; color: #666;"></small>
                        </div>
                    </div>
                    <div class="w3-half">
                        <div class="form-group">
                            <label class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-input" name="confirma_senha"
                                placeholder="Repita a nova senha">
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-actions" style="margin: 0 40px 40px 40px;">
                <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar</button>
                <button type="submit" class="btn-save"><i class="fa fa-check"></i> Salvar Alterações</button>
            </div>

        </form>
    </div>
</div>

<script>
    function openTab(evt, tabName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("tab-content");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('preview-img').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function checkPasswordStrength() {
        var psw = document.getElementById("nova_senha").value;
        var bar = document.getElementById("password-strength-bar");
        var text = document.getElementById("password-strength-text");

        if (psw.length === 0) {
            bar.style.width = "0%";
            text.innerHTML = "";
            return;
        }

        var strength = 0;
        if (psw.length >= 6) strength += 1;
        if (psw.match(/[a-z]+/)) strength += 1;
        if (psw.match(/[A-Z]+/)) strength += 1;
        if (psw.match(/[0-9]+/)) strength += 1;
        if (psw.match(/[$@#&!*]+/)) strength += 1;

        if (psw.length < 6) {
            bar.style.width = "20%";
            bar.style.backgroundColor = "red";
            text.innerHTML = "Muito fraca (mínimo 6 caracteres)";
            return;
        }

        switch (strength) {
            case 1:
            case 2:
                bar.style.width = "40%";
                bar.style.backgroundColor = "orange";
                text.innerHTML = "Fraca";
                break;
            case 3:
                bar.style.width = "60%";
                bar.style.backgroundColor = "#FFD700"; // gold
                text.innerHTML = "Média";
                break;
            case 4:
                bar.style.width = "80%";
                bar.style.backgroundColor = "blue";
                text.innerHTML = "Forte";
                break;
            case 5:
                bar.style.width = "100%";
                bar.style.backgroundColor = "green";
                text.innerHTML = "Muito Forte";
                break;
        }
    }
</script>