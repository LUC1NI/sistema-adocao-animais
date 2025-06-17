<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

$id_animal = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_animal <= 0) {
    echo "<p>ID do animal não informado.</p>";
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
    echo "<p>Usuário não encontrado.</p>";
    exit;
}

$q_check = "SELECT * FROM adocoes WHERE id_usuario = ? AND id_animal = ?";
$stmt_check = $banco->prepare($q_check);
$stmt_check->bind_param("ii", $id_usuario, $id_animal);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

$message = '';
if ($result_check && $result_check->num_rows > 0) {
    $message = "Você já fez uma solicitação de adoção para este animal. Aguarde a resposta.<br>";
    $message .= '<a href="../../Views/usuarios/acompanhamento.php">Minhas Adoções</a> | ';
    $message .= '<a href="detalhes.php?id=' . $id_animal . '">Voltar para os detalhes do animal</a>';
}

if (empty($message) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $pergunta1 = $_POST['pergunta1'] ?? '';
    $pergunta2 = $_POST['pergunta2'] ?? '';
    $pergunta3 = $_POST['pergunta3'] ?? '';

    $respostas = json_encode([
        'Por que deseja adotar este animal?' => $pergunta1,
        'Você tem outros animais de estimação?' => $pergunta2,
        'Você tem experiência em cuidar de animais?' => $pergunta3,
    ]);

    $data_pedido = date('Y-m-d H:i:s');
    $status = 'pendente';

    $q_insert = "INSERT INTO adocoes (id_usuario, id_animal, data_pedido, status, respostas_formulario) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $banco->prepare($q_insert);
    $stmt_insert->bind_param("iisss", $id_usuario, $id_animal, $data_pedido, $status, $respostas);

    if ($stmt_insert->execute()) {
        $message = "<div class='alert alert-success mt-3'>Solicitação de adoção enviada com sucesso!</div>";
    } else {
        $message = "<div class='alert alert-danger mt-3'>Erro ao enviar solicitação de adoção.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Formulário de Solicitação de Adoção</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Google Material Icons -->
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
        }
        .form-container {
            background: white;
            padding: 2.5rem 2rem 3rem;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
        }
        h1 {
            font-weight: 900;
            margin-bottom: 2rem;
            text-align: center;
            color: #212529;
            font-size: clamp(2rem, 5vw, 2.5rem);
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #4b5563;
        }
        textarea {
            width: 100%;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            resize: vertical;
            min-height: 80px;
            transition: border-color 0.3s ease;
        }
        textarea:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 6px rgba(99, 102, 241, 0.5);
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
        .alert {
            margin-bottom: 1rem;
        }
        a.btn, a.back-link {
            margin-top: 1rem;
            display: inline-block;
            text-decoration: none;
            font-weight: 600;
            color: #6366f1;
            transition: color 0.3s ease;
        }
        a.btn:hover, a.back-link:hover,
        a.btn:focus, a.back-link:focus {
            color: #4f46e5;
            text-decoration: underline;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <?php if (!empty($message)): ?>
            <?php echo $message; ?>
            <a href="detalhes.php?id=<?php echo $id_animal; ?>" class="btn btn-primary" aria-label="Voltar para os detalhes do animal">Voltar para os detalhes do animal</a>
        <?php else: ?>
            <h1>Formulário de Solicitação de Adoção</h1>
            <form method="post" action="">
                <label for="pergunta1">Por que deseja adotar este animal?</label>
                <textarea id="pergunta1" name="pergunta1" rows="4" required></textarea>

                <label for="pergunta2">Você tem outros animais de estimação?</label>
                <textarea id="pergunta2" name="pergunta2" rows="2" required></textarea>

                <label for="pergunta3">Você tem experiência em cuidar de animais?</label>
                <textarea id="pergunta3" name="pergunta3" rows="2" required></textarea>

                <button type="submit" aria-label="Enviar solicitação de adoção">Enviar Solicitação</button>
            </form>

            <a href="detalhes.php?id=<?php echo $id_animal; ?>" class="back-link" aria-label="Voltar para os detalhes do animal">Voltar para os detalhes do animal</a><br/>
            <a href="../usuarios/acompanhamento.php" class="back-link" aria-label="Minhas adoções">Minhas Adoções</a>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
