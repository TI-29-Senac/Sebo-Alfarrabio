<div class="w3-container">
    <h3>Novo Autor</h3>
    <form action="backend/autor/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">

        <p>
        <label class="w3-text-blue"><b>Nome do Autor</b></label>
        <input class="w3-input w3-border" name="nome_autor" type="text" required>
        </p>

        <p>
        <label class="w3-text-blue"><b>Nacionalidade</b></label>
        <input class="w3-input w3-border" name="nacionalidade_autor" type="text">
        </p>

        <p>
        <label class="w3-text-blue"><b>Data de Nascimento</b></label>
        <input class="w3-input w3-border" name="data_nascimento_autor" type="date">
        </p>

        <p>
        <label class="w3-text-blue"><b>Biografia</b></label>
        <textarea class="w3-input w3-border" name="biografia_autor" rows="4" placeholder="Escreva uma breve biografia..."></textarea>
        </p>

        <p>
        <label class="w3-text-blue"><b>Foto do Autor</b></label>
        <input class="w3-input w3-border" name="foto_autor" type="file" accept="image/*">
        </p>

        <p>
        <button class="w3-button w3-blue">Salvar Autor</button>
        </p>

    </form>
</div>
