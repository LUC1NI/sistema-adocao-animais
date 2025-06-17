<?php
session_start();
require_once 'Config/banco.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Adote um Amigo - Sistema de Adoção</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <style>
        :root {
            --bs-body-bg: #f7f9fc;
            --bs-body-color: #212529;
        }

        header {
            position: sticky;
            top: 0;
            backdrop-filter: saturate(180%) blur(12px);
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 1030;
            height: 64px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 10px rgb(0 0 0 / 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(45deg, #6366f1, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            user-select: none;
        }

        /* Animal card hover elevation */
        .animal-card:hover {
            box-shadow: 0 12px 24px rgb(99 102 241 / 0.4);
            transform: translateY(-6px);
            transition: all 0.3s ease;
        }

        .animal-card {
            transition: all 0.3s ease;
            border-radius: 1rem;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 8px rgb(0 0 0 / 0.05);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .animal-card img {
            object-fit: cover;
            aspect-ratio: 4 / 3;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            max-width: 100%;
            height: auto;
        }

        /* Card body padding and flexible grow */
        .card-body {
            flex-grow: 1;
            padding: 1.25rem; /* Added padding for better text spacing */
        }

        /* Button gradient accent */
        .btn-primary-custom {
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            border: none;
            transition: background 0.4s ease;
        }
        .btn-primary-custom:hover, 
        .btn-primary-custom:focus {
            background: linear-gradient(135deg, #4f46e5, #0891b2);
        }

        /* Footer style */
        footer {
            background-color: #f1f5f9;
            padding: 1.5rem 0;
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
            user-select: none;
        }

        /* Responsive typography for headings */
        h1 {
            font-weight: 900;
            font-size: clamp(1.8rem, 4vw, 3rem);
        }

        /* Navigation link spacing */
        .nav-link {
            font-weight: 600;
            color: #212529;
        }

        .nav-link:hover, .nav-link:focus {
            color: #6366f1;
            text-decoration: underline;
        }

        /* Material icons button styles */
        .material-icons.md-18 { font-size: 18px; vertical-align: middle; }
        .material-icons.md-24 { font-size: 24px; vertical-align: middle; }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
    <header>
        <nav class="container navbar navbar-expand-lg navbar-light p-0 px-3">
            <a class="navbar-brand" href="#">Adote um Amigo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="material-icons md-24">menu</span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-3">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <li class="nav-item">
                            <span class="nav-link">Olá, <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></span>
                        </li>
                        <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin'): ?>
                            <li class="nav-item"><a href="Views/usuarios/solicitacoes.php" class="nav-link">Solicitações</a></li>
                            <li class="nav-item"><a href="Views/usuarios/painel.php" class="nav-link">Painel Admin</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a href="Views/usuarios/acompanhamento.php" class="nav-link">Minhas Adoções</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a href="Views/usuarios/logout.php" class="btn btn-outline-primary btn-sm">Sair</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a href="Views/usuarios/login.php" class="btn btn-primary btn-sm">Login</a></li>
                        <li class="nav-item"><a href="Views/usuarios/cadastro.php" class="btn btn-secondary btn-sm">Cadastrar-se</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container flex-grow-1 my-5">
        <h1 class="text-center mb-4">Bem-vindo ao Sistema de Adoção de Animais</h1>
        <p class="lead text-center text-secondary mb-5">Encontre seu novo melhor amigo! Veja os animais disponíveis ou entre para cadastrar e adotar.</p>

        <h2 class="mb-4">Animais Disponíveis para Adoção</h2>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <?php
            $q = "SELECT * FROM animais ORDER BY id DESC";
            $resultado = $banco->query($q);

            if ($resultado && $resultado->num_rows > 0) {
                while ($animal = $resultado->fetch_assoc()) {
                    ?>
                    <div class="col d-flex">
                        <div class="animal-card shadow-sm w-100 d-flex flex-column">
                            <?php if (!empty($animal['foto'])): ?>
                                <img src="uploads/animais/<?php echo htmlspecialchars($animal['foto']); ?>" alt="Foto do animal <?php echo htmlspecialchars($animal['nome']); ?>" loading="lazy" class="mb-3" />
                            <?php else: ?>
                                <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/8d067ee9-b5e1-4f59-adcb-1c1503f48fc1.png" alt="Imagem placeholder sem foto do animal" class="mb-3" />
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($animal['nome']); ?></h5>
                                <p class="mb-1"><strong>Espécie:</strong> <?php echo htmlspecialchars($animal['especie']); ?></p>
                                <p class="mb-1"><strong>Idade:</strong> <?php echo htmlspecialchars($animal['idade']); ?> anos</p>
                                <p class="card-text text-truncate" title="<?php echo htmlspecialchars($animal['descricao']); ?>"><?php echo htmlspecialchars($animal['descricao']); ?></p>
                                <div class="mt-auto">
                                    <a href="Views/animais/detalhes.php?id=<?php echo htmlspecialchars($animal['id']); ?>" 
                                       class="btn btn-primary btn-primary-custom w-100 mt-3" aria-label="Ver detalhes do animal <?php echo htmlspecialchars($animal['nome']); ?>">
                                        Ver Detalhes <span class="material-icons md-18">chevron_right</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="col-12">
                    <div class="alert alert-info text-center" role="alert">
                        Nenhum animal disponível no momento.
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </main>

    <footer>
        <div class="container text-center text-muted">
            <small>© 2024 Adote um Amigo. Todos os direitos reservados.</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

