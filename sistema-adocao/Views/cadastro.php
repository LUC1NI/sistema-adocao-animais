<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h1>Cadastro de Usuário</h1>

    <?php
    session_start();
    if (isset($_SESSION['cadastro_erro'])) {
        echo "<p style='color:red;'>".$_SESSION['cadastro_erro']."</p>";
        unset($_SESSION['cadastro_erro']);
    }

    if (isset($_SESSION['cadastro_ok'])) {
        echo "<p style='color:green;'>".$_SESSION['cadastro_ok']."</p>";
        unset($_SESSION['cadastro_ok']);
    }
    ?>

    <form action="processa_cadastro.php" method="post">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <br>
    <a href="usuarios/login.php">Já tem conta? Fazer login</a>
</body>
</html>
