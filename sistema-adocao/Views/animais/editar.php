<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $q = "SELECT * FROM animais WHERE id = $id";
    $resultado = $banco->query($q);

    if ($resultado && $resultado->num_rows > 0) {
        $animal = $resultado->fetch_assoc();
    } else {
        echo "<p>Animal não encontrado.</p>";
        echo '<a href="listar_admin.php">Voltar</a>';
        exit;
    }
} else {
    echo "<p>ID do animal não informado.</p>";
    echo '<a href="listar_admin.php">Voltar</a>';
    exit;
}

if (isset($_POST['salvar'])) {
    $nome = $banco->real_escape_string($_POST['nome']);
    $especie = $banco->real_escape_string($_POST['especie']);
    $idade = intval($_POST['idade']);
    $descricao = $banco->real_escape_string($_POST['descricao']);

    $q = "UPDATE animais SET nome='$nome', especie='$especie', idade=$idade, descricao='$descricao' WHERE id=$id";
    $resultado = $banco->query($q);

    if ($resultado) {
        echo "<div class='alert alert-success mt-3'>Animal atualizado com sucesso!</div>";
        echo '<a href="listar_admin.php" class="btn btn-primary mt-3">Voltar para a listagem</a>';
        exit;
    } else {
        echo "<div class='alert alert-danger mt-3'>Erro ao atualizar o animal.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Animal</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <style>
        body {
            background-color: #f7f9fc;
            font-family: "Inter", sans-serif, system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
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
            max-width: 600px;
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
        form label {
            font-weight: 600;
            margin-top: 1rem;
        }
        form input[type="text"],
        form input[type="number"],
        form textarea {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        form input[type="text"]:focus,
        form input[type="number"]:focus,
        form textarea:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 6px #6366f1aa;
        }
        form textarea {
            resize: vertical;
            min-height: 100px;
        }
        input[type="submit"] {
            margin-top: 2rem;
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            border: none;
            color: white;
            font-weight: 700;
            font-size: 1.125rem;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            transition: background 0.4s ease;
        }
        input[type="submit"]:hover,
        input[type="submit"]:focus {
            background: linear-gradient(135deg, #4f46e5, #0891b2);
        }
        a.back-link {
            display: inline-block;
            margin-top: 1.5rem;
            font-weight: 600;
            color: #6366f1;
            text-decoration: none;
            transition: color 0.3s ease;
            width: 100%;
            text-align: center;
        }
        a.back-link:hover,
        a.back-link:focus {
            color: #4f46e5;
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<header>
    Editar Animal
</header>

<main class="container">
    <form method="post" novalidate>
        <h1>Editar Animal</h1>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($animal['nome']); ?>" required />

        <label for="especie">Espécie:</label>
        <input type="text" id="especie" name="especie" value="<?php echo htmlspecialchars($animal['especie']); ?>" required />

        <label for="idade">Idade (anos):</label>
        <input type="number" id="idade" name="idade" value="<?php echo htmlspecialchars($animal['idade']); ?>" min="0" required />

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($animal['descricao']); ?></textarea>

        <input type="submit" name="salvar" value="Salvar Alterações" aria-label="Salvar alterações do animal" />
    </form>

    <a href="listar_admin.php" class="back-link" aria-label="Cancelar e voltar para a listagem de animais">Cancelar e voltar</a>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
