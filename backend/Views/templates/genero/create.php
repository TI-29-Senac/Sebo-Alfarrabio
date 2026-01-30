<div class="w3-container">
    <h3>Novo Gênero</h3>

    <form action="/backend/genero/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="nome_genero">Nome do Gênero*</label>
                <input type="text" class="form-control" id="nome_genero" name="nome_genero"
                    placeholder="Ex: Romance, Ficção, Fantasia, Rock, MPB..." required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="descricao_genero">Descrição</label>
                <textarea class="form-control" id="descricao_genero" name="descricao_genero" rows="4"
                    placeholder="Fale um pouco sobre esse gênero..."></textarea>
            </div>
        </div>

        <p>
            <button type="submit" class="w3-button w3-blue">Salvar Gênero</button>
        </p>

    </form>
</div>