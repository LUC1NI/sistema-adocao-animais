<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $q = "DELETE FROM animais WHERE id = $id";
    $resultado = $banco->query($q);

    if ($resultado) {
        echo "<p>Animal excluído com sucesso!</p>";
    } else {
        echo "<p>Erro ao excluir o animal.</p>";
    }
} else {
    echo "<p>ID do animal não informado.</p>";
}

echo '<br><a href="listar_admin.php">Voltar para a listagem</a>';
?>
