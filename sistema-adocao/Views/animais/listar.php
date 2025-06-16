<?php
require_once '../../Config/banco.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Animais para Adoção</title>
</head>
<body>
    <h1>Animais Disponíveis para Adoção</h1>

    <?php
    $q = "SELECT * FROM animais ORDER BY id DESC";
    $resultado = $banco->query($q);

    if ($resultado && $resultado->num_rows > 0) {
        while ($animal = $resultado->fetch_assoc()) {
            echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";
            echo "<h2>".$animal['nome']."</h2>";
            if (!empty($animal['foto'])) {
                echo "<img src='../../uploads/animais/".$animal['foto']."' alt='Foto do animal' width='200'><br>";
            }
            echo "<strong>Espécie:</strong> ".$animal['especie']."<br>";
            echo "<strong>Idade:</strong> ".$animal['idade']." anos<br>";
            echo "<strong>Descrição:</strong> ".$animal['descricao']."<br>";
            echo "<a href='detalhes.php?id=".$animal['id']."'>Ver Detalhes</a>";

            echo "</div>";
        }
    } else {
        echo "<p>Nenhum animal disponível no momento.</p>";
    }
    ?>

    <br>
    <a href="../../index.php">Voltar para a Home</a>
</body>
</html>
