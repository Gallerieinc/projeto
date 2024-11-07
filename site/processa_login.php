<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_gallerie";

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
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['tipo_usuario'] = $tipo_usuario;

            // Redireciona com base no tipo de usuário
            if ($tipo_usuario === 'administrador') {
                header("Location: dashboard.php"); // Página do administrador
            } else {
                header("Location: index.html"); // Página do cliente
            }
            exit; // Importante para parar a execução do código após o redirecionamento
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

