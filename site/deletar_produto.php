<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_gallerie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém o ID do produto
$id = $_GET['id'];

// Busca a imagem associada ao produto
$sql = "SELECT imagem FROM produtos WHERE id = $id";
$result = $conn->query($sql);
$produto = $result->fetch_assoc();

// Exclui a imagem do servidor, se existir
if (!empty($produto['imagem'])) {
    unlink("uploads/" . $produto['imagem']);
}

// Exclui o produto do banco de dados
$sql = "DELETE FROM produtos WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php");
        exit();
} else {
    echo "Erro ao excluir o produto: " . $conn->error;
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
