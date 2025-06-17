<?php
session_start();
require_once '../../Config/banco.php';

function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    
    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ($d * 10) % 11;
        $d = ($d == 10) ? 0 : $d;
        if ($cpf[$c] != $d) {
            return false;
        }
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
