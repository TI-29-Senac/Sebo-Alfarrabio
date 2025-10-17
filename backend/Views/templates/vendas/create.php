<h2>Cadastrar/Criar um registro de venda:</h2>
<form action="/backend/vendas/salvar" method="post" enctype="multipart/form-data">
<label for="Data">Data</label>
<input type="date" name="data_venda" id="data_venda" required>
<br>
<label for="Valor">Valor</label>
<input type="text" name="valor_total" id="valor_total" required>
<br>
<h4>Forma de pagamento</h4>
<br>
<label for="Dinheiro">Dinheiro</label>
<input type="radio" name="forma_pagamento" id="forma_pagamento" value required>
<br>
<label for="Cartão">Cartão</label>
<input type="radio" name="forma_pagamento" id="forma_pagamento" value required>
<br>
<label for="Transferência">Transferência</label>
<input type="radio" name="forma_pagamento" id="forma_pagamento" value required>
<br>
<label for="Pix">Pix</label>
<input type="radio" name="forma_pagamento" id="forma_pagamento" value required>
<br>
<button type="submit">Salvar</button>
</form>