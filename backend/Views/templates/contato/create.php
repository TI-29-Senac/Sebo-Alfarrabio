<div>Sou o create</div>
<form action="/backend/contato/salvar" method="post">
    <label for="nome_contato">Nome:</label>
    <input type="text" id="nome_usuario" name="nome_contato" required>
    <br>
    <label for="email_contato">Email:</label>
    <input type="email" id="email_contato" name="email_contato" required>
    <br>
    <label for="telefone_contato">Telefone:</label>
    <input type="number" id="telefone_contato" name="telefone_contato" required>
    <br>
    <label for="mensagem_contato">Mensagem:</label>
    <select id="mensagem_contato" name="mensagem_contato" required>
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select>
    <br>
    <button type="submit">Criar Contato</button>