<?php
$host = "localhost:3307";
$user = "root";
$pass = "";
$dbname = "sistema_adocao";

$banco = new mysqli($host, $user, $pass, $dbname);
if ($banco->connect_errno) {
    die("Erro de conexão: " . $banco->connect_error);
}
?>
