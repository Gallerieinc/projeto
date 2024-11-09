<?php
session_start();
include 'conect.php';

// Selecionar o banco de dados 'db_gallerie'
mysqli_select_db($conn, 'db_gallerie');

// Verificar se o usuário está logado e o ID do usuário está na sessão
if (!isset($_SESSION['usuario_id'])) {
    die("Erro: Usuário não está logado.");
}

$id_usuario = $_SESSION['usuario_id'];

// Verificar se todos os dados foram enviados pelo formulário
if (isset($_POST['endereco'], $_POST['cidade'], $_POST['estado'], $_POST['cep'])) {
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

    // Preparar a inserção no banco de dados usando $conn
    $query = "INSERT INTO enderecos (id_usuario, endereco, cidade, estado, cep) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'issss', $id_usuario, $endereco, $cidade, $estado, $cep);
        mysqli_stmt_execute($stmt);
        
        // Redirecionar para a página de perfil após cadastrar
        header("Location: profile.php");
        exit;
    } else {
        echo "Erro ao preparar a consulta.";
    }
} else {
    echo "Erro: Dados incompletos.";
}
?>
