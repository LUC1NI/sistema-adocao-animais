<?php
require_once '../Config/banco.php';

$q = "SELECT * FROM animais WHERE status = 'disponivel'";
$resultado = $banco->query($q);
?>

<h2>Animais Disponíveis para Adoção</h2>
<a href="index.php">Voltar</a>
<hr>

<?php while ($animal = $resultado->fetch_assoc()) : ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
        <strong>Nome:</strong> <?= $animal['nome'] ?><br>
        <strong>Espécie:</strong> <?= $animal['especie'] ?><br>
        <strong>Raça:</strong> <?= $animal['raca'] ?><br>
        <strong>Idade:</strong> <?= $animal['idade'] ?> anos<br>
        <strong>Descrição:</strong> <?= $animal['descricao'] ?><br>
        <?php if (!empty($animal['imagem'])): ?>
            <img src="../uploads/<?= $animal['imagem'] ?>" alt="Imagem do animal" width="200">
        <?php endif; ?>
    </div>
<?php endwhile; ?>
