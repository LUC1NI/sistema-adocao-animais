<?php
require_once '../../Config/banco.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $banco->real_escape_string($_POST['nome']);
    $especie = $banco->real_escape_string($_POST['especie']);
    $idade = intval($_POST['idade']);
    $descricao = $banco->real_escape_string($_POST['descricao']);

    $foto_nome = '';

    // Verificar se foi enviada uma foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_nome = uniqid() . '.' . $extensao;

        // Move o arquivo para a pasta uploads
        move_uploaded_file($_FILES['foto']['tmp_name'], '../../uploads/animais/' . $foto_nome);
    }

    // Inserir no banco de dados
    $q = "INSERT INTO animais (nome, especie, idade, descricao, foto) 
          VALUES ('$nome', '$especie', $idade, '$descricao', '$foto_nome')";

    if ($banco->query($q)) {
        echo "<p>Animal cadastrado com sucesso!</p>";
        echo '<a href="listar_admin.php">Ver Lista de Animais (Admin)</a>';
    } else {
        echo "<p>Erro ao cadastrar o animal: " . $banco->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Animal</title>
</head>
<body>
    <h1>Cadastrar Novo Animal</h1>

    <form method="post" enctype="multipart/form-data">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Espécie:</label><br>
        <input type="text" name="especie" required><br><br>

        <label>Idade:</label><br>
        <input type="number" name="idade" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao" rows="5" cols="30" required></textarea><br><br>

        <label>Foto do Animal:</label><br>
        <input type="file" name="foto" accept="image/*"><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <br>
    <a href="listar_admin.php">Voltar para o Painel</a>
</body>
</html>
