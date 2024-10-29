<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Verifica se há uma mensagem de sucesso para o agendamento
$agendamento_sucesso = isset($_SESSION['agendamento_sucesso']) ? $_SESSION['agendamento_sucesso'] : null;
unset($_SESSION['agendamento_sucesso']); // Remove a mensagem da sessão após exibir
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Agendar Procedimento</h1>

    <?php if ($agendamento_sucesso): ?>
        <div class="message">
            <p>Agendamento realizado com sucesso!</p>
            <p><strong>Data:</strong> <?= htmlspecialchars($agendamento_sucesso['data_agendamento']) ?></p>
            <p><strong>Hora:</strong> <?= htmlspecialchars($agendamento_sucesso['hora_agendamento']) ?></p>
            <p><strong>Procedimento:</strong> <?= htmlspecialchars($agendamento_sucesso['procedimento']) ?></p>
        </div>
    <?php endif; ?>

    <!-- Formulário de agendamento -->
    <form action="../actions/agendar.php" method="POST">
        <label for="data_agendamento">Data do Agendamento:</label>
        <input type="date" id="data_agendamento" name="data_agendamento" required><br>

        <label for="hora_agendamento">Hora do Agendamento:</label>
        <input type="time" id="hora_agendamento" name="hora_agendamento" required><br>

        <label for="procedimento">Procedimento:</label>
        <input type="text" id="procedimento" name="procedimento" required><br>

        <button type="submit">Agendar</button>
    </form>

    <a href="index.php">Sair</a> <!-- Link para sair e voltar ao login -->
</body>
</html>
