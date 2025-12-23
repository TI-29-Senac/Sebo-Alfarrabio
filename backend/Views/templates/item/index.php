<style>
:root {
    --bege-primary: #D4B896;
    --bege-light: #E8DCCF;
    --bege-dark: #B89968;
    --marrom: #B89968;
    --verde: #6B8E23;
    --azul: #5B9BD5;
    --laranja: #F4A460;
    --vermelho: #dc3545;
}

body {
    background: linear-gradient(135deg, #f5f5f0 0%, #faf8f3 100%);
    color: #333;
    font-family: "Segoe UI", sans-serif;
}

/* CONTAINER */
.itens-container {
    max-width: 1200px;
    margin: 50px auto;
    background: white;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    animation: fadeIn 0.6s ease-in-out;
}

/* TÍTULO */
.itens-container h1 {
    color: var(--marrom);
    font-weight: 700;
    font-size: 30px;
    margin-bottom: 30px;
    text-align: center;
    letter-spacing: 0.5px;
}

/* BOTÃO NOVO ITEM */
.btn-primary {
    background: var(--bege-dark);
    color: #fff;
    font-weight: 600;
    padding: 12px 22px;
    border-radius: 8px;
    border: none;
    text-decoration: none;
    transition: all 0.3s ease;
}
.btn-primary:hover {
    background: var(--marrom);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(139, 111, 71, 0.3);
}

/* CARDS DE RESUMO */
.card-deck {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
}
.card {
    flex: 1;
    min-width: 200px;
    background: var(--bege-light);
    border-radius: 10px;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    text-align: center;
}
.card-body {
    padding: 15px 10px;
}
.card-title {
    color: var(--marrom);
    font-weight: 600;
}
.card-text {
    font-size: 20px;
    color: #444;
}

/* TABELA */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 25px;
}
.table thead {
    background: var(--marrom);
    color: white;
}
.table th, .table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: center;
    vertical-align: middle;
}
.table tbody tr:hover {
    background-color: #f9f5ef;
}

/* BOTÕES DE AÇÃO */
.btn-warning {
    background: var(--laranja);
    border: none;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-warning:hover {
    background: #e69540;
    transform: translateY(-2px);
}

.btn-danger {
    background: var(--vermelho);
    border: none;
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-danger:hover {
    background: #b02a37;
    transform: translateY(-2px);
}

/* PAGINAÇÃO */
.paginacao {
    display: flex;
    justify-content: center;
    align-items: center;
    list-style: none;
    gap: 10px;
    padding: 0;
    margin-top: 20px;
}
.paginacao li {
    padding: 6px 12px;
    border-radius: 6px;
}
.paginacao li a {
    text-decoration: none;
    color: var(--marrom);
    font-weight: 500;
}
.paginacao li.active span {
    background: var(--bege-dark);
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
}
.paginacao li.disabled span {
    color: #aaa;
}
.paginacao li:hover a {
    color: var(--laranja);
}

/* ANIMAÇÃO */
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(30px);}
    to {opacity: 1; transform: translateY(0);}
}
</style>


<div class="itens-container">
    <h1><i class="fa fa-archive"></i> Gerenciamento de Itens do Sebo</h1>

    <div style="text-align:right; margin-bottom:25px;">
        <a href="/backend/item/criar" class="btn-primary"><i class="fa fa-plus"></i> Adicionar Novo Item</a>
    </div>

    <div class="card-deck">
        <div class="card">

            <div class="card-body">
                <h5 class="card-title">Total de Itens</h5>
                <p class="card-text"><?= $total_itens ?? 0 ?></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Itens Ativos</h5>
                <p class="card-text"><?= $total_ativos ?? 0 ?></p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Itens Inativos (Lixeira)</h5>
                <p class="card-text"><?= $total_inativos ?? 0 ?></p>
            </div>
        </div>
    </div>


    <!-- Barra de Pesquisa de Itens -->
<div class="search-container" style="margin-bottom: 20px;">
    <form method="GET" action="/backend/item/listar" style="display: flex; gap: 10px; align-items: center;">
        <input 
            type="text" 
            name="search" 
            placeholder="Pesquisar por título, autor, categoria, gênero ou ISBN..." 
            value="<?= htmlspecialchars($termo_pesquisa ?? '') ?>"
            style="flex: 1; padding: 10px 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;"
        />
        <button 
            type="submit" 
            style="padding: 10px 20px; background-color: #B89968; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;"
        >
            🔍 Pesquisar
        </button>
        <?php if (!empty($termo_pesquisa)): ?>
        <a 
            href="/backend/item/listar" 
            style="padding: 10px 20px; background-color: #dc3545; color: white; border: none; border-radius: 5px; text-decoration: none; display: inline-block; font-weight: 600;"
        >
            ✕ Limpar
        </a>
        <?php endif; ?>
    </form>
    
    <?php if (!empty($termo_pesquisa)): ?>
    <p style="margin-top: 10px; color: #666; font-size: 14px;">
        Resultados para: <strong><?= htmlspecialchars($termo_pesquisa) ?></strong>
    </p>
    <?php endif; ?>
</div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>foto</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Gênero</th>
                    <th>Categoria</th>
                    <th>Autores/Artistas</th>
                    <th>Estoque</th>
                    <th>Ações</th>

                </tr>
            </thead>
            <tbody>
                <?php if (empty($itens)): ?>
                    <tr>
                        <td colspan="7">Nenhum item encontrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($itens as $item): ?>
                        <tr>
                        <td><img src="/backend/uploads/<?= htmlspecialchars($item['foto_item']) ?>" alt="" style="width:100px;"></td>
                            <td><?= htmlspecialchars($item['titulo_item']) ?></td>
                            <td><?= htmlspecialchars(ucfirst($item['tipo_item'])) ?></td>
                            <td><?= htmlspecialchars($item['nome_genero']) ?></td>
                            <td><?= htmlspecialchars($item['nome_categoria']) ?></td>
                            <td><?= htmlspecialchars($item['autores'] ?? 'N/A') ?></td>
                            <td><?= (int)$item['estoque'] ?></td>
                            
                            <td>
                                <a href="/backend/item/editar/<?= $item['id_item'] ?>" class="btn-warning"><i class="fa fa-edit"></i></a>
                                <a href="backend/item/excluir/<?= $item['id_item'] ?>" class="btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <nav>
        <ul class="paginacao">
            <?php $pag = $paginacao; ?>

            <li class="<?= ($pag['pagina_atual'] <= 1) ? 'disabled' : '' ?>">
                <a href="/backend/item/listar/<?= $pag['pagina_atual'] - 1 ?>">Anterior</a>
            </li>

            <li class="active">
                <span>Página <?= $pag['pagina_atual'] ?> de <?= $pag['ultima_pagina'] ?></span>
            </li>

            <li class="<?= ($pag['pagina_atual'] >= $pag['ultima_pagina']) ? 'disabled' : '' ?>">
                <a href="/backend/item/listar/<?= $pag['pagina_atual'] + 1 ?>">Próxima</a>
            </li>
        </ul>
        <p style="text-align:center; color:#666;">
            Mostrando de <?= $pag['de'] ?> até <?= $pag['para'] ?> de <?= $pag['total'] ?> registros.
        </p>
    </nav>
</div>
