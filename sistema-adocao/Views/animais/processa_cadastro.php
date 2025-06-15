<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

$nome = $_POST['nome'];
$especie = $_POST['especie'];
$idade = $_POST['idade'];
$descricao = $_POST['descricao'];

$q = "INSERT INTO animais (nome, especie, idade, descricao) VALUES ('$nome', '$especie', '$idade', '$descricao')";

if ($banco->query($q)) {
    $_SESSION['cadastro_animal_ok'] = "Animal cadastrado com sucesso!";
    header('Location: cadastrar.php');
    exit;
} else {
    $_SESSION['cadastro_animal_erro'] = "Erro ao cadastrar animal!";
    header('Location: cadastrar.php');
    exit;
}
?>
