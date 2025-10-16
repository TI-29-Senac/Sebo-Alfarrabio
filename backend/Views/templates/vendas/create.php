<div>Sou o create</div>
<form action="/backend/vendas/salvar" method="post" enctype="multipart/form-data">
<label for="Data">Data</label>
<input type="date" name="data_venda" id="data_venda" required>
<br>
<label for="Valor">Valor</label>
<input type="text" name="valor_total" id="valor_total" required>
<br>
<label for="Pagamento">Forma de Pagamento</label>
<input type="radio" name="forma_pagamento" id="forma_pagamento" value required>
<br>
<button type="submit">Salvar</button>
</form>