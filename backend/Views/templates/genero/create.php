<div class="w3-container">
    <h3>Novo Gênero</h3>
    <form action="backend/genero/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">

        <p>
        <label class="w3-text-blue"><b>Nome do Livro</b></label>
        <input class="w3-input w3-border" name="nome_genero_livro" type="text" required>
        </p>

        <p>
        <label class="w3-text-blue"><b>Nome da Musica</b></label>
        <textarea class="w3-input w3-border" name="nome_genero_musica" rows="3" placeholder="Descreva o gênero literário..."></textarea>
        </p>

        <p>
        <button class="w3-button w3-blue">Salvar Gênero</button>
        </p>

    </form>
</div>
