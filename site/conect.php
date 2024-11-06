<?php
// Definindo as credenciais de conexão
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "db_gallerie";

// Conectando ao servidor (sem selecionar banco)
$conn = new mysqli($servername, $db_username, $db_password);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Criando o banco de dados se ele não
