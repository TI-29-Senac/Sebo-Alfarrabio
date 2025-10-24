<h2>Cadastrar/Criar uma nova reserva:</h2>
<form action="/backend/reservas/salvar" method="post" enctype="multipart/form-data">
<label for="Data">Data</label>
<input type="date" name="data_reserva" id="data_reserva" required>
<br>
<h4>Status da Reserva</h4>
<label for="Ativa">Ativa</label>
<input type="radio" name="status_reserva" id="status_reserva" value required>
<br>
<label for="Concluida">Concluída</label>
<input type="radio" name="status_reserva" id="status_reserva" value required>
<br>
<label for="Cancelada">Cancelada</label>
<input type="radio" name="status_reserva" id="status_reserva" value required>
<br>
<button type="submit">Salvar</button>
