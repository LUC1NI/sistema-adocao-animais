<?php
require_once '../../Config/banco.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $q = "SELECT * FROM usuarios WHERE email='$email'";
    $resp = $banco->query($q);

    if ($resp->num_rows == 1) {
        $usuario = $resp->fetch_assoc();
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario'] = $usuario;
            header("Location: painel.php");
            exit;
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
}
?>

<h2>Login</h2>
<form method="POST">
    Email: <input type="email" name="email" required><br><br>
    Senha: <input type="password" name="senha" required><br><br>
    <button type="submit">Entrar</button>
</form>
