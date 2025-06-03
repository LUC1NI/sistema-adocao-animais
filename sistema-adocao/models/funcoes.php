<?php
session_start();

function estaLogado() {
    return isset($_SESSION['usuario']);
}

function isAdmin() {
    return estaLogado() && $_SESSION['usuario']['tipo_usuario'] === 'admin';
}

function redirecionar($url) {
    header("Location: $url");
    exit;
}
?>
