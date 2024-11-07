<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado e é um administrador
if (!isset($_SESSION['email']) || $_SESSION['tipo_usuario'] != 'administrador') {
    header("Location: login.php");
    exit();
}

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_gallerie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o ID do usuário foi passado na URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Deleta o usuário no banco de dados
    $sql = "DELETE FROM usuarios WHERE id = $user_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erro ao deletar usuário!";
    }
} else {
    echo "ID não fornecido!";
    exit();
}

$conn->close();
?>
