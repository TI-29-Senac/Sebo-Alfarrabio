 <!-- Header -->
 <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>
 
  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-amber w3-padding-16"  >
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          
        </div>
        <div class="w3-clear"></div>
        <a href="/backend/catli/listar/1"></a>
        <h4>Editar</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>99</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Views</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>23</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Shares</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>50</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Users</h4>
      </div>
    </div>
  </div>
 
<div>listar Categoria livro</div>
<?php if (isset($catlivros) && count($catlivros) > 0): ?>
        <ul class="w3-ul w3-card-4" style="width:80%">
    <table border="1" cellpadding="5" cellspacing="0">
        <tbody>
            <?php
            foreach ($catlivros as $categoriaLivro):
           
            ?>
</ul>
                <tr>
                    <li>
                <?= htmlspecialchars($categoriaLivro['nome_categoria']) ?> -
                   
                    <a href="/backend/catlivros/editar/<?= htmlspecialchars($categoriaLivro['id_cat_livros']) ?>">Editar</a>
                    <a href="/backend/catlivros/excluir/<?= htmlspecialchars($categoriaLivro['id_cat_livros']) ?>">Excluir</a>
                </li>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginacao-controls" style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
    <div class="page-selector" style="display:flex; align-items:center;">
        <div class="page-nav">
            <?php if ($paginacao['pagina_atual'] > 1): ?>
                <a href="/backend/catlivros/listar/<?= $paginacao['pagina_atual'] - 1 ?>">Anterior</a>
            <?php endif; ?>
            <span style="margin:0 10px;">Página <?= $paginacao['pagina_atual'] ?> de <?= $paginacao['ultima_pagina'] ?></span>
            <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                <a href="/backend/catlivros/listar/<?= $paginacao['pagina_atual'] + 1 ?>">Próximo</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php else: ?>
    <div>Nenhum Categoria encontrada.</div>
<?php endif ?>
</div>