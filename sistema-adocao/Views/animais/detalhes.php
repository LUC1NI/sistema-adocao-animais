<?php
session_start();
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

    <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin'): ?>
        <a href="editar.php?id=<?php echo $animal['id']; ?>">Editar</a> |
        <a href="excluir.php?id=<?php echo $animal['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este animal?');">Excluir</a>
    <?php endif; ?>

    <?php if (isset($_SESSION['usuario']) && (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin')): ?>
        <form action="solicitar_adocao.php" method="get" style="margin-top: 20px;">
            <input type="hidden" name="id" value="<?php echo $animal['id']; ?>">
            <button type="submit">Solicitar Adoção</button>
        </form>
    <?php endif; ?>

    <br>
    <a href="../../index.php">Voltar para a página inicial</a> |
    <a href="listar.php">Voltar para a lista de animais</a>
</body>
</html>
