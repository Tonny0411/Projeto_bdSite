<?php
$host = 'localhost';
$user = 'root'; // Usuário padrão no XAMPP
$pass = ''; // Coloque sua senha do MySQL aqui
$dbname = 'agendamento_anapaula'; // Nome do banco de dados

// Criar a conexão
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
?>
