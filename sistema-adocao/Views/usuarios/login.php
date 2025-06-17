<?php
//session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Sistema de Adoção</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            font-family: "Inter", sans-serif, system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            margin: 0;
        }
        .login-container {
            background: white;
            padding: 2.5rem 2rem 3rem;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgb(99 102 241 / 0.3);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }
        h1 {
            font-weight: 900;
            margin-bottom: 2rem;
            text-align: center;
            color: #212529;
            font-size: clamp(2rem, 5vw, 2.5rem);
        }
        form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #4b5563;
        }
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 0.5rem;
            margin-bottom: 1.25rem;
            transition: border-color 0.3s ease;
        }
        form input[type="email"]:focus,
        form input[type="password"]:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 6px rgb(99 102 241 / 0.5);
        }
        button[type="submit"] {
            width: 100%;
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            color: white;
            border: none;
            padding: 0.75rem;
            font-weight: 700;
            font-size: 1.125rem;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.4s ease;
        }
        button[type="submit"]:hover,
        button[type="submit"]:focus {
            background: linear-gradient(135deg, #4f46e5, #0891b2);
        }
        .error-message {
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
        }
        .links {
            margin-top: 1.5rem;
            text-align: center;
        }
        .links a {
            color: #6366f1;
            font-weight: 600;
            margin: 0 0.5rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .links a:hover,
        .links a:focus {
            color: #4f46e5;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container" role="main" aria-labelledby="login-title">
        <h1 id="login-title">Login</h1>

        <?php
        if (isset($_SESSION['erro_login'])) {
            echo '<div class="error-message" role="alert">'.htmlspecialchars($_SESSION['erro_login']).'</div>';
            unset($_SESSION['erro_login']);
        }
        ?>

        <form action="valida_login.php" method="post" novalidate>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required autocomplete="email" />
            
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required autocomplete="current-password" />
            
            <button type="submit" aria-label="Entrar no sistema">Entrar</button>
        </form>

        <div class="links">
            <a href="recuperar_senha.php" aria-label="Recuperar senha">Recuperar senha</a> |
            <a href="cadastro.php" aria-label="Cadastrar nova conta">Ainda não tem conta? Cadastre-se</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
