<div class="w3-container">
    <h3>Nova Categoria</h3>

    <form action="/backend/categoria/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">

        <div class="form-row">
            <div class="form-group col-md-8">
                <label for="nome_categoria">Nome da Categoria*</label>
                <input type="text" class="form-control" id="nome_categoria" name="nome_categoria" required>
            </div>

            <div class="form-group col-md-4">
                <label for="tipo_categoria">Tipo*</label>
                <select id="tipo_categoria" name="tipo_categoria" class="form-control" required>
                    <option value="" selected disabled>Selecione o tipo</option>

                    <option value="novo">Livro</option>
                    <option value="usado">CD</option>
                    <option value="raro">DVD</option>
                    <option value="antigo">Revista</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="imagem">Imagem (opcional)</label>
                <input type="file" id="imagem" name="imagem" class="form-control">
            </div>
        </div>

        <p>
            <button type="submit" class="w3-button w3-blue">Salvar Categoria</button>
        </p>

    </form>
</div>
