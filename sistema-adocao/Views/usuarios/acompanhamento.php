<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$email_usuario = $_SESSION['usuario'];

// Get user id
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

// Get adoption requests for user
$q_adocoes = "SELECT a.id, a.data_pedido, a.status, an.nome AS animal_nome, an.foto AS animal_foto FROM adocoes a JOIN animais an ON a.id_animal = an.id WHERE a.id_usuario = ? ORDER BY a.data_pedido DESC";
$stmt_adocoes = $banco->prepare($q_adocoes);
$stmt_adocoes->bind_param("i", $id_usuario);
$stmt_adocoes->execute();
$result_adocoes = $stmt_adocoes->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Pedidos de Adoção</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Meus Pedidos de Adoção</h1>
    <?php if ($result_adocoes && $result_adocoes->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Animal</th>
                    <th>Data do Pedido</th>
                    <th>Status</th>
                    <th>Mensagem do Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($adocao = $result_adocoes->fetch_assoc()): ?>
                    <tr>
                        <td><img src="../../uploads/animais/<?php echo htmlspecialchars($adocao['animal_foto']); ?>" alt="Foto do animal"></td>
                        <td><?php echo htmlspecialchars($adocao['animal_nome']); ?></td>
                        <td><?php echo htmlspecialchars($adocao['data_pedido']); ?></td>
                        <td><?php echo htmlspecialchars($adocao['status']); ?></td>
                        <td><?php echo !empty($adocao['mensagem']) ? nl2br(htmlspecialchars($adocao['mensagem'])) : 'Nenhuma mensagem'; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Você ainda não fez nenhum pedido de adoção.</p>
    <?php endif; ?>

    <br>
    <a href="../../index.php">Voltar para a página inicial</a>
</body>
</html>
