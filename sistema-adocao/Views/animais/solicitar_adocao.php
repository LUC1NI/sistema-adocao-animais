<?php
session_start();
require_once '../../Config/banco.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../usuarios/login.php');
    exit;
}

$id_animal = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_animal <= 0) {
    echo "ID do animal não informado.";
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
        echo "Solicitação de adoção enviada com sucesso!";
    } else {
        echo "Erro ao enviar solicitação de adoção.";
    }
    echo '<br><a href="detalhes.php?id=' . $id_animal . '">Voltar para os detalhes do animal</a>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Formulário de Solicitação de Adoção</title>
</head>
<body>
<?php if (!empty($message)): ?>
    <p><?php echo $message; ?></p>
<?php else: ?>
    <h1>Formulário de Solicitação de Adoção</h1>
    <form method="post" action="">
        <label for="pergunta1">Por que deseja adotar este animal?</label><br>
        <textarea id="pergunta1" name="pergunta1" rows="4" cols="50" required></textarea><br><br>

        <label for="pergunta2">Você tem outros animais de estimação?</label><br>
        <textarea id="pergunta2" name="pergunta2" rows="2" cols="50" required></textarea><br><br>

        <label for="pergunta3">Você tem experiência em cuidar de animais?</label><br>
        <textarea id="pergunta3" name="pergunta3" rows="2" cols="50" required></textarea><br><br>

        <button type="submit">Enviar Solicitação</button>
    </form>
    <br>
    <a href="detalhes.php?id=<?php echo $id_animal; ?>">Voltar para os detalhes do animal</a>
    <a href="../usuarios/acompanhamento.php">Minhas Adoções</a>
<?php endif; ?>
</body>
</html>
