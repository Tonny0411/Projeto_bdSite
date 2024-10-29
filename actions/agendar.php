<?php
session_start();
include '../config/db.php';

$cpf_cliente = $_SESSION['cpf_cliente']; // Obtém o CPF do usuário logado
$data_agendamento = $_POST['data_agendamento'];
$hora_agendamento = $_POST['hora_agendamento'];
$procedimento = $_POST['procedimento'];

// Insere o agendamento no banco de dados
$sql = "INSERT INTO agendamento (cpf_cliente, data_agendamento, hora_agendamento, procedimento) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $cpf_cliente, $data_agendamento, $hora_agendamento, $procedimento);

if ($stmt->execute()) {
    $_SESSION['agendamento_sucesso'] = [
        'data_agendamento' => $data_agendamento,
        'hora_agendamento' => $hora_agendamento,
        'procedimento' => $procedimento
    ];
    header("Location: ../public/agendamento.php"); // Redireciona de volta para a tela de agendamento
    exit();
} else {
    echo "Erro ao realizar o agendamento: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
