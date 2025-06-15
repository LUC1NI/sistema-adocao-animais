<?php
session_start();
require_once '../../Config/banco.php';

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$q = "SELECT * FROM usuarios WHERE usuario='$usuario' AND senha='$senha'";
$resultado = $banco->query($q);

if ($resultado && $resultado->num_rows > 0) {
    $_SESSION['usuario'] = $usuario;
    header('Location: painel.php');
} else {
    $_SESSION['erro_login'] = "Usuário ou senha inválidos!";
    header('Location: login.php');
}
?>
