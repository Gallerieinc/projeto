<?php
session_start();

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
    // Verifica se as variáveis estão definidas
    if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
        $nome = $_POST['name'];
        $email = $_POST['email'];
        $senha = $_POST['password'];
        $confirm_senha = $_POST['confirm_password'];

        // Verifica se a senha e a confirmação são iguais
        if ($senha !== $confirm_senha) {
            $_SESSION['mensagem'] = "As senhas não correspondem.";
            $_SESSION['mensagem_tipo'] = "error";
        } else {
            // Verifica se o email já existe
            $sql_check = "SELECT id FROM usuarios WHERE email = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                $_SESSION['mensagem'] = "Este email já está cadastrado. Por favor, use outro email.";
                $_SESSION['mensagem_tipo'] = "error";
            } else {
                // Hash da senha antes de armazená-la
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                // Prepara a consulta SQL para inserir o novo usuário
                $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if ($stmt === false) {
                    $_SESSION['mensagem'] = "Erro no cadastro: " . $conn->error;
                    $_SESSION['mensagem_tipo'] = "error";
                } else {
                    $stmt->bind_param("sss", $nome, $email, $senha_hash);

                    // Executa a consulta
                    if ($stmt->execute()) {
                        $_SESSION['mensagem'] = "Cadastro realizado com sucesso.";
                        $_SESSION['mensagem_tipo'] = "success";
                    } else {
                        $_SESSION['mensagem'] = "Erro no cadastro: " . $stmt->error;
                        $_SESSION['mensagem_tipo'] = "error";
                    }
                    $stmt->close();
                }
            }
            $stmt_check->close();
        }
    } else {
        $_SESSION['mensagem'] = "Por favor, preencha todos os campos.";
        $_SESSION['mensagem_tipo'] = "error";
    }

    // Redireciona para a página de login com a mensagem configurada
    header("Location: login.php");
}

// Fecha a conexão
$conn->close();
?>
