<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

echo "<h2>Bem-vindo, " . $_SESSION['usuario']['nome'] . "!</h2>";

echo "<a href='logout.php'>Sair</a>";
?>
