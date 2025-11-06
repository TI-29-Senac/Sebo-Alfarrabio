<div class="w3-container">
    <h3>Novo Autor</h3>

    <form action="/backend/autor/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="nome_autor">Nome do Autor*</label>
                <input type="text" class="form-control" id="nome_autor" name="nome_autor" placeholder="Digite o nome completo" required>
            </div>

            <div class="form-group col-md-6">
                <label for="nacionalidade">Nacionalidade</label>
                <input type="text" class="form-control" id="nacionalidade" name="nacionalidade" placeholder="Ex: Brasileira, Francesa, etc.">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="biografia">Biografia</label>
                <textarea class="form-control" id="biografia" name="biografia" rows="5" placeholder="Escreva um breve resumo sobre o autor"></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="foto_autor">Foto (opcional)</label>
                <input type="file" id="foto_autor" name="foto_autor" class="form-control">
            </div>
        </div>

        <p>
            <button type="submit" class="w3-button w3-blue">Salvar Autor</button>
        </p>

    </form>
</div>
