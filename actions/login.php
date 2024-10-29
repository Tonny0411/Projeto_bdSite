<?php
session_start();
require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT cpf_cliente, senha_hash FROM login_cliente WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($senha, $user['senha_hash'])) {
            $_SESSION['email'] = $email;
            header("Location: ../public/agendamento.php");
            exit();
        } else {
            $_SESSION['error_msg'] = "Senha incorreta.";
            header("Location: ../public/index.php");
            exit();
        }
    } else {
        $_SESSION['error_msg'] = "Email não encontrado.";
        header("Location: ../public/index.php");
        exit();
    }
} else {
    header("Location: ../public/index.php");
    exit();
}
