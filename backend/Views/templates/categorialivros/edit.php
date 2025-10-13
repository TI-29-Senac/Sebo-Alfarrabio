<div>Sou o edit</div><div>Edite o Acervo</div>

<form action="/backend/acervo/atualizar/ <?php  echo $acervo['id_acervo']; ?>" method="post">
    <label for="titulo_acervo">Titulo:</label>
    <input type="text" id="titulo_acervo" name="titulo_acervo" value="<?php  echo $acervo['titulo_acervo']; ?>" required>
    <br>
    <label for="tipo_item_acervo">Tipo Item</label>
    <input type="text" id="tipo_item_acervo" name="tipo_item_acervo" value="<?php  echo $acervo['tipo_item_acervo']; ?>" required>
    <br>
    <label for="estado_conservacao">Estado de Conservação:</label>
    <input type="text" id="estado_conservacao" name="estado_conservacao" value="<?php  echo $acervo['estado_conservacao']; ?>" required>
    <br>
    <label for="tipo_item_acervo">Disponibilidade:</label>
    <select id="disponibilidade_acervo" name="disponibilidade_acervo" value="<?php  echo $acervo['disponibilidade_acervo']; ?>" required>
        <option value="Em estoque">Vendido</option>
        <option value="">Em estoque</option>
        <option value="user">Reservado</option>
    </select>
    <br>
    <button type="submit">Editar Acervo</button>