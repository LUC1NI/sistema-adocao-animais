<?php
require_once '../../Config/banco.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $q = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
    if ($banco->query($q)) {
        echo "Usuário cadastrado com sucesso! <a href='login.php'>Ir para login</a>";
    } else {
        echo "Erro: " . $banco->error;
    }
}
?>

<h2>Cadastro de Usuário</h2>
<form method="POST">
    Nome: <input type="text" name="nome" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Senha: <input type="password" name="senha" required><br><br>
    <button type="submit">Cadastrar</button>
</form>
