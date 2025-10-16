<div>Sou o edit</div>
<form action="/backend/vendas/atualizar/ <?php echo $vendas['id_venda']; ?>" method="post" 
enctype="multipart/form-data">
<label for="Data">Data</label>
<input type="date" name="data_venda" id="data_venda" value="<?php echo $vendas['data_venda']; ?>" required>
<br>
<label for="Valor">Valor Total</label>
<input type="text" name="valor_total" id="valor_total" value="<?php echo $vendas['valor_total']; ?>" required>
<br>
<label for="Pagamento">Forma de Pagamento</label>
<input type="text" name="forma_pagamento" id="forma_pagamento" required>
<br>
<button type="submit">Salvar</button>
</form>