<?php
session_start();
require_once 'Config/banco.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adote um Amigo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        h1 {
            color: #2c3e50;
        }
        .menu {
            margin-top: 30px;
        }
        .menu a {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .menu a:hover {
            background-color: #2980b9;
        }
        .animal-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            text-align: left;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .animal-card img {
            max-width: 200px;
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>🐾 Bem-vindo ao Sistema de Adoção de Animais 🐾</h1>
    <p>Encontre seu novo melhor amigo! Veja os animais disponíveis ou entre para cadastrar e adotar.</p>

    <div class="menu">
        <?php if (isset($_SESSION['usuario'])): ?>
            <span>Olá, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</span>
            <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin'): ?>
                <a href="Views/usuarios/painel.php">Painel Admin</a>
            <?php endif; ?>
            <a href="Views/usuarios/logout.php">Logout</a>
        <?php else: ?>
            <a href="Views/usuarios/login.php">Login</a>
            <a href="Views/cadastro.php">Cadastrar-se</a>
        <?php endif; ?>
    </div>

    <h2>Animais Disponíveis para Adoção</h2>

    <?php
    $q = "SELECT * FROM animais ORDER BY id DESC";
    $resultado = $banco->query($q);

    if ($resultado && $resultado->num_rows > 0) {
        while ($animal = $resultado->fetch_assoc()) {
            echo "<div class='animal-card'>";
            echo "<h3>" . htmlspecialchars($animal['nome']) . "</h3>";
            if (!empty($animal['foto'])) {
                echo "<img src='uploads/animais/" . htmlspecialchars($animal['foto']) . "' alt='Foto do animal'>";
            }
            echo "<strong>Espécie:</strong> " . htmlspecialchars($animal['especie']) . "<br>";
            echo "<strong>Idade:</strong> " . htmlspecialchars($animal['idade']) . " anos<br>";
            echo "<strong>Descrição:</strong> " . htmlspecialchars($animal['descricao']) . "<br>";
            echo "<a href='Views/animais/detalhes.php?id=" . htmlspecialchars($animal['id']) . "'>Ver Detalhes</a>";
            echo "</div>";
        }
    } else {
        echo "<p>Nenhum animal disponível no momento.</p>";
    }
    ?>

</body>
</html>
