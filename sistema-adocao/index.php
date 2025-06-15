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
    </style>
</head>
<body>
    <h1>🐾 Bem-vindo ao Sistema de Adoção de Animais 🐾</h1>
    <p>Encontre seu novo melhor amigo! Veja os animais disponíveis ou entre para cadastrar e adotar.</p>

    <div class="menu">
        <a href="Views/animais/listar.php">Ver Animais para Adoção</a>
        <a href="Views/usuarios/login.php">Login</a><br>
        <a href="Views/cadastro.php">Cadastrar-se</a>
    </div>
</body>
</html>
