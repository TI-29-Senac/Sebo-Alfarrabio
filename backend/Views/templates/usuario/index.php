<header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Dashboard Usuários</b></h5>
</header>

<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
        <div class="w3-container w3-teal w3-padding-16">
            <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
            <div class="w3-right"><h3><?php echo $total_ativos; ?></h3></div>
            <div class="w3-clear"></div><h4>Ativos</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-red w3-padding-16">
            <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
            <div class="w3-right"><h3><?php echo $total_inativos; ?></h3></div>
            <div class="w3-clear"></div><h4>Inativos</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-blue w3-padding-16">
            <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
            <div class="w3-right"><h3><?php echo $total_usuarios; ?></h3></div>
            <div class="w3-clear"></div><h4>Total</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <a href="/backend/usuario/criar" class="w3-button w3-teal w3-padding-16 w3-block">Criar</a>
    </div>
</div>

<?php if (!empty($usuarios)): ?>
    <table class="w3-table w3-striped w3-bordered w3-hoverable">
        <thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th><th>Status</th><th>Ações</th></tr></thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?php echo $u['id_usuario']; ?></td>
                    <td><?php echo htmlspecialchars($u['nome_usuario']); ?></td>
                    <td><?php echo htmlspecialchars($u['email_usuario']); ?></td>
                    <td><?php echo ucfirst($u['tipo_usuario']); ?></td>
                    <td><?php echo ($u['excluido_em'] ? 'Inativo' : 'Ativo'); ?></td>
                    <td>
                        <a href="/backend/usuario/editar/<?php echo $u['id_usuario']; ?>" class="w3-button w3-blue w3-small">Editar</a>
                        <a href="/backend/usuario/excluir/<?php echo $u['id_usuario']; ?>" class="w3-button w3-red w3-small" onclick="return confirm('Desativar?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($paginacao['ultima_pagina'] > 1): ?>
        <div class="w3-bar w3-center">
            <?php if ($paginacao['pagina_atual'] > 1): ?>
                <a href="/backend/usuario/listar/<?= $paginacao['pagina_atual'] - 1 ?>" class="w3-button w3-border">Anterior</a>
            <?php endif; ?>
            <span class="w3-button w3-blue"><?= $paginacao['pagina_atual'] ?> de <?= $paginacao['ultima_pagina'] ?></span>
            <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                <a href="/backend/usuario/listar/<?= $paginacao['pagina_atual'] + 1 ?>" class="w3-button w3-border">Próximo</a>
            <?php endif; ?>
        </div>
        <p>Mostrando <?= $paginacao['de'] ?> a <?= $paginacao['para'] ?> de <?= $paginacao['total'] ?></p>
    <?php endif; ?>
<?php else: ?>
    <div class="w3-panel w3-yellow">Nenhum usuário ativo. <a href="/backend/usuario/criar" class="w3-button w3-green">Criar primeiro</a></div>
<?php endif; ?>