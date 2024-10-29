<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    $conn->begin_transaction();

    try {
        $sql_verifica_cpf = "SELECT cpf FROM cadastro_cliente WHERE cpf = ?";
        $stmt_verifica = $conn->prepare($sql_verifica_cpf);
        $stmt_verifica->bind_param("s", $cpf);
        $stmt_verifica->execute();
        $stmt_verifica->store_result();

        if ($stmt_verifica->num_rows > 0) {
            throw new Exception("CPF já cadastrado.");
        }
        $stmt_verifica->close();

        // Atualização para incluir o campo 'email' na tabela cadastro_cliente
        $sql_cliente = "INSERT INTO cadastro_cliente (cpf, nome, telefone, data_nascimento, email) VALUES (?, ?, ?, ?, ?)";
        $stmt_cliente = $conn->prepare($sql_cliente);
        $stmt_cliente->bind_param("sssss", $cpf, $nome, $telefone, $data_nascimento, $email);

        if (!$stmt_cliente->execute()) {
            throw new Exception("Erro ao cadastrar cliente: " . $stmt_cliente->error);
        }
        $stmt_cliente->close();

        $sql_login = "INSERT INTO login_cliente (cpf_cliente, email, senha_hash) VALUES (?, ?, ?)";
        $stmt_login = $conn->prepare($sql_login);
        $stmt_login->bind_param("sss", $cpf, $email, $senha);

        if (!$stmt_login->execute()) {
            throw new Exception("Erro ao cadastrar login: " . $stmt_login->error);
        }
        $stmt_login->close();

        $conn->commit();

        // Armazena a mensagem de sucesso na sessão e redireciona
        $_SESSION['success_msg'] = "Cadastro efetuado com sucesso!";
        header("Location: ../public/index.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        echo "Erro ao realizar o cadastro: " . $e->getMessage();
    }
} else {
    echo "Método de requisição inválido.";
}
