<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Animal</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        form { max-width: 500px; margin: auto; }
        input, textarea, select { width: 100%; padding: 10px; margin-bottom: 10px; }
        button { padding: 10px 20px; background-color: green; color: white; border: none; cursor: pointer; }
        a { display: inline-block; margin-top: 10px; }
    </style>
</head>
<body>

    <h2>Cadastrar Novo Animal para Adoção</h2>

    <form action="salvar_animal.php" method="post" enctype="multipart/form-data">
        <label>Nome:</label>
        <input type="text" name="nome" required>

        <label>Espécie:</label>
        <input type="text" name="especie" required>

        <label>Raça:</label>
        <input type="text" name="raca">

        <label>Idade:</label>
        <input type="number" name="idade" min="0">

        <label>Descrição:</label>
        <textarea name="descricao" rows="4"></textarea>

        <label>Imagem do Animal:</label>
        <input type="file" name="imagem">

        <button type="submit">Salvar Animal</button>
    </form>

    <a href="painel.php">Voltar ao Painel</a>

</body>
</html>
