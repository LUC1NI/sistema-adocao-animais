<?php
require_once 'Config/banco.php';
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$nome = $_POST['nome'];
$especie = $_POST['especie'];
$raca = $_POST['raca'];
$idade = $_POST['idade'];
$descricao = $_POST['descricao'];
$imagem_nome = '';

// Verifica se uma imagem foi enviada
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $imagem_nome = time() . '_' . $_FILES['imagem']['name'];
    move_uploaded_file($_FILES['imagem']['tmp_name'], 'uploads/' . $imagem_nome);
}

// Insere no banco
$q = "INSERT INTO animais (nome, especie, raca, idade, descricao, imagem, status) 
      VALUES ('$nome', '$especie', '$raca', '$idade', '$descricao', '$imagem_nome', 'disponivel')";

if ($banco->query($q)) {
    echo "Animal cadastrado com sucesso!";
    echo "<br><a href='painel.php'>Voltar ao Painel</a>";
} else {
    echo "Erro ao cadastrar: " . $banco->error;
}
