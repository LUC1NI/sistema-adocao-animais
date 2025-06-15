<?php
session_start();
require_once '../Config/banco.php';

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

$q = "SELECT * FROM usuarios WHERE email='$email'";
$resultado = $banco->query($q);

if ($resultado && $resultado->num_rows > 0) {
    $_SESSION['cadastro_erro'] = "Este e-mail já está cadastrado!";
    header('Location: cadastro.php');
    exit;
}

$q = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha_criptografada')";
if ($banco->query($q)) {
    $_SESSION['cadastro_ok'] = "Usuário cadastrado com sucesso! Agora faça login.";
    header('Location: cadastro.php');
    exit;
} else {
    $_SESSION['cadastro_erro'] = "Erro ao cadastrar usuário!";
    header('Location: cadastro.php');
    exit;
}
?>
