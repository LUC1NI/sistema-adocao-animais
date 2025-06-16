<?php
require_once '../../Config/banco.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $q = "SELECT * FROM animais WHERE id = $id";
    $resultado = $banco->query($q);

    if ($resultado && $resultado->num_rows > 0) {
        $animal = $resultado->fetch_assoc();
    } else {
        echo "<p>Animal não encontrado.</p>";
        echo '<a href="../../index.php">Voltar</a>';
        exit;
    }
} else {
    echo "<p>ID do animal não informado.</p>";
    echo '<a href="../../index.php">Voltar</a>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Animal</title>
</head>
<body>
    <h1>Detalhes do Animal</h1>

    <h2><?php echo $animal['nome']; ?></h2>
    <?php 
        if (!empty($animal['foto'])) {
                echo "<img src='../../uploads/animais/".$animal['foto']."' alt='Foto do animal' width='200'><br>";
        }
    ?>
    <p><strong>Espécie:</strong> <?php echo $animal['especie']; ?></p>
    <p><strong>Idade:</strong> <?php echo $animal['idade']; ?> anos</p>
    <p><strong>Descrição:</strong> <?php echo $animal['descricao']; ?></p>

    <br>
    <a href="../../index.php">Voltar para a página inicial</a> |
    <a href="listar.php">Voltar para a lista de animais</a>
</body>
</html>
