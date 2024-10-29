<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Login</h1>

    <?php
    if (isset($_SESSION['success_msg'])) {
        echo '<div class="message">' . $_SESSION['success_msg'] . '</div>';
        unset($_SESSION['success_msg']);
    }

    if (isset($_SESSION['error_msg'])) {
        echo '<div class="error">' . $_SESSION['error_msg'] . '</div>';
        unset($_SESSION['error_msg']);
    }
    ?>

    <form action="../actions/login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <button type="submit">Login</button>
    </form>

    <a href="cadastro.php">Criar conta</a>

    <script>
        setTimeout(() => {
            const message = document.querySelector('.message');
            const error = document.querySelector('.error');
            if (message) message.style.display = 'none';
            if (error) error.style.display = 'none';
        }, 5000);
    </script>
</body>
</html>
