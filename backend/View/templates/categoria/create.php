<div class="w3-container">
    <h3>Nova Categoria</h3>
    <form action="backend/categoria/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">

        <p>
        <label class="w3-text-blue"><b>Nome da Categoria</b></label>
        <input class="w3-input w3-border" name="nome_categoria" type="text" required>
        </p>

        <p>
        <label class="w3-text-blue"><b>Descrição</b></label>
        <textarea class="w3-input w3-border" name="descricao_categoria" rows="3" placeholder="Descreva brevemente a categoria..."></textarea>
        </p>

        <p>
        <button class="w3-button w3-blue">Salvar Categoria</button>
        </p>

    </form>
</div>
