<div class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin w3-center">
    <h1>Redefinir Senha</h1>
    <p>Crie uma nova senha para sua conta.</p>
    <form action="<?= url('/backend/redefinir-senha') ?>" method="POST" class="w3-panel w3-center">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="senha_nova" type="password" placeholder="Nova Senha" minlength="6" required>
            </div>
        </div>
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-lock"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="senha_confirm" type="password" placeholder="Confirmar Nova Senha" minlength="6" required>
            </div>
        </div>
        <button type="submit" class="w3-button w3-blue">Redefinir Senha</button>
    </form>
    <a href="/backend/login">Voltar para o Login</a><br><br>
</div>
