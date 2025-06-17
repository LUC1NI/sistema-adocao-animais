<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha - Sistema de Adoção</title>
</head>
<body>
    <h1>Recuperar Senha</h1>

    <?php
    if (isset($_SESSION['erro_recuperar'])) {
        echo "<p style='color:red;'>".$_SESSION['erro_recuperar']."</p>";
        unset($_SESSION['erro_recuperar']);
    }
    if (isset($_SESSION['sucesso_recuperar'])) {
        echo "<p style='color:green;'>".$_SESSION['sucesso_recuperar']."</p>";
        unset($_SESSION['sucesso_recuperar']);
    }
    ?>

    <form action="processa_recuperar_senha.php" method="post">
        <label>CPF:</label><br>
        <input type="text" name="cpf" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="000.000.000-00" required><br><br>

        <label>Data de Nascimento:</label><br>
        <input type="date" name="data_nascimento" required><br><br>

        <label>Nova Senha:</label><br>
        <input type="password" name="nova_senha" required><br><br>

        <button type="submit">Redefinir Senha</button>
    </form>

    <br>
    <a href="login.php">Voltar ao Login</a>
</body>
</html>
