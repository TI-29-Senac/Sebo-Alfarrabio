<div class="w3-container w3-card-4 w3-light-grey w3-margin w3-center" style="max-width:800px;">
    <h1>Editar Usuário #<?php echo $usuario['id_usuario']; ?></h1>
    <form action="/backend/usuario/atualizar" method="post" onsubmit="return confirm('Atualizar?');">
        <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
        <div class="w3-section">
            <label>Nome</label>
            <input class="w3-input w3-border" type="text" name="nome_usuario" value="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>" required>
        </div>
        <div class="w3-section">
            <label>Email</label>
            <input class="w3-input w3-border" type="email" name="email_usuario" value="<?php echo htmlspecialchars($usuario['email_usuario']); ?>" required>
        </div>
        <div class="w3-section">
            <label>Senha (vazio = manter)</label>
            <input class="w3-input w3-border" type="password" name="senha_usuario" minlength="6">
        </div>
        <div class="w3-section">
            <label>Tipo</label>
            <select class="w3-select w3-border" name="tipo_usuario" required>
                <option value="cliente" <?php echo ($usuario['tipo_usuario'] == 'cliente') ? 'selected' : ''; ?>>Cliente</option>
                <option value="admin" <?php echo ($usuario['tipo_usuario'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="funcionario" <?php echo ($usuario['tipo_usuario'] == 'funcionario') ? 'selected' : ''; ?>>Funcionário</option>
            </select>
        </div>
        <button type="submit" class="w3-button w3-blue">Salvar</button>
        <a href="/backend/usuario/listar" class="w3-button w3-grey">Cancelar</a>
    </form>
</div>