<?php
session_start(); // Inicia a sessão no início do arquivo

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_gallerie";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // Prepara a consulta SQL
    $sql = "SELECT senha, tipo_usuario, nome, id FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o email existe
    if ($stmt->num_rows > 0) {
        // Bind corretamente as variáveis de acordo com as colunas selecionadas
        $stmt->bind_result($senha_hash, $tipo_usuario, $nome, $id);
        $stmt->fetch();

        // Verifica se a senha está correta
        if (password_verify($senha, $senha_hash)) {
            // Armazena informações na sessão
            $_SESSION['email'] = $email;
            $_SESSION['tipo_usuario'] = $tipo_usuario;
            $_SESSION['nome'] = $nome; // Salva o nome do usuário na sessão
            $_SESSION['usuario_id'] = $id; // Salva o ID do usuário na sessão

            // Redireciona com base no tipo de usuário
            if ($tipo_usuario === 'administrador') {
                header("Location: dashboard.php"); // Página do administrador
            } else {
                header("Location: index.php"); // Página do cliente
            }
            exit; // Para garantir que o código não continue executando após o redirecionamento
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
