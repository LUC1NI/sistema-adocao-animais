<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gerenciar Animais (Admin)</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <style>
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
        .animal-card {
            border-radius: 1rem;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.05);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .animal-card:hover {
            box-shadow: 0 12px 24px rgb(99 102 241 / 0.4);
            transform: translateY(-6px);
        }
        .animal-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }
        .card-body {
            padding: 1rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            color: white;
            border: none;
            transition: background 0.4s ease;
        }
        .btn-primary-custom:hover, 
        .btn-primary-custom:focus {
            background: linear-gradient(135deg, #4f46e5, #0891b2);
            color: white;
        }
        .btn-danger-custom {
            background: #dc3545;
            color: white;
            border: none;
            transition: background 0.4s ease;
        }
        .btn-danger-custom:hover, 
        .btn-danger-custom:focus {
            background: #bd2130;
            color: white;
        }
        .actions {
            margin-top: auto;
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .container {
            max-width: 1100px;
            margin-top: 2rem;
            margin-bottom: 3rem;
        }
        a.back-to-panel {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
            font-weight: 600;
            color: #6366f1;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        a.back-to-panel:hover {
            color: #4f46e5;
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<header>
    Gerenciar Animais (Admin)
</header>

<div class="container">
    <?php
    $q = "SELECT * FROM animais ORDER BY id DESC";
    $resultado = $banco->query($q);

    if ($resultado && $resultado->num_rows > 0) { ?>
        <div class="row g-4">
            <?php while ($animal = $resultado->fetch_assoc()) { ?>
                <div class="col-12 col-md-6 col-lg-4 d-flex">
                    <div class="animal-card w-100">
                        <?php if (!empty($animal['foto'])): ?>
                            <img src='../../uploads/animais/<?php echo htmlspecialchars($animal['foto']); ?>' alt='Foto do animal <?php echo htmlspecialchars($animal['nome']); ?>' class="animal-img" loading="lazy" />
                        <?php else: ?>
                            <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/c50bbcfe-f34f-4894-b3ba-5b604f9e48a3.png" alt="Imagem placeholder sem foto do animal" class="animal-img" loading="lazy" />
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5><?php echo htmlspecialchars($animal['nome']); ?></h5>
                            <p class="mb-1"><strong>Espécie:</strong> <?php echo htmlspecialchars($animal['especie']); ?></p>
                            <p class="mb-2"><strong>Idade:</strong> <?php echo htmlspecialchars($animal['idade']); ?> anos</p>
                            <p class="text-truncate" title="<?php echo htmlspecialchars($animal['descricao']); ?>"><?php echo htmlspecialchars($animal['descricao']); ?></p>
                            <div class="actions">
                                <a href="detalhes.php?id=<?php echo $animal['id']; ?>" class="btn btn-primary-custom d-flex align-items-center gap-1" aria-label="Ver detalhes do animal <?php echo htmlspecialchars($animal['nome']); ?>">
                                    <span class="material-icons md-18">visibility</span> Ver Detalhes
                                </a>
                                <a href="editar.php?id=<?php echo $animal['id']; ?>" class="btn btn-outline-secondary d-flex align-items-center gap-1" aria-label="Editar animal <?php echo htmlspecialchars($animal['nome']); ?>">
                                    <span class="material-icons md-18">edit</span> Editar
                                </a>
                                <a href="excluir.php?id=<?php echo $animal['id']; ?>" class="btn btn-danger-custom d-flex align-items-center gap-1" aria-label="Excluir animal <?php echo htmlspecialchars($animal['nome']); ?>" onclick="return confirm('Tem certeza que deseja excluir este animal?');">
                                    <span class="material-icons md-18">delete</span> Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-info text-center" role="alert">
            Nenhum animal cadastrado.
        </div>
    <?php } ?>
    <a href="../usuarios/painel.php" class="back-to-panel d-inline-flex align-items-center gap-1">
        <span class="material-icons md-18" aria-hidden="true">arrow_back</span> Voltar ao Painel
    </a>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

