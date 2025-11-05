<div class="w3-container">
    <h3>Nova Categoria</h3>
    <form action="/backend/categoria/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">

        <div class="form-row">
        <div class="form-group col-md-8">
            <label for="nome_categoria">Título*</label>
            <input type="text" class="form-control" id="nome_categoria" name="nome_categoria" required>
        </div>
        <div class="form-group col-md-4">
            <select id="nome_categoria" name="nome_categoria" class="form-control" required>
                <option value="" selected disabled>Escolha a categoria</option>
                <option value="livro">Livro</option>
                <option value="cd">CD</option>
                <option value="dvd">DVD</option>
                <option value="revista">Revista</option>
            </select>
        </div>
    </div>

        <div class="form-row">
        <div class="form-group col-md-8">
            <input type="text" class="form-control" id="descricao_categoria" name="descricao_categoria" required>
        </div>
        <div class="form-group col-md-4">
            <select id="descricao_categoria" name="descricao_categoria" class="form-control" required>
                <option value="" selected disabled>Selecione o tipo</option>
                <option value="livro">Importado</option>
                <option value="cd">Novo</option>
                <option value="dvd">Usado</option>
                <option value="revista">Raro</option>
                <option value="dvd">Antigo</option>

            </select>
        </div>
    </div>
        <p>
        <button class="w3-button w3-blue">Salvar Categoria</button>
        </p>

    </form>
</div>
 