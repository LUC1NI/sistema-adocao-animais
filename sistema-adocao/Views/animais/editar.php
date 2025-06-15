<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $q = "SELECT * FROM animais WHERE id = $id";
    $resultado = $banco->query($q);

    if ($resultado && $resultado->num_rows > 0) {
        $animal = $resultado->fetch_assoc();
    } else {
        echo "<p>Animal não encontrado.</p>";
        echo '<a href="listar_admin.php">Voltar</a>';
        exit;
    }
} else {
    echo "<p>ID do animal não informado.</p>";
    echo '<a href="listar_admin.php">Voltar</a>';
    exit;
}

if (isset($_POST['salvar'])) {
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $idade = intval($_POST['idade']);
    $descricao = $_POST['descricao'];

    $q = "UPDATE animais SET nome='$nome', especie='$especie', idade=$idade, descricao='$descricao' WHERE id=$id";
    $resultado = $banco->query($q);

    if ($resultado) {
        echo "<p>Animal atualizado com sucesso!</p>";
        echo '<a href="listar_admin.php">Voltar para a listagem</a>';
        exit;
    } else {
        echo "<p>Erro ao atualizar o animal.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Animal</title>
</head>
<body>
    <h1>Editar Animal</h1>

    <form method="post">
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo $animal['nome']; ?>"><br><br>

        <label>Espécie:</label><br>
        <input type="text" name="especie" value="<?php echo $animal['especie']; ?>"><br><br>

        <label>Idade (anos):</label><br>
        <input type="number" name="idade" value="<?php echo $animal['idade']; ?>"><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao"><?php echo $animal['descricao']; ?></textarea><br><br>

        <input type="submit" name="salvar" value="Salvar Alterações">
    </form>

    <br>
    <a href="listar_admin.php">Cancelar e voltar</a>
</body>
</html>
