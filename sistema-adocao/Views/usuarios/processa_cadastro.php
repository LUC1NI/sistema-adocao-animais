<?php
session_start();
require_once '../Config/banco.php';

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['cadastro_erro'] = "Erro de segurança: token CSRF inválido.";
    header('Location: cadastro.php');
    exit;
}

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$cpf = $_POST['cpf'];
$data_nascimento = $_POST['data_nascimento'];

function validarCPF($cpf) {
    $cpf = preg_replace('/\D/', '', $cpf);

    if (strlen($cpf) != 11) {
        return false;
    }
    if ($cpf == str_repeat($cpf[0], 11)) {
        return false;
    }
    return true;
}


if (!validarCPF($cpf)) {
    $_SESSION['cadastro_erro'] = "CPF inválido!";
    header('Location: cadastro.php');
    exit;
}

$senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

$q = "SELECT * FROM usuarios WHERE email='$email' OR cpf='$cpf'";
$resultado = $banco->query($q);

if ($resultado && $resultado->num_rows > 0) {
    $_SESSION['cadastro_erro'] = "Este e-mail ou CPF já está cadastrado!";
    header('Location: cadastro.php');
    exit;
}

$q = "INSERT INTO usuarios (nome, email, senha, cpf, data_nascimento) VALUES ('$nome', '$email', '$senha_criptografada', '$cpf', '$data_nascimento')";
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
