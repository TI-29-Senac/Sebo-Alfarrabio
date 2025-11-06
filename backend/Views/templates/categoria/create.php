<div class="w3-container" style="padding: 20px;">
    <h3 style="color: #6B5235;">
        <i class="fa fa-plus-circle"></i> Nova Categoria
    </h3>

    <form action="/backend/categoria/salvar" method="POST" enctype="multipart/form-data"
          class="w3-card-4 w3-white w3-round-large w3-padding"
          style="max-width: 700px; margin-top: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

        <div class="w3-row-padding">
            <div class="w3-half">
                <label class="w3-text-brown"><b>Nome da Categoria*</b></label>
                <input class="w3-input w3-border w3-round" 
                       id="nome_categoria" 
                       name="nome_categoria" 
                       type="text" 
                       placeholder="Ex: Literatura, Filmes, Revistas..."
                       required>
            </div>

            <div class="w3-half">
                <label class="w3-text-brown"><b>Tipo*</b></label>
                <select class="w3-select w3-border w3-round" 
                        id="tipo_categoria" 
                        name="tipo_categoria" required>
                    <option value="" disabled selected>Selecione o tipo</option>
                    <option value="importado">Importado</option>
                    <option value="novo">Livro</option>
                    <option value="usado">CD</option>
                    <option value="raro">DVD</option>
                    <option value="antigo">Revista</option>
                </select>
            </div>
        </div>

        <div class="w3-row-padding" style="margin-top: 20px;">
            <label class="w3-text-brown"><b>Imagem (opcional)</b></label>
            <input class="w3-input w3-border w3-round" 
                   id="imagem" 
                   name="imagem" 
                   type="file" 
                   accept="image/*">
        </div>

        <div class="w3-center" style="margin-top: 30px;">
            <button type="submit" 
                    class="w3-button w3-round-large" 
                    style="background-color: #6B5235; color: white; margin-right: 10px;">
                <i class="fa fa-save"></i> Salvar Categoria
            </button>

            <a href="/categoria/listar" 
               class="w3-button w3-light-grey w3-round-large">
                <i class="fa fa-arrow-left"></i> Cancelar
            </a>
        </div>
    </form>
</div>
