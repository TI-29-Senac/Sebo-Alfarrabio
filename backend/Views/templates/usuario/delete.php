<div class="w3-container w3-card-4 w3-red w3-margin w3-center" style="max-width:600px;">
    <h1>Confirmar Desativação</h1>
    <p>Desativar "<?php echo htmlspecialchars($usuario['nome_usuario']); ?>" (#<?php echo $usuario['id_usuario']; ?>)?</p>
    <form action="/backend/usuario/deletar" method="POST" onsubmit="return confirm('Sim?');">
        <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
        <button type="submit" class="w3-button w3-red">Desativar</button>
        <a href="/backend/usuario/listar" class="w3-button w3-grey">Cancelar</a>
    </form>
</div>