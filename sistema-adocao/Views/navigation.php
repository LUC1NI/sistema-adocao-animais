<div class="menu">
    <?php if (isset($_SESSION['usuario'])): ?>
        <span>Olá, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</span>
        <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin'): ?>
            <a href="Views/usuarios/solicitacoes.php">Solicitações</a>
            <a href="Views/usuarios/painel.php">Painel Admin</a>
        <?php else: ?>
            <a href="Views/usuarios/acompanhamento.php">Minhas Adoções</a>
        <?php endif; ?>

        <a href="Views/usuarios/logout.php">Logout</a>
    <?php else: ?>
        <a href="Views/usuarios/login.php">Login</a>
        <a href="cadastro.php">Cadastrar-se</a>
    <?php endif; ?>
</div>
