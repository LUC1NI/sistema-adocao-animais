<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Animal para Adoção</title>
</head>
<body>
    <h1>Cadastrar Novo Animal</h1>

    <?php
    if (isset($_SESSION['cadastro_animal_ok'])) {
        echo "<p style='color:green;'>".$_SESSION['cadastro_animal_ok']."</p>";
        unset($_SESSION['cadastro_animal_ok']);
    }

    if (isset($_SESSION['cadastro_animal_erro'])) {
        echo "<p style='color:red;'>".$_SESSION['cadastro_animal_erro']."</p>";
        unset($_SESSION['cadastro_animal_erro']);
    }
    ?>

    <form action="processa_cadastro.php" method="post">
        <label>Nome do Animal:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Espécie:</label><br>
        <input type="text" name="especie" required><br><br>

        <label>Idade (em anos):</label><br>
        <input type="number" name="idade" min="0" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao" rows="4" cols="30"></textarea><br><br>

        <button type="submit">Cadastrar Animal</button>
    </form>

    <br>
    <a href="../usuarios/painel.php">Voltar ao Painel</a>
</body>
</html>
