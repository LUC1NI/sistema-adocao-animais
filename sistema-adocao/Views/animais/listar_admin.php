<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Animais</title>
</head>
<body>
    <h1>Gerenciar Animais (Admin)</h1>

    <?php
    $q = "SELECT * FROM animais ORDER BY id DESC";
    $resultado = $banco->query($q);

    if ($resultado && $resultado->num_rows > 0) {
        while ($animal = $resultado->fetch_assoc()) {
            echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";
            echo "<h2>".$animal['nome']."</h2>";
            echo "<strong>Espécie:</strong> ".$animal['especie']."<br>";
            echo "<strong>Idade:</strong> ".$animal['idade']." anos<br>";
            echo "<strong>Descrição:</strong> ".$animal['descricao']."<br><br>";

            echo "<a href='editar.php?id=".$animal['id']."'>Editar</a> | ";
            echo "<a href='excluir.php?id=".$animal['id']."' onclick=\"return confirm('Tem certeza que deseja excluir este animal?');\">Excluir</a>";

            echo "</div>";
        }
    } else {
        echo "<p>Nenhum animal cadastrado.</p>";
    }
    ?>

    <br>
    <a href="../usuarios/painel.php">Voltar ao Painel</a>
</body>
</html>
