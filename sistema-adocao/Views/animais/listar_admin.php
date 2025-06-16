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
    <meta charset="UTF-8">
    <title>Gerenciar Animais</title>
</head>
<body>
    <h1>Gerenciar Animais (Admin)</h1>

    <?php
    $q = "SELECT * FROM animais ORDER BY id DESC";
    $resultado = $banco->query($q);

    if ($resultado && $resultado->num_rows > 0) {
        while ($animal = $resultado->fetch_assoc()) {
            echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";
            echo "<h2>".$animal['nome']."</h2>";
            if (!empty($animal['foto'])) {
                echo "<img src='../../uploads/animais/".$animal['foto']."' alt='Foto do animal' width='200'><br>";
            }
            echo "<strong>Espécie:</strong> ".$animal['especie']."<br>";
            echo "<strong>Idade:</strong> ".$animal['idade']." anos<br>";
            echo "<strong>Descrição:</strong> ".$animal['descricao']."<br><br>";
            echo "<a href='detalhes.php?id=".$animal['id']."'>Ver Detalhes</a>";
            echo "<a href='editar.php?id=".$animal['id']."'>Editar</a> | ";
            echo "<a href='excluir.php?id=".$animal['id']."' onclick=\"return confirm('Tem certeza que deseja excluir este animal?');\">Excluir</a>";

            echo "</div>";
        }
    } else {
        echo "<p>Nenhum animal cadastrado.</p>";
    }
    ?>

    <hr>
    <h1>Solicitações de Adoção</h1>

    <?php
    // Handle approve or reject actions
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
            }

            $q_update = "UPDATE adocoes SET status = ?, mensagem = ? WHERE id = ?";
            $stmt_update = $banco->prepare($q_update);
            $stmt_update->bind_param("ssi", $status, $mensagem, $id_adocao);
            $stmt_update->execute();
        }
    }

    // Fetch all adoption requests with user and animal info
    $q_adocoes = "SELECT a.id, a.data_pedido, a.status, a.mensagem, u.nome AS usuario_nome, an.nome AS animal_nome
                  FROM adocoes a
                  JOIN usuarios u ON a.id_usuario = u.id
                  JOIN animais an ON a.id_animal = an.id
                  ORDER BY a.data_pedido DESC";
    $result_adocoes = $banco->query($q_adocoes);

    if ($result_adocoes && $result_adocoes->num_rows > 0):
    ?>
        <table border="1" cellpadding="5" cellspacing="0" style="width: 90%; margin: auto; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Animal</th>
                    <th>Data do Pedido</th>
                    <th>Status</th>
                    <th>Mensagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_adocoes->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['usuario_nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['animal_nome']); ?></td>
                        <td><?php echo htmlspecialchars($row['data_pedido']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['mensagem'])); ?></td>
                        <td>
                            <?php if ($row['status'] === 'pendente'): ?>
                                <form method="post" style="display:inline-block; margin-bottom: 5px;">
                                    <input type="hidden" name="id_adocao" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="aprovar">
                                    <button type="submit">Aprovar</button>
                                </form>
                                <form method="post" style="display:inline-block;">
                                    <input type="hidden" name="id_adocao" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="recusar">
                                    <textarea name="mensagem" placeholder="Mensagem para o usuário (se recusar)" rows="2" cols="20"></textarea><br>
                                    <button type="submit">Recusar</button>
                                </form>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center;">Nenhuma solicitação de adoção encontrada.</p>
    <?php endif; ?>

    <br>
    <a href="../usuarios/painel.php">Voltar ao Painel</a>
</body>
</html>
