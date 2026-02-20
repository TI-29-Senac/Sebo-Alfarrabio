<div class="w3-container w3-card-4 w3-light-grey w3-text-blue w3-margin w3-center">
    <h1>Esqueci a Senha</h1>
    <p>Informe seu email cadastrado para receber o link de recuperação.</p>
    <form action="<?= url('/backend/forgot-password') ?>" method="POST" class="w3-panel w3-center">
        <div class="w3-row w3-section">
            <div class="w3-col" style="width:50px"><i class="w3-xxlarge fa fa-envelope-o"></i></div>
            <div class="w3-rest">
                <input class="w3-input w3-border" name="email_usuario" type="email" placeholder="Seu email cadastrado" required>
            </div>
        </div>
        <button type="submit" class="w3-button w3-blue">Enviar link de recuperação</button>
    </form>
    <a href="/backend/login">Voltar para o Login</a><br><br>
</div>
