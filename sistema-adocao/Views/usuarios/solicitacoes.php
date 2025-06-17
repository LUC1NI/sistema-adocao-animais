<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$email_usuario = $_SESSION['usuario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_adocao'], $_POST['action'])) {
    $id_adocao = intval($_POST['id_adocao']);
    $action = $_POST['action'];
    $mensagem = $_POST['mensagem'] ?? '';

    if (in_array($action, ['aprovar', 'recusar'])) {
        if ($action === 'aprovar') {
            $status = 'aprovado';
            $mensagem = '';
        } else { 
            $status = 'recusado';
            $mensagem = $_POST['mensagem'] ?? '';
        }
    
        $q_update = "UPDATE adocoes SET status = ?, mensagem = ? WHERE id = ?";
        $stmt_update = $banco->prepare($q_update);
        $stmt_update->bind_param("ssi", $status, $mensagem, $id_adocao);
        $stmt_update->execute();
    }
    
}

$q_adocoes = "SELECT a.id, a.data_pedido, a.status, a.mensagem, u.nome AS usuario_nome, an.nome AS animal_nome, an.foto AS animal_foto
              FROM adocoes a
              JOIN usuarios u ON a.id_usuario = u.id
              JOIN animais an ON a.id_animal = an.id
              ORDER BY a.data_pedido DESC";

$result_adocoes = $banco->query($q_adocoes);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Solicitações de Adoção</title>
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
            box-shadow: 0 2px 10px rgb(0 0 0 / 0.1);
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
            box-shadow: 0 8px 24px rgb(99 102 241 / 0.15);
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
            box-shadow: 0 2px 8px rgb(99 102 241 / 0.3);
        }
        form.inline-form {
            display: inline-block;
            margin: 0;
        }
        textarea.message-input {
            width: 100%;
            min-height: 60px;
            resize: vertical;
            padding: 6px 8px;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            font-size: 0.9rem;
        }
        textarea.message-input:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 6px #6366f1aa;
        }
        button.action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 6px 12px;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
            user-select: none;
        }
        button.approve-btn {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
        }
        button.approve-btn:hover, button.approve-btn:focus {
            background: linear-gradient(135deg, #15803d, #166534);
            outline: none;
        }
        button.reject-btn {
            background: #ef4444;
            color: white;
        }
        button.reject-btn:hover, button.reject-btn:focus {
            background: #b91c1c;
            outline: none;
        }
        .no-requests {
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
    Solicitações de Adoção
</header>

<main class="container" role="main">
    <h1>Solicitações de Adoção</h1>
    <?php if ($result_adocoes && $result_adocoes->num_rows > 0): ?>
        <table role="table" aria-label="Solicitações de adoção detalhadas">
            <thead>
                <tr>
                    <th scope="col">Foto</th>
                    <th scope="col">Animal</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Data do Pedido</th>
                    <th scope="col">Status</th>
                    <th scope="col">Mensagem</th>
                    <th scope="col" style="min-width: 240px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_adocoes->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?php
                        $animalFoto = !empty($row['animal_foto']) ? '../../uploads/animais/' . htmlspecialchars($row['animal_foto']) : 'https://placehold.co/80x60/6366f1/ffffff?text=Sem+Foto';
                        ?>
                        <img src="<?= $animalFoto ?>" alt="Foto do animal <?= htmlspecialchars($row['animal_nome']); ?>" class="animal-photo" loading="lazy" />
                    </td>
                    <td><?= htmlspecialchars($row['animal_nome']); ?></td>
                    <td><?= htmlspecialchars($row['usuario_nome']); ?></td>
                    <td><?= htmlspecialchars($row['data_pedido']); ?></td>
                    <td><?= ucfirst(htmlspecialchars($row['status'])); ?></td>
                    <td style="max-width: 300px; white-space: pre-wrap; word-wrap: break-word;"><?= !empty($row['mensagem']) ? nl2br(htmlspecialchars($row['mensagem'])) : 'Nenhuma mensagem'; ?></td>
                    <td>
                        <?php if ($row['status'] === 'pendente'): ?>
                        <form method="post" class="inline-form" aria-label="Formulário para aprovar solicitação <?= $row['id']; ?>">
                            <input type="hidden" name="id_adocao" value="<?= $row['id']; ?>">
                            <input type="hidden" name="action" value="aprovar">
                            <button type="submit" class="action-btn approve-btn" title="Aprovar esta solicitação">
                                <span class="material-icons md-18" aria-hidden="true">check_circle</span> Aprovar
                            </button>
                        </form>
                        <form method="post" class="inline-form" aria-label="Formulário para recusar solicitação <?= $row['id']; ?>" style="margin-top: 0.5rem;">
                            <input type="hidden" name="id_adocao" value="<?= $row['id']; ?>">
                            <input type="hidden" name="action" value="recusar">
                            <textarea name="mensagem" placeholder="Mensagem para o usuário (se recusar)" class="message-input" aria-label="Mensagem para o usuário se recusar solicitação"></textarea>
                            <button type="submit" class="action-btn reject-btn" title="Recusar esta solicitação" style="margin-top: 0.4rem;">
                                <span class="material-icons md-18" aria-hidden="true">cancel</span> Recusar
                            </button>
                        </form>
                        <?php else: ?>
                            <span aria-label="Nenhuma ação disponível">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-requests">Nenhuma solicitação de adoção encontrada.</div>
    <?php endif; ?>

    <a href="../usuarios/painel.php" class="back-link" aria-label="Voltar ao painel de administração">
        <span class="material-icons md-18" aria-hidden="true">arrow_back</span> Voltar ao Painel
    </a>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
