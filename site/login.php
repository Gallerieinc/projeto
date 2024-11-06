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
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // Prepara a consulta SQL
    $sql = "SELECT senha, tipo_usuario FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o email existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($senha_hash, $tipo_usuario);
        $stmt->fetch();

        // Verifica se a senha está correta
        if (password_verify($senha, $senha_hash)) {
            // A senha está correta, inicie a sessão
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['tipo_usuario'] = $tipo_usuario; // Pode ser usado para controle de acesso
            echo "Login bem-sucedido. Bem-vindo, " . $email;
            // Aqui você pode redirecionar o usuário para a página inicial ou o que desejar
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Email não encontrado.";
    }

    $stmt->close();
}

// Fecha a conexão
$conn->close();
?>
