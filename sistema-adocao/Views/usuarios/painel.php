<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Usuário</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo $_SESSION['usuario']; ?>!</h1>

    <p>Você está logado no sistema.</p>

    <h2>Opções:</h2>
    <ul>
        <li><a href="../animais/cadastrar.php">Cadastrar Novo Animal</a></li>
        <li><a href="../animais/listar_admin.php">Gerenciar Animais (Listar, Editar, Excluir)</a></li>
        <li><a href="logout.php">Sair</a></li>
    </ul>

    <br>
    <a href="../../index.php">Voltar para a Home Pública</a>
</body>
</html>
