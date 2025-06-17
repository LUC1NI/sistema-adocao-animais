<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Adoção</title>
</head>
<body>
    <h1>Login</h1>

    <?php
    if (isset($_SESSION['erro_login'])) {
        echo "<p style='color:red;'>".$_SESSION['erro_login']."</p>";
        unset($_SESSION['erro_login']);
    }
    ?>

    <form action="valida_login.php" method="post">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <button type="submit">Entrar</button>
    </form>

    <br>
    <a href="recuperar_senha.php">Recuperar senha</a><br><br>

    <a href="../cadastro.php">Ainda não tem conta? Cadastre-se</a>
</body>
</html>
