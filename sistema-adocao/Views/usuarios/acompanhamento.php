<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$email_usuario = $_SESSION['usuario'];

$q = "SELECT id FROM usuarios WHERE nome = ?";
$stmt = $banco->prepare($q);
$stmt->bind_param("s", $email_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    $id_usuario = $usuario['id'];
} else {
    echo "Usuário não encontrado.";
    exit;
}

$q_adocoes = "SELECT a.id, a.data_pedido, a.status, a.mensagem, an.nome AS animal_nome, an.foto AS animal_foto 
              FROM adocoes a 
              JOIN animais an ON a.id_animal = an.id 
              WHERE a.id_usuario = ? ORDER BY a.data_pedido DESC";
$stmt_adocoes = $banco->prepare($q_adocoes);
$stmt_adocoes->bind_param("i", $id_usuario);
$stmt_adocoes->execute();
$result_adocoes = $stmt_adocoes->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Meus Pedidos de Adoção</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-weight: 700;
            font-size: 1.75rem;
            color: #4f46e5;
            user-select: none;
            z-index: 1030;
        }
        main.container {
            max-width: 1100px;
            margin: 3rem auto 4rem;
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.15);
        }
        h1 {
            font-weight: 900;
            text-align: center;
            margin-bottom: 2rem;
            color: #222;
            font-size: clamp(2rem, 5vw, 3rem);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 10px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }
        th {
            background: linear-gradient(135deg, #6366f1, #06b6d4);
            color: white;
            font-weight: 700;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        tbody tr:hover {
            background-color: #f1f5ff;
        }
        img.animal-photo {
            max-width: 80px;
            height: auto;
            border-radius: 0.5rem;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
        }
        .no-orders {
            font-size: 1.2rem;
            font-weight: 600;
            color: #64748b;
            text-align: center;
            padding: 4rem 0;
        }
        a.back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
            font-weight: 600;
            color: #6366f1;
            text-decoration: none;
            user-select: none;
            transition: color 0.3s ease;
        }
        a.back-link:hover, a.back-link:focus {
            color: #4f46e5;
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<header>
    Meus Pedidos de Adoção
</header>

<main class="container" role="main">
    <h1>Meus Pedidos de Adoção</h1>

    <?php if ($result_adocoes && $result_adocoes->num_rows > 0): ?>
        <table role="table" aria-label="Pedidos de adoção do usuário">
            <thead>
                <tr>
                    <th scope="col">Foto</th>
                    <th scope="col">Animal</th>
                    <th scope="col">Data do Pedido</th>
                    <th scope="col">Status</th>
                    <th scope="col">Mensagem do Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($adocao = $result_adocoes->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php
                            $foto = !empty($adocao['animal_foto']) ? '../../uploads/animais/' . htmlspecialchars($adocao['animal_foto']) : 'https://placehold.co/80x60/6366f1/ffffff?text=Sem+Foto';
                            ?>
                            <img src="<?= $foto ?>" alt="Foto do animal <?= htmlspecialchars($adocao['animal_nome']); ?>" class="animal-photo" loading="lazy" />
                        </td>
                        <td><?= htmlspecialchars($adocao['animal_nome']); ?></td>
                        <td><?= htmlspecialchars($adocao['data_pedido']); ?></td>
                        <td><?= ucfirst(htmlspecialchars($adocao['status'])); ?></td>
                        <td><?= !empty($adocao['mensagem']) ? nl2br(htmlspecialchars($adocao['mensagem'])) : 'Nenhuma mensagem'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-orders">Você ainda não fez nenhum pedido de adoção.</div>
    <?php endif; ?>

    <a href="../../index.php" class="back-link" aria-label="Voltar para a página inicial">
        <span class="material-icons md-18" aria-hidden="true">arrow_back</span> Voltar para a página inicial
    </a>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
