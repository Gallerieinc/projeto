<?php
// Configurações do banco de dados
$servername = "localhost"; // ou o endereço do seu servidor
$username = "root"; // seu usuário do banco de dados
$password = ""; // sua senha do banco de dados
$dbname = "db_gallerie"; // seu banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se as variáveis estão definidas
    if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
        $nome = $_POST['name'];
        $email = $_POST['email'];
        $senha = $_POST['password'];
        $confirm_senha = $_POST['confirm_password'];

        // Verifica se a senha e a confirmação são iguais
        if ($senha !== $confirm_senha) {
            die("As senhas não correspondem.");
        }

        // Hash a senha antes de armazená-la
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Prepara a consulta SQL
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        $stmt->bind_param("sss", $nome, $email, $senha_hash);

        // Executa a consulta
        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso.";
            // Aqui você pode redirecionar o usuário ou mostrar uma mensagem de sucesso
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}

// Fecha a conexão
$conn->close();
?>
