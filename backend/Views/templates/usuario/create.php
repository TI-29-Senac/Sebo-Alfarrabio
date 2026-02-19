<div class="w3-container w3-card-4 w3-light-grey w3-margin w3-center" style="max-width:800px;">
    <h1>Criar Usuário</h1>
    
    <form action="/backend/usuario/salvar" method="POST" class="w3-panel">
        
        <div class="w3-section">
            <label class="w3-text-blue"><b>Nome Completo</b></label>
            <input class="w3-input w3-border" 
                   type="text" 
                   name="nome_usuario" 
                   placeholder="Ex: João da Silva"
                   required 
                   minlength="3">
        </div>
        
        <div class="w3-section">
            <label class="w3-text-blue"><b>Email</b></label>
            <input class="w3-input w3-border" 
                   type="email" 
                   name="email_usuario" 
                   placeholder="usuario@email.com"
                   required>
        </div>
        
        <div class="w3-section">
            <label class="w3-text-blue"><b>Senha</b></label>
            <input class="w3-input w3-border" 
                   type="password" 
                   name="senha_usuario" 
                   placeholder="Mínimo 6 caracteres"
                   required 
                   minlength="6">
            <small class="w3-text-grey">A senha será criptografada automaticamente</small>
        </div>
        
        <div class="w3-section">
            <label class="w3-text-blue"><b>Tipo de Usuário</b></label>
            <select class="w3-select w3-border" name="tipo_usuario" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="Cliente">Cliente</option>
                <option value="Funcionario">Funcionário</option>
                <option value="Admin">Administrador</option>
            </select>
            <small class="w3-text-grey">
                • Cliente: Acesso limitado<br>
                • Funcionário: Gerencia vendas e estoque<br>
                • Admin: Controle total do sistema
            </small>
        </div>
        
        <div class="w3-section">
            <button type="submit" class="w3-button w3-blue w3-large">
                <i class="fa fa-save"></i> Criar Usuário
            </button>
            <a href="/backend/usuario/listar" class="w3-button w3-grey w3-large">
                <i class="fa fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
// Validação adicional no frontend
document.querySelector('form').addEventListener('submit', function(e) {
    const senha = document.querySelector('input[name="senha_usuario"]').value;
    
    if (senha.length < 6) {
        alert('A senha deve ter no mínimo 6 caracteres!');
        e.preventDefault();
        return false;
    }
    
    return confirm('Confirma a criação do usuário?');
});
</script>