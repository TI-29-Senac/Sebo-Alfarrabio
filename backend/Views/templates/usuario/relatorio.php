<h2>Relatório de Usuários (<?php echo $data1 ?? 'Todas Datas'; ?> a <?php echo $data2 ?? 'Atual'; ?>)</h2>
<?php if (isset($usuarios) && !empty($usuarios)): ?>
    <table class="w3-table w3-striped">
        <thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th><th>Criado Em</th></tr></thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr><td><?php echo $u['id_usuario']; ?></td><td><?php echo htmlspecialchars($u['nome_usuario']); ?></td><td><?php echo htmlspecialchars($u['email_usuario']); ?></td><td><?php echo ucfirst($u['tipo_usuario']); ?></td><td><?php echo date('d/m/Y', strtotime($u['criado_em'])); ?></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum usuário no período.</p>
<?php endif; ?>
<a href="/backend/usuario/listar" class="w3-button w3-blue">Voltar</a>