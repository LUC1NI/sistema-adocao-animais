<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['erro_recuperar'] = "Erro de segurança: token CSRF inválido.";
    header('Location: recuperar_senha.php');
    exit;
}

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



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $nova_senha = $_POST['nova_senha'];

    if (empty($cpf) || empty($data_nascimento) || empty($nova_senha)) {
        $_SESSION['erro_recuperar'] = "Por favor, preencha todos os campos.";
        header('Location: recuperar_senha.php');
        exit;
    }

    if (!validarCPF($cpf)) {
        $_SESSION['erro_recuperar'] = "CPF inválido.";
        header('Location: recuperar_senha.php');
        exit;
    }

    $stmt = $banco->prepare("SELECT id FROM usuarios WHERE cpf = ? AND data_nascimento = ?");
    $stmt->bind_param("ss", $cpf, $data_nascimento);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $_SESSION['erro_recuperar'] = "CPF ou data de nascimento não conferem.";
        $stmt->close();
        header('Location: recuperar_senha.php');
        exit;
    }

    $stmt->close();

    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

    $stmt = $banco->prepare("UPDATE usuarios SET senha = ? WHERE cpf = ? AND data_nascimento = ?");
    $stmt->bind_param("sss", $senha_hash, $cpf, $data_nascimento);

    if ($stmt->execute()) {
        $_SESSION['sucesso_recuperar'] = "Senha atualizada com sucesso! Faça login com a nova senha.";
        $stmt->close();
        header('Location: recuperar_senha.php');
        exit;
    } else {
        $_SESSION['erro_recuperar'] = "Erro ao atualizar a senha.";
        $stmt->close();
        header('Location: recuperar_senha.php');
        exit;
    }
} else {
    header('Location: recuperar_senha.php');
    exit;
}
?>
