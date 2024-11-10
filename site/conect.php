<?php
// Definindo as credenciais de conexão
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "db_gallerie";

// Conectando ao servidor (sem selecionar banco)
$conn = new mysqli('localhost', 'root', '', 'db_gallerie'); // Substitua 'usuario' e 'senha' pelas credenciais corretas.

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

