<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header('Location: ../usuarios/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel do Usuário (Admin)</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <style>
        header {
            position: sticky;
            top: 0;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f7f9fc;
            backdrop-filter: saturate(180%) blur(12px);
            box-shadow: 0 2px 10px rgb(0 0 0 / 0.1);
            font-weight: 700;
            font-size: 1.75rem;
            color: #4f46e5;
            user-select: none;
            z-index: 1030;
        }

        main.container {
            max-width: 960px;
            margin: 3rem auto 4rem;
            padding: 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgb(99 102 241 / 0.15);
        }

        h1 {
            font-weight: 900;
            color: #222;
            text-align: center;
            margin-bottom: 2rem;
            font-size: clamp(2rem, 5vw, 2.5rem);
        }

        .welcome-message {
            text-align: center;
            font-size: 1.25rem;
            margin-bottom: 3rem;
            color: #555;
        }

        .options-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            max-width: 400px;
            margin: 0 auto;
        }

        .options-list a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.85rem 1.25rem;
            font-weight: 600;
            font-size: 1.125rem;
            color: white;
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            border-radius: 12px;
            text-decoration: none;
            box-shadow: 0 6px 15px rgb(99 102 241 / 0.3);
            transition: background 0.3s ease, transform 0.3s ease;
            user-select: none;
        }
        .options-list a:hover,
        .options-list a:focus {
            background: linear-gradient(135deg, #4f46e5, #0891b2);
            transform: translateY(-3px);
            text-decoration: none;
        }

        .options-list a .material-icons {
            margin-right: 0.75rem;
        }

        .footer-link {
            display: block;
            text-align: center;
            margin-top: 3rem;
            font-weight: 600;
            color: #6366f1;
            font-size: 1rem;
            text-decoration: none;
            user-select: none;
            transition: color 0.3s ease;
        }
        .footer-link:hover,
        .footer-link:focus {
            color: #4f46e5;
            text-decoration: underline;
        }
        body {
            background-color: #f7f9fc;
            font-family: "Inter", sans-serif, system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <header role="banner" aria-label="Painel do Usuário">
        Painel do Admin
    </header>

    <main class="container" role="main">
        <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
        <p class="welcome-message">Você está logado no sistema como administrador.</p>

        <nav class="options-list" aria-label="Opções principais do painel">
            <a href="../animais/cadastrar_animal.php" role="link" aria-label="Cadastrar Novo Animal">
                <span class="material-icons" aria-hidden="true">add_circle</span> Cadastrar Novo Animal
            </a>
            <a href="../animais/listar_admin.php" role="link" aria-label="Gerenciar Animais (Listar, Editar, Excluir)">
                <span class="material-icons" aria-hidden="true">pets</span> Gerenciar Animais (Listar, Editar, Excluir)
            </a>
            <a href="solicitacoes.php" role="link" aria-label="Solicitações de Adoção">
                <span class="material-icons" aria-hidden="true">assignment</span> Solicitações
            </a>
            <a href="logout.php" role="link" aria-label="Sair do sistema">
                <span class="material-icons" aria-hidden="true">logout</span> Sair
            </a>
        </nav>

        <a href="../../index.php" class="footer-link">
            Voltar para a Home Pública
        </a>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

