
<div>Sou o Edit</div>

<form action="/backend/usuario/atualizar/ <?php  echo $usuario['id_usuario']; ?>" method="post">
    <label for="nome_usuario">Nome:</label>
    <input type="text" id="nome_usuario" name="nome_usuario" value="<?php  echo $usuario['nome_usuario']; ?>" required>
    <br>
    <label for="email_usuario">Email:</label>
    <input type="email" id="email_usuario" name="email_usuario" value="<?php  echo $usuario['email_usuario']; ?>" required>
    <br>
    <label for="senha_usuario">Senha:</label>
    <input type="password" id="senha_usuario" name="senha_usuario" required>
    <br>
    <label for="tipo_usuario">Tipo:</label>
    <select id="tipo_usuario" name="tipo_usuario" value="<?php  echo $usuario['tipo_usuario']; ?>" required>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select>
    <br>
    <button type="submit">Criar Usuário</button>