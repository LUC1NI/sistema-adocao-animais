<?php
session_start();
require_once '../../Config/banco.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$q = "SELECT * FROM usuarios WHERE email='$email'";
$resultado = $banco->query($q);

if ($resultado && $resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    if (password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['nome'];
        header('Location: painel.php');
        exit;
    } else {
        $_SESSION['erro_login'] = "Email ou senha inválidos!";
        header('Location: login.php');
        exit;
    }
} else {
    $_SESSION['erro_login'] = "Email ou senha inválidos!";
    header('Location: login.php');
    exit;
}
?>
