<?php
session_start();
require_once '../../Config/banco.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $q = "SELECT * FROM animais WHERE id = $id";
    $resultado = $banco->query($q);

    if ($resultado && $resultado->num_rows > 0) {
        $animal = $resultado->fetch_assoc();
    } else {
        echo "<p>Animal não encontrado.</p>";
        echo '<a href="../../index.php">Voltar</a>';
        exit;
    }
} else {
    echo "<p>ID do animal não informado.</p>";
    echo '<a href="../../index.php">Voltar</a>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detalhes do Animal - <?php echo htmlspecialchars($animal['nome']); ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <style>
        /* Glassmorphism header replacement */
        header {
            position: sticky;
            top: 0;
            background: rgba(255,255,255,0.85);
            backdrop-filter: saturate(180%) blur(12px);
            height: 64px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 10px rgb(0 0 0 / 0.1);
            padding: 0 1rem;
            z-index: 1030;
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(45deg, #6366f1, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            user-select: none;
        }

        .content-container {
            max-width: 900px;
            margin: 2rem auto 4rem;
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 16px rgb(99 102 241 / 0.1);
        }

        .animal-img {
            width: 100%;
            height: auto;
            border-radius: 1rem;
            object-fit: cover;
            aspect-ratio: 4 / 3;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
            margin-bottom: 1.5rem;
        }

        h1 {
            font-weight: 900;
            font-size: clamp(2rem, 4vw, 3rem);
            margin-bottom: 1rem;
            color: #2c3e50;
        }

        .animal-info strong {
            color: #6366f1;
            font-weight: 600;
        }

        .btn-group .btn {
            min-width: 140px;
        }

        /* Buttons with gradient background */
        .btn-primary-custom {
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            border: none;
            transition: background 0.4s ease;
            color: white;
        }

        .btn-primary-custom:hover, 
        .btn-primary-custom:focus {
            background: linear-gradient(135deg, #4f46e5, #0891b2);
            color: white;
        }

        /* Responsive typography */
        p {
            font-size: 1.125rem;
            line-height: 1.6;
            color: #444c59;
        }

        /* Container for buttons */
        .action-buttons {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* Back link styling */
        .back-link {
            display: inline-block;
            margin-top: 2rem;
            color: #6366f1;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #4f46e5;
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-light">
<header>
    Detalhes do Animal
</header>

<div class="content-container">
    <h1><?php echo htmlspecialchars($animal['nome']); ?></h1>

    <?php if (!empty($animal['foto'])): ?>
        <img src='../../uploads/animais/<?php echo htmlspecialchars($animal['foto']); ?>' alt='Foto do animal <?php echo htmlspecialchars($animal['nome']); ?>' class="animal-img" loading="lazy" />
    <?php else: ?>
        <img src="https://placehold.co/900x675/6366f1/ffffff?text=Sem+Imagem+do+Animal" alt="Imagem placeholder sem foto do animal" class="animal-img" loading="lazy" />
    <?php endif; ?>

    <div class="animal-info">
        <p><strong>Espécie:</strong> <?php echo htmlspecialchars($animal['especie']); ?></p>
        <p><strong>Idade:</strong> <?php echo htmlspecialchars($animal['idade']); ?> anos</p>
        <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($animal['descricao'])); ?></p>
    </div>

    <div class="action-buttons">
        <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin'): ?>
            <a href="editar.php?id=<?php echo $animal['id']; ?>" class="btn btn-primary-custom btn-lg d-flex align-items-center gap-1" aria-label="Editar animal <?php echo htmlspecialchars($animal['nome']); ?>">
                <span class="material-icons md-24">edit</span> Editar
            </a>
            <a href="excluir.php?id=<?php echo $animal['id']; ?>" class="btn btn-outline-danger btn-lg d-flex align-items-center gap-1" onclick="return confirm('Tem certeza que deseja excluir este animal?');" aria-label="Excluir animal <?php echo htmlspecialchars($animal['nome']); ?>">
                <span class="material-icons md-24">delete</span> Excluir
            </a>
        <?php endif; ?>

        <?php if (isset($_SESSION['usuario']) && (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin')): ?>
            <form action="solicitar_adocao.php" method="get" class="m-0">
                <input type="hidden" name="id" value="<?php echo $animal['id']; ?>">
                <button type="submit" class="btn btn-primary-custom btn-lg d-flex align-items-center gap-1" aria-label="Solicitar adoção do animal <?php echo htmlspecialchars($animal['nome']); ?>">
                    <span class="material-icons md-24">favorite</span> Solicitar Adoção
                </button>
            </form>
        <?php endif; ?>
    </div>

    <a href='../../index.php' class="back-link">
        <span class="material-icons md-18" aria-hidden="true">arrow_back</span> Voltar para a página inicial
    </a>
</div>

<!-- Bootstrap 5 JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

