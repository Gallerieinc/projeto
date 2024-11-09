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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Senha criptografada
    $genero = $_POST['genero'];
    $tipo_usuario = $_POST['tipo_usuario'];
    

    // Adiciona o novo usuário no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha, genero, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $senha, $genero, $tipo_usuario);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erro ao adicionar usuário!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Usuário</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="imgnew/20241104_012926303_iOS-removebg-preview.png" />
</head>
<body>

<div class="container">
    <h2 class="mt-4">Adicionar Usuário</h2>
    <form action="adicionar_usuario.php" method="POST">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>
        <div class="form-group">
    <label for="genero">Sexo</label>
    <select class="form-control" id="genero" name="genero" required>
        <option value="Feminino">Feminino</option>
        <option value="Masculino">Masculino</option>
        <option value="Prefiro não dizer">Prefiro não dizer</option>
    </select>
</div>

        <div class="form-group">
            <label for="tipo_usuario">Tipo de Usuário</label>
            <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                <option value="cliente">Cliente</option>
                <option value="administrador">Administrador</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Adicionar</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
// Fecha a conexão
$conn->close();
?>
